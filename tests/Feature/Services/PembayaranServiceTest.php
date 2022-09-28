<?php

namespace Tests\Feature\Services;

use App\Http\Requests\PembayaranAddRequest;
use App\Models\Akun;
use App\Models\JenisPembayaran;
use App\Services\PembayaranService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PembayaranServiceTest extends TestCase
{
    use RefreshDatabase;

    private PembayaranService $pembayaranService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->pembayaranService = $this->app->make(PembayaranService::class);
    }
    public function test_add_pembayaran()
    {
        $jenisPembayaran = JenisPembayaran::factory()->create(['nama' => 'test']);
        Akun::factory()->create(['nama' => 'test']);


        $request = new PembayaranAddRequest([
            'nim' => 'd83c00b8-52b8-3cf7-a781-3fad832f7f39',
            'jenis_pembayaran_id' => $jenisPembayaran->id
        ]);

        $this->pembayaranService->add($request);

        $this->assertDatabaseCount('pembayaran', 1);
        $this->assertDatabaseCount('transaksi', 1);
    }
}
