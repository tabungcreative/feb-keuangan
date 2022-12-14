<?php

namespace App\Repositories;

use App\Models\Transaksi;

interface TransaksiRepository
{
    function getAll();
    function getAllByMonthYear($date = null);
    function getBetweenTanggalAndAkun($dateStart, $dateEnd, $akunId);
    function create(array $detailTransaksi, int $akunId): Transaksi;
    function update(int $id, array $detailTransaksi): Transaksi;
    function updateByKodeAndAkun($kodeTransaksi, $akunId, array $detailTransaksi): Transaksi;
    function delete(int $id);
    function deleteByKode($kode);
    function getById(int $id);
    function getByAkunKas($akunKas, $date = null);
    function getByAkunId($akunId, $month = null, $year = null);
    function getByAkunKasGroupByAkun($akunKas, $date = null);
    function findByCode($kode): ?Transaksi;
    function sumByAkun($akunId, $month, $year, $field);
    function findFirstOrderTanggal();
    function findFirstOrderTanggalByAkunId($akunId);
}
