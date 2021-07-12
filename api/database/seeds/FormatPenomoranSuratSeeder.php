<?php

namespace Database\Seeders;

use App\Models\FormatPenomoranSurat;
use App\Models\OPDBidang;
use Illuminate\Database\Seeder;

class FormatPenomoranSuratSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $format_penomoran_surat = [
            ['id_opd' => 1, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 2, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 3, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 4, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 5, 'format_penomoran' => 'kode_klasifikasi,opd_bidang,nomor_urut_terakhir,tahun', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 6, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 7, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 8, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 9, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 10, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 11, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 12, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 13, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 14, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 15, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 16, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 17, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 18, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 19, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 20, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 21, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 22, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 23, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 24, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 25, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 26, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 27, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 28, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 29, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 30, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 31, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 32, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 33, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 34, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 35, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 36, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 38, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 39, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 40, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 42, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 43, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 44, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 45, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 46, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 47, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 48, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 49, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 50, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0],
            ['id_opd' => 51, 'format_penomoran' => '', 'nomor_urut_terakhir' => 0]
        ];

        foreach ($format_penomoran_surat as $item){
            FormatPenomoranSurat::create($item);
        }

        //data dummy OPDBidang
        $opd_bidang = [
            ['id_opd' => 5, 'nama_opd_bidang' => 'BPP Inotek'],
            ['id_opd' => 5, 'nama_opd_bidang' => 'BPP Umum']
        ];
        foreach ($opd_bidang as $data){
            OPDBidang::create($data);
        }
    }
}
