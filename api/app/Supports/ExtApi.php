<?php

namespace App\Supports;

use Illuminate\Http\Request;

class ExtApi
{
    /**
     * Login ke sinergi
     *
     * @param Request $request
     * @return array|bool|false[]|mixed|string
     */
    public static function login(Request $request)
    {
        $curl = new Curl();
        $tmp = $curl->get('api_login', $request->all());

        if (!isset($tmp['error']) && isset($tmp['result'])) {
            if ($tmp['result'] === 'verified') {

                $pegawai = self::getPegawaiByNip($tmp['nip']);

                if ($pegawai['result']) {
                    $tmp['nama_pegawai'] = $pegawai['nama_pegawai'];
                    return $tmp;
                }

                return $tmp;
            }
        }

        return ['result' => false];
    }

    /**
     * Get List OPD
     *
     * @return array|bool|mixed|string
     */
    public static function listOpd()
    {
        $curl = new Curl();
        $tmp = $curl->get('api_opd', ['all' => 'yes']);

        if (!isset($tmp['error'])) {
            return $tmp;
        }

        return ['result' => false];
    }

    /**
     * Get OPD by id OPD
     *
     * @param $id_opd
     * @return array|bool|mixed|string
     */
    public static function getOpdById($id_opd)
    {
        $curl = new Curl();
        $tmp = $curl->get('api_opd',
            ['id_opd' => $id_opd]
        );

        if (!isset($tmp['error']) && is_array($tmp)) {
            return $tmp[0];
        }
        return ['result' => false];
    }

    /**
     * Get List Pegawai by id OPD
     *
     * @param $id_opd
     * @return array|bool|mixed|string
     */
    public static function listPegawaiByOpd($id_opd)
    {
        $curl = new Curl();
        $tmp = $curl->get('api_pegawai',
            ['id_opd' => $id_opd > 0 ? $id_opd : 'all']
        );

        if (!isset($tmp['error']) && $tmp) {
            return $tmp;
        }
        return [];
    }

    /**
     * Get Pegawai by NIP
     *
     * @param string $nip
     * @return array|bool|mixed|string
     */
    public static function getPegawaiByNip($nip)
    {
        $curl = new Curl();
        $tmp = $curl->get('api_pegawai',
            ['nip' => $nip]
        );

        if (!isset($tmp['error']) && !isset($tmp['result'])) {
            $tmp['result'] = true;
            return $tmp;
        }

        return ['result' => false];
    }

    /**
     * Get Pegawai by Kode Jabatan
     *
     * @param $kode_jabatan
     * @return array|bool|mixed|string
     */
    public static function getPegawaiByKodeJabatan($kode_jabatan)
    {
        $curl = new Curl();
        $tmp = $curl->get('api_pegawai',
            ['kode_jabatan' => $kode_jabatan]
        );

        if (!isset($tmp['error']) && !isset($tmp['result'])) {
            $tmp['result'] = true;
            return $tmp;
        }

        return ['result' => false];
    }
}
