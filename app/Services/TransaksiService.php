<?php

namespace App\Services;

use App\Http\Requests\TransaksiAddRequest;
use App\Http\Requests\TransaksiUpdateRequest;

interface TransaksiService
{
    function add(TransaksiAddRequest $request);
    function update($kodeTransaksi, TransaksiUpdateRequest $request);
}
