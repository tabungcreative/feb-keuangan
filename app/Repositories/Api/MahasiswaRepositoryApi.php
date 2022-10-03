<?php

namespace App\Repositories\Api;

use App\Exceptions\ResponseHttpNotOk;
use App\Repositories\MahasiswaRepository;
use Illuminate\Support\Facades\Http;

class MahasiswaRepositoryApi implements MahasiswaRepository
{
    private string $url;

    public function __construct()
    {
        $this->url = env('URL_API');
    }

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
        $endpoint = $this->url . '/mahasiswa/' . $nim;
        $response = Http::get($endpoint);

        if ($response->status() == 200) {
            $mahasiswa = json_decode($response->body(), true)['data'];
            return $mahasiswa;
        } else {
            throw new ResponseHttpNotOk('tidak dapat mendapatkan data dari api');
        }
    }
}
