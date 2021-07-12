<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Base\Controller;
use App\Models\FormatPenomoranSurat;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FormatPenomoranSuratController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:format-penomoran-list|format-penomoran-create|format-penomoran-edit', ['only' => 'getNomorSurat', 'index']);
        $this->middleware('permission:format-penomoran-create', ['only' => 'store']);
        $this->middleware('permission:format-penomoran-edit', ['only' => 'update']);
    }

    public function index(Request $request)
    {
        $data = DB::table('tb_format_penomoran_surat')->where('id_opd',$request->id_opd)->first();
        if ($data) {
            return [
                'value' => $data,
                'msg' => "Data Ditemukan"
            ];
        }

        return [
            'value' => [],
            'msg' => "Data Tidak Ditemukan"
        ];
    }

    public function store()
    {

    }

    public function update(Request $request, $id_format_penomoran)
    {
        $data = FormatPenomoranSurat::where('id_format_penomoran','=', $id_format_penomoran)->first();

        if ($data->update($request->all())) {
            return [
                'value' => $data,
                'msg' => "#{$id_format_penomoran} berhasil diperbarui"
            ];
        }

        return [
            'value' => [],
            'msg' => "#{$id_format_penomoran} gagal diperbarui"
        ];
    }

    public function getNomorSurat($id_opd,$kode_klasifikasi,$opd_bidang)
    {
        $data = FormatPenomoranSurat::where('id_opd', $id_opd)->first();

        if ($data)
        {
            $date = Carbon::now();
            $tahun = $date->format("Y");
            $bulan = $date->format("m");
            $bulan_romawi = $this->getRomawi($date->format("m"));
            $nomor_urut = $data->nomor_urut_terakhir+1;
            $nomor_urut_sebelumnya = $data->nomor_urut_terakhir;

            $format = explode(",", $data->format_penomoran);
            $nomor_surat = "";

            //menyusun sesuai format
            foreach ($format as $d)
            {
                if($d=="opd_bidang")
                {
                    if($nomor_surat==""){
                        $nomor_surat=$opd_bidang;
                    }else{
                        $nomor_surat=$nomor_surat."/".$opd_bidang;
                    }
                }
                if($d=="kode_klasifikasi")
                {
                    if($nomor_surat==""){
                        $nomor_surat=$kode_klasifikasi;
                    }else{
                        $nomor_surat=$nomor_surat."/".$kode_klasifikasi;
                    }
                }
                if($d=="tahun")
                {
                    if($nomor_surat==""){
                        $nomor_surat=$tahun;
                    }else{
                        $nomor_surat=$nomor_surat."/".$tahun;
                    }
                }
                if($d=="bulan_romawi")
                {
                    if($nomor_surat==""){
                        $nomor_surat=$bulan_romawi;
                    }else{
                        $nomor_surat=$nomor_surat."/".$bulan_romawi;
                    }
                }
                if($d=="bulan")
                {
                    if($nomor_surat==""){
                        $nomor_surat=$bulan;
                    }else{
                        $nomor_surat=$nomor_surat."/".$bulan;
                    }
                }
                if($d=="nomor_urut_terakhir")
                {
                    if($nomor_surat==""){
                        $nomor_surat=$nomor_urut;
                    }else{
                        $nomor_surat=$nomor_surat."/".$nomor_urut;
                    }
                }
            }
            return [
                'nomor_surat' => $nomor_surat,
                'nomor_urut' => $nomor_urut,
                'id_format_penomoran' => $data['id_format_penomoran'],
                'msg' => "Data Ditemukan"
            ];

        }

        return [
            'nomor_surat' => "",
            'nomor_urut' => "",
            'id_format_penomoran' => "",
            'msg' => "Data Tidak Ditemukan"
        ];
    }

    function getRomawi($bln){
        switch ($bln){
            case 1:
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }

}
