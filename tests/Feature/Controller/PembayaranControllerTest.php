<?php

namespace Tests\Feature\Controller;

use App\Models\Akun;
use App\Models\JenisPembayaran;
use App\Models\Pembayaran;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PembayaranControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;

    public function test_post_cek_nim()
    {
        $response = $this->post(route('pembayaran.post-cek-nim'), [
            'nim' => 'd83c00b8-52b8-3cf7-a781-3fad832f7f39'
        ]);

        $response->assertStatus(302);
    }
    public function test_store()
    {
        // $this->markTestIncomplete(
        //     'Harus diperbaiki !!'
        // );
        $jenisPembayaran = JenisPembayaran::factory()->create(['nama' => 'test', 'jumlah_bayar' => 1000]);
        $akunDebit = Akun::factory()->create();
        $akunKredit = Akun::factory()->create();

        $response = $this->post(route('pembayaran.store'), [
            'nim' => 'd83c00b8-52b8-3cf7-a781-3fad832f7f39',
            'jenis_pembayaran_id' => $jenisPembayaran->id,
            'akun_debit_id' => $akunDebit->id,
            'akun_kredit_id' => $akunKredit->id,
        ]);

        $response->assertStatus(302);

        $idPembayaran = Pembayaran::orderBy('created_at', 'DESC')->first()->id;
        $response->assertRedirect(route('pembayaran.detail', $idPembayaran));

        $this->assertDatabaseCount('pembayaran', 1);
        $this->assertDatabaseCount('transaksi', 2);
        $this->assertDatabaseCount('akun', 2);

        $this->assertDatabaseHas('transaksi', [
            'debit' => 1000,
            'kredit' => null,
        ]);

        $this->assertDatabaseHas('transaksi', [
            'debit' => null,
            'kredit' => 1000,
        ]);
    }
}
