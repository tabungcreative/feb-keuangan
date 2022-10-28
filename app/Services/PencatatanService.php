<?php

namespace App\Services;

interface PencatatanService
{
    function saldoAwal($dateStart, $dateEnd, $akunId);
    function bukuBesar($akunKas) : array;
}
