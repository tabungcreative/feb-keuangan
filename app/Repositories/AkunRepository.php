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
    function getSaldoById($id): Akun;
    function updateSaldoById(int $id, int $saldo): Akun;
}
