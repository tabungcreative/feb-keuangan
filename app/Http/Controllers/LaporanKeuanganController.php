<?php

namespace App\Http\Controllers;

use App\Http\Requests\LaporanCatatanAtasKeuanganRequest;
use App\Http\Requests\LaporanLabaRugiRequest;
use App\Models\Akun;
use App\Models\Transaksi;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\LaporanService;
use App\Services\TransaksiService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    //
    private AkunRepository $akunRepository;
    private TransaksiRepository $transaksiRepository;
    private TransaksiService $transaksiService;

    private LaporanService $laporanService;

    public function __construct(AkunRepository $akunRepository, TransaksiRepository $transaksiRepository, TransaksiService $transaksiService, LaporanService $laporanService)
    {
        $this->akunRepository = $akunRepository;
        $this->transaksiRepository = $transaksiRepository;
        $this->transaksiService = $transaksiService;
        $this->laporanService = $laporanService;
    }


    public function catatanAtasKeuangan(LaporanCatatanAtasKeuanganRequest $request) {
        list(
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
            ) =
            $this->laporanService->catatanAtasKeuangan($request);
        return view('laporan.catatan-atas-keuangan',
            compact(
                'posisiKas',
                'totalBank',
                'totalPiutang',
                'totalPendapatan',
                'totalPengeluaran',
                'modalAwal',
                'modalAkhir',
                'penambahanModalBersih',
                'transaksiBank',
                'transaksiPendapatan',
                'transaksiPengeluaran'
            ));
    }

    public function labaRugi(LaporanLabaRugiRequest $request) {
        list($modalAwal, $penambahanModalBersih, $modalAkhir) = $this->laporanService->labaRugi($request->get('year_month'));
        return view('laporan.laba-rugi', compact('modalAwal', 'modalAkhir', 'penambahanModalBersih'));
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
        $dateStart = Transaksi::orderBy('tanggal', 'ASC')->first()->tanggal ?? null;
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

        $totalPendapatan = 0;
        foreach ($pendapatan as $value) {
            $totalPendapatan += $value->total_kredit;
        }

        $totalPengeluaran = 0;
        foreach ($pengeluaran as $value) {
            $totalPengeluaran += $value->total_debit;
        }

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

        return view('laporan.perubahan-modal', compact('pendapatan', 'totalPendapatan', 'pengeluaran', 'totalPengeluaran', 'modalAwal', 'modalAkhir', 'penambahanModalBersih'));
    }

    public function neraca(Request $request) {
        // mendapatkan bulan dan tahun dari request
        $yearMounth = $request->query('bulan');
        // jika tidak ada bulan dan tahun akan default now
        if ($yearMounth == null) {
            $yearMounth = Carbon::now()->format('Y-m');
        }

        // inisialisasi bulan
        $month = Carbon::createFromFormat('Y-m', $yearMounth)->month;
        // inisialisasi tahun
        $year = Carbon::createFromFormat('Y-m', $yearMounth)->year;

        $transaksiKas =  Transaksi::selectRaw('id, akun_id, sum(kredit) as total_kredit,sum(debit) as total_debit, count(id) as count_id')
            ->groupBy('akun_id')
            ->whereHas('akun', function ($query) {
                $query->where('akun_kas', 'kas_jalan');
            })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $totalKas = 0;
        foreach ($transaksiKas as $value) {
            $totalKas += $value->total_debit;
        }

        $transaksiBank =  Transaksi::selectRaw('id, akun_id, sum(kredit) as total_kredit,sum(debit) as total_debit, count(id) as count_id')
            ->groupBy('akun_id')
            ->whereHas('akun', function ($query) {
                $query->where('akun_kas', 'kas_bank');
            })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $totalBank = 0;
        foreach ($transaksiBank as $value) {
            $totalBank += $value->total_debit;
        }

        $transaksiPiutang =  Transaksi::selectRaw('id, akun_id, sum(kredit) as total_kredit,sum(debit) as total_debit, count(id) as count_id')
            ->groupBy('akun_id')
            ->whereHas('akun', function ($query) {
                $query->where('akun_kas', 'piutang');
            })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();

        $totalPiutang = 0;
        foreach ($transaksiPiutang as $value) {
            $totalPiutang += $value->total_debit;
        }

        $totalAktivaLancar = $totalKas + $totalPiutang + $totalBank;

        return view('laporan.neraca', compact('totalKas', 'totalBank', 'totalPiutang', 'totalAktivaLancar'));
    }
}
