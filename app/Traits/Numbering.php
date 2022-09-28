<?php

namespace App\Traits;

use App\Models\Pembayaran;
use Carbon\Carbon;

trait Numbering
{
    public function nomerPembayaran($kodePembayaran)
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

            $no_pembayaran = $kodePembayaran . '-' . $year . '-' . $nomer;

            return $no_pembayaran;
        } else {
            $no_pembayaran = $kodePembayaran . '-' . $year . '-' . '0001';
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
