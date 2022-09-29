<?php

namespace App\Http\Controllers;

use App\Http\Requests\AkunAddRequest;
use App\Http\Requests\AkunUpdateRequest;
use App\Http\Requests\AkunUpdateSaldoRequest;
use App\Repositories\AkunRepository;
use App\Repositories\JenisPembayaranRepository;
use App\Services\AkunService;
use Illuminate\Support\Arr;

class AkunController extends Controller
{
    private AkunRepository $akunRepository;
    private AkunService $akunService;
    private JenisPembayaranRepository $jenisPembayaranRepository;


    public function __construct(
        AkunRepository $akunRepository,
        AkunService $akunService,
        JenisPembayaranRepository $jenisPembayaranRepository
    ) {
        $this->akunRepository = $akunRepository;
        $this->akunService = $akunService;
        $this->jenisPembayaranRepository = $jenisPembayaranRepository;
    }

    public function index()
    {
        $jenisPembayarans = $this->jenisPembayaranRepository->getAll();
        $jenisPembayaran = [];
        foreach ($jenisPembayarans as $value) {
            $jenisPembayaran[] = $value->nama;
        }
        $data = $this->akunRepository->getAll();
        return view('akun.index', compact('data', 'jenisPembayaran'));
    }

    public function store(AkunAddRequest $request)
    {
        try {
            $this->akunService->add($request);
            return redirect()->route('akun.index')->with('success', 'Akun berhasil ditambahkan');
        } catch (\Exception $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    public function updateSaldo(AkunUpdateSaldoRequest $request)
    {
        try {
            $akunId = $request->input('akun_id');
            $typeUpdate = $request->input('update_type');
            if ($typeUpdate == 'add') {
                $this->akunService->addSaldo($akunId, $request);
            } else {
                $this->akunService->subtractSaldo($akunId, $request);
            }
            return redirect()->route('akun.index')->with('success', 'Saldo berhasil terupdate');
        } catch (\Exception $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $data = $this->akunRepository->findById($id);
        return view('akun.edit', compact('data'));
    }

    public function update(AkunUpdateRequest $request, $id)
    {
        try {
            $this->akunService->update($id, $request);
            return redirect()->route('akun.index')->with('success', 'Akun berhasi diubah');
        } catch (\Exception $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }
}
