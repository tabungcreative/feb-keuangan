<?php

namespace App\Repositories\Api;

use App\Exceptions\ResponseHttpNotOk;
use App\Repositories\MahasiswaRepository;
use Illuminate\Support\Facades\Http;

class MahasiswaRepositoryApi implements MahasiswaRepository
{
    private $url = 'https://feb-unsiq.ac.id/api';

    function getAll()
    {
        $response = Http::get($this->url . '/mahasiswa');

        if ($response->status() == 200) {
            // dd($response->body());
            $mahasiswa = json_decode($response->body(), true)['data'];
            return $mahasiswa;
        }

        throw new ResponseHttpNotOk('tidak dapat mendapatkan data dari api');
    }

    function findByNim(string $nim)
    {
        $response = Http::get($this->url . '/mahasiswa/' . $nim);

        if ($response->status() == 200) {
            $mahasiswa = json_decode($response->body(), true)['data'];
            return $mahasiswa;
        }

        throw new ResponseHttpNotOk('tidak dapat mendapatkan data dari api');
    }
}
