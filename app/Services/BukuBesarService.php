<?php

namespace App\Services;

use App\Http\Requests\BukuBesarBankRequest;
use App\Http\Requests\BukuBesarBiayaRequest;
use App\Http\Requests\BukuBesarHutangRequest;
use App\Http\Requests\BukuBesarKasRequest;
use App\Http\Requests\BukuBesarModalRequest;
use App\Http\Requests\BukuBesarPendapatanRequest;
use App\Http\Requests\BukuBesarPiutangRequest;

interface BukuBesarService
{
    function bukuBesarKas(BukuBesarKasRequest $request);
    function bukuBesarBank(BukuBesarBankRequest $request);
    function bukuBesarBiaya(BukuBesarBiayaRequest $request);
    function bukuBesarPendapatan(BukuBesarPendapatanRequest $request);
    function bukuBesarModal(BukuBesarModalRequest $request);
    function bukuBesarHutang(BukuBesarHutangRequest $request);
    function bukuBesarPiutang(BukuBesarPiutangRequest $request);
}
