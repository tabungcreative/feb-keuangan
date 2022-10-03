<?php

namespace Tests\Feature\Services;

use App\Http\Requests\JenisPembayaranAddRequest;
use App\Http\Requests\JenisPembayaranUpdateRequest;
use App\Models\Akun;
use App\Models\JenisPembayaran;
use App\Repositories\JenisPembayaranRepository;
use App\Services\JenisPembayaranService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JenisPembayaranServiceTest extends TestCase
{
    use RefreshDatabase;

    private JenisPembayaranService $jenisPembayaranService;

    protected function setUp(): void
    {
        parent::setUp();
        $this->jenisPembayaranService = $this->app->make(JenisPembayaranService::class);
    }
    public function test_add_success()
    {
        // dd($this->jenisPembayaranService->add());
        $request = new JenisPembayaranAddRequest([
            'nama' => 'test',
            'kode' => 'test',
            'jumlah_bayar' => 20000,
        ]);

        // dd($request->only(['nama', 'kode']));
        $this->jenisPembayaranService->add($request);

        $this->assertDatabaseCount('jenis_pembayaran', 1);
        $this->assertDatabaseHas('jenis_pembayaran', [
            'nama' => 'test',
            'kode' => 'test',
            'jumlah_bayar' => 20000
        ]);

        $this->assertDatabaseCount('akun', 1);
        $this->assertDatabaseHas('akun', [
            'nama' => 'Pendapatan test',
            'saldo_awal' => 0,
            'akun_kas' => 'kas_masuk'
        ]);
    }
    public function test_update_success()
    {
        $jenisPembayaran = JenisPembayaran::factory()->create(['nama' => 'testdumy']);

        $request = new JenisPembayaranUpdateRequest([
            'nama' => 'test',
            'kode' => 'test',
            'jumlah_bayar' => 20000,
        ]);

        $this->jenisPembayaranService->update($jenisPembayaran->id, $request);

        $this->assertDatabaseCount('jenis_pembayaran', 1);
        $this->assertDatabaseHas('jenis_pembayaran', [
            'nama' => 'test',
            'kode' => 'test',
            'jumlah_bayar' => 20000
        ]);
    }
}
