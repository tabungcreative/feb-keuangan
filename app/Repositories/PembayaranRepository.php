<?php

namespace App\Repositories;

use App\Models\Pembayaran;

interface PembayaranRepository
{
    function getAll();
    function create(array $detailPembayaran, int $jenisPembayaranId): Pembayaran;
    function update(int $id, array $detailPembayaran): Pembayaran;
    function delete(int $id);
    function findById(int $id): Pembayaran;
}
