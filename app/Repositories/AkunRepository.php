<?php

namespace App\Repositories;

use App\Models\Akun;

interface AkunRepository
{
    function getAll();
    function create(array $detailAkun): Akun;
    function update(int $id, array $detailAkun): Akun;
    function delete(int $id);
    function findById(int $id);
    function findByNama(string $name);
    function getByAkunKas($akunKas);
    function getById($akunKas);
    function getSaldoAwalById($id): Akun;
    function updateSaldoAwalById(int $id, int $saldoAwal): Akun;
    function getAkunByAkunKasMasuk();
    function getAkunOrderByAkunKas();
    function getAkunByAkunKasJalan();
    function getAkunByIsNotAkunKasJalan();


}
