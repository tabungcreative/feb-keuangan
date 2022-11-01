<?php

namespace App\Services\Impl;

use App\Http\Requests\BukuBesarKasRequest;
use App\Models\Transaksi;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\PencatatanService;
use Carbon\Carbon;

class PencatatanServiceImpl implements PencatatanService
{

    private AkunRepository $akunRepository;
    private TransaksiRepository $transaksiRepository;

    public function __construct(AkunRepository $akunRepository,
                                TransaksiRepository $transaksiRepository)
    {
        $this->akunRepository = $akunRepository;
        $this->transaksiRepository = $transaksiRepository;
    }

    function saldoAwal($dateStart, $dateEnd, $akunId)
    {
        $saldoAwal = 0;
        $transaksi = $this->transaksiRepository->getBetweenTanggalAndAkun($dateStart, $dateEnd, $akunId);

        foreach ($transaksi as $value) {
            $saldoAwal += $value->debit - $value->kredit;
        }

        return $saldoAwal;
    }

    function bukuBesar($akunKas, BukuBesarKasRequest $request): array
    {
        $yearMonth = $request->get('year_month') ?? Carbon::now()->format('Y-m');
        $akunID = $request->get('akun_id');

        $akuns = $this->akunRepository->getByAkunKas($akunKas);

        if ($akunID != null) {
            $akuns = $this->akunRepository->getById($akunID);
        }

        $dateStart = $this->transaksiRepository->findFirstOrderTanggal()->tanggal ?? null;

        $dateEnd = Carbon::createFromFormat('Y-m', $yearMonth)->subMonth(1)->lastOfMonth()->format('Y-m-d');

        $date = Carbon::createFromFormat('Y-m', $yearMonth) ?? Carbon::now();

        $listTotalDebit = [];
        $listTotalKredit = [];
        $listSaldoAwalKas = [];
        $listTransaksi = [];

        // iterasi akun kas jalan
        foreach ($akuns as $akun) {
            // query mendapatkan transaksi berdasarkan akun
            $queryTransaksi = $this->transaksiRepository->getByAkunId($akun->id, $date->month, $date->year);

            // memsukan transaksi kedalam arrat
            $listTransaksi[] = $queryTransaksi;
            // inisialisasi total debit dan kredit
            $totalDebit = $this->transaksiRepository->sumByAkun($akun->id, $date->month, $date->year, 'debit');
            $totalKredit = $this->transaksiRepository->sumByAkun($akun->id, $date->month, $date->year, 'kredit');

            $listTotalDebit[] = $totalDebit;
            $listTotalKredit[] = $totalKredit;

            // mengisi array saldo kas awal dari transaksi pertama sampai transaksi bulan lalu
            $saldoAwal = $this->saldoAwal($dateStart, $dateEnd, $akun->id);

            $listSaldoAwalKas[] = $saldoAwal;
        }

        return array($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi);
    }
}
