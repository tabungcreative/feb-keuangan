<?php

namespace Database\Seeders;

use App\Models\Akun;
use Illuminate\Database\Seeder;

class CreateKasAkun extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Akun::factory()->create(['nama' => 'Kas', 'akun_kas' => 'kas_jalan']);
    }
}
