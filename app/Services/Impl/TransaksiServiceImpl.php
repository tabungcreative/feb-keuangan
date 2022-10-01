<?php

namespace App\Services\Impl;

use App\Exceptions\InvariantExceotion;
use App\Exceptions\SameAkunException;
use App\Http\Requests\TransaksiAddRequest;
use App\Models\Transaksi;
use App\Repositories\AkunRepository;
use App\Repositories\TransaksiRepository;
use App\Services\TransaksiService;
use App\Traits\Numbering;
use Illuminate\Support\Facades\DB;

class TransaksiServiceImpl implements TransaksiService
{
    use Numbering;

    private TransaksiRepository $transaksiRepository;
    private AkunRepository $akunRepository;


    public function __construct(TransaksiRepository $transaksiRepository, AkunRepository $akunRepository)
    {
        $this->transaksiRepository = $transaksiRepository;
        $this->akunRepository = $akunRepository;
    }

    function add(TransaksiAddRequest $request)
    {
        $tanggalTransaksi = $request->input('tanggal_transaksi');
        $kodeTransaksi = $request->input('kode_transaksi');
        $namaTransaksi = $request->input('nama_transaksi');
        $akunDebitId = $request->input('akun_debit_id');
        $akunKreditId = $request->input('akun_kredit_id');
        $jumlahTransaksi = $request->input('jumlah_transaksi');

        /**
         * Validasi akun kredit jika sama
         **/
        if ($akunDebitId == $akunKreditId) {
            throw new SameAkunException('akun kredit dan debit tidak boleh sama');
        }

        try {
            DB::beginTransaction();
            /**
             * Menambah transaksi debit
             **/
            $detailTransaksiDebit = [
                'tanggal' => $tanggalTransaksi,
                'kode_transaksi' => $kodeTransaksi,
                'nama_transaksi' => $namaTransaksi,
                'debit' => $jumlahTransaksi,
                'kredit' => null,
            ];
            $this->transaksiRepository->create($detailTransaksiDebit, $akunDebitId);

            /**
             * Menambah transaksi kredit
             **/
            $detailTransaksiKredit = [
                'tanggal' => $tanggalTransaksi,
                'kode_transaksi' => $kodeTransaksi,
                'nama_transaksi' => $namaTransaksi,
                'debit' => null,
                'kredit' => $jumlahTransaksi,
            ];
            $this->transaksiRepository->create($detailTransaksiKredit, $akunKreditId);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
        }
    }
}
