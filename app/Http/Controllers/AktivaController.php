<?php

namespace App\Http\Controllers;

use App\Http\Requests\AktivaAddRequest;
use App\Http\Requests\AktivaUpdateRequest;
use App\Repositories\AktivaRepository;
use App\Services\AktivaService;
use App\Traits\ConvertBase64;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AktivaController extends Controller
{
    use ConvertBase64;

    //
    private AktivaRepository $aktivaRepository;
    private AktivaService $aktivaService;

    public function __construct(
        AktivaService $aktivaService,
        AktivaRepository $aktivaRepository
    ) {
        $this->aktivaService = $aktivaService;
        $this->aktivaRepository = $aktivaRepository;
    }

    public function index(Request $request)
    {
        $aktiva = $this->aktivaRepository->getAll();

        $totalAkhirAktiva = 0;

        foreach ($aktiva as $value) {
            $penyusutanSdHariIni = Carbon::now()->diffInDays(Carbon::createFromFormat('Y-m-d', $value->tanggal_perolehan));
            $nilaiBuku = $value->harga_perolehan - ($penyusutanSdHariIni * $value->penyusutan_perhari);
            if (!$nilaiBuku <= 0) {
                $totalAkhirAktiva += $nilaiBuku;
            }
        }

        return view('aktiva.index', compact('aktiva', 'totalAkhirAktiva'));
    }

    public function create()
    {
        return view('aktiva.create');
    }

    public function store(AktivaAddRequest $request)
    {
        try {
            $this->aktivaService->add($request);
            return redirect()->route('aktiva.index')->with('success', 'aktiva berhasil ditambahkan');
        } catch (\Exception $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    public function edit($id)
    {
        $data = $this->aktivaRepository->findById($id);
        return view('aktiva.edit', compact('data'));
    }

    public function update(AktivaUpdateRequest $request, $id)
    {
        try {
            $this->aktivaService->update($request, $id);
            return redirect()->route('aktiva.index')->with('success', 'aktiva berhasi diubah');
        } catch (\Exception $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    public function delete($id) {
        try {
            $this->aktivaService->delete($id);
            return redirect()->route('aktiva.index')->with('success', 'aktiva berhasi dihapus');
        } catch (\Exception $e) {
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }

    public function penghapusan($id) {
        try{
            $this->aktivaService->penghapusan($id);
            Session::flash('success', 'Penghapusan asset berhasil');

            $aktiva = $this->aktivaRepository->findById($id);
            $tanggal = Carbon::parse(now())->translatedFormat('d F Y');


            $kop = $this->image('img/kop-feb.png');
            $footerKop = $this->image('img/footer-kop.png');
            $title = 'Penghapusan Asset';


            $pdf = Pdf::loadView('aktiva.print-penghapusan', compact('kop', 'footerKop', 'title', 'aktiva', 'tanggal'));


            $pdf->setPaper('a4', 'portrait');
            return $pdf->stream($title);
        }catch (Exception $e){
            return response()->view('errors.500', ['message' => $e->getMessage()], 500);
        }
    }
}
