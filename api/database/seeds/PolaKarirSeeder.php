<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class PolaKarirSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $pola_collection = [

            ['esselon' => '0','fungsional' => '7','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Madya.png'],
            ['esselon' => '0','fungsional' => '6','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Muda.png'],
            ['esselon' => '0','fungsional' => '5','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Pertama.png'],
            ['esselon' => '0','fungsional' => '4','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Mahir.png'],
            ['esselon' => '0','fungsional' => '3','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Penyelia.png'],
            ['esselon' => '0','fungsional' => '2','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Terampil.png'],
            ['esselon' => '2','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-JFT_Pratama.png'],
            ['esselon' => '3','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Administrator.png'],
            ['esselon' => '5','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Pengawas.png'],
            ['esselon' => '4','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Pengawas.png'],
            ['esselon' => '0','fungsional' => '0','kode_jabatan' => '3','url' => '/pola_karir/BKPSDM-Pelaksana.png'],


        ];

        foreach ($pola_collection as $item){
            \App\Models\PolaKarir::create($item);
        }
    }
}
