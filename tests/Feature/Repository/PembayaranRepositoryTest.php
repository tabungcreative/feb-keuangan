<?php

namespace Tests\Feature\Repository;

use App\Models\JenisPembayaran;
use App\Repositories\PembayaranRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PembayaranRepositoryTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    private PembayaranRepository $repository;
    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(PembayaranRepository::class);
    }
    public function test_example()
    {
        $jenisPembayaranId = JenisPembayaran::factory()->create()->id;

        $detailPembayaran = [
            'no_pembayaran' => $this->faker()->word(10, true),
            'nim' => $this->faker()->word(10),
            'tanggal_bayar' => $this->faker()->date(),
        ];

        $this->repository->create($detailPembayaran, $jenisPembayaranId);
        $this->assertDatabaseCount('pembayaran', 1);
    }
}
