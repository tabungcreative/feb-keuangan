<?php

namespace App\Traits;

use App\Models\Pembayaran;
use Carbon\Carbon;

trait Numbering
{
    public function nomerPembayaran($kodePembayaran)
    {
        $year = Carbon::parse(now())->translatedFormat('y');
        $month = Carbon::parse(now())->translatedFormat('m');


        $pembayaran = Pembayaran::orderBy('id', 'DESC')->first();

        if ($pembayaran != null) {
            $noPembayaranTerakhir = $pembayaran->no_pembayaran;
            $explode = explode('-', $noPembayaranTerakhir);
            $dateAkhir = $explode[1];
            $explodeDate = explode('.', $dateAkhir);
            $tahunAkhir = end($explodeDate);
            $nomerTerahir = $explode[0];
            $newNumber = 0;
            if ($year == $tahunAkhir) {
                $newNumber = $nomerTerahir + 1;
            } else {
                $newNumber = 1;
            }

            $nomer = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            $no_pembayaran = $nomer . '-' . $month . '.' . $year . '-' . $kodePembayaran;

            return $no_pembayaran;
        } else {
            $no_pembayaran = '0001' . '-' . $month . '.' . $year . '-' . $kodePembayaran;
            return $no_pembayaran;
        }
    }

    public function kodeTransaksi()
    {
        $year = Carbon::parse(now())->translatedFormat('Y');

        $pembayaran = Pembayaran::orderBy('id', 'DESC')->first();

        if ($pembayaran != null) {
            $noPembayaranTerakhir = $pembayaran->no_pembayaran;
            $explode = explode('-', $noPembayaranTerakhir);
            $tahunAkhir = $explode[1];
            $nomerTerahir = end($explode);
            $newNumber = 0;
            if ($year == $tahunAkhir) {
                $newNumber = $nomerTerahir + 1;
            } else {
                $newNumber = 1;
            }

            $nomer = str_pad($newNumber, 4, '0', STR_PAD_LEFT);

            $no_pembayaran = 'TRS' . '-' . $year . '-' . $nomer;

            return $no_pembayaran;
        } else {
            $no_pembayaran = 'TRS' . '-' . $year . '-' . '0001';
            return $no_pembayaran;
        }
    }
}
