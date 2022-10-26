<?php

namespace App\Http\Controllers;

use App\Models\Akun;
use App\Models\Transaksi;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BukuBesarController extends Controller
{
    public function kas(Request $request) {
        // mendapatkan bulan dan tahun dari request
        list($yearMounth, $akunId) = $this->mendapatkanBulanDanTahunDariRequest($request);
        list($dateStart, $dateEnd, $month, $year) = $this->mendapatTanggalTransaksi($yearMounth);

        // get akun where akun kas jalan
        $akunKasJalan = Akun::where('akun_kas', 'kas_jalan')->orWhere('akun_kas', 'kas_bank')
            ->get();
        list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->inisialisasiKebutuhaView($akunKasJalan, $month, $year, $dateStart, $dateEnd);

        return view('buku-besar.kas', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi'));
    }

    public function biaya(Request $request) {
        // mendapatkan bulan dan tahun dari request
        list($yearMounth, $akunId) = $this->mendapatkanBulanDanTahunDariRequest($request);

        // mendapat tanggal transaksi pertama
        list($dateStart, $dateEnd, $month, $year) = $this->mendapatTanggalTransaksi($yearMounth);

        // get akun where akun kas jalan
        $listAkun = Akun::where('akun_kas', 'kas_keluar')->get();
        $akunKasJalan = Akun::where('akun_kas', 'kas_keluar')->get();
        if ($akunId != null) {
            $akunKasJalan = Akun::where('id', $akunId)
                ->get();
        }

        // inisialisasi kebutuha view
        list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->inisialisasiKebutuhaView($akunKasJalan, $month, $year, $dateStart, $dateEnd);

        return view('buku-besar.biaya', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
    }

    public function pendapatan(Request $request) {
        list($yearMounth, $akunId) = $this->mendapatkanBulanDanTahunDariRequest($request);

        // mendapat tanggal transaksi pertama
        list($dateStart, $dateEnd, $month, $year) = $this->mendapatTanggalTransaksi($yearMounth);

        // get akun where akun kas jalan
        $listAkun = Akun::where('akun_kas', 'kas_masuk')->get();
        $akunKasJalan = Akun::where('akun_kas', 'kas_masuk')->get();
        if ($akunId != null) {
            $akunKasJalan = Akun::where('id', $akunId)
                ->get();
        }

        // inisialisasi kebutuha view
        list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->inisialisasiKebutuhaView($akunKasJalan, $month, $year, $dateStart, $dateEnd);

        return view('buku-besar.pendapatan', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
    }

    public function modal(Request $request) {
        // mendapatkan bulan dan tahun dari request
        list($yearMounth, $akunId) = $this->mendapatkanBulanDanTahunDariRequest($request);

        // mendapat tanggal transaksi pertama
        list($dateStart, $dateEnd, $month, $year) = $this->mendapatTanggalTransaksi($yearMounth);

        // get akun where akun kas jalan
        $listAkun = Akun::where('akun_kas', 'modal')->get();
        $akunKasJalan = Akun::where('akun_kas', 'modal')->get();
        if ($akunId != null) {
            $akunKasJalan = Akun::where('id', $akunId)
                ->get();
        }

        // inisialisasi kebutuha view
        list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->inisialisasiKebutuhaView($akunKasJalan, $month, $year, $dateStart, $dateEnd);

        return view('buku-besar.modal', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
    }
    public function hutang(Request $request) {
        // mendapatkan bulan dan tahun dari request
        list($yearMounth, $akunId) = $this->mendapatkanBulanDanTahunDariRequest($request);

        // mendapat tanggal transaksi pertama
        list($dateStart, $dateEnd, $month, $year) = $this->mendapatTanggalTransaksi($yearMounth);

        // get akun where akun kas jalan
        $listAkun = Akun::where('akun_kas', 'hutang')->get();
        $akunKasJalan = Akun::where('akun_kas', 'hutang')->get();
        if ($akunId != null) {
            $akunKasJalan = Akun::where('id', $akunId)
                ->get();
        }

        // inisialisasi kebutuha view
        // inisialisasi kebutuha view
        $listTotalDebit = [];
        $listTotalKredit = [];
        $listSaldoAwalKas = [];
        $listTransaksi = [];

        // iterasi akun kas jalan
        foreach ($akunKasJalan as $akun) {
            // query mendapatkan transaksi berdasarkan akun
            $queryTransaksi = Transaksi::where('akun_id', $akun->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->orderBy('tanggal', 'ASC')->get();

            // memsukan transaksi kedalam arrat
            $listTransaksi[] = $queryTransaksi;
            // inisialisasi total debit dan kredit
            $totalDebit = 0;
            $totalKredit = 0;

            // iterasi menambah debit dan kredit
            foreach ($queryTransaksi as $transaksi) {
                $totalDebit += $transaksi->debit;
                $totalKredit += $transaksi->kredit;
            }

            $listTotalDebit[] = $totalDebit;
            $listTotalKredit[] = $totalKredit;

            // mengisi array saldo kas awal dari transaksi pertama sampai transaksi bulan lalu

            $saldoAwalKas = 0;

            $transaksiOld = Transaksi::select('id', 'debit', 'tanggal', 'kredit', 'akun_id')
                ->whereBetween('tanggal', [$dateStart, $dateEnd])->where('akun_id', $akun->id)->get();

            foreach ($transaksiOld as $value) {
                $saldoAwalKas += $akun->saldo_awal + ($value->kredit - $value->debit);
            }

            $listSaldoAwalKas[] = $saldoAwalKas;
        }
        return view('buku-besar.hutang', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
    }
    public function piutang(Request $request) {
        // mendapatkan bulan dan tahun dari request
        list($yearMounth, $akunId) = $this->mendapatkanBulanDanTahunDariRequest($request);

        // mendapat tanggal transaksi pertama
        list($dateStart, $dateEnd, $month, $year) = $this->mendapatTanggalTransaksi($yearMounth);

        // get akun where akun kas jalan
        $listAkun = Akun::where('akun_kas', 'piutang')->get();
        $akunKasJalan = Akun::where('akun_kas', 'piutang')->get();
        if ($akunId != null) {
            $akunKasJalan = Akun::where('id', $akunId)
                ->get();
        }

        // inisialisasi kebutuha view
        list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->inisialisasiKebutuhaView($akunKasJalan, $month, $year, $dateStart, $dateEnd);

        return view('buku-besar.piutang', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
    }






    /**
     * @param Request $request
     * @return array
     */
    public function mendapatkanBulanDanTahunDariRequest(Request $request): array
    {
        // mendapatkan bulan dan tahun dari request
        $yearMounth = $request->query('bulan');
        $akunId = $request->query('akun_id');

        // jika tidak ada bulan dan tahun akan default now
        if ($yearMounth == null) {
            $yearMounth = Carbon::now()->format('Y-m');
        }
        return array($yearMounth, $akunId);
    }

    /**
     * @param $akunKasJalan
     * @param int $month
     * @param int $year
     * @param $dateStart
     * @param string $dateEnd
     * @return array[]
     */
    public function inisialisasiKebutuhaView($akunKasJalan, int $month, int $year, $dateStart, string $dateEnd): array
    {
        // inisialisasi kebutuha view
        $listTotalDebit = [];
        $listTotalKredit = [];
        $listSaldoAwalKas = [];
        $listTransaksi = [];

        // iterasi akun kas jalan
        foreach ($akunKasJalan as $akun) {
            // query mendapatkan transaksi berdasarkan akun
            $queryTransaksi = Transaksi::where('akun_id', $akun->id)
                ->whereMonth('tanggal', $month)
                ->whereYear('tanggal', $year)
                ->orderBy('tanggal', 'ASC')->get();

            // memsukan transaksi kedalam arrat
            $listTransaksi[] = $queryTransaksi;
            // inisialisasi total debit dan kredit
            $totalDebit = 0;
            $totalKredit = 0;

            // iterasi menambah debit dan kredit
            foreach ($queryTransaksi as $transaksi) {
                $totalDebit += $transaksi->debit;
                $totalKredit += $transaksi->kredit;
            }

            $listTotalDebit[] = $totalDebit;
            $listTotalKredit[] = $totalKredit;

            // mengisi array saldo kas awal dari transaksi pertama sampai transaksi bulan lalu

            $saldoAwalKas = 0;

            $transaksiOld = Transaksi::select('id', 'debit', 'tanggal', 'kredit', 'akun_id')
                ->whereBetween('tanggal', [$dateStart, $dateEnd])->where('akun_id', $akun->id)->get();

            foreach ($transaksiOld as $value) {
                $saldoAwalKas += $akun->saldo_awal + ($value->debit - $value->kredit);
            }

            $listSaldoAwalKas[] = $saldoAwalKas;
        }
        return array($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi);
    }

    /**
     * @param $yearMounth
     * @return array
     */
    public function mendapatTanggalTransaksi($yearMounth): array
    {
// mendapat tanggal transaksi
        $dateStart = Transaksi::orderBy('tanggal', 'ASC')->first()->tanggal ?? null;
        $dateEnd = Carbon::createFromFormat('Y-m', $yearMounth)->subMonth(1)->lastOfMonth()->format('Y-m-d');
        $month = Carbon::createFromFormat('Y-m', $yearMounth)->month;
        $year = Carbon::createFromFormat('Y-m', $yearMounth)->year;
        return array($dateStart, $dateEnd, $month, $year);
    }
}
