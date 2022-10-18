<?php

namespace App\Http\Controllers;

use App\Http\Requests\AktivaAddRequest;
use App\Repositories\AktivaRepository;
use App\Services\AktivaService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AktivaController extends Controller
{
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
            $nilaiBuku = $value->harga_perolehan - $penyusutanSdHariIni;
            $totalAkhirAktiva += $nilaiBuku;
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
}
