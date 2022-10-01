<?php

namespace App\Services;

use App\Http\Requests\AkunAddRequest;
use App\Http\Requests\AkunUpdateRequest;
use App\Http\Requests\AkunUpdateSaldoRequest;
use App\Models\Akun;

interface AkunService
{
    function add(AkunAddRequest $request): Akun;
    function addSaldoAwal(int $id, AkunUpdateSaldoRequest $request): Akun;
    function subtractSaldoAwal(int $id, AkunUpdateSaldoRequest $request): Akun;
    function update(int $id, AkunUpdateRequest $request): Akun;
}
