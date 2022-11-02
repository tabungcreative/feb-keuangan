<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuBesarBiayaRequest;
use App\Http\Requests\BukuBesarHutangRequest;
use App\Http\Requests\BukuBesarKasRequest;
use App\Http\Requests\BukuBesarModalRequest;
use App\Http\Requests\BukuBesarPendapatanRequest;
use App\Http\Requests\BukuBesarPiutangRequest;
use App\Repositories\AkunRepository;
use App\Services\BukuBesarService;

class BukuBesarController extends Controller
{
    private BukuBesarService $bukuBesarService;
    private AkunRepository $akunRepository;

    public function __construct(BukuBesarService $bukuBesarService, AkunRepository $akunRepository)
    {
        $this->bukuBesarService = $bukuBesarService;
        $this->akunRepository = $akunRepository;
    }


    public function kas(BukuBesarKasRequest $request)
    {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('kas_jalan');
            $akunID = $request->get('akun_id');

            $akunKasJalan = $this->akunRepository->getByAkunKas('kas_jalan');

            if ($akunID != null) {
                $akunKasJalan = $this->akunRepository->getById($akunID);
            }

            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->bukuBesarService->bukuBesarKas($request);
            return view('buku-besar.kas', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function biaya(BukuBesarBiayaRequest $request)
    {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('kas_keluar');
            $akunID = $request->get('akun_id');

            $akunKasJalan = $this->akunRepository->getByAkunKas('kas_keluar');

            if ($akunID != null) {
                $akunKasJalan = $this->akunRepository->getById($akunID);
            }

            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->bukuBesarService->bukuBesarBiaya($request);
            return view('buku-besar.biaya', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function pendapatan(BukuBesarPendapatanRequest $request)
    {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('kas_masuk');
            $akunID = $request->get('akun_id');

            $akunKasJalan = $this->akunRepository->getByAkunKas('kas_masuk');

            if ($akunID != null) {
                $akunKasJalan = $this->akunRepository->getById($akunID);
            }

            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->bukuBesarService->bukuBesarPendapatan($request);
            return view('buku-besar.pendapatan', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function modal(BukuBesarModalRequest $request)
    {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('modal');
            $akunID = $request->get('akun_id');

            $akunKasJalan = $this->akunRepository->getByAkunKas('modal');

            if ($akunID != null) {
                $akunKasJalan = $this->akunRepository->getById($akunID);
            }

            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->bukuBesarService->bukuBesarModal($request);
            return view('buku-besar.modal', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function hutang(BukuBesarHutangRequest $request)
    {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('hutang');
            $akunID = $request->get('akun_id');

            $akunKasJalan = $this->akunRepository->getByAkunKas('hutang');

            if ($akunID != null) {
                $akunKasJalan = $this->akunRepository->getById($akunID);
            }

            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->bukuBesarService->bukuBesarHutang($request);
            return view('buku-besar.hutang', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }

    public function piutang(BukuBesarPiutangRequest $request)
    {
        try {
            $listAkun = $this->akunRepository->getByAkunKas('piutang');
            $akunID = $request->get('akun_id');

            $akunKasJalan = $this->akunRepository->getByAkunKas('piutang');

            if ($akunID != null) {
                $akunKasJalan = $this->akunRepository->getById($akunID);
            }

            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->bukuBesarService->bukuBesarPiutang($request);
            return view('buku-besar.piutang', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'listAkun'));
        } catch (\Exception $exception) {
            abort(500);
        }
    }
}
