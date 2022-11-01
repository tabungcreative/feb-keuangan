<?php

namespace App\Services;

use App\Http\Requests\BukuBesarKasRequest;

interface PencatatanService
{
    function saldoAwal($dateStart, $dateEnd, $akunId);
    function bukuBesar($akunKas, BukuBesarKasRequest $request) : array;
}
