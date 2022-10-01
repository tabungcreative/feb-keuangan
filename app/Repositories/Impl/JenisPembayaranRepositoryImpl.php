<?php

namespace App\Repositories\Impl;

use App\Models\JenisPembayaran;
use App\Repositories\JenisPembayaranRepository;

class JenisPembayaranRepositoryImpl implements JenisPembayaranRepository
{


    function getAll()
    {
        return JenisPembayaran::orderBy('created_at', 'DESC')->get();
    }

    function create(array $detail): JenisPembayaran
    {
        $jenisPembayaran = new JenisPembayaran($detail);
        $jenisPembayaran->save();
        return $jenisPembayaran;
    }

    function update(int $id, array $detail): JenisPembayaran
    {
        JenisPembayaran::whereId($id)->update($detail);
        return JenisPembayaran::find($id);
    }

    function delete(int $id)
    {
        JenisPembayaran::destroy($id);
    }

    function findById(int $id): JenisPembayaran
    {
        return JenisPembayaran::find($id);
    }
}
