<?php

namespace Database\Seeders;

use App\Models\JenisSurat;
use Illuminate\Database\Seeder;

class JenisSuratTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $jenis_surat_collection = [
            ['kode_surat' => '-','nama_jenis_surat' => 'Instruksi'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Edaran'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Biasa'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Keterangan'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Perintah'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Izin'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Nota Kesepakatan Bersama'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Perjanjian'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Perintah Tugas'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Perintah Perjalanan Dinas'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Kuasa'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Undangan'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Keterangan Melaksanakan Tugas'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Panggilan'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Nota Dinas'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Nota Pengajuan Konsep Naskah Dinas'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Lembar Disposisi'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Telaahan Staf'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Pengumuman'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Laporan'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Rekomendasi'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Pengantar'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Telegram'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Lembaran Daerah'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Berita Daerah'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Berita Acara'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Notulen'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Daftar Hadir'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Piagam'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Sertifikat'],
            ['kode_surat' => '-','nama_jenis_surat' => 'Surat Tanda Tamat Pendidikian dan Pelatihan (STTPP)'],
        ];

        foreach ($jenis_surat_collection as $item){
            \App\Models\JenisSurat::create($item);
        }
    }
}
