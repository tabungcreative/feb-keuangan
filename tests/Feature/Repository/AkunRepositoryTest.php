<?php

namespace Tests\Feature\Repository;

use App\Models\Akun;
use App\Repositories\AkunRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AkunRepositoryTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    private AkunRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(AkunRepository::class);
    }
    public function test_find_by_nama()
    {
        $akun = Akun::factory()->create(['nama' => 'test']);
        $result = $this->repository->findByNama('test');

        $this->assertSame(1, $result->count());
    }

    public function test_add_saldo_by_id()
    {
        $akun = Akun::factory()->create(['saldo_awal' => 0]);

        $result = $this->repository->updateSaldoAwalById($akun->id, 2000);
        $this->assertSame(2000, $result->saldo_awal);
        $this->assertDatabaseCount('akun', 1);
        $this->assertDatabaseHas('akun', [
            'saldo_awal' => 2000
        ]);
    }
}
