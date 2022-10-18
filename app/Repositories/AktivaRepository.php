<?php

namespace App\Repositories;



use App\Models\Aktiva;

interface AktivaRepository
{
    function getAll();
    function getAllByMonthYear($date = null);
    function create($detailAktiva): Aktiva;
    function findById(int $id);
}
