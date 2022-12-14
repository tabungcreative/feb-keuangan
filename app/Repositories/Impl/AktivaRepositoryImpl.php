<?php

namespace App\Repositories\Impl;

use App\Models\Aktiva;
use App\Repositories\AktivaRepository;
use Carbon\Carbon;
use Illuminate\Notifications\Action;

class AktivaRepositoryImpl implements AktivaRepository
{
    function getAll()
    {
        return Aktiva::orderBy('tanggal_perolehan', 'ASC')
            ->get();
    }

    function getAllByMonthYear($date = null)
    {
        $month = Carbon::now()->month;
        $year = Carbon::now()->year;

        if ($date != null) {
            $month = Carbon::createFromFormat('Y-m', $date)->month;
            $year = Carbon::createFromFormat('Y-m', $date)->year;
        }

        return Aktiva::whereMonth('tanggal_perolehan', $month)->whereYear('tanggal_perolehan', $year)->get();
    }

    function create($detailAktiva): Aktiva
    {
        $aktiva = new Aktiva($detailAktiva);
        $aktiva->save();
        return $aktiva;
    }

    function findById(int $id)
    {
        return Aktiva::findOrFail($id);
    }

    function update(int $id, $detailActiva)
    {
        $activa = Aktiva::find($id);
        $activa->update($detailActiva);
        $activa->save();
        return $activa;
    }

    function delete(int $id)
    {
        $aktiva = Aktiva::find($id);
        $aktiva->delete();
    }
}
