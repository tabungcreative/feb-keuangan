<?php

namespace Tests\Feature\Services;

use App\Exceptions\SameAkunException;
use App\Http\Requests\TransaksiAddRequest;
use App\Models\Akun;
use App\Services\TransaksiService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TransaksisServiceTest extends TestCase
{
    use RefreshDatabase;

    private TransaksiService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = $this->app->make(TransaksiService::class);
    }
    /**
     * @expectedException SameAkunException
     */
    public function test_add_transaksi_akun_is_same()
    {
        $this->expectException(SameAkunException::class);
        $this->expectDeprecationMessage('akun kredit dan debit tidak boleh sama');


        $akun = Akun::factory()->create();

        $request = new TransaksiAddRequest([
            'kode_transaksi' => 'TEST',
            'nama_transaksi' => 'Test Transaksi',
            'akun_debit_id' => $akun->id,
            'akun_kredit_id' => $akun->id,
            'jumlah_transaksi' => 1000
        ]);

        $this->service->add($request);
    }

    public function test_add_transaksi_success()
    {

        $akunDebit = Akun::factory()->create();
        $akunKredit = Akun::factory()->create();

        $request = new TransaksiAddRequest([
            'tanggal_transaksi' => now(),
            'kode_transaksi' => 'TEST',
            'nama_transaksi' => 'Test Transaksi',
            'akun_debit_id' => $akunDebit->id,
            'akun_kredit_id' => $akunKredit->id,
            'jumlah_transaksi' => 1000
        ]);

        $this->service->add($request);

        $this->assertDatabaseCount('transaksi', 2);
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
