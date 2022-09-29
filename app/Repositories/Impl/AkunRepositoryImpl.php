<?php

namespace App\Repositories\Impl;

use App\Models\Akun;
use App\Repositories\AkunRepository;

class AkunRepositoryImpl implements AkunRepository
{

    function getAll()
    {
        return Akun::orderBy('created_at', 'DESC')->get();
    }

    function create(array $detailAkun): Akun
    {
        $akun = new Akun($detailAkun);
        $akun->save();
        return $akun;
    }

    function update(int $id, array $detailAkun): Akun
    {
        $akun = Akun::find($id);
        $akun->update($detailAkun);
        $akun->save();
        return $akun;
    }

    function delete(int $id)
    {
        throw new \Exception("Method not implemented");
    }

    function findById(int $id)
    {
        return Akun::findOrFail($id);
    }

    function findByNama(string $nama)
    {
        return Akun::where('nama', $nama)->first();
    }

    function getSaldoById($id): Akun
    {
        return Akun::select('id', 'saldo')->whereId($id)->first();
    }

    function updateSaldoById(int $id, int $saldo): Akun
    {
        $akun = Akun::select('id', 'saldo')->whereId($id)->first();
        $akun->saldo = $saldo;
        $akun->save();

        return $akun;
    }
}
