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
            ['id_esselon' => '6','nama_esselon' => '4B'],
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
            //badan
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '2','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-JFT_Pratama.png'],
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '3','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Administrator.png'],
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '4','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Administrator.png'],
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '5','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/BKPSDM-Pengawas.png'],

            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '0','fungsional' => '2','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Terampil.png'],
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '0','fungsional' => '3','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Penyelia.png'],
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '0','fungsional' => '4','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Mahir.png'],
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '0','fungsional' => '5','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Pertama.png'],
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '0','fungsional' => '6','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Muda.png'],
            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '0','fungsional' => '7','kode_jabatan' => '2','url' => '/pola_karir/BKPSDM-JF_Ahli_Madya.png'],

            ['id_opd' => ["01","02","03","04","05","06","07"],'esselon' => '0','fungsional' => '0','kode_jabatan' => '3','url' => '/pola_karir/BKPSDM-Pelaksana.png'],

            //dinas
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '2','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/DINKES-JFT_Pratama.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '3','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/DINKES-Administrator.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '4','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/DINKES-Administrator.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '5','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/DINKES-Pengawas.png'],

            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '0','fungsional' => '1','kode_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Pemula.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '0','fungsional' => '2','kode_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Terampil.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '0','fungsional' => '3','kode_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Penyelia.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '0','fungsional' => '4','kode_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Mahir.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '0','fungsional' => '5','kode_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Ahli_Pertama.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '0','fungsional' => '6','kode_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Ahli_Muda.png'],
            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '0','fungsional' => '7','kode_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Ahli_Madya.png'],

            ['id_opd' => ["08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"],'esselon' => '0','fungsional' => '0','kode_jabatan' => '3','url' => '/pola_karir/DINKES-Pelaksana.png'],

            //kecamatan
            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '3','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/KECAMATAN-Administrator_a.png'],
            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '4','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/KECAMATAN-Administrator_b.png'],
            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '5','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/KECAMATAN-Pengawas_a.png'],
            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '6','fungsional' => '0','kode_jabatan' => '1','url' => '/pola_karir/KECAMATAN-Pengawas_b.png'],

            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '0','fungsional' => '2','kode_jabatan' => '2','url' => '/pola_karir/KECAMATAN-JF_Terampil.png'],
            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '0','fungsional' => '3','kode_jabatan' => '2','url' => '/pola_karir/KECAMATAN-JF_Penyelia.png'],
            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '0','fungsional' => '4','kode_jabatan' => '2','url' => '/pola_karir/KECAMATAN-JF_Mahir.png'],
            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '0','fungsional' => '5','kode_jabatan' => '2','url' => '/pola_karir/KECAMATAN-JF_Ahli_Pertama.png'],

            ['id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"],'esselon' => '0','fungsional' => '0','kode_jabatan' => '3','url' => '/pola_karir/KECAMATAN-Pelaksana.png'],

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
