<?php

namespace App\Traits;

use App\Models\Pembayaran;
use App\Models\Transaksi;
use Carbon\Carbon;

trait Numbering
{
    public function nomerPembayaran($kodePembayaran)
    {
        $year = Carbon::parse(now())->translatedFormat('y');
        $month = Carbon::parse(now())->translatedFormat('m');

        $pembayaran = Pembayaran::latest()->first();

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

    public function kodeTransaksi($kodeTransaksi)
    {
        $year = Carbon::parse(now())->translatedFormat('y');
        $month = Carbon::parse(now())->translatedFormat('m');

        $transaksi = Transaksi::latest()->first();

        if ($transaksi != null) {
            $noPembayaranTerakhir = $transaksi->kode_transaksi;
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

            $no_transaksi = $nomer . '-' . $month . '.' . $year . '-' . $kodeTransaksi;

            return $no_transaksi;
        } else {
            $no_transaksi = '0001' . '-' . $month . '.' . $year . '-' . $kodeTransaksi;
            return $no_transaksi;
        }
    }

}
