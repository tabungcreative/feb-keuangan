<?php

namespace App\Services;

interface MahasiswaService
{
    function checkNim(string $nim): bool;
}
