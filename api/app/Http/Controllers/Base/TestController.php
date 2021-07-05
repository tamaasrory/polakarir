<?php

namespace App\Http\Controllers\Base;

use App\Supports\ExtApi;
use Illuminate\Http\Request;

class TestController extends Controller
{
    public function index()
    {
        return ['oke'];
    }

    public function login(Request $request)
    {
        return ExtApi::login($request);
    }

    public function listOpd(Request $request)
    {
        return ExtApi::listOpd();
    }

    public function getOpdById(Request $request)
    {
        return ExtApi::getOpdById($request);
    }

    public function listPegawaiByOpd(Request $request)
    {
        return ExtApi::listPegawaiByOpd($request);
    }

    public function getPegawaiByNip(Request $request)
    {
        return ExtApi::getPegawaiByNip($request);
    }

    public function getPegawaiByKj(Request $request)
    {
        return ExtApi::getPegawaiByKodeJabatan($request);
    }

    public function getAtasanByKj(Request $request)
    {
        $dataUser = ExtApi::getPegawaiByKodeJabatan($request);
        $dataAtasan = [];

        if($dataUser['result']==true){
            //cek limit panjang kode jabatan (batasnya 6)
            if(strlen($dataUser["kode_jabatan_atasan"])<=6){
                //jika kode atasannya dibawah sama dengan 6 karakter
                $request->request->add(['kj' => $dataUser["kode_jabatan_atasan"]]);
                $tampungAtasan = ExtApi::getPegawaiByKodeJabatan($request);
                array_push($dataAtasan, [
                    "kode_jabatan" => $tampungAtasan['kode_jabatan'],
                    "nip" => $tampungAtasan['nip'],
                    "nama_pegawai" => $tampungAtasan['nama_pegawai']
                ]);
                return $dataAtasan;
            }else{
                //jika kode atasannya masih diatas 6
                $kode_jabatan_atasan = $dataUser["kode_jabatan_atasan"];

                while(1){
                    $request->request->add(['kj' => $kode_jabatan_atasan]);
                    $tampungAtasan = ExtApi::getPegawaiByKodeJabatan($request);
                    array_push($dataAtasan, [
                        "kode_jabatan" => $tampungAtasan['kode_jabatan'],
                        "nip" => $tampungAtasan['nip'],
                        "nama_pegawai" => $tampungAtasan['nama_pegawai']
                    ]);
                    if(strlen($kode_jabatan_atasan)<=6){
                        break;
                    }
                    $kode_jabatan_atasan = $tampungAtasan['kode_jabatan_atasan'];
                }

                return $dataAtasan;
            }
        }else{
            return "kode jabatan tidak ditemukan";
        }
    }
}
