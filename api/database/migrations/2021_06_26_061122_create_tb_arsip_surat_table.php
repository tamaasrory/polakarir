<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbArsipSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_arsip_surat', function (Blueprint $table) {
            $table->id('id_arsip_surat');
            $table->bigInteger('id_klasifikasi');
            $table->string('nomor_berkas',150);
            $table->string('nama_berkas',200);
            $table->string('lokasi_fisik',250);
            $table->text('url_softfile');
            $table->date('retensi_aktif');
            $table->date('retensi_inaktif');
            $table->string('tindakan_penyusutan',50);
            $table->dateTime('waktu_diarsiapkan');
            $table->json('jenis_arsip');
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
        Schema::dropIfExists('tb_arsip_surat');
    }
}
