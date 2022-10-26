<?php

namespace App\Repositories;



use App\Models\Aktiva;

interface AktivaRepository
{
    function getAll();
    function getAllByMonthYear($date = null);
    function create($detailAktiva): Aktiva;
    function update(int $id, $detailActiva);
    function findById(int $id);
    function delete(int $id);
}
