<?php

namespace Tests\Feature\Repository;

use App\Models\Akun;
use App\Repositories\TransaksiRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransaksiRepositoryTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private TransaksiRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(TransaksiRepository::class);
    }
    public function test_create_transaksi()
    {
        $akunId = Akun::factory()->create()->id;

        $detailTransaksi = [
            'tanggal' => $this->faker()->date(),
            'kode_transaksi' => $this->faker()->word(10),
            'akun_id' => $akunId,
            'debit' => 0,
            'kredit' => 0,
        ];

        $this->repository->create($detailTransaksi, $akunId);
        $this->assertDatabaseCount('transaksi', 1);
    }
}
