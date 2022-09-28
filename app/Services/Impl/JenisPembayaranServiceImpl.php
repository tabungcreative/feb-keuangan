<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantExceotion;
use App\Http\Requests\JenisPembayaranAddRequest;
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
                'nama' => $detail['nama'],
                'jenis_akun' => 'debit',
            ];

            $this->akunRepository->create($detailAkun);

            return $jenisPembayaran;
            DB::commit();
        } catch (\Exception $th) {
            DB::rollBack();
            throw new InvariantExceotion('terjadi kesalahan pada server kami');
        }
    }
}
