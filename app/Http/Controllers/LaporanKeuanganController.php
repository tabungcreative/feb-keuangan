<?php

namespace App\Http\Controllers;

use App\Models\Transaksi;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\TransaksiService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class LaporanKeuanganController extends Controller
{
    //
    private AkunRepository $akunRepository;
    private TransaksiRepository $transaksiRepository;
    private TransaksiService $transaksiService;



    public function __construct(
        AkunRepository $akunRepository,
        TransaksiRepository $transaksiRepository,
        TransaksiService $transaksiService
    ) {
        $this->akunRepository = $akunRepository;
        $this->transaksiRepository = $transaksiRepository;
        $this->transaksiService = $transaksiService;
    }

    public function bukuBesar(Request $request)
    {
        $title = 'Buku Besar';
        $akun = $this->akunRepository->getAkunByAkunKasJalan();

        return view('transaksi.buku-besar', compact('title', 'akun'));
    }

    public function bukuBesarRinci()
    {
        $title = 'Perincian Buku Besar';
        $akun = $this->akunRepository->getAkunByIsNotAkunKasJalan();
        return view('transaksi.buku-besar-rinci', compact('title', 'akun'));
    }

    public function perubahanModal(Request $request)
    {
    }
}
