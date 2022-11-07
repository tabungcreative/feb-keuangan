<?php

namespace Tests\Feature\Repository;

use App\Models\Akun;
use App\Models\Transaksi;
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
            'nama_transaksi' => 'Test Transaksi',
            'akun_id' => $akunId,
            'debit' => 0,
            'kredit' => 0,
        ];

        $this->repository->create($detailTransaksi, $akunId);
        $this->assertDatabaseCount('transaksi', 1);
    }

    public function test_get_all_group_by_Akun()
    {
        $akun1 = Akun::factory()->create(['id' => 1, 'akun_kas' => 'kas_masuk']);
        $akun2 = Akun::factory()->create(['id' => 2, 'akun_kas' => 'kas_keluar']);

        Transaksi::factory(50)->create(['akun_id' => $akun1->id]);
        Transaksi::factory(100)->create(['akun_id' => $akun2->id]);
        $transaksi = $this->repository->getByAkunKas('kas_masuk');

        $this->assertSame(1, $transaksi->count());
    }
}
