<?php

namespace App\Http\Controllers;

use App\Exceptions\AkunNotFound;
use App\Exceptions\InvariantExceotion;
use App\Http\Requests\PembayaranAddRequest;
use App\Repositories\MahasiswaRepository;
use App\Services\MahasiswaService;
use App\Services\PembayaranService;

class PembayaranController extends Controller
{
    private PembayaranService $pembayaranService;
    private MahasiswaService $mahasiswaService;

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

    public function store(PembayaranAddRequest $request)
    {
        try {
            $nim = $request->input('nim');
            $cekNim = $this->mahasiswaService->checkNim($nim);
            if ($cekNim) {
                $this->pembayaranService->add($request);
                return redirect()->route('pembayaran.index')->with('success', 'pembayaran berhasil');
            }
            return redirect()->route('pembayaran.index')->with('error', 'Mahasiswa tidak ditemukan');
        } catch (AkunNotFound $e) {
            return redirect()->route('pembayaran.index')->with('error', $e->getMessage());
        } catch (InvariantExceotion $e) {
            return redirect()->route('pembayaran.index')->with('error', $e->getMessage());
        }
    }
}
