<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSuratKeluarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_surat_keluar', function (Blueprint $table) {
            $table->id('id_surat_keluar');
            $table->string('nip_author', 22);
            $table->bigInteger('id_opd');
            $table->string('kode_jabatan_terusan', 30);
            $table->bigInteger('id_jenis_surat');
            $table->string('nomor_surat', 250);
            $table->date('tanggal_surat');
            $table->string('perihal_surat', 250);
            $table->text('isi_surat_ringkas');
            $table->string('kategori_surat', 40);
            $table->string('karakteristik_surat', 40);
            $table->string('derajat_surat', 40);
            $table->text('catatan');
            $table->text('lampiran');
            $table->string('status', 30);
            $table->json('histori_surat');
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
        Schema::dropIfExists('tb_surat_keluar');
    }
}
