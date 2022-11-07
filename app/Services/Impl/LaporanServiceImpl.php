<?php

namespace App\Services\Impl;

use App\Http\Requests\LaporanCatatanAtasKeuanganRequest;
use App\Http\Requests\LaporanLabaRugiRequest;
use App\Http\Requests\LaporanNeracaRequest;
use App\Http\Requests\LaporanPerubahanModalRequest;
use App\Models\Transaksi;
use App\Repositories\TransaksiRepository;
use App\Services\LaporanService;
use Carbon\Carbon;

class LaporanServiceImpl implements LaporanService
{

    private TransaksiRepository $transaksiRepository;

    /**
     * @param TransaksiRepository $transaksiRepository
     */
    public function __construct(TransaksiRepository $transaksiRepository)
    {
        $this->transaksiRepository = $transaksiRepository;
    }


    function catatanAtasKeuangan(LaporanCatatanAtasKeuanganRequest $request)
    {
        $yearMonth = $request->get('year_month') ?? Carbon::now()->format('Y-m');
        $date= Carbon::createFromFormat('Y-m', $yearMonth);

        $posisiKas = 0;
        $totalBank = 0;
        $totalPiutang = 0;
        $totalPendapatan = 0;
        $totalPengeluaran = 0;

        // laba rugi
        list($modalAwal, $penambahanModalBersih, $modalAkhir) = $this->labaRugi($yearMonth);

        // kas awal
        $posisiKas += $modalAwal;
        $transaksiKas =  $this->transaksiRepository->getByAkunKasGroupByAkun('kas_jalan', $date);
        foreach ($transaksiKas as $transaksi) {
            $posisiKas += $transaksi->debit;
            $posisiKas -= $transaksi->kredit;
        }

        // total bank
        $transaksiBank = $this->transaksiRepository->getByAkunKasGroupByAkun('kas_bank', $date);
        foreach ($transaksiBank as $transaksi) {
            $totalBank += $transaksi->debit;
            $totalBank -= $transaksi->kredit;
        }

        // total pendapatan
        $transaksiPendapatan = $this->transaksiRepository->getByAkunKasGroupByAkun('kas_masuk', $date);
        foreach ($transaksiPendapatan as $transaksi) {
            $totalPendapatan += $transaksi->kredit;
        }

        // total pengeluaran
        $transaksiPengeluaran = $this->transaksiRepository->getByAkunKasGroupByAkun('kas_keluar', $date);
        foreach ($transaksiPengeluaran as $transaksi) {
            $totalPengeluaran += $transaksi->debit;
        }


        return array(
            $posisiKas,
            $totalBank,
            $totalPiutang,
            $totalPendapatan,
            $totalPengeluaran,
            $modalAwal,
            $modalAkhir,
            $penambahanModalBersih,
            $transaksiBank,
            $transaksiPendapatan,
            $transaksiPengeluaran
        );
    }

    function labaRugi($yearMonth)
    {
        $yearMonth = $yearMonth?? Carbon::now()->format('Y-m');

        $modalAwal = 0;
        $penambahanModalBersih = 0;
        $modalAkhir = 0;

        // mendapat tanggal transaksi pertama
        $dateStart = Transaksi::orderBy('tanggal', 'ASC')->first()->tanggal ?? null;
        // mendapat bulan lau dari request
        $dateEnd = Carbon::createFromFormat('Y-m', $yearMonth)->subMonth(1)->lastOfMonth()->format('Y-m-d');
        // inisialisasi bulan
        $month = Carbon::createFromFormat('Y-m', $yearMonth)->month;
        // inisialisasi tahun
        $year = Carbon::createFromFormat('Y-m', $yearMonth)->year;

        // get pendapatan bulan ini
        $transaksiNow =  Transaksi::whereHas('akun', function ($query) {
            $query->where('akun_kas', 'kas_jalan');
        })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        foreach ($transaksiNow as $transaksi) {
            $penambahanModalBersih += $transaksi->debit - $transaksi->kredit;
        }


        // Modal Tanggal 1
        $transaksiOld = Transaksi::select('id', 'debit', 'tanggal', 'kredit', 'akun_id')
            ->whereBetween('tanggal', [$dateStart, $dateEnd])->whereHas('akun', function ($query) {
                $query->where('akun_kas', 'kas_jalan');
            })->get();


        foreach ($transaksiOld as $value) {
            $modalAwal += $value->debit - $value->kredit;
        }

        $modalAkhir = $modalAwal + $penambahanModalBersih;


       return array($modalAwal, $penambahanModalBersih, $modalAkhir);
    }

    function perubahanModal(LaporanPerubahanModalRequest $request)
    {
        // TODO: Implement perubahanModal() method.
    }

    function neraca(LaporanNeracaRequest $request)
    {
        // TODO: Implement neraca() method.
    }
}
