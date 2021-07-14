<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbFormatPenomoranSurat extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_format_penomoran_surat', function (Blueprint $table) {
            $table->id('id_format_penomoran');
            $table->bigInteger('id_opd');
            $table->string('format_penomoran',200);
            $table->bigInteger('nomor_urut_terakhir');
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
        Schema::dropIfExists('tb_format_penomoran_surat');
    }
}
