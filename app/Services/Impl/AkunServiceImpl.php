<?php

namespace App\Services\Impl;

use App\Http\Requests\AkunAddRequest;
use App\Http\Requests\AkunUpdateRequest;
use App\Http\Requests\AkunUpdateSaldoRequest;
use App\Models\Akun;
use App\Repositories\AkunRepository;
use App\Services\AkunService;

class AkunServiceImpl implements AkunService
{

    private AkunRepository $akunRepository;

    public function __construct(AkunRepository $akunRepository)
    {
        $this->akunRepository = $akunRepository;
    }

    function add(AkunAddRequest $request): Akun
    {
        $detailAkun = $request->only([
            'nama', 'akun_kas', 'kode'
        ]);

        return $this->akunRepository->create($detailAkun);
    }


    function addSaldoAwal(int $id, AkunUpdateSaldoRequest $request): Akun
    {
        $saldoAwal = $request->input('saldo_awal');

        // get last saldo
        $lastSaldoAwal = $this->akunRepository->getSaldoAwalById($id)->saldo_awal;
        // adding saldo
        $newSaldoAwal = $lastSaldoAwal + $saldoAwal;

        return $this->akunRepository->updateSaldoAwalById($id, $newSaldoAwal);
    }

    function subtractSaldoAwal(int $id, AkunUpdateSaldoRequest $request): Akun
    {
        $saldoAwal = $request->input('saldo_awal');

        // get last saldo
        $lastSaldoAwal = $this->akunRepository->getSaldoAwalById($id)->saldo_awal;

        // adding saldo
        $newSaldo = $lastSaldoAwal - $saldoAwal;

        return $this->akunRepository->updateSaldoAwalById($id, $newSaldo);
    }



    function update(int $id, AkunUpdateRequest $request): Akun
    {
        $detailAkun = $request->only([
            'nama', 'jenis_akun', 'kode'
        ]);

        $akun = $this->akunRepository->update($id, $detailAkun);

        return $akun;
    }
}
