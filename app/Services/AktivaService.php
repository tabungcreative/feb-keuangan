<?php

namespace App\Services;

use App\Http\Requests\AktivaAddRequest;
use App\Models\Aktiva;

interface AktivaService
{
    function add(AktivaAddRequest $request): Aktiva;
}
