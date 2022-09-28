<?php

namespace Tests\Feature\Repository;

use App\Repositories\JenisPembayaranRepository;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

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


}
