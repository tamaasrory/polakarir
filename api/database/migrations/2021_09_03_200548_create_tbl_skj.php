<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSkj extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_skj', function (Blueprint $table) {
            $table->id();
            $table->string('nama_jabatan');
            $table->text('kelompok_jabatan');
            $table->text('urusan_pemerintah');
            $table->text('kode_jabatan');
            $table->text('id_opd');
            $table->text('url_berkas');
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
        Schema::dropIfExists('tbl_skj');
    }
}
