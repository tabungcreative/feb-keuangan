<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantExceotion;
use App\Http\Requests\JenisPembayaranAddRequest;
use App\Http\Requests\JenisPembayaranUpdateRequest;
use App\Models\JenisPembayaran;
use App\Repositories\AkunRepository;
use App\Repositories\JenisPembayaranRepository;
use App\Services\JenisPembayaranService;
use Illuminate\Support\Facades\DB;

class JenisPembayaranServiceImpl implements JenisPembayaranService
{

    private JenisPembayaranRepository $jenisPembayaranRepository;
    private AkunRepository $akunRepository;

    public function __construct(
        JenisPembayaranRepository $jenisPembayaranRepository,
        AkunRepository $akunRepository
    ) {
        $this->jenisPembayaranRepository = $jenisPembayaranRepository;
        $this->akunRepository = $akunRepository;
    }

    function add(JenisPembayaranAddRequest $request): JenisPembayaran
    {
        try {
            DB::beginTransaction();
            $detail = $request->only([
                'nama', 'kode', 'jumlah_bayar'
            ]);

            $jenisPembayaran = $this->jenisPembayaranRepository->create($detail);
            $detailAkun = [
                'nama' => 'Pendapatan ' . $detail['nama'],
                'isPendapatan' => 1
            ];

            $this->akunRepository->create($detailAkun);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new InvariantExceotion('terjadi kesalahan pada server kami :' . $e->getMessage());
        }
        return $jenisPembayaran;
    }



    function update(int $id, JenisPembayaranUpdateRequest $request): JenisPembayaran
    {
        try {

            DB::beginTransaction();
            $detail = $request->only([
                'nama', 'kode', 'jumlah_bayar'
            ]);

            $jenisPembayaran = $this->jenisPembayaranRepository->update($id, $detail);

            DB::commit();
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            throw new InvariantExceotion('terjadi kesalahan pada server kami :' . $e->getMessage());
        }

        return $jenisPembayaran;
    }
}
