<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbSuratMasukTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_surat_masuk', function (Blueprint $table) {
            $table->id('id_surat_masuk');
            $table->smallInteger('id_opd');
            $table->string('kode_jabatan_terusan',30);
            $table->bigInteger('id_jenis_surat');
            $table->string('nomor_surat',250);
            $table->date('tanggal_surat');
            $table->date('tanggal_terima');
            $table->text('asal_surat');
            $table->string('perihal_surat',250);
            $table->text('isi_surat_ringkas');
            $table->string('kategori_surat',40);
            $table->string('karakteristik_surat',40);
            $table->string('derajat_surat',40);
            $table->text('catatan');
            $table->text('lampiran');
            $table->string('status',30);
            $table->json('penerima_surat');
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
        Schema::dropIfExists('tb_surat_masuk');
    }
}
