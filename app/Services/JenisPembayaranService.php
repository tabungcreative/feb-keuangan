<?php

namespace App\Services;

use App\Http\Requests\JenisPembayaranAddRequest;
use App\Models\JenisPembayaran;

interface JenisPembayaranService {
    function add(JenisPembayaranAddRequest $request): JenisPembayaran;
}