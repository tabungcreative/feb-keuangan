<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantExceotion;
use App\Http\Requests\JenisPembayaranAddRequest;
use App\Http\Requests\JenisPembayaranUpdateRequest;
use App\Models\JenisPembayaran;
use App\Repositories\JenisPembayaranRepository;
use App\Services\JenisPembayaranService;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    private JenisPembayaranService $jenisPembayaranService;
    private JenisPembayaranRepository $jenisPembayaranRepository;


    public function __construct(
        JenisPembayaranService $jenisPembayaranService,
        JenisPembayaranRepository $jenisPembayaranRepository
    ) {
        $this->jenisPembayaranService = $jenisPembayaranService;
        $this->jenisPembayaranRepository = $jenisPembayaranRepository;
    }

    public function index()
    {
        $data = $this->jenisPembayaranRepository->getAll();
        return view('jenis-pembayaran.index', compact('data'));
    }


    public function update(JenisPembayaranUpdateRequest $request, $id)
    {
        try {
            $this->jenisPembayaranService->update($id, $request);
            return redirect()->route('jenis-pembayaran.index')->with('success', 'Jenis pembayaran berhasil ditambahkan');
        } catch (InvariantExceotion $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    public function store(JenisPembayaranAddRequest $request)
    {
        try {
            $this->jenisPembayaranService->add($request);
            return redirect()->route('jenis-pembayaran.index')->with('success', 'Jenis pembayaran berhasil ditambahkan');
        } catch (InvariantExceotion $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $data = $this->jenisPembayaranRepository->findById($id);
        return view('jenis-pembayaran.edit', compact('data'));
    }
}
