<?php

namespace App\Http\Controllers;

use App\Exceptions\SameAkunException;
use App\Http\Requests\TransaksiAddRequest;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\TransaksiService;
use Exception;

class TransaksiController extends Controller
{

    private TransaksiRepository $transaksiRepository;
    private TransaksiService $transaksiService;
    private AkunRepository $akunRepository;


    public function __construct(TransaksiRepository $transaksiRepository, TransaksiService $transaksiService, AkunRepository $akunRepository)
    {
        $this->transaksiRepository = $transaksiRepository;
        $this->akunRepository = $akunRepository;
        $this->transaksiService = $transaksiService;
    }

    public function index()
    {
        $data = $this->transaksiRepository->getAllByTanggal();
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
            return redirect()->route('transaksi.create')->with('error', $e->getMessage());
        } catch (Exception $e) {
            return response()->view('errors.500', ['message' => 'Terjadi kesalahan pada server .'], 500);
        }
    }

    public function bukuBesar()
    {
        $title = 'Buku Besar';
        $akun = $this->akunRepository->getAll();
        return view('transaksi.buku-besar', compact('title', 'akun'));
    }
}
