<?php

namespace App\Repositories\Impl;

use App\Models\Akun;
use App\Models\Transaksi;
use App\Repositories\TransaksiRepository;

class TransaksiRepositoryImpl implements TransaksiRepository
{

    function getAll()
    {
        throw new \Exception("Method not implemented");
    }

    function create(array $detailTransaksi, int $akunId): Transaksi
    {
        $akun = Akun::findOrFail($akunId);
        $transaksi = new Transaksi($detailTransaksi);
        $akun->transaksi()->save($transaksi);
        return $transaksi;
    }

    function update(int $id, array $detailTransaksi): Transaksi
    {
        throw new \Exception("Method not implemented");
    }

    function delete(int $id)
    {
        throw new \Exception("Method not implemented");
    }

    function getById(int $id)
    {
        throw new \Exception("Method not implemented");
    }
}
