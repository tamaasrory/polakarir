<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbNomorSuratTerakhirTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_nomor_surat_terakhir', function (Blueprint $table) {
            $table->id('id_nomor_surat_terakhir');
            $table->bigInteger('id_jenis_surat');
            $table->smallInteger('id_opd');
            $table->string('nama_bidang_surat',100);
            $table->year('tahun_surat');
            $table->bigInteger('nomor_auto');
            $table->string('format_penomoran',100);
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
        Schema::dropIfExists('tb_nomor_surat_terakhir');
    }
}
