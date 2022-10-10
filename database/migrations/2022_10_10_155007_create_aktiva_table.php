<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAktivaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('aktiva', function (Blueprint $table) {
            $table->id();
            $table->string('kode_aktiva');
            $table->string('nama_aktiva');
            $table->string('jenis_aktiva');
            $table->date('tanggal_perolehan');
            $table->integer('harga_perolehan');
            $table->double('penyusutan_perhari');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('aktiva');
    }
}
