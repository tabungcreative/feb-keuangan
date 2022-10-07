<?php

namespace App\Repositories;

use App\Models\Transaksi;

interface TransaksiRepository
{
    function getAll();
    function getAllByMonthYear($date = null);
    function create(array $detailTransaksi, int $akunId): Transaksi;
    function update(int $id, array $detailTransaksi): Transaksi;
    function delete(int $id);
    function getById(int $id);
    function getWhereAkunKas($akunKas, $date = null);
    function getWhereAkunKasGroupByAkun($akunKas, $date = null);
}
