<?php

namespace App\Services\Impl;

use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\PencatatanService;

class PencatatanServiceImpl implements PencatatanService
{

    private AkunRepository $akunRepository;
    private TransaksiRepository $transaksiRepository;

    public function __construct(AkunRepository $akunRepository,
                                TransaksiRepository $transaksiRepository)
    {
        $this->akunRepository = $akunRepository;
        $this->transaksiRepository = $transaksiRepository;
    }

    function bukuBesar($akunKas): array
    {
        $result = [];
        return $result;
    }

    function saldoAwal($dateStart, $dateEnd, $akunId)
    {
        $saldoAwal = 0;
        $transaksi = $this->transaksiRepository->getBetweenTanggalAndAkun($dateStart, $dateEnd, $akunId);

        foreach ($transaksi as $value) {
            $saldoAwal += $value->kredit - $value->debit;
        }

        return $saldoAwal;
    }
}
