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

    function getSaldoAwalById($id): Akun
    {
        return Akun::select('id', 'saldo_awal')->whereId($id)->first();
    }

    function updateSaldoAwalById(int $id, int $saldoAwal): Akun
    {
        $akun = Akun::select('id', 'saldo_awal')->whereId($id)->first();
        $akun->saldo_awal = $saldoAwal;
        $akun->save();

        return $akun;
    }

    function getAkunByAkunKasMasuk()
    {
        return Akun::where('akun_kas', 'kas_masuk')->get();
    }

    function getAkunOrderByAkunKas()
    {
        return Akun::orderBy('akun_kas', 'DESC')->get();
    }

    function getAkunByAkunKasJalan()
    {
        return Akun::where('akun_kas', 'kas_jalan')->get();
    }
}
