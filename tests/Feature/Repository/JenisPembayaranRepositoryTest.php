<?php

namespace Tests\Feature\Repository;

use App\Models\Akun;
use App\Models\JenisPembayaran;
use App\Repositories\JenisPembayaranRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertSame;

class JenisPembayaranRepositoryTest extends TestCase
{
    use RefreshDatabase;

    private JenisPembayaranRepository $repository;

    protected function setUp(): void
    {
        parent::setUp();
        $this->repository = $this->app->make(JenisPembayaranRepository::class);
    }

    public function test_create()
    {
        $this->repository->create([
            'nama' =>  'test',
            'kode' => 'test',
            'jumlah_bayar' => 2000
        ]);

        $this->assertDatabaseHas('jenis_pembayaran', [
            'nama' =>  'test',
            'kode' => 'test',
            'jumlah_bayar' => 2000
        ]);
    }

    public function test_update()
    {
        $jenisPembayaran = JenisPembayaran::factory()->create();

        $this->repository->update($jenisPembayaran->id, [
            'nama' =>  'test',
            'kode' => 'test',
            'jumlah_bayar' => 2000
        ]);

        $this->assertDatabaseCount('jenis_pembayaran', 1);
        $this->assertDatabaseHas('jenis_pembayaran', [
            'nama' =>  'test',
            'kode' => 'test',
            'jumlah_bayar' => 2000
        ]);
    }

    public function test_find_by_id()
    {
        $jenisPembayaran = JenisPembayaran::factory()->create();
        $result = $this->repository->findById($jenisPembayaran->id);

        $this->assertSame(1, $result->count());
    }
}
