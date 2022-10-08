<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\TransaksiService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    //
    private AkunRepository $akunRepository;
    private TransaksiRepository $transaksiRepository;
    private TransaksiService $transaksiService;



    public function __construct(
        AkunRepository $akunRepository,
        TransaksiRepository $transaksiRepository,
        TransaksiService $transaksiService
    ) {
        $this->akunRepository = $akunRepository;
        $this->transaksiRepository = $transaksiRepository;
        $this->transaksiService = $transaksiService;
    }

    public function bukuBesar(Request $request)
    {
        $title = 'Buku Besar';
        $akun = $this->akunRepository->getAkunByAkunKasJalan();

        return view('transaksi.buku-besar', compact('title', 'akun'));
    }

    public function bukuBesarRinci()
    {
        $title = 'Perincian Buku Besar';
        $akun = $this->akunRepository->getAkunByIsNotAkunKasJalan();
        return view('transaksi.buku-besar-rinci', compact('title', 'akun'));
    }

    public function perubahanModal(Request $request)
    {
        $date = '2022-11';
        $datePrevius = '2022-10';


        $month = Carbon::now()->month;
        $monthPrevius = Carbon::now()->subMonth(1)->month;
        $year = Carbon::now()->year;

        if ($date != null) {
            $month = Carbon::createFromFormat('Y-m', $date)->month;
            $monthPrevius = Carbon::createFromFormat('Y-m', $date)->subMonth(1)->month;
            $year = Carbon::createFromFormat('Y-m', $date)->year;
        }

        // pendapatan bulan ini
        $pendapatanBulanIni = $this->transaksiRepository->getWhereAkunKasGroupByAkun('kas_masuk', $date);
        $totalPendapatanBulanIni = 0;
        foreach ($pendapatanBulanIni as $value) {
            $totalPendapatanBulanIni += $value->total_kredit;
        }

        // pendapatan bulan lalu
        $pendapatanBulanLalu = $this->transaksiRepository->getWhereAkunKasGroupByAkun('kas_masuk', $datePrevius);
        $totalPendapatanBulanLalu = 0;
        foreach ($pendapatanBulanLalu as $value) {
            $totalPendapatanBulanLalu += $value->total_kredit;
        }

        // pengeluran bulan ini
        $pengeluaranBulanIni = $this->transaksiRepository->getWhereAkunKasGroupByAkun('kas_keluar', $date);
        $totalPengeluaranBulanIni = 0;
        foreach ($pengeluaranBulanIni as $value) {
            $totalPengeluaranBulanIni += $value->total_debit;
        }

        $pengeluaranBulanLalu = $this->transaksiRepository->getWhereAkunKasGroupByAkun('kas_keluar', $datePrevius);
        $totalPengeluaranBulanLalu = 0;
        foreach ($pengeluaranBulanLalu as $value) {
            $totalPengeluaranBulanLalu += $value->total_debit;
        }

        $hasilPendapatanBulanIni = $totalPendapatanBulanIni - $totalPengeluaranBulanIni;

        $hasilPendapatanBulanLalu = $totalPendapatanBulanLalu - $totalPengeluaranBulanLalu;

        $modalAwalBulanIni = $hasilPendapatanBulanLalu;

        $modalAwalBulanLalu = 0;

        $modalAkhirBulanIni = $modalAwalBulanIni + $hasilPendapatanBulanIni;


        echo 'Pendapatan bulan lalu = ' . $totalPendapatanBulanLalu;

        echo '<hr>';
        echo 'Pengeluran bulan lalu = ' . $totalPengeluaranBulanLalu;

        echo '<hr>';
        echo 'Hasil Pendapatan bulan lalu = ' . $hasilPendapatanBulanLalu;

        echo '<hr>';
        echo 'Modal Awal Bulan lalu = ' . $modalAwalBulanLalu;

        echo '<hr>';
        echo '<hr>';
        echo '<hr>';
        echo '<hr>';
        echo '<hr>';

        echo 'Pendapatan bulan ini = ' . $totalPendapatanBulanIni;

        echo '<hr>';
        echo 'Pengeluran bulan ini = ' . $totalPengeluaranBulanIni;

        echo '<hr>';
        echo 'Hasil Pendapatan bulan ini = ' . $hasilPendapatanBulanIni;

        echo '<hr>';
        echo 'Modal Awal Bulan ini = ' . $modalAwalBulanIni;


        echo '<hr>';
        echo 'Modal Akhir Bulan ini = ' . $modalAkhirBulanIni;

        die;
    }
}
