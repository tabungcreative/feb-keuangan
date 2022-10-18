<?php

namespace App\Http\Controllers;

use App\Models\Akun;
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

    public function perubahanModal(Request $request)
    {
        // mendapatkan bulan dan tahun dari request
        $yearMounth = $request->query('bulan');
        // jika tidak ada bulan dan tahun akan default now
        if ($yearMounth == null) {
            $yearMounth = Carbon::now()->format('Y-m');
        }

        // mendapat tanggal transaksi pertama
        $dateStart = Transaksi::orderBy('tanggal', 'ASC')->first()->tanggal;
        // mendapat bulan lau dari request
        $dateEnd = Carbon::createFromFormat('Y-m', $yearMounth)->subMonth(1)->lastOfMonth()->format('Y-m-d');
        // inisialisasi bulan
        $month = Carbon::createFromFormat('Y-m', $yearMounth)->month;
        // inisialisasi tahun
        $year = Carbon::createFromFormat('Y-m', $yearMounth)->year;

        // get pendapatan bulan ini
        $pendapatan =  Transaksi::selectRaw('id, akun_id, sum(kredit) as total_kredit,sum(debit) as total_debit, count(id) as count_id')
            ->groupBy('akun_id')
            ->whereHas('akun', function ($query) {
                $query->where('akun_kas', 'kas_masuk');
            })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        // get pengeuaran
        $pengeluaran =  Transaksi::selectRaw('id, akun_id, sum(kredit) as total_kredit,sum(debit) as total_debit, count(id) as count_id')
            ->groupBy('akun_id')
            ->whereHas('akun', function ($query) {
                $query->where('akun_kas', 'kas_keluar');
            })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        // echo 'PENDAPATAN' . '<br>';
        // iterasi pendapatan
        $totalPendapatan = 0;
        foreach ($pendapatan as $value) {
            $totalPendapatan += $value->total_kredit;
            // echo $value->akun->nama . ' ====>' . $value->total_kredit . '<br>';
        }

        // echo '<hr>';
        // echo 'PENGELUARAN' . '<br>';
        // iterasi pengeluaran
        $totalPengeluaran = 0;
        foreach ($pengeluaran as $value) {
            $totalPengeluaran += $value->total_debit;
            // echo $value->akun->nama . ' ====>' . $value->total_debit . '<br>';
        }

        // echo '<hr>';
        // echo 'Total Pendapatan : ' . $totalPendapatan . '<br>';
        // echo 'Total Pengeluaran : ' . $totalPengeluaran . '<br>';
        // echo '<hr>';



        $penambahanModalBersih = $totalPendapatan - $totalPengeluaran;

        $modalAwal = 0;
        // Modal Tanggal 1
        $transaksiOld = Transaksi::select('id', 'debit', 'tanggal', 'kredit', 'akun_id')
            ->whereBetween('tanggal', [$dateStart, $dateEnd])->whereHas('akun', function ($query) {
                $query->where('akun_kas', 'kas_jalan');
            })->get();


        foreach ($transaksiOld as $value) {
            $modalAwal += ($value->debit - $value->kredit);
        }

        $modalAkhir = $modalAwal + $penambahanModalBersih;
        // echo 'Modal Tanggal 1 : ' . $modalAwal . '<br>';
        // echo 'Pendambahan modal bersih : ' . $penambahanModalBersih . '<br>';
        // echo 'Modal Tanggal 30 : ' . $modalAkhir . '<br>';

        return view('laporan.perubahan-modal', compact('pendapatan', 'totalPendapatan', 'pengeluaran', 'totalPengeluaran', 'modalAwal', 'modalAkhir', 'penambahanModalBersih'));
        // $pendapatanBulanIni = $this->transaksiRepository->getWhereAkunKasGroupByAkun('kas_masuk', $date);
        // $totalPendapatanBulanIni = 0;
        // foreach ($pendapatanBulanIni as $value) {
        //     $totalPendapatanBulanIni += $value->total_kredit;
        // }
    }
}
