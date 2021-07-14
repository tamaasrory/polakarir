<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbKlasifikasiTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_klasifikasi', function (Blueprint $table) {
            $table->id('id_klasifikasi');
            $table->string('kode_klasifikasi',50);
            $table->string('nama_klasifikasi',200);
            $table->string('parent_kode',50)->nullable();
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
        Schema::dropIfExists('tb_klasifikasi');
    }
}
