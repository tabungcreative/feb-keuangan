<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class AkunFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->word(10),
            'saldo_awal' => 0,
            'akun_kas' => Arr::random(['kas_masuk', 'kas_keluar', 'kas_jalan']),
        ];
    }
}
