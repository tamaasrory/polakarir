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

                $request->request->add(['nip' => $tmp['nip']]);
                $pegawai = self::getPegawaiByNip($request);

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
     * @param Request $request
     * @return array|bool|mixed|string
     */
    public static function getOpdById(Request $request)
    {
        $curl = new Curl();
        $tmp = $curl->get('api_opd',
            ['id_opd' => $request->input('id_opd')]
        );

        if (!isset($tmp['error']) && is_array($tmp)) {
            return $tmp[0];
        }
        return ['result' => false];
    }

    /**
     * Get List Pegawai by id OPD
     *
     * @param Request $request
     * @return array|bool|mixed|string
     */
    public static function listPegawaiByOpd(Request $request)
    {
        $id_opd = $request->input('id_opd');
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
     * @param Request $request
     * @return array|bool|mixed|string
     */
    public static function getPegawaiByNip(Request $request)
    {
        $curl = new Curl();
        $tmp = $curl->get('api_pegawai',
            ['nip' => $request->input('nip')]
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
     * @param Request $request
     * @return array|bool|mixed|string
     */
    public static function getPegawaiByKodeJabatan(Request $request)
    {
        $curl = new Curl();
        $tmp = $curl->get('api_pegawai',
            ['kode_jabatan' => $request->input('kj')]
        );

        if (!isset($tmp['error']) && !isset($tmp['result'])) {
            $tmp['result'] = true;
            return $tmp;
        }

        return ['result' => false];
    }
}
