<?php

namespace App\Http\Controllers;

use App\Http\Requests\AktivaAddRequest;
use App\Http\Requests\AktivaUpdateRequest;
use App\Repositories\AktivaRepository;
use App\Services\AktivaService;
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
        $date = $request->query('tahun');
        $aktiva = $this->aktivaRepository->getAllByMonthYear($date);
        return view('aktiva.index', compact('aktiva'));
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
}
