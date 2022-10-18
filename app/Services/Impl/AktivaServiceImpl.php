<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantExceotion;
use App\Http\Requests\AktivaAddRequest;
use App\Models\Aktiva;
use App\Repositories\AktivaRepository;
use App\Services\AktivaService;

class AktivaServiceImpl implements AktivaService
{

    private AktivaRepository $aktivaRepository;

    public function __construct(AktivaRepository $aktivaRepository)
    {
        $this->aktivaRepository = $aktivaRepository;
    }

    function add(AktivaAddRequest $request): Aktiva
    {
        $kodeAktiva = $request->input('kode_aktiva');
        $namaAktiva = $request->input('nama_aktiva');
        $tanggalPerolehan = $request->input('tanggal_perolehan');
        $hargaPerolehan = $request->input('harga_perolehan');
        $kategori = $request->input('kategori');
        $penyusutanPerhari = ($hargaPerolehan * 20 / 100) / 360;

        $detailAktiva = [
            'kode_aktiva' => $kodeAktiva,
            'nama_aktiva' => $namaAktiva,
            'tanggal_perolehan' => $tanggalPerolehan,
            'harga_perolehan' => $hargaPerolehan,
            'penyusutan_perhari' => $penyusutanPerhari,
            'kategori' => $kategori,
        ];

        $aktiva = $this->aktivaRepository->create($detailAktiva);

        return $aktiva;

    }
}
