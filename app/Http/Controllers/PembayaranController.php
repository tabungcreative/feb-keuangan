<?php

namespace App\Http\Controllers;

use App\Exceptions\AkunNotFound;
use App\Exceptions\InvariantExceotion;
use App\Exceptions\SameAkunException;
use App\Http\Requests\PembayaranAddRequest;
use App\Http\Requests\PembayaranCekNimRequest;
use App\Repositories\AkunRepository;
use App\Repositories\JenisPembayaranRepository;
use App\Repositories\MahasiswaRepository;
use App\Repositories\PembayaranRepository;
use App\Services\MahasiswaService;
use App\Services\PembayaranService;

class PembayaranController extends Controller
{
    private PembayaranService $pembayaranService;
    private PembayaranRepository $pembayaranRepository;
    private MahasiswaService $mahasiswaService;
    private MahasiswaRepository $mahasiswaRepository;
    private JenisPembayaranRepository $jenisPembayaranRepository;
    private AkunRepository $akunRepository;



    public function __construct(
        PembayaranService $pembayaranService,
        PembayaranRepository $pembayaranRepository,
        MahasiswaService $mahasiswaService,
        MahasiswaRepository $mahasiswaRepository,
        JenisPembayaranRepository $jenisPembayaranRepository,
        AkunRepository $akunRepository
    ) {
        $this->pembayaranService = $pembayaranService;
        $this->pembayaranRepository = $pembayaranRepository;
        $this->mahasiswaService = $mahasiswaService;
        $this->mahasiswaRepository = $mahasiswaRepository;
        $this->jenisPembayaranRepository = $jenisPembayaranRepository;
        $this->akunRepository = $akunRepository;
    }

    public function index()
    {
        return 'pembayaran.index';
    }

    public function getCekNim()
    {
        return view('pembayaran.cek-nim');
    }

    public function postCekNim(PembayaranCekNimRequest $request)
    {
        $nim = $request->input('nim');
        $cekNim = $this->mahasiswaService->checkNim($nim);
        if ($cekNim) {
            return redirect()->route('pembayaran.create', $nim)->with('success', 'Mahasiswa ditemukan');
        }
        return redirect()->route('pembayaran.post-cek-nim')->with('error', 'Mahasiswa tidak terdaftar');
    }

    public function create($nim)
    {
        $jenisPembayaran = $this->jenisPembayaranRepository->getAll();
        $mahasiswa = $this->mahasiswaRepository->findByNim($nim);
        $akun = $this->akunRepository->getAll();
        return view('pembayaran.create', compact('mahasiswa', 'jenisPembayaran', 'akun'));
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
        } catch (InvariantExceotion $e) {
            return redirect()->route('pembayaran.create', $nim)->with('error', $e->getMessage());
        } catch (\Exception $e) {
            return response()->view('errors.500', ['message' => 'Terjadi kesalahan pada server .'], 500);
        }
    }

    public function detail($id)
    {
        $pembayaran = $this->pembayaranRepository->findById($id);
        $mahasiswa = $this->mahasiswaRepository->findByNim($pembayaran->nim);
        return view('pembayaran.show', compact('mahasiswa', 'pembayaran'));
    }
}
