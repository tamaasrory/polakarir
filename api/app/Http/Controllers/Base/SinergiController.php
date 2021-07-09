<?php

namespace App\Http\Controllers\Base;

use App\Supports\ExtApi;
use Illuminate\Http\Request;

class SinergiController extends Controller
{
    /**
     * @param Request $request
     * @return array|bool|mixed|string
     */
    public function listOpd(Request $request)
    {
        return ExtApi::listOpd();
    }

    /**
     * @param Request $request
     * @return array|bool|mixed|string
     */
    public function getOpdById(Request $request)
    {
        return ExtApi::getOpdById($request->id_opd);
    }

    /**
     * @param Request $request
     * @return array|bool|mixed|string
     */
    public function listPegawaiByOpd(Request $request)
    {
        return ExtApi::listPegawaiByOpd($request->id_opd);
    }

    /**
     * @param Request $request
     * @return array|bool|false[]|mixed|string
     */
    public function getPegawaiByNip(Request $request)
    {
        return ExtApi::getPegawaiByNip($request->nip);
    }
}
