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
        throw new \Exception("Method not implemented");
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
}
