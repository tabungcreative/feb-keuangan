<?php

namespace App\Services\Impl;

use App\Exceptions\AkunNotFound;
use App\Exceptions\InvariantExceotion;
use App\Http\Requests\PembayaranAddRequest;
use App\Models\Pembayaran;
use App\Repositories\AkunRepository;
use App\Repositories\JenisPembayaranRepository;
use App\Repositories\MahasiswaRepository;
use App\Repositories\PembayaranRepository;
use App\Repositories\TransaksiRepository;
use App\Services\PembayaranService;
use App\Traits\Numbering;
use Illuminate\Support\Facades\DB;

class PembayaranServiceImpl implements PembayaranService
{
    use Numbering;

    private PembayaranRepository $pembayaranRepository;
    private AkunRepository $akunRepository;
    private TransaksiRepository $transaksiRepository;
    private JenisPembayaranRepository $jenisPembayaranRepository;

    public function __construct(
        PembayaranRepository $pembayaranRepository,
        AkunRepository $akunRepository,
        TransaksiRepository $transaksiRepository,
        JenisPembayaranRepository $jenisPembayaranRepository
    ) {
        $this->pembayaranRepository = $pembayaranRepository;
        $this->akunRepository = $akunRepository;
        $this->transaksiRepository = $transaksiRepository;
        $this->jenisPembayaranRepository = $jenisPembayaranRepository;
    }

    function add(PembayaranAddRequest $request): Pembayaran
    {
        try {
            DB::beginTransaction();

            // --find jenis pembayaran by id--
            $jenisPembayaranId = $request->input('jenis_pembayaran_id');
            $jenisPembayaran = $this->jenisPembayaranRepository->findById($jenisPembayaranId);

            // --create pembayaran--
            $nim = $request->input('nim');
            $noPembayaran = $this->nomerPembayaran($jenisPembayaran->kode);
            $tanggalBayar = now();
            $detailPembayaran = [
                'no_pembayaran' => $noPembayaran,
                'nim' => $nim,
                'tanggal_bayar' => $tanggalBayar,
            ];
            $pembayaran = $this->pembayaranRepository->create($detailPembayaran, $jenisPembayaranId);

            // --create transaksi debit--
            // find akun by id
            $akun = $this->akunRepository->findByNama($jenisPembayaran->nama);

            if ($akun == null) {
                throw new AkunNotFound('akun tidak ditemukan');
            }
            $kodeTransaksi = $this->kodeTransaksi();
            $detailTransaksi = [
                'tanggal' => $tanggalBayar,
                'kode_transaksi' => $kodeTransaksi,
                'debit' => $jenisPembayaran->jumlah_bayar,
                'kredit' => null,
            ];
            $this->transaksiRepository->create($detailTransaksi, $akun->id);

            // --create transaksi kredit--
            $akunKreditId = $request->input('akun_kredit_id');
            $akunKredit = $this->akunRepository->findById($akunKreditId);
            if ($akun == null) {
                throw new AkunNotFound('akun tidak ditemukan');
            }
            $detailTransaksi = [
                'tanggal' => $tanggalBayar,
                'kode_transaksi' => $kodeTransaksi,
                'debit' => null,
                'kredit' => 0,
            ];

            $this->transaksiRepository->create($detailTransaksi, $akunKredit->id);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw new InvariantExceotion('Terjadi kesalahan pada server kami : ' . $e->getMessage());
        }

        return $pembayaran;
    }
}
