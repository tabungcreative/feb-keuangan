<?php

namespace Database\Factories;

use App\Models\Akun;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TransaksiFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'tanggal' => $this->faker->date(),
            'kode_transaksi' => $this->faker->uuid(),
            'nama_transaksi' => $this->faker->word(3),
            'akun_id' => Akun::factory()->create()->id,
            'debit' => Arr::random([0, 10000]),
            'kredit' => Arr::random([0, 10000]),
        ];
    }
}
