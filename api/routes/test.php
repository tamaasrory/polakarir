<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

use Illuminate\Http\Request;

$router->get('/test-page', function () {
    return view('index');
});

$router->group(['prefix' => 'api/test'], function () use ($router) {

    /** @see \App\Http\Controllers\Base\ExtAuthController::authenticate() */
    $router->post('auth', 'Base\ExtAuthController@authenticate');

    /** @see \App\Http\Controllers\Base\TestController::login() */
    $router->post('login', 'Base\TestController@login');

    /** @see \App\Http\Controllers\Base\TestController::listOpd() */
    $router->post('opd', 'Base\TestController@listOpd');

    /** @see \App\Http\Controllers\Base\TestController::getOpdById() */
    $router->post('opd-by-id', 'Base\TestController@getOpdById');

    /** @see \App\Http\Controllers\Base\TestController::listPegawaiByOpd() */
    $router->post('pegawai-by-opd', 'Base\TestController@listPegawaiByOpd');

    /** @see \App\Http\Controllers\Base\TestController::getPegawaiByNip() */
    $router->post('pegawai-by-nip', 'Base\TestController@getPegawaiByNip');

    // test penerapan TOKEN JWT
    $router->group(['middleware' => ['extauth']], function () use ($router) {
        $router->get('dump-test', function (Request $request) {
            return ['msg' => "it's work", 'value' => $request->auth];
        });
    });
});
