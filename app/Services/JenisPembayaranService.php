<?php

namespace App\Services;

use App\Http\Requests\JenisPembayaranAddRequest;
use App\Http\Requests\JenisPembayaranUpdateRequest;
use App\Models\JenisPembayaran;

interface JenisPembayaranService
{
    function add(JenisPembayaranAddRequest $request): JenisPembayaran;
    function update(int $id, JenisPembayaranUpdateRequest $request): JenisPembayaran;
}
