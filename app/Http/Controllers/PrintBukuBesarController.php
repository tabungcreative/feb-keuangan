<?php

namespace App\Http\Controllers;

use App\Http\Requests\BukuBesarKasRequest;
use App\Repositories\AkunRepository;
use App\Services\BukuBesarService;
use App\Traits\ConvertBase64;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class PrintBukuBesarController extends Controller
{
    use ConvertBase64;

    private AkunRepository $akunRepository;
    private BukuBesarService $bukuBesarService;

    public function __construct(AkunRepository $akunRepository, BukuBesarService $bukuBesarService)
    {
        $this->akunRepository = $akunRepository;
        $this->bukuBesarService = $bukuBesarService;
    }

    public function kas(BukuBesarKasRequest $request)
    {
        try {
            $akunID = $request->get('akun_id');
            $akunKasJalan = $this->akunRepository->getByAkunKas('kas_jalan');
            if ($akunID != null) {
                $akunKasJalan = $this->akunRepository->getById($akunID);
            }

            list($listTotalDebit, $listTotalKredit, $listSaldoAwalKas, $listTransaksi) = $this->bukuBesarService->bukuBesarKas($request);
            $title = 'Laporan Jurnal Transaksi - ';
            $kop = $this->image('img/kop-feb.png');
            $footerKop = $this->image('img/footer-kop.png');

            $pdf = Pdf::loadView('buku-besar-print.kas', compact('akunKasJalan', 'listTotalDebit', 'listTotalKredit', 'listSaldoAwalKas', 'listTransaksi', 'kop', 'footerKop', 'title'));

            $pdf->setPaper('a4', 'portrait');
            return $pdf->stream($title);

        } catch (\Exception $exception) {
            abort(500);
        }
    }
}
