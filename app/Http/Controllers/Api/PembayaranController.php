<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Repositories\PembayaranRepository;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    private PembayaranRepository $pembayaranRepository;

    public function __construct(PembayaranRepository $pembayaranRepository)
    {
        $this->pembayaranRepository = $pembayaranRepository;
    }

    public function index()
    {
        $pembayaran = $this->pembayaranRepository->getAll();
        return response()->json([
            'status' => true,
            'message' => 'data ditemukan',
            'data' => $pembayaran,
        ]);
    }

    public function showNoPembayaran($noPembayaran)
    {

        try {
            $pembayaran = $this->pembayaranRepository->findByNoPembayaran($noPembayaran);

            if ($pembayaran == null) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data tidak ditemukan ',
                ], 404);
            }

            return response()->json([
                'status' => true,
                'data' => $pembayaran,
            ], 200);
        } catch (\Exception  $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi masalah pada server ',
            ], 500);
        }
    }
}
