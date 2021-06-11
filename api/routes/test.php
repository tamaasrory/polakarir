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

    /** @see \App\Http\Controllers\ExtAuthController::authenticate() */
    $router->post('auth', 'ExtAuthController@authenticate');

    /** @see \App\Http\Controllers\TestController::login() */
    $router->post('login', 'TestController@login');

    /** @see \App\Http\Controllers\TestController::listOpd() */
    $router->post('opd', 'TestController@listOpd');

    /** @see \App\Http\Controllers\TestController::getOpdById() */
    $router->post('opd-by-id', 'TestController@getOpdById');

    /** @see \App\Http\Controllers\TestController::listPegawaiByOpd() */
    $router->post('pegawai-by-opd', 'TestController@listPegawaiByOpd');

    /** @see \App\Http\Controllers\TestController::getPegawaiByNip() */
    $router->post('pegawai-by-nip', 'TestController@getPegawaiByNip');

    // test penerapan TOKEN JWT
    $router->group(['middleware' => ['extauth']], function () use ($router) {
        $router->get('dump-test', function (Request $request) {
            return ['msg' => "it's work", 'value' => $request->auth];
        });
    });
});
