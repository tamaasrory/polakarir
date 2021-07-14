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
            ['nama_jenis_surat' => 'Instruksi'],
            ['nama_jenis_surat' => 'Surat Edaran'],
            ['nama_jenis_surat' => 'Surat Biasa'],
            ['nama_jenis_surat' => 'Surat Keterangan'],
            ['nama_jenis_surat' => 'Surat Perintah'],
            ['nama_jenis_surat' => 'Surat Izin'],
            ['nama_jenis_surat' => 'Nota Kesepakatan Bersama'],
            ['nama_jenis_surat' => 'Surat Perjanjian'],
            ['nama_jenis_surat' => 'Surat Perintah Tugas'],
            ['nama_jenis_surat' => 'Surat Perintah Perjalanan Dinas'],
            ['nama_jenis_surat' => 'Surat Kuasa'],
            ['nama_jenis_surat' => 'Surat Undangan'],
            ['nama_jenis_surat' => 'Surat Keterangan Melaksanakan Tugas'],
            ['nama_jenis_surat' => 'Surat Panggilan'],
            ['nama_jenis_surat' => 'Nota Dinas'],
            ['nama_jenis_surat' => 'Nota Pengajuan Konsep Naskah Dinas'],
            ['nama_jenis_surat' => 'Lembar Disposisi'],
            ['nama_jenis_surat' => 'Telaahan Staf'],
            ['nama_jenis_surat' => 'Pengumuman'],
            ['nama_jenis_surat' => 'Laporan'],
            ['nama_jenis_surat' => 'Rekomendasi'],
            ['nama_jenis_surat' => 'Surat Pengantar'],
            ['nama_jenis_surat' => 'Telegram'],
            ['nama_jenis_surat' => 'Lembaran Daerah'],
            ['nama_jenis_surat' => 'Berita Daerah'],
            ['nama_jenis_surat' => 'Berita Acara'],
            ['nama_jenis_surat' => 'Notulen'],
            ['nama_jenis_surat' => 'Daftar Hadir'],
            ['nama_jenis_surat' => 'Piagam'],
            ['nama_jenis_surat' => 'Sertifikat'],
            ['nama_jenis_surat' => 'Surat Tanda Tamat Pendidikian dan Pelatihan (STTPP)'],
        ];

        foreach ($jenis_surat_collection as $item){
            \App\Models\JenisSurat::create($item);
        }
    }
}
