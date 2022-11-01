<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuBesarKasRequest;
use App\Models\Akun;
use App\Models\Transaksi;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\PencatatanService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BukuBesarController extends Controller
{
    private PencatatanService $pencatatanService;
    private AkunRepository $akunRepository;
    private TransaksiRepository $transaksiRepository;

    public function __construct(PencatatanService $pencatatanService, AkunRepository $akunRepository, TransaksiRepository $transaksiRepository)
    {
        $this->pencatatanService = $pencatatanService;
        $this->akunRepository = $akunRepository;
        $this->transaksiRepository = $transaksiRepository;
    }


    public function kas(BukuBesarKasRequest $request) {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('kas_jalan');
            $akunKasJalan = $this->akunRepository->getByAkunKas('kas_jalan');
            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->pencatatanService->bukuBesar('kas_jalan', $request);
            return view('buku-besar.kas', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        }catch (\Exception $exception) {
            abort(500);
        }
    }

    public function biaya(BukuBesarKasRequest $request) {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('kas_keluar');
            $akunKasJalan = $this->akunRepository->getByAkunKas('kas_keluar');
            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->pencatatanService->bukuBesar('kas_jalan', $request);
            return view('buku-besar.biaya', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        }catch (\Exception $exception) {
            abort(500);
        }
    }
    public function biaya2(Request $request) {
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

    public function pendapatan(BukuBesarKasRequest $request) {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('kas_masuk');
            $akunKasJalan = $this->akunRepository->getByAkunKas('kas_masuk');
            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->pencatatanService->bukuBesar('kas_jalan', $request);
            return view('buku-besar.pendapatan', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        }catch (\Exception $exception) {
            abort(500);
        }
    }
    public function pendapatan2(Request $request) {
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

            $saldoAwalKas = $this->pencatatanService->saldoAwal($dateStart, $dateEnd, $akun->id);

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
            $queryTransaksi = $this->transaksiRepository->getByAkunId($akun->id, $month, $year);

            // memsukan transaksi kedalam arrat
            $listTransaksi[] = $queryTransaksi;
            // inisialisasi total debit dan kredit
            $totalDebit = $this->transaksiRepository->sumByAkun($akun->id, $month, $year, 'debit');
            $totalKredit = $this->transaksiRepository->sumByAkun($akun->id, $month, $year, 'kredit');

            $listTotalDebit[] = $totalDebit;
            $listTotalKredit[] = $totalKredit;

            // mengisi array saldo kas awal dari transaksi pertama sampai transaksi bulan lalu
            $saldoAwal = $this->pencatatanService->saldoAwal($dateStart, $dateEnd, $akun->id);

            $listSaldoAwalKas[] = $saldoAwal;
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
