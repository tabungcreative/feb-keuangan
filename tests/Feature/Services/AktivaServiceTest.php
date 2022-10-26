<?php

namespace Tests\Feature\Services;

use App\Http\Requests\AktivaAddRequest;
use App\Models\Aktiva;
use App\Services\AktivaService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Notifications\Action;
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
            'tanggal_perolehan' => '2020-10-01',
            'harga_perolehan' => 100000,
            'umur_ekonomis' => 10,
        ]);

        $this->aktivaService->add($request);

        $penyusutan = 100000 / 10 / 365;

        $this->assertDatabaseCount('aktiva', 1);
        $this->assertDatabaseHas('aktiva', [
            'kode_aktiva' => 'required',
            'nama_aktiva' => 'required',
            'tanggal_perolehan' => '2020-10-01',
            'harga_perolehan' => 100000,
            'penyusutan_perhari' => $penyusutan,
            'umur_ekonomis' => 10,
        ]);
    }

    public function test_add_deletion()
    {
        $aktiva = Aktiva::factory()->create();

        $this->assertDatabaseHas('aktiva', ['is_active' => 1 ]);

        $this->aktivaService->deletion($aktiva->id);

        $this->assertDatabaseHas('aktiva', ['is_active' => 0 ]);

    }

    public function test_add_delet()
    {
        $aktiva = Aktiva::factory()->create();

        $this->assertDatabaseCount('aktiva', 1);

        $this->aktivaService->delete($aktiva->id);

        $this->assertDatabaseCount('aktiva', 0);

    }
}
