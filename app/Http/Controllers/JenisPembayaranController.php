<?php

namespace App\Http\Controllers;

use App\Exceptions\InvariantExceotion;
use App\Http\Requests\JenisPembayaranAddRequest;
use App\Services\JenisPembayaranService;
use Illuminate\Http\Request;

class JenisPembayaranController extends Controller
{
    private JenisPembayaranService $jenisPembayaranService;

    public function __construct(JenisPembayaranService $jenisPembayaranService)
    {
        $this->jenisPembayaranService = $jenisPembayaranService;
    }

    public function index()
    {
        return view('index');
    }

    public function store(JenisPembayaranAddRequest $request)
    {
        try {
            $this->jenisPembayaranService->add($request);
            return redirect()->route('jenis-pembayaran.index')->with('success', 'Jenis pembayaran berhasil ditambahkan');
        } catch (InvariantExceotion $e) {
            return redirect()->route('jenis-pembayaran.index')->with('error', $e->getMessage());
        }
    }
}
