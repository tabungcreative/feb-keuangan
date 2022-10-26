<?php

namespace App\Services;

use App\Http\Requests\AktivaAddRequest;
use App\Http\Requests\AktivaUpdateRequest;
use App\Models\Aktiva;

interface AktivaService
{
    function add(AktivaAddRequest $request): Aktiva;
    function update(AktivaUpdateRequest $request, int $id): Aktiva;
    function deletion(int $id): void;
    function delete(int $id): void;
}
