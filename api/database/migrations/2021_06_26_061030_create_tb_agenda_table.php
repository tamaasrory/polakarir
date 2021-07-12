<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbAgendaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_agenda', function (Blueprint $table) {
            $table->id('id_agenda');
            $table->string('nip_pegawai',22);
            $table->bigInteger('id_surat_masuk')->nullable();
            $table->string('nama_kegiatan',50);
            $table->string('deskripsi_kegiatan',250);
            $table->dateTime('waktu_mulai');
            $table->dateTime('waktu_akhir');
            $table->string('lokasi',250);
            $table->bigInteger('id_opd');
            $table->string('status',30);
            $table->string('color',30);
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
        Schema::dropIfExists('tb_agenda');
    }
}
