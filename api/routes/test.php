<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

use App\Http\Controllers\Base\ExtAuthController;
use App\Http\Controllers\Base\TestController;
use Illuminate\Http\Request;

$router->get('/test-page', function () {
    return view('index');
});

$router->group(['prefix' => 'api/test'], function () use ($router) {

    $router->post('auth', [ExtAuthController::class, 'authenticate']);

    $router->post('login', [TestController::class, 'login']);

    $router->get('index', [TestController::class, 'index']);

    $router->post('opd', [TestController::class, 'listOpd']);

    $router->post('opd-by-id', [TestController::class, 'getOpdById']);

    $router->post('pegawai-by-opd', [TestController::class, 'listPegawaiByOpd']);

    $router->post('pegawai-by-nip', [TestController::class, 'getPegawaiByNip']);

    $router->post('pegawai-by-kj', [TestController::class, 'getPegawaiByKj']);

    // test penerapan TOKEN JWT
    $router->group(['middleware' => ['extauth']], function () use ($router) {
        $router->get('dump-test', function (Request $request) {
            return ['msg' => "it's work", 'value' => $request->auth];
        });
    });
});
