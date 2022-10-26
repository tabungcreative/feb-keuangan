<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantExceotion;
use App\Http\Requests\AktivaAddRequest;
use App\Http\Requests\AktivaUpdateRequest;
use App\Models\Aktiva;
use App\Repositories\AktivaRepository;
use App\Services\AktivaService;
use Carbon\Carbon;

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
        $umurEkonimis = $request->input('umur_ekonomis');

        $penyusutanPerhari = $hargaPerolehan / $umurEkonimis  /  Carbon::now()->daysInYear;

        $detailAktiva = [
            'kode_aktiva' => $kodeAktiva,
            'nama_aktiva' => $namaAktiva,
            'tanggal_perolehan' => $tanggalPerolehan,
            'harga_perolehan' => $hargaPerolehan,
            'penyusutan_perhari' => $penyusutanPerhari,
            'kategori' => $kategori,
            'umur_ekonomis' => $umurEkonimis,
        ];

        $aktiva = $this->aktivaRepository->create($detailAktiva);

        return $aktiva;
    }

    function update(AktivaUpdateRequest $request, int $id): Aktiva
    {
        $kodeAktiva = $request->input('kode_aktiva');
        $namaAktiva = $request->input('nama_aktiva');
        $tanggalPerolehan = $request->input('tanggal_perolehan');
        $hargaPerolehan = $request->input('harga_perolehan');
        $umurEkonimis = $request->input('umur_ekonomis');
        $kategori = $request->input('kategori');
        $penyusutanPerhari = $hargaPerolehan / $umurEkonimis  /  Carbon::now()->daysInYear;


        $detailAktiva = [
            'kode_aktiva' => $kodeAktiva,
            'nama_aktiva' => $namaAktiva,
            'tanggal_perolehan' => $tanggalPerolehan,
            'harga_perolehan' => $hargaPerolehan,
            'penyusutan_perhari' => $penyusutanPerhari,
            'kategori' => $kategori,
            'umur_ekonomis' => $umurEkonimis,
        ];

        $aktiva = $this->aktivaRepository->update($id, $detailAktiva);

        return $aktiva;
    }

    function deletion(int $id): void
    {
        $this->aktivaRepository->update($id, ['is_active' => 0]);
    }

    function delete(int $id): void
    {
        $this->aktivaRepository->delete($id);
    }
}
