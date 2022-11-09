<?php

namespace App\Http\Controllers;

use App\Exceptions\KodeTransaksiCanotSame;
use App\Exceptions\SameAkunException;
use App\Http\Requests\TransaksiAddRequest;
use App\Http\Requests\TransaksiUpdateRequest;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\TransaksiService;
use App\Traits\ConvertBase64;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{

    use ConvertBase64;

    private TransaksiRepository $transaksiRepository;
    private TransaksiService $transaksiService;
    private AkunRepository $akunRepository;


    public function __construct(TransaksiRepository $transaksiRepository, TransaksiService $transaksiService, AkunRepository $akunRepository)
    {
        $this->transaksiRepository = $transaksiRepository;
        $this->akunRepository = $akunRepository;
        $this->transaksiService = $transaksiService;
    }

    public function index(Request $request)
    {
        $date = $request->query('bulan');
        $data = $this->transaksiRepository->getAllByMonthYear($date);
        return view('transaksi.index', compact('data'));
    }

    public function create()
    {
        $akun = $this->akunRepository->getAll();
        return view('transaksi.create', compact('akun'));
    }

    public function store(TransaksiAddRequest $request)
    {
        try {
            $this->transaksiService->add($request);
            return redirect()->route('transaksi.index')->with('success', 'Berhasil menambah transaksi');
        } catch (SameAkunException $e) {
            return redirect()->route('transaksi.create')->with('error', $e->getMessage())->withInput($request->all());
        }catch (KodeTransaksiCanotSame $e) {
                return redirect()->route('transaksi.create')->with('error', $e->getMessage())->withInput($request->all());
        } catch (Exception $e) {
            return response()->view('errors.500', ['message' => 'Terjadi kesalahan pada server .'], 500);
        }
    }

    public function edit($kode)
    {
        $transaksi = $this->transaksiRepository->findByCode($kode);
        $akun = $this->akunRepository->getAll();
        return view('transaksi.edit', compact('akun', 'transaksi'));
    }

    public function update(TransaksiUpdateRequest $request, $kode)
    {
        try {
            $this->transaksiService->update($kode, $request);
            return redirect()->route('transaksi.index')->with('success', 'Berhasil megubah transaksi');
        } catch (SameAkunException $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput($request->all());
        } catch (Exception $e) {
            return response()->view('errors.500', ['message' => 'Terjadi kesalahan pada server .'], 500);
        }
    }

    public function delete($kode) {
        try {
            $this->transaksiRepository->deleteByKode($kode);
            return redirect()->route('transaksi.index')->with('success', 'Berhasil menghapus transaksi');
        } catch (Exception $e) {
            return response()->view('errors.500', ['message' => 'Terjadi kesalahan pada server .'], 500);
        }
    }

    public function print(Request $request) {
        $title = 'Laporan Jurnal Transaksi - ' . Carbon::createFromFormat('Y-m', $request->year_month)->monthName ?? Carbon::now()->monthName;
        $transaksi = $this->transaksiRepository->getAllByMonthYear($request->year_month);
        $kop = $this->image('img/kop-feb.png');
        $footerKop = $this->image('img/footer-kop.png');

        $pdf = Pdf::loadView('transaksi.pdf', compact('transaksi',  'kop', 'footerKop', 'title'));

        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream($title);
    }


}
