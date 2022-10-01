<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class JenisPembayaranFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'nama' => $this->faker->word(3, true),
            'kode' => $this->faker->word(3, true),
            'jumlah_bayar' => $this->faker->randomNumber(),
        ];
    }
}
