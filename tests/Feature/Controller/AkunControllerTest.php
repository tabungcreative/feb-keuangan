<?php

namespace Tests\Feature\Controller;

use App\Models\Akun;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Arr;
use Tests\TestCase;

class AkunControllerTest extends TestCase
{
    use WithFaker, RefreshDatabase;
    public function test_store()
    {
        $response = $this->post(route('akun.store'), [
            'nama' => $this->faker()->word(3, true),
            'saldo_awal' => 0,
        ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('akun.index'));

        $this->assertDatabaseCount('akun', 1);
    }

    public function test_update_saldo_add()
    {
        $akun = Akun::factory()->create(['saldo_awal' => 0]);
        $response = $this->post(route('akun.update-saldo'), [
            'akun_id' => $akun->id,
            'update_type' => 'add',
            'saldo_awal' => 1000,
        ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('akun.index'));

        $this->assertDatabaseCount('akun', 1);

        $this->assertDatabaseHas('akun', [
            'saldo_awal' => 1000
        ]);
    }

    public function test_update_saldo_subtract()
    {
        $akun = Akun::factory()->create(['saldo_awal' => 2000]);
        $response = $this->post(route('akun.update-saldo'), [
            'akun_id' => $akun->id,
            'update_type' => 'subtract',
            'saldo_awal' => 1000,
        ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('akun.index'));

        $this->assertDatabaseCount('akun', 1);

        $this->assertDatabaseHas('akun', [
            'saldo_awal' => 1000
        ]);
    }

    public function test_update()
    {
        $akun = Akun::factory()->create(['saldo_awal' => 1000]);

        $response = $this->put(route('akun.update', $akun->id), [
            'nama' => $this->faker()->word(3, true),
        ]);

        $response->assertStatus(302);

        $response->assertRedirect(route('akun.index'));

        $this->assertDatabaseCount('akun', 1);
    }
}
