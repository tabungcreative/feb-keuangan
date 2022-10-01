<?php

namespace App\Services;

use App\Http\Requests\PembayaranAddRequest;
use App\Models\Pembayaran;

interface PembayaranService
{
    function add(PembayaranAddRequest $request): Pembayaran;
}
