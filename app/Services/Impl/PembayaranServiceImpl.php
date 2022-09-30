<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantExceotion;
use App\Exceptions\SameAkunException;
use App\Http\Requests\PembayaranAddRequest;
use App\Http\Requests\TransaksiAddRequest;
use App\Models\Pembayaran;
use App\Repositories\JenisPembayaranRepository;
use App\Repositories\PembayaranRepository;
use App\Services\PembayaranService;
use App\Services\TransaksiService;
use App\Traits\Numbering;
use Illuminate\Support\Facades\DB;

class PembayaranServiceImpl implements PembayaranService
{
    use Numbering;

    private PembayaranRepository $pembayaranRepository;
    private JenisPembayaranRepository $jenisPembayaranRepository;
    private TransaksiService $transaksiService;

    public function __construct(
        PembayaranRepository $pembayaranRepository,
        JenisPembayaranRepository $jenisPembayaranRepository,
        TransaksiService $transaksiService
    ) {
        $this->pembayaranRepository = $pembayaranRepository;
        $this->jenisPembayaranRepository = $jenisPembayaranRepository;
        $this->transaksiService = $transaksiService;
    }

    function add(PembayaranAddRequest $request): Pembayaran
    {
        try {
            DB::beginTransaction();

            // --find jenis pembayaran by id--
            $jenisPembayaranId = $request->input('jenis_pembayaran_id');
            $akunDebitId = $request->input('akun_debit_id');
            $akunKreditId = $request->input('akun_kredit_id');
            $nim = $request->input('nim');



            /**
             * Tambah Pembayaran
             */
            $jenisPembayaran = $this->jenisPembayaranRepository->findById($jenisPembayaranId);
            $noPembayaran = $this->nomerPembayaran($jenisPembayaran->kode);
            $tanggalBayar = now();
            $detailPembayaran = [
                'no_pembayaran' => $noPembayaran,
                'nim' => $nim,
                'tanggal_bayar' => $tanggalBayar,
            ];
            $pembayaran = $this->pembayaranRepository->create($detailPembayaran, $jenisPembayaranId);

            /**
             * Membuat transaksi
             */
            $request = new TransaksiAddRequest([
                'tanggal_transaksi' => now(),
                'kode_transaksi' => $noPembayaran,
                'akun_kredit_id' => $akunKreditId,
                'akun_debit_id' => $akunDebitId,
                'jumlah_transaksi' => $jenisPembayaran->jumlah_bayar
            ]);

            $this->transaksiService->add($request);

            DB::commit();
        } catch (SameAkunException $e) {
            throw new InvariantExceotion($e->getMessage());
        }

        return $pembayaran;
    }
}
