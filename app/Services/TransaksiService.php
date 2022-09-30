<?php

namespace App\Services;

use App\Http\Requests\TransaksiAddRequest;
use App\Models\Transaksi;

interface TransaksiService
{
    function add(TransaksiAddRequest $request);
}
