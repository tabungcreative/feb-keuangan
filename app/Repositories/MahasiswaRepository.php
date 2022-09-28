<?php

namespace App\Repositories;

interface MahasiswaRepository
{
    function getAll();
    function findByNim(string $nim);
}
