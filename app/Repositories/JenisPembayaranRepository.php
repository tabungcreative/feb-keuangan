<?php

namespace App\Repositories;

use App\Models\JenisPembayaran;

interface JenisPembayaranRepository
{
    function getAll();
    function create(array $detail): JenisPembayaran;
    function update(int $id, array $detail): JenisPembayaran;
    function delete(int $id);
    function findById(int $id): JenisPembayaran;
}
