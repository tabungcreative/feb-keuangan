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
            'nama', 'jenis_akun', 'saldo'
        ]);

        return $this->akunRepository->create($detailAkun);
    }


    function addSaldo(int $id, AkunUpdateSaldoRequest $request): Akun
    {
        $saldo = $request->input('saldo');

        // get last saldo
        $lastSaldo = $this->akunRepository->getSaldoById($id)->saldo;

        // adding saldo
        $newSaldo = $lastSaldo + $saldo;

        return $this->akunRepository->updateSaldoById($id, $newSaldo);
    }

    function subtractSaldo(int $id, AkunUpdateSaldoRequest $request): Akun
    {
        $saldo = $request->input('saldo');

        // get last saldo
        $lastSaldo = $this->akunRepository->getSaldoById($id)->saldo;

        // adding saldo
        $newSaldo = $lastSaldo - $saldo;

        return $this->akunRepository->updateSaldoById($id, $newSaldo);
    }



    function update(int $id, AkunUpdateRequest $request): Akun
    {
        $detailAkun = $request->only([
            'nama', 'jenis_akun'
        ]);

        $akun = $this->akunRepository->update($id, $detailAkun);

        return $akun;
    }
}
