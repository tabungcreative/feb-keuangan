<?php

namespace Tests\Feature\Traits;

use App\Models\Pembayaran;
use App\Traits\Numbering;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class NumberingTest extends TestCase
{
    use Numbering, RefreshDatabase;
    public function test_numbering_payment_without_data()
    {
        $nomerPembayaran = $this->nomerPembayaran('TEST');
        $this->assertSame('TEST-' . Carbon::parse(now())->translatedFormat('Y') . '-0001', $nomerPembayaran);
    }

    public function test_numbering_payment_with_data()
    {
        Pembayaran::factory()->create();
        $nomerPembayaran = $this->nomerPembayaran('TEST');
        $this->assertSame('TEST-' . Carbon::parse(now())->translatedFormat('Y') . '-0002', $nomerPembayaran);
    }
}
