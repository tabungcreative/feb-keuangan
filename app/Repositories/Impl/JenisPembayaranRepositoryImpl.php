<?php

namespace App\Repositories\Impl;

use App\Models\JenisPembayaran;
use App\Repositories\JenisPembayaranRepository;

class JenisPembayaranRepositoryImpl implements JenisPembayaranRepository {
    

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
    
    function update(int $id, array $detail)
    {
        return JenisPembayaran::whereId($id)->update($detail);
    }
    
    function delete(int $id)
    {
        JenisPembayaran::destroy($id);
    }
        
}