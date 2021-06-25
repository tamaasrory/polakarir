<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTbDisposisiSuratTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tb_disposisi_surat', function (Blueprint $table) {
            $table->id('id_disposisi');
            $table->bigInteger('id_surat_masuk');
            $table->string('nip_pendisposisi',22);
            $table->string('nip_disposisi',22);
            $table->text('isi_disposisi');
            $table->text('ket_disposisi');
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
        Schema::dropIfExists('tb_disposisi_surat');
    }
}
