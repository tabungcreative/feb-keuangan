<?php

namespace App\Services\Impl;

use App\Http\Requests\BukuBesarBankRequest;
use App\Http\Requests\BukuBesarBiayaRequest;
use App\Http\Requests\BukuBesarHutangRequest;
use App\Http\Requests\BukuBesarKasRequest;
use App\Http\Requests\BukuBesarModalRequest;
use App\Http\Requests\BukuBesarPendapatanRequest;
use App\Http\Requests\BukuBesarPiutangRequest;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\BukuBesarService;
use Carbon\Carbon;

class BukuBesarServiceImpl implements BukuBesarService
{

    private AkunRepository $akunRepository;
    private TransaksiRepository $transaksiRepository;

    public function __construct(AkunRepository $akunRepository, TransaksiRepository $transaksiRepository)
    {
        $this->akunRepository = $akunRepository;
        $this->transaksiRepository = $transaksiRepository;
    }


    function bukuBesarKas(BukuBesarKasRequest $request)
    {
        $yearMonth = $request->get('year_month') ?? Carbon::now()->format('Y-m');
        $akunID = $request->get('akun_id');

        $akuns = $this->akunRepository->getByAkunKas('kas_jalan');

        if ($akunID != null) {
            $akuns = $this->akunRepository->getById($akunID);
        }

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
            $saldoAwal = $this->saldoAwal($yearMonth, $akun->id);

            $listSaldoAwalKas[] = $saldoAwal;
        }

        return array($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi);
    }

    function bukuBesarBank(BukuBesarBankRequest $request)
    {
        // TODO: Implement bukuBesarBank() method.
    }

    function bukuBesarBiaya(BukuBesarBiayaRequest $request)
    {
        $yearMonth = $request->get('year_month') ?? Carbon::now()->format('Y-m');
        $akunID = $request->get('akun_id');

        $akuns = $this->akunRepository->getByAkunKas('kas_keluar');

        if ($akunID != null) {
            $akuns = $this->akunRepository->getById($akunID);
        }

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
            $saldoAwal = $this->saldoAwal($yearMonth, $akun->id);

            $listSaldoAwalKas[] = $saldoAwal;
        }

        return array($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi);
    }

    function bukuBesarPendapatan(BukuBesarPendapatanRequest $request)
    {

        $yearMonth = $request->get('year_month') ?? Carbon::now()->format('Y-m');
        $akunID = $request->get('akun_id');

        $akuns = $this->akunRepository->getByAkunKas('kas_masuk');

        if ($akunID != null) {
            $akuns = $this->akunRepository->getById($akunID);
        }

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
            $saldoAwal = 0;

            $dateStart = $this->transaksiRepository->findFirstOrderTanggalByAkunId($akun->id)->tanggal ?? null;
            $dateEnd = Carbon::createFromFormat('Y-m', $yearMonth)->subMonth(1)->lastOfMonth()->format('Y-m-d');

            $transaksi = $this->transaksiRepository->getBetweenTanggalAndAkun($dateStart, $dateEnd, $akun->id);

            foreach ($transaksi as $value) {
                $saldoAwal += $value->kredit;
            }


            $listSaldoAwalKas[] = $saldoAwal;
        }
        return array($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi);
    }

    function bukuBesarModal(BukuBesarModalRequest $request)
    {
        $yearMonth = $request->get('year_month') ?? Carbon::now()->format('Y-m');
        $akunID = $request->get('akun_id');

        $akuns = $this->akunRepository->getByAkunKas('modal');

        if ($akunID != null) {
            $akuns = $this->akunRepository->getById($akunID);
        }

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
            $saldoAwal = 0;

            $dateStart = $this->transaksiRepository->findFirstOrderTanggalByAkunId($akun->id)->tanggal ?? null;
            $dateEnd = Carbon::createFromFormat('Y-m', $yearMonth)->subMonth(1)->lastOfMonth()->format('Y-m-d');

            $transaksi = $this->transaksiRepository->getBetweenTanggalAndAkun($dateStart, $dateEnd, $akun->id);

            foreach ($transaksi as $value) {
                $saldoAwal += $value->kredit;
            }


            $listSaldoAwalKas[] = $saldoAwal;
        }

        return array($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi);
    }

    function bukuBesarHutang(BukuBesarHutangRequest $request)
    {
        $yearMonth = $request->get('year_month') ?? Carbon::now()->format('Y-m');
        $akunID = $request->get('akun_id');

        $akuns = $this->akunRepository->getByAkunKas('hutang');

        if ($akunID != null) {
            $akuns = $this->akunRepository->getById($akunID);
        }

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
            $saldoAwal = 0;

            $dateStart = $this->transaksiRepository->findFirstOrderTanggalByAkunId($akun->id)->tanggal ?? null;
            $dateEnd = Carbon::createFromFormat('Y-m', $yearMonth)->subMonth(1)->lastOfMonth()->format('Y-m-d');

            $transaksi = $this->transaksiRepository->getBetweenTanggalAndAkun($dateStart, $dateEnd, $akun->id);

            foreach ($transaksi as $value) {
                $saldoAwal += $value->kredit - $value->debit;
            }


            $listSaldoAwalKas[] = $saldoAwal;
        }

        return array($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi);
    }

    function bukuBesarPiutang(BukuBesarPiutangRequest $request)
    {
        $yearMonth = $request->get('year_month') ?? Carbon::now()->format('Y-m');
        $akunID = $request->get('akun_id');

        $akuns = $this->akunRepository->getByAkunKas('piutang');

        if ($akunID != null) {
            $akuns = $this->akunRepository->getById($akunID);
        }

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
            $saldoAwal = 0;

            $dateStart = $this->transaksiRepository->findFirstOrderTanggalByAkunId($akun->id)->tanggal ?? null;
            $dateEnd = Carbon::createFromFormat('Y-m', $yearMonth)->subMonth(1)->lastOfMonth()->format('Y-m-d');

            $transaksi = $this->transaksiRepository->getBetweenTanggalAndAkun($dateStart, $dateEnd, $akun->id);

            foreach ($transaksi as $value) {
                $saldoAwal += $value->debit - $value->kredit;
            }


            $listSaldoAwalKas[] = $saldoAwal;
        }

        return array($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi);
    }

    function saldoAwal($yearMonth, $akunId)
    {
        $saldoAwal = 0;

        $dateStart = $this->transaksiRepository->findFirstOrderTanggalByAkunId($akunId)->tanggal ?? null;
        $dateEnd = Carbon::createFromFormat('Y-m', $yearMonth)->subMonth(1)->lastOfMonth()->format('Y-m-d');

        $transaksi = $this->transaksiRepository->getBetweenTanggalAndAkun($dateStart, $dateEnd, $akunId);

        foreach ($transaksi as $value) {
            $saldoAwal += $value->debit - $value->kredit;
        }

        return $saldoAwal;
    }
}
