<?php

namespace Tests\Feature\Services;

use App\Http\Requests\AkunAddRequest;
use App\Http\Requests\AkunUpdateRequest;
use App\Http\Requests\AkunUpdateSaldoRequest;
use App\Models\Akun;
use App\Services\AkunService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

use function PHPUnit\Framework\assertTrue;

class AkunServiceTest extends TestCase
{

    use RefreshDatabase;

    private AkunService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(AkunService::class);
    }
    public function test_add()
    {
        $request = new AkunAddRequest([
            'nama' => 'test',
            'saldo_awal' => 0,
        ]);

        $this->service->add($request);

        $this->assertDatabaseCount('akun', 1);
        $this->assertDatabaseHas('akun', [
            'nama' => 'test',
            'saldo_awal' => 0
        ]);
    }

    public function test_add_saldo_awal()
    {
        $akun = Akun::factory()->create(['saldo_awal' => 1000]);
        $request = new AkunUpdateSaldoRequest([
            'saldo_awal' => 1000,
        ]);

        $result = $this->service->addSaldoAwal($akun->id, $request);
        $this->assertSame(2000, $result->saldo_awal);

        $result = $this->service->addSaldoAwal($result->id, $request);
        $this->assertSame(3000, $result->saldo_awal);
    }

    public function test_update_success()
    {
        $akun = Akun::factory()->create(['saldo_awal' => 1000]);

        $request = new AkunUpdateRequest([
            'nama' => 'test',
        ]);

        $this->service->update($akun->id, $request);

        $this->assertDatabaseCount('akun', 1);
        $this->assertDatabaseHas('akun', [
            'nama' => 'test',
            'saldo_awal' => 1000
        ]);
    }
}
