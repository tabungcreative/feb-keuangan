<?php

namespace App\Services;

use App\Http\Requests\AkunAddRequest;
use App\Http\Requests\AkunUpdateRequest;
use App\Http\Requests\AkunUpdateSaldoRequest;
use App\Models\Akun;

interface AkunService
{
    function add(AkunAddRequest $request): Akun;
    function addSaldo(int $id, AkunUpdateSaldoRequest $request): Akun;
    function subtractSaldo(int $id, AkunUpdateSaldoRequest $request): Akun;
    function update(int $id, AkunUpdateRequest $request): Akun;
}
