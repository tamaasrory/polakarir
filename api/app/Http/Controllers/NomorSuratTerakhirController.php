<?php
namespace App\Http\Controllers;

use App\NomorSuratTerakhir;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class NomorSuratTerakhirController extends Controller {

    public $title = 'Nomor Surat Terakhir';

    public function __construct()
    {
        $this->middleware('permission:nomorsuratterakhir-list|nomorsuratterakhir-create|nomorsuratterakhir-edit|nomorsuratterakhir-delete', ['only' => 'index','getNomorTerakhir']);
        $this->middleware('permission:nomorsuratterakhir-create', ['only' => 'store']);
        $this->middleware('permission:nomorsuratterakhir-edit', ['only' => 'edit']);
        $this->middleware('permission:nomorsuratterakhir-delete', ['only' => 'destroy']);
        $this->middleware('permission:nomorsuratterakhir-view', ['only' => 'indexByOPD','getNomorTerakhir']);
    }

    public function index()
    {
        $data = DB::table('tb_nomor_surat_terakhir')
            ->join('tb_jenis_surat', 'tb_nomor_surat_terakhir.id_jenis_surat', '=','tb_jenis_surat.id_jenis_surat')
            ->select('tb_nomor_surat_terakhir.*', 'tb_jenis_surat.kode_surat', 'tb_jenis_surat.nama_jenis_surat')
            ->paginate(20);

        if ($data) {
            return [
                'value' => $data,
                'msg' => "Data {$this->title} Ditemukan"
            ];
        }
        return [
            'value' => [],
            'msg' => "Data {$this->title} Tidak Ditemukan"
        ];
    }

    public function indexByOPD(Request $request)
    {
        $data = DB::table('tb_nomor_surat_terakhir')
            ->join('tb_jenis_surat', 'tb_nomor_surat_terakhir.id_jenis_surat', '=','tb_jenis_surat.id_jenis_surat')
            ->where(["id_opd"=>$request->id_opd])
            ->select('tb_nomor_surat_terakhir.*', 'tb_jenis_surat.kode_surat', 'tb_jenis_surat.nama_jenis_surat')
            ->paginate(20);

        if ($data) {
            return [
                'value' => $data,
                'msg' => "Data {$this->title} Ditemukan"
            ];
        }
        return [
            'value' => [],
            'msg' => "Data {$this->title} Tidak Ditemukan"
        ];
    }

    public function getNomorTerakhir(Request $request)
    {
        $data = DB::table('tb_nomor_surat_terakhir')
            ->join('tb_jenis_surat', 'tb_nomor_surat_terakhir.id_jenis_surat', '=','tb_jenis_surat.id_jenis_surat')
            ->where(["tb_nomor_surat_terakhir.id_opd"=>$request->id_opd,'tb_nomor_surat_terakhir.id_jenis_surat'=>$request->id_jenis_surat])
            ->select('tb_nomor_surat_terakhir.*', 'tb_jenis_surat.kode_surat', 'tb_jenis_surat.nama_jenis_surat')
            ->first();

        if ($data) {
            $format = explode("/", $data->format_penomoran);
            $format_terakhir="";
            $format_selanjutnya="";
            foreach ($format as $d) {
                //jika pertama tidak pakai slash
                if($format_terakhir==""){
                    $format_terakhir=$data->$d;
                }else {
                    $format_terakhir = $format_terakhir . "/" . $data->$d;
                }

                //auto increment utk nomor_auto
                if($d=="nomor_auto"){
                    $data->$d=$data->$d+1;
                }

                //jika pertama tidak pakai slash
                if($format_selanjutnya==""){
                    $format_selanjutnya=$data->$d;
                }else{
                    $format_selanjutnya=$format_selanjutnya."/".$data->$d;
                }
            }

            return [
                'nomor_terakhir' => $format_terakhir,
                'nomor_selanjutnya' => $format_selanjutnya,
                'msg' => "Data {$this->title} Ditemukan"
            ];
        }
        return [
            'nomor_terakhir' => "",
            'nomor_selanjutnya' => "",
            'msg' => "Data {$this->title} Tidak Ditemukan"
        ];
    }

    public function store(Request $request)
    {
        $tambah = DB::table('tb_nomor_surat_terakhir')->insert([
            'id_jenis_surat' => $request->id_jenis_surat,
            'id_opd' => $request->id_opd,
            'nama_bidang_surat' => $request->nama_bidang_surat,
            'tahun_surat' => $request->tahun_surat,
            'nomor_auto' => $request->nomor_auto,
            'format_penomoran' => $request->format_penomoran,
            'created_at' => Carbon::now(),
            'modified_at' => Carbon::now()
        ]);
        if($tambah){
            return response()->json(['msg' => 'Berhasil disimpan']);
        }else{
            return response()->json(['msg' => 'Terjadi masalah, coba lagi']);
        }

    }

    public function edit(Request $request)
    {
        $edit = DB::table('tb_nomor_surat_terakhir')
            ->where('id_nomor_surat_terakhir',$request->id_nomor_surat_terakhir)
            ->update([
            'id_jenis_surat' => $request->id_jenis_surat,
            'id_opd' => $request->id_opd,
            'nama_bidang_surat' => $request->nama_bidang_surat,
            'tahun_surat' => $request->tahun_surat,
            'nomor_auto' => $request->nomor_auto,
            'format_penomoran' => $request->format_penomoran,
            'modified_at' => Carbon::now()
        ]);
        if($edit){
            return response()->json(['msg' => 'Berhasil diedit']);
        }else{
            return response()->json(['msg' => 'Terjadi masalah, coba lagi']);
        }

    }

    public function destroy(Request $request)
    {
        $delete = DB::table('tb_nomor_surat_terakhir')
            ->where('id_nomor_surat_terakhir',$request->id_nomor_surat_terakhir)
            ->delete();
        if($delete){
            return response()->json(['msg' => 'Berhasil dihapus']);
        }else{
            return response()->json(['msg' => 'Terjadi masalah, coba lagi']);
        }

    }

}
