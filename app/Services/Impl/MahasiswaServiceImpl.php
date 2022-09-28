<?php

namespace App\Services\Impl;

use App\Exceptions\ResponseHttpNotOk;
use App\Repositories\MahasiswaRepository;
use App\Services\MahasiswaService;

class MahasiswaServiceImpl implements MahasiswaService
{
    private MahasiswaRepository $mahasiswaRepository;

    public function __construct(MahasiswaRepository $mahasiswaRepository)
    {
        $this->mahasiswaRepository = $mahasiswaRepository;
    }

    function checkNim(string $nim): bool
    {
        try {
            $this->mahasiswaRepository->findByNim($nim);
            return true;
        } catch (ResponseHttpNotOk $th) {
            return false;
        }
    }
}
