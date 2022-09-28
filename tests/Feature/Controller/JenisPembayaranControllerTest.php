<?php

namespace Tests\Feature\Controller;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class JenisPembayaranControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    public function test_store()
    {
        $response = $this->post(route('jenis-pembayaran.store'), [
            'nama' => $this->faker()->word(3, true),
            'kode' => $this->faker()->word(3, true),
            'jumlah_bayar' => $this->faker()->randomNumber(),
        ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('jenis-pembayaran.index'));

        $this->assertDatabaseCount('jenis_pembayaran', 1);
        $this->assertDatabaseCount('akun', 1);
    }
}
