<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use function Illuminate\Events\queueable;

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
        $esselon_collection = [

            ['id_esselon' => '1','nama_esselon' => '2A'],
            ['id_esselon' => '2','nama_esselon' => '2B'],
            ['id_esselon' => '3','nama_esselon' => '3A'],
            ['id_esselon' => '4','nama_esselon' => '3B'],
            ['id_esselon' => '5','nama_esselon' => '4A'],
            ['id_esselon' => '0','nama_esselon' => '-'],
        ];

        $jenis_jabatan_collection = [
            ['id_jenis_jabatan' => '1','nama_jenis_jabatan' => 'Struktural'],
            ['id_jenis_jabatan' => '2','nama_jenis_jabatan' => 'Fungsional'],
            ['id_jenis_jabatan' => '3','nama_jenis_jabatan' => 'Pelaksana'],
            ['id_jenis_jabatan' => '0','nama_jenis_jabatan' => '-'],
            ];

        $fungsional_collection = [
            ['id_fungsional' => '1','nama_fungsional' => 'Pemula'],
            ['id_fungsional' => '2','nama_fungsional' => 'Terampil'],
            ['id_fungsional' => '3','nama_fungsional' => 'Mahir'],
            ['id_fungsional' => '4','nama_fungsional' => 'Penyelia'],
            ['id_fungsional' => '5','nama_fungsional' => 'Ahli Pertama'],
            ['id_fungsional' => '6','nama_fungsional' => 'Ahli Muda'],
            ['id_fungsional' => '7','nama_fungsional' => 'Ahli Madya'],
            ['id_fungsional' => '8','nama_fungsional' => 'Ahli Utama'],
            ['id_fungsional' => '0','nama_fungsional' => '-'],

        ];

        $pola_collection = [
            ['esselon' => '2','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-JFT_Pratama.png'],
            ['esselon' => '3','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Administrator.png'],
            ['esselon' => '4','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Administrator.png'],
            ['esselon' => '5','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Pengawas.png'],

            ['esselon' => '0','fungsional' => '2','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Terampil.png'],
            ['esselon' => '0','fungsional' => '3','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Penyelia.png'],
            ['esselon' => '0','fungsional' => '4','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Mahir.png'],
            ['esselon' => '0','fungsional' => '5','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Pertama.png'],
            ['esselon' => '0','fungsional' => '6','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Muda.png'],
            ['esselon' => '0','fungsional' => '7','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Madya.png'],

            ['esselon' => '0','fungsional' => '0','kode_jabatan' => '3','url' => '/pola_karir/BKPSDM-Pelaksana.png'],

        ];


        foreach ($jenis_jabatan_collection as $item){
            \App\Models\JenisJabatan::create($item);
        }
        foreach ($esselon_collection as $item){
            \App\Models\Esesslon::create($item);
        }
        foreach ($fungsional_collection as $item){
            \App\Models\Fungsional::create($item);
        }

        foreach ($pola_collection as $item){
            \App\Models\PolaKarir::create($item);
        }
    }
}
