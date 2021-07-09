<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Base\Controller;
use App\Models\Agenda;
use App\Models\SuratKeluar;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        //


        $auth=$request->auth;
        $dataUser = $request->auth['sinergi'];
        $data =null;




        //role kasubag
        if (in_array("Kasubag",$auth['role'])){
            //data surat keluar berdasarkan opd
            $suratKeluar = SuratKeluar::where('id_opd',$dataUser['id_opd'])
                ->where('status','!=','selesai')
                ->where('status','!=','ditolak')
            ;

            //role super admin
        }elseif (in_array("Super Admin",$auth['role'])){
            //seluruh surat keluar
            $suratKeluar = SuratKeluar::select();

            //role staf/sekre/kabid/pimpinan
        }else {
            //data berdasarkan terusan atau nip author dalam suatu opd
            $suratKeluar = SuratKeluar::where('id_opd',$dataUser['id_opd'])
                ->where('nip_author',$dataUser['nip'])
                ->where('status','!=','selesai')
                ->where('status','!=','ditolak')
                ->orWhere('kode_jabatan_terusan',$dataUser['kode_jabatan']);


        }

        //agenda berdasarkan nip
        $data = Agenda::where('id_opd',$dataUser['id_opd'])
            ->where('nip_pegawai',$dataUser['nip'])->get();



        return [

            'surat_keluar_active' => ($suratKeluar)->count(),
            'surat_masuk_active' => 0,
            'agenda' => $data,

        ];
    }
}
