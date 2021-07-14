<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\Controller;
use App\Models\Agenda;
use App\Models\Base\User;
use App\Models\SuratKeluar;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        //


        /** @var User $auth */
        $auth = $request->auth;
        $dataUser = $request->auth['sinergi'];
        $data =null;
        $from =$request->input('from');
        $to =$request->input('to');

        $filterSuratKeluar = function () use ($auth, $dataUser) {
            $query = SuratKeluar::select();

            // tidak muncul lagi setelah di setujui
            $query->where('status', 'NOT LIKE', 'Selesai%');

            // untuk yang memiliki akses surat-keluar-list-all
            if ($auth->can('surat-keluar-list-all')) {
                // munculkan seluruh data surat keluar
                return $query;
            }

            // untuk yang memiliki akses surat-keluar-list-opd
            if ($auth->can('surat-keluar-list-opd')) {
                // hanya munculkan surat keluar yang sesuai dengan "id_opd" user yang mengakses
                $query->where('id_opd', $dataUser['id_opd']);
                return $query;
            }

            // untuk yang tidak memiliki kedua akses diatas
            $query->whereJsonContains('kode_jabatan_terusan', $dataUser['kode_jabatan']);

            // akan terus muncul di surat keluar pembuat
            $query->orWhere('nip_author', $dataUser['nip']);

            return $query;
        };

        //agenda berdasarkan nip
        if ($from != $to) {
            $data = Agenda::where('id_opd', $dataUser['id_opd'])
                ->where('nip_pegawai', $dataUser['nip'])
                ->where(function ($query) use ($from,$to){
                    $query->whereBetween('waktu_mulai', [$from, $to])
                        ->orWhereBetween('waktu_akhir', [$from, $to]);
                })->get();
//
        }else{
            $data = Agenda::where('id_opd', $dataUser['id_opd'])
                ->where('nip_pegawai','=', $dataUser['nip'])
                ->WhereDate('waktu_mulai','<=',$from)
                ->WhereDate('waktu_akhir','>=',$to)->get();
        }


        return [
            'nip' => $dataUser['nip'],
            'surat_keluar_active' => $filterSuratKeluar()->count(),
            'surat_masuk_active' => 0,
            'agenda' => $data,

        ];
    }
}
