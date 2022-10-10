<?php

namespace Tests\Feature\Services;

use App\Http\Requests\AktivaAddRequest;
use App\Services\AktivaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AktivaServiceTest extends TestCase
{
    use RefreshDatabase;

    private AktivaService $aktivaService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->aktivaService = $this->app->make(AktivaService::class);
    }

    public function test_add_aktiva()
    {
        $request = new AktivaAddRequest([
            'kode_aktiva' => 'required',
            'nama_aktiva' => 'required',
            'jenis_aktiva' => 'required',
            'tanggal_perolehan' => '2020-10-01',
            'harga_perolehan' => 100000,
        ]);

        $this->aktivaService->add($request);

        $penyusutan = (100000 * 20 / 100) / 360;

        $this->assertDatabaseCount('aktiva', 1);
        $this->assertDatabaseHas('aktiva', [
            'kode_aktiva' => 'required',
            'nama_aktiva' => 'required',
            'jenis_aktiva' => 'required',
            'tanggal_perolehan' => '2020-10-01',
            'harga_perolehan' => 100000,
            'penyusutan_perhari' => $penyusutan
        ]);
    }
}
