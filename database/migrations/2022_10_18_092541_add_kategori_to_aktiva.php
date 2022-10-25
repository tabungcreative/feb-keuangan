<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddKategoriToAktiva extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aktiva', function (Blueprint $table) {
            $table->enum('kategori', ['peralatan', 'perlengkapan','gedung'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('aktiva', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
}
