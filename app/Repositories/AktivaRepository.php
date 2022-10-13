<?php

namespace App\Repositories;



interface AktivaRepository
{
    function getAll();
    function getAllByMonthYear($date = null);
    function findById(int $id);
}
