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
            //Badan dan Inspektorat
            ['esselon' => '2','fungsional' => '0','jenis_jabatan' => '1','id_opd' => ["1","2","3","4","5","6","7","8"],'url' => '/pola_karir/BKPSDM-JFT_Pratama.png'],
            ['esselon' => '3','fungsional' => '0','jenis_jabatan' => '1','id_opd' => ["1","2","3","4","5","6","7","8"],'url' => '/pola_karir/BKPSDM-Administrator.png'],
            ['esselon' => '4','fungsional' => '0','jenis_jabatan' => '1','id_opd' => ["1","2","3","4","5","6","7","8"],'url' => '/pola_karir/BKPSDM-Administrator.png'],
            ['esselon' => '5','fungsional' => '0','jenis_jabatan' => '1','id_opd' => ["1","2","3","4","5","6","7","8"],'url' => '/pola_karir/BKPSDM-Pengawas.png'],
            ['esselon' => '6','fungsional' => '0','jenis_jabatan' => '1','id_opd' => ["1","2","3","4","5","6","7","8"],'url' => '/pola_karir/BKPSDM-Pengawas.png'],

            ['esselon' => '0','fungsional' => '2','jenis_jabatan' => '2','id_opd' => ["1","2","3","4","5","6","7","8","30"],'url' => '/pola_karir/BKPSDM-JF_Terampil.png'],
            ['esselon' => '0','fungsional' => '3','jenis_jabatan' => '2','id_opd' => ["1","2","3","4","5","6","7","8","30"],'url' => '/pola_karir/BKPSDM-JF_Penyelia.png'],
            ['esselon' => '0','fungsional' => '4','jenis_jabatan' => '2','id_opd' => ["1","2","3","4","5","6","7","8","30"],'url' => '/pola_karir/BKPSDM-JF_Mahir.png'],
            ['esselon' => '0','fungsional' => '5','jenis_jabatan' => '2','id_opd' => ["1","2","3","4","5","6","7","8","30"],'url' => '/pola_karir/BKPSDM-JF_Ahli_Pertama.png'],
            ['esselon' => '0','fungsional' => '6','jenis_jabatan' => '2','id_opd' => ["1","2","3","4","5","6","7","8","30"],'url' => '/pola_karir/BKPSDM-JF_Ahli_Muda.png'],
            ['esselon' => '0','fungsional' => '7','jenis_jabatan' => '2','id_opd' => ["1","2","3","4","5","6","7","8","30"],'url' => '/pola_karir/BKPSDM-JF_Ahli_Madya.png'],

            ['esselon' => '0','fungsional' => '0','jenis_jabatan' => '3','id_opd' => ["1","2","3","4","5","6","7","8","30"],'url' => '/pola_karir/BKPSDM-Pelaksana.png'],

            //Dinas

            ['esselon' => '2','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/DINKES-JFT_Pratama.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '3','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/DINKES-Administrator.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '4','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/DINKES-Administrator.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '5','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/DINKES-Pengawas.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '6','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/DINKES-Pengawas.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],

            ['esselon' => '0','fungsional' => '1','jenis_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Pemula.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '0','fungsional' => '2','jenis_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Terampil.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '0','fungsional' => '3','jenis_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Penyelia.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '0','fungsional' => '4','jenis_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Mahir.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '0','fungsional' => '5','jenis_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Ahli_Pertama.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '0','fungsional' => '6','jenis_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Ahli_Muda.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],
            ['esselon' => '0','fungsional' => '7','jenis_jabatan' => '2','url' => '/pola_karir/DINKES-JF_Ahli_Madya.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],

            ['esselon' => '0','fungsional' => '0','jenis_jabatan' => '3','url' => '/pola_karir/DINKES-Pelaksana.png','id_opd' => ["9","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29"]],

            // Kecamatan

            ['esselon' => '3','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/KECAMATAN-Administrator_a.png','id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],
            ['esselon' => '4','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/KECAMATAN-Administrator_b.png','id_opd' =>["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],
            ['esselon' => '5','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/KECAMATAN-Pengawas_a.png','id_opd' =>["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],
            ['esselon' => '6','fungsional' => '0','jenis_jabatan' => '1','url' => '/pola_karir/KECAMATAN-Pengawas_b.png','id_opd' =>["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],

            ['esselon' => '0','fungsional' => '2','jenis_jabatan' => '2','url' => '/pola_karir/KECAMATAN-JF_Terampil.png','id_opd' =>["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],
            ['esselon' => '0','fungsional' => '3','jenis_jabatan' => '2','url' => '/pola_karir/KECAMATAN-JF_Penyelia.png','id_opd' =>["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],
            ['esselon' => '0','fungsional' => '4','jenis_jabatan' => '2','url' => '/pola_karir/KECAMATAN-JF_Mahir.png','id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],
            ['esselon' => '0','fungsional' => '5','jenis_jabatan' => '2','url' => '/pola_karir/KECAMATAN-JF_Ahli_Pertama.png','id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],

            ['esselon' => '0','fungsional' => '0','jenis_jabatan' => '3','url' => '/pola_karir/KECAMATAN-Pelaksana.png','id_opd' => ["31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50"]],
            ];

        $skj_collection = [
            //Data Badan
            ['nama_jabatan' => 'Kepala Badan Kepegawaian dan Pengembangan Sumber Daya Manusia','kelompok_jabatan' => 'Jabatan Pimpinan Tinggi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772517.doc'],
            ['nama_jabatan' => 'Sekretaris','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Urusan Penunjang Bidang Kepegawaian, Pendidikan dan Pelatihan','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772518.doc'],
            ['nama_jabatan' => 'Kepala Sub Bagian Program','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Urusan Penunjang Bidang Kepegawaian, Pendidikan dan Pelatihan','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772519.doc'],
            ['nama_jabatan' => 'Kepala Sub Bagian Keuangan','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Urusan Penunjang Bidang Kepegawaian, Pendidikan dan Pelatihan','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772520.doc'],
            ['nama_jabatan' => 'Kepala Sub Bagian Umum','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Urusan Penunjang Bidang Kepegawaian, Pendidikan dan Pelatihan','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772521.doc'],
            ['nama_jabatan' => 'Kepala Bidang Penilaian Kinerja Aparatur dan Penghargaan','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772522.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Disiplin dan Penghargaan','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772523.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Penilaian dan Evaluasi Kinerja Jabatan Struktural','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772524.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Penilaian dan Evaluasi Kinerja Jabatan Fungsional','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772525.doc'],
            ['nama_jabatan' => 'Kepala Bidang Pengadaan, Pemberhentian dan Sistem Informasi ASN','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772526.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Pengadaan dan Pemberhentian','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772527.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Sistem Informasi ASN','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772528.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang fasilitasi Profesi ASN','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772529.doc'],
            ['nama_jabatan' => 'Kepala Bidang Mutasi dan Promosi','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772530.docx'],
            ['nama_jabatan' => 'Kepala Sub Bidang Pengembangan Karir dan Promosi','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772531.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Pengembangan Karir dan Promosi','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772532.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Mutasi','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772533.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Kepangkatan','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772534.doc'],
            ['nama_jabatan' => 'Kepala Bidang Pengembangan Kompetensi Aparatur','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772535.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Pelatihan Struktural Kepemimpinan dan Pelatihan Dasar','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772536.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Pelatihan Teknis Fungsional dan Sosial Kultural','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/draf-1630772537.doc'],
            ['nama_jabatan' => 'Kepala Sub Bidang Peningkatan Pendidikan PNS','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Pemerintahan Umum (fungsi penunjang)','jenis_jabatan' => '-','id_opd' => '2','url_berkas' => '/skj/Badan/'],

            //Data Dinas
            ['nama_jabatan' => 'Kepala Dinas','kelompok_jabatan' => 'Jabatan Pimpinan Tinggi','urusan_pemerintah' => 'Bidang Pendidikan','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772497.doc'],
            ['nama_jabatan' => 'Sekretaris Dinas','kelompok_jabatan' => 'Jabatan Administrator','urusan_pemerintah' => 'Bidang Pendidikan Sub Urusan Umum, Keuangan dan Penyusunan Program','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772498.doc'],
            ['nama_jabatan' => 'Kepala Sub Bagian Umum','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Kesekretariatan','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772499.doc'],
            ['nama_jabatan' => 'Sub Bagian Keuangan','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Kesekretariatan','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772500.docx'],
            ['nama_jabatan' => 'Kepala Sub Bagian Program','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Kesekretariatan','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772501.doc'],
            ['nama_jabatan' => 'Kepala Bidang PAUD dan PNF','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang PAUD dan PNF Sub Urusan Kurikulum dan Penilaian PAUD, Ketenagaan PAUD dan PNF, dan Pendidikan Non Formal','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772502.doc'],
            ['nama_jabatan' => 'Seksi Kurikulum dan Penilaian PAUD','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang PAUD dan PNF','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772503.doc'],
            ['nama_jabatan' => 'Seksi Pendidikan Non Formal','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang PAUD dan PNF','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772504.docx'],
            ['nama_jabatan' => 'Kepala Bidang Pembinaan Pendidikan SD','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Pembinaan Pendidikan SD Sub Urusan Pendidik dan Tenaga Kependidikan','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772505.doc'],
            ['nama_jabatan' => 'Kepala Seksi Kurikulum dan Penilaian SD','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Pembinaan Pendidikan SD','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772506.doc'],
            ['nama_jabatan' => 'Kepala Seksi Ketenagaan Pendidikan SD','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Pembinaan dan Penilaian SD','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772507.doc'],
            ['nama_jabatan' => 'Seksi Kesiswaan','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Pembinaan Pendidikan SD','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772508.doc'],
            ['nama_jabatan' => 'Kepala Bidang Pembinaan Pendidikan SMP','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Pembinaan Pendidikan SMP Sub Urusan Pendidik dan Tenaga Kependidikan','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772509.doc'],
            ['nama_jabatan' => 'Seksi Kurikulum dan Penilaian Pembinaan Pendidikan SMP','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Pembinaan Pendidikan SMP','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772510.docx'],
            ['nama_jabatan' => 'Seksi Ketenagaan Pembinaan Pendidikan SMP','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Pembinaan Pendidikan SMP','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772511.docx'],
            ['nama_jabatan' => 'Seksi Kesiswaan Pembinaan Pendidikan SMP','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Bidang Pembinaan Pendidikan SMP','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772512.docx'],
            ['nama_jabatan' => 'Kepala Bidang Sarana dan Prasarana','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Sarana dan Prasarana Sub Urusan Bidang Sarana dan Prasarana','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772513.doc'],
            ['nama_jabatan' => 'Seksi Sarana dan Prasarana PAUD','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Sarana dan Prasarana PAUD Sub Urusan Seksi Sarana dan Prasarana PAUD','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772514.doc'],
            ['nama_jabatan' => 'Seksi Sarana dan Prasarana SD','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Sarana dan Prasarana SD Sub Urusan Seksi Sarana dan Prasarana SD','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772515.doc'],
            ['nama_jabatan' => 'Seksi Sarana dan Prasarana SMP','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Sarana dan Prasarana SMP Sub Urusan Seksi Sarana dan Prasarana SMP','jenis_jabatan' => '-','id_opd' => '1','url_berkas' => '/skj/Dinas/draf-1630772516.doc'],

            //Inspektorat
            ['nama_jabatan' => 'Inspektur','kelompok_jabatan' => 'Jabatan Pimpinan Tingg','urusan_pemerintah' => 'Bidang Pengawasan','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772538.doc'],
            ['nama_jabatan' => 'Sekretaris','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Kesektariatan','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772539.doc'],
            ['nama_jabatan' => 'Kepala Sub Bagian Umum','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Kesektariatan','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772540.doc'],
            ['nama_jabatan' => 'Kepala Sub Bagian Keuangan','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Kesektariatan','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772541.doc'],
            ['nama_jabatan' => 'Kepala Sub Bagian Program','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Bidang Kesektariatan','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772542.doc'],
            ['nama_jabatan' => 'Inspektur Pembantu I','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Unsur pengawas penyelenggaraan Pemerintahan Daerah','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772543.doc'],
            ['nama_jabatan' => 'Inspektur Pembantu II','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Unsur pengawas penyelenggaraan Pemerintahan Daerah','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772544.doc'],
            ['nama_jabatan' => 'Inspektur Pembantu III','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Unsur pengawas penyelenggaraan Pemerintahan Daerah','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772545.doc'],
            ['nama_jabatan' => 'Inspektur Pembantu dan IV','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Unsur pengawas penyelenggaraan Pemerintahan Daerah','jenis_jabatan' => '-','id_opd' => '3','url_berkas' => '/skj/Inspektorat/draf-1630772546.doc'],


            //Kecamatan
            ['nama_jabatan' => 'Lurah','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Umum dan pelimpahan sebagian kewenangan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772547.docx'],
            ['nama_jabatan' => 'Camat Tipe A','kelompok_jabatan' => 'Administator','urusan_pemerintah' => 'Umum dan pelimpahan sebagian kewenangan Walikota Pekanbaru kepada Camat','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772548.doc'],
            ['nama_jabatan' => 'Sekretaris Lurah','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Umum Sub Urusan Kesekretariatan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772549.docx'],
            ['nama_jabatan' => 'Sekretaris Camat','kelompok_jabatan' => 'Administator','urusan_pemerintah' => 'Kesekretariatan Kecamatan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772550.docx'],
            ['nama_jabatan' => 'Seksi Pemerintahan, Ketentraman dan Ketertiban Kelurahan','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Umum Sub Bagian Pemerintahan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772551.docx'],
            ['nama_jabatan' => 'Kepala Sub Bagian Umum','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Umum Sub Urusan Umum Kesekretariatan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772552.docx'],
            ['nama_jabatan' => 'Kepala Seksi Pembangunan dan Pemberdayaan Masyarakat Kelurahan ','kelompok_jabatan' => 'Jabatan Administrasi','urusan_pemerintah' => 'Umum sub urusan pembangunan dan pemberdayaan masyarakat kelurahan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772553.docx'],
            ['nama_jabatan' => 'Kepala Sub Bagian Keuangan','kelompok_jabatan' => 'Jabatan Pengawas','urusan_pemerintah' => 'Umum, Sub Urusan Keuangan Kecamatan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772554.doc'],
            ['nama_jabatan' => 'Seksi Kesejahteraan Sosial Kelurahan','kelompok_jabatan' => 'Administrasi','urusan_pemerintah' => 'Umum Sub Urusan Kesejahteraan Sosial','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772555.docx'],
            ['nama_jabatan' => 'Kepala Seksi Pemerintahan Kecamatan Rumbai','kelompok_jabatan' => 'Pengawas','urusan_pemerintah' => 'Umum Sub Urusan Pemerintahan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '//skj/Kecamatan/draf-1630772556.doc'],
            ['nama_jabatan' => 'Kepala Seksi Pembangunan dan Pemberdayaan Masyarakat','kelompok_jabatan' => 'Pengawas','urusan_pemerintah' => 'Umum Sub Urusan Bidang Pembangunan dan Pemberdayaan Masyarakat','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772557.doc'],
            ['nama_jabatan' => 'Kepala Seksi Kesejahteraan Sosial','kelompok_jabatan' => 'Pengawas','urusan_pemerintah' => 'Umum Sub Urusan Bidang Kesejahteraan Sosial','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772558.doc'],
            ['nama_jabatan' => 'Kepala Seksi Pelayanan Terpadu','kelompok_jabatan' => 'Pengawas','urusan_pemerintah' => 'Umum Sub Urusan Bidang Pelayanan','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772559.doc'],
            ['nama_jabatan' => 'Kepala Seksi Ketentraman dan Ketertiban Kecamatan Rumba','kelompok_jabatan' => 'Pengawas','urusan_pemerintah' => 'Umum, Sub Urusan Ketentraman dan Ketertiban','jenis_jabatan' => '-','id_opd' => '4','url_berkas' => '/skj/Kecamatan/draf-1630772560.doc'],



        ];

        $syarat_jabatan_collection = [
            ['nama_syarat' => 'SYARAT JABATAN PIMPINAN TINGGI PRATAMA (1)','jenis_jabatan' => 'Fungsional','kode_jabatan' => '1','url_berkas' => '/syarat_jabatan/draf-1626842985.docx'],
            ['nama_syarat' => 'SYARAT JABATAN ADMINISTRATOR (SETARA ESELON III.a)','jenis_jabatan' => 'Struktural','kode_jabatan' => '1','url_berkas' => '/syarat_jabatan/draf-1626842979.docx'],
            ['nama_syarat' => 'SYARAT JABATAN ADMINISTRATOR (SETARA ESELON III.b)','jenis_jabatan' => 'Struktural','kode_jabatan' => '1','url_berkas' => '/syarat_jabatan/draf-1626842980.docx'],
            ['nama_syarat' => 'SYARAT JABATAN PENGAWAS (SETARA ESELON IV.a)','jenis_jabatan' => 'Struktural','kode_jabatan' => '1','url_berkas' => '/syarat_jabatan/draf-1626842983.docx'],
            ['nama_syarat' => 'SYARAT JABATAN PENGAWAS (SETARA ESELON IV.b)','jenis_jabatan' => 'Struktural','kode_jabatan' => '1','url_berkas' => '/syarat_jabatan/draf-1626842984.docx'],
            ['nama_syarat' => 'SYARAT JABATAN FUNGSIONAL KATEGORI AHLI','jenis_jabatan' => 'Fungsional','kode_jabatan' => '2','url_berkas' => '/syarat_jabatan/draf-1626842981.docx'],
            ['nama_syarat' => 'SYARAT JABATAN FUNGSIONAL KATEGORI TERAMPIL','jenis_jabatan' => 'Fungsional','kode_jabatan' => '2','url_berkas' => '/syarat_jabatan/draf-1626842982.docx'],



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
        foreach ($skj_collection as $item){
            \App\Models\SKJ::create($item);
        }
        foreach ($syarat_jabatan_collection as $item){
            \App\Models\SyaratJabatan::create($item);
        }
    }
}
