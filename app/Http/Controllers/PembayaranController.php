<?php

namespace App\Http\Controllers;

use App\Exceptions\AkunNotFound;
use App\Exceptions\InvariantExceotion;
use App\Http\Requests\PembayaranAddRequest;
use App\Http\Requests\PembayaranCekNimRequest;
use App\Repositories\MahasiswaRepository;
use App\Services\MahasiswaService;
use App\Services\PembayaranService;

class PembayaranController extends Controller
{
    private PembayaranService $pembayaranService;
    private MahasiswaService $mahasiswaService;
    private MahasiswaRepository $mahasiswaRepository;

    public function __construct(
        PembayaranService $pembayaranService,
        MahasiswaService $mahasiswaService
    ) {
        $this->pembayaranService = $pembayaranService;
        $this->mahasiswaService = $mahasiswaService;
    }

    public function index()
    {
        return 'pembayaran.index';
    }

    public function getCekNim()
    {
        return 'pembayaran.ceknim';
    }

    public function postCekNim(PembayaranCekNimRequest $request)
    {
        $nim = $request->input('nim');
        $cekNim = $this->mahasiswaService->checkNim($nim);
        if ($cekNim) {
            return redirect()->route('pembayaran.create')->with('success', 'Mahasiswa ditemukan');
        }
        return redirect()->route('pembayaran.post-cek-nim')->with('success', 'Mahasiswa tidak terdaftar');
    }

    public function create()
    {
        return 'pembayaran.create';
    }

    public function store(PembayaranAddRequest $request)
    {
        try {
            $nim = $request->input('nim');
            $cekNim = $this->mahasiswaService->checkNim($nim);
            if ($cekNim) {
                $pembayaran = $this->pembayaranService->add($request);
                return redirect()->route('pembayaran.detail', ['id' => $pembayaran->id])->with('success', 'pembayaran berhasil');
            }
            return redirect()->route('pembayaran.index')->with('error', 'Mahasiswa tidak ditemukan');
        } catch (AkunNotFound $e) {
            return redirect()->route('pembayaran.index')->with('error', $e->getMessage());
        } catch (InvariantExceotion $e) {
            return redirect()->route('pembayaran.index')->with('error', $e->getMessage());
        }
    }
}
