<?php

namespace App\Repositories\Impl;

use App\Models\JenisPembayaran;
use App\Models\Pembayaran;
use App\Repositories\PembayaranRepository;

class PembayaranRepositoryImpl implements PembayaranRepository
{

    function getAll()
    {
        return Pembayaran::orderBy('created_at', 'DESC')->get();
    }

    function create(array $detailPembayaran, int $jenisPembayaranId): Pembayaran
    {
        $jenisPembayaran = JenisPembayaran::findOrFail($jenisPembayaranId);
        $pembayaran = new Pembayaran($detailPembayaran);
        $jenisPembayaran->pembayaran()->save($pembayaran);
        return $pembayaran;
    }

    function update(int $id, array $detailPembayaran): Pembayaran
    {
        throw new \Exception("Method not implemented");
    }

    function delete(int $id)
    {
        throw new \Exception("Method not implemented");
    }

    function findById(int $id): Pembayaran
    {
        return Pembayaran::find($id);
    }

    function findByNoPembayaran(string $nomerPembayaran): ?Pembayaran
    {
        return Pembayaran::where('no_pembayaran', $nomerPembayaran)->first();
    }
}
