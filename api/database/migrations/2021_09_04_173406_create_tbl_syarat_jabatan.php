<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblSyaratJabatan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_syarat_jabatan', function (Blueprint $table) {
            $table->id('id_syarat_jabatan');
            $table->string('nama_syarat');
            $table->string('jenis_jabatan');
            $table->string('kode_jabatan');
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
        Schema::dropIfExists('tbl_syarat_jabatan');
    }
}
