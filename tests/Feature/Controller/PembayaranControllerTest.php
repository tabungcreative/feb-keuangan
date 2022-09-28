<?php

namespace Tests\Feature\Controller;

use App\Models\Akun;
use App\Models\JenisPembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PembayaranControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    public function test_store_nim_found()
    {
        $jenisPembayaran = JenisPembayaran::factory()->create(['nama' => 'test']);
        $akunKredit = Akun::factory()->create(['jenis_akun' => 'kredit']);
        Akun::factory()->create(['nama' => 'test']);

        $response = $this->post(route('pembayaran.store'), [
            'nim' => 'd83c00b8-52b8-3cf7-a781-3fad832f7f39',
            'jenis_pembayaran_id' => $jenisPembayaran->id,
            'akun_kredit_id' => $akunKredit->id,
        ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('pembayaran.index'));

        $this->assertDatabaseCount('pembayaran', 1);
        $this->assertDatabaseCount('transaksi', 2);
        $this->assertDatabaseCount('akun', 2);
    }
}
