<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkjTable extends Migration
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
            $table->string('kelompok_jabatan');
            $table->string('urusan_pemerintah');
            $table->string('kode_jabatan');
            $table->string('id_opd');
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
        Schema::dropIfExists('skj');
    }
}
