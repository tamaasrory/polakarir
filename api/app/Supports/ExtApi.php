<?php

namespace App\Supports;

use Illuminate\Http\Request;

class ExtApi
{
    public static function login(Request $request)
    {
        $curl = new Curl();
        $tmp = $curl->route('api_login')
            ->method('GET')
            ->addField($request->all())
            ->run();

        if (isset($tmp['result'])) {
            if ($tmp['result'] === 'verified') {
                return $tmp;
            }
        }

        return ['result' => false];
    }

    public static function listOpd()
    {
        $curl = new Curl();
        return $curl->route('api_opd')
            ->method('GET')
            ->addField(['all' => 'yes'])
            ->run();
    }

    public static function getOpdById(Request $request)
    {
        $curl = new Curl();
        $tmp = $curl->route('api_opd')
            ->method('GET')
            ->addField(['id_opd' => $request->input('id_opd')])
            ->run();
        if (is_array($tmp)) {
            return $tmp[0];
        }
        return $tmp;
    }

    public static function listPegawaiByOpd(Request $request)
    {
        $curl = new Curl();
        return $curl->route('api_pegawai')
            ->method('GET')
            ->addField(['id_opd' => $request->input('id_opd')])
            ->run();
    }

    /**
     * @param Request $request
     * @return array|bool|mixed|string
     */
    public static function getPegawaiByNip(Request $request)
    {
        $curl = new Curl();
        $tmp = $curl->route('api_pegawai')
            ->method('GET')
            ->addField(['nip' => $request->input('nip')])
            ->run();

        if (!isset($tmp['result'])) {
            return $tmp;
        }

        return ['result' => false];
    }
}
