<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusAndUmurEkonomisToAktivaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('aktiva', function (Blueprint $table) {
            $table->boolean('is_active')->default(1);
            $table->integer('umur_ekonomis')->default(0);
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
            $table->dropColumn('is_active');
            $table->dropColumn('umur_ekonomis');
        });
    }
}
