<?php

namespace App\Repositories\Impl;

use App\Models\Akun;
use App\Models\Transaksi;
use App\Repositories\TransaksiRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class TransaksiRepositoryImpl implements TransaksiRepository
{

    function getAll()
    {
        return Transaksi::orderBy('tanggal', 'DESC')->get();
    }



    function getAllByMonthYear($date = null)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        if ($date != null) {
            $month = Carbon::createFromFormat('Y-m', $date)->month;
            $year = Carbon::createFromFormat('Y-m', $date)->year;
        }

        return Transaksi::whereMonth('tanggal', $month)->whereYear('tanggal', $year)->orderBy('tanggal', 'ASC')->get();
    }


    function create(array $detailTransaksi, int $akunId): Transaksi
    {
        $akun = Akun::findOrFail($akunId);
        $transaksi = new Transaksi($detailTransaksi);
        $akun->transaksi()->save($transaksi);
        return $transaksi;
    }

    function update(int $id, array $detailTransaksi): Transaksi
    {
        throw new \Exception("Method not implemented");
    }

    function updateByKodeAndAkun($kodeTransaksi, $akunId,  array $detailTransaksi): Transaksi
    {
        $transaksi = Transaksi::where('kode_transaksi', $kodeTransaksi)
                    ->where('akun_id', $akunId)->first();
        $transaksi->update($detailTransaksi);
        $transaksi->save();
        return $transaksi;
    }

    function delete(int $id)
    {
        throw new \Exception("Method not implemented");
    }

    function getById(int $id)
    {
        throw new \Exception("Method not implemented");
    }

    public function getWhereAkunKas($akunKas, $date = null)
    {

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        if ($date != null) {
            $month = Carbon::createFromFormat('Y-m', $date)->month;
            $year = Carbon::createFromFormat('Y-m', $date)->year;
        }


        return Transaksi::whereHas('akun', function ($query) use ($akunKas) {
            $query->where('akun_kas', $akunKas);
        })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();
    }

    public function getByAkunId($akunId, $month = null, $year = null)
    {
        return Transaksi::where('akun_id', $akunId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'ASC')->get();
    }


    function getWhereAkunKasGroupByAkun($akunKas, $date = null)
    {

        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        if ($date != null) {
            $month = Carbon::createFromFormat('Y-m', $date)->month;
            $year = Carbon::createFromFormat('Y-m', $date)->year;
        }

        return Transaksi::selectRaw('id, akun_id, sum(kredit) as total_kredit,sum(debit) as total_debit, count(id) as count_id')
            ->groupBy('akun_id')
            ->whereHas('akun', function ($query) use ($akunKas) {
                $query->where('akun_kas', $akunKas);
            })
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->get();
    }

    function findByCode($kode): ?Transaksi
    {
        return Transaksi::where('kode_transaksi', $kode)->first();
    }

    function deleteByKode($kode)
    {
        $transaksi = Transaksi::where('kode_transaksi', $kode)->get();
        $transaksi->each->delete();
    }

    function getBetweenTanggalAndAkun($dateStart, $dateEnd, $akunId)
    {
        return Transaksi::select('id', 'debit', 'tanggal', 'kredit', 'akun_id')
            ->whereBetween('tanggal', [$dateStart, $dateEnd])->where('akun_id', $akunId)->get();
    }

    function sumKreditByAkun($akunId, $month, $year)
    {

        $transaksi = Transaksi::where('akun_id', $akunId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'ASC')->get();

        return $transaksi->sum('kredit');
    }

    function sumByAkun($akunId, $month, $year, $field)
    {
        $transaksi = Transaksi::where('akun_id', $akunId)
            ->whereMonth('tanggal', $month)
            ->whereYear('tanggal', $year)
            ->orderBy('tanggal', 'ASC')->get();

        return $transaksi->sum($field);
    }

    function findFirstOrderTanggal()
    {
        return Transaksi::orderBy('tanggal', 'ASC')->first();
    }

    function findFirstOrderTanggalByAkunId($akunId)
    {
        return Transaksi::where('akun_id', $akunId)->orderBy('tanggal', 'ASC')->first();
    }
}
