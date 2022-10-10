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
        $jenisAktiva = $request->input('jenis_aktiva');
        $tanggalPerolehan = $request->input('tanggal_perolehan');
        $hargaPerolehan = $request->input('harga_perolehan');
        $penyusutanPerhari = ($hargaPerolehan * 20 / 100) / 360;
        try {
            $aktiva = new Aktiva([
                'kode_aktiva' => $kodeAktiva,
                'nama_aktiva' => $namaAktiva,
                'jenis_aktiva' => $jenisAktiva,
                'tanggal_perolehan' => $tanggalPerolehan,
                'harga_perolehan' => $hargaPerolehan,
                'penyusutan_perhari' => $penyusutanPerhari,
            ]);
            $aktiva->save();
            return $aktiva;
        } catch (\Exception $exception) {
            throw new InvariantExceotion($exception->getMessage());
        }
    }
}
