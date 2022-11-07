<?php

namespace App\Services;

use App\Http\Requests\LaporanCatatanAtasKeuanganRequest;
use App\Http\Requests\LaporanLabaRugiRequest;
use App\Http\Requests\LaporanNeracaRequest;
use App\Http\Requests\LaporanPerubahanModalRequest;

interface LaporanService
{
    function catatanAtasKeuangan(LaporanCatatanAtasKeuanganRequest $request);
    function labaRugi($yearMonth);
    function perubahanModal(LaporanPerubahanModalRequest $request);
    function neraca(LaporanNeracaRequest $request);
}
