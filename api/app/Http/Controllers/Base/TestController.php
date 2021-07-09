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
        return ExtApi::getOpdById($request->id_opd);
    }

    public function listPegawaiByOpd(Request $request)
    {
        return ExtApi::listPegawaiByOpd($request->id_opd);
    }

    public function getPegawaiByNip(Request $request)
    {
        return ExtApi::getPegawaiByNip($request->nip);
    }

    public function getPegawaiByKj(Request $request)
    {
        return ExtApi::getPegawaiByKodeJabatan($request->kj);
    }

    public function getAtasanByKj(Request $request)
    {
        $dataUser = ExtApi::getPegawaiByKodeJabatan($request->kj);
        $dataAtasan = [];

        if ($dataUser['result'] == true) {
            //cek limit panjang kode jabatan (batasnya 6)
            if (strlen($dataUser["kode_jabatan_atasan"]) <= 6) {
                //jika kode atasannya dibawah sama dengan 6 karakter
                $tampungAtasan = ExtApi::getPegawaiByKodeJabatan($dataUser["kode_jabatan_atasan"]);
                array_push($dataAtasan, [
                    "kode_jabatan" => $tampungAtasan['kode_jabatan'],
                    "nip" => $tampungAtasan['nip'],
                    "nama_pegawai" => $tampungAtasan['nama_pegawai']
                ]);
                return $dataAtasan;
            } else {
                //jika kode atasannya masih diatas 6
                $kode_jabatan_atasan = $dataUser["kode_jabatan_atasan"];

                while (1) {
                    $tampungAtasan = ExtApi::getPegawaiByKodeJabatan($kode_jabatan_atasan);
                    array_push($dataAtasan, [
                        "kode_jabatan" => $tampungAtasan['kode_jabatan'],
                        "nip" => $tampungAtasan['nip'],
                        "nama_pegawai" => $tampungAtasan['nama_pegawai']
                    ]);
                    if (strlen($kode_jabatan_atasan) <= 6) {
                        break;
                    }
                    $kode_jabatan_atasan = $tampungAtasan['kode_jabatan_atasan'];
                }

                return $dataAtasan;
            }
        } else {
            return "kode jabatan tidak ditemukan";
        }
    }
}
