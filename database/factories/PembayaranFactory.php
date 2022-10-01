<?php

namespace Database\Factories;

use App\Models\JenisPembayaran;
use App\Traits\Numbering;
use Illuminate\Database\Eloquent\Factories\Factory;

class PembayaranFactory extends Factory
{
    use Numbering;
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'no_pembayaran' => $this->nomerPembayaran('TEST'),
            'nim' => $this->faker->word(10),
            'tanggal_bayar' => $this->faker->date(),
            'jenis_pembayaran_id' => JenisPembayaran::factory()->create()->id
        ];
    }
}
