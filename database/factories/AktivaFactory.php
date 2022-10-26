<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AktivaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'kode_aktiva' => $this->faker->unixTime,
            'nama_aktiva' => $this->faker->word(10),
            'tanggal_perolehan' => $this->faker->date,
            'harga_perolehan' => 100000,
            'umur_ekonomis' => 10,
            'is_active' => 1,
            'penyusutan_perhari' => 0,
        ];
    }
}
