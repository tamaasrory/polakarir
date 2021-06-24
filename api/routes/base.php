<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

$router->get('/', function () {
    header('Location:bpp.pekanbaru.go.id');
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    /** @see \App\Http\Controllers\Base\ExtAuthController::authenticate() */
    $router->post('auth/login', 'Base\ExtAuthController@authenticate');

    $router->get('/', function () {
        header('Location:bpp.pekanbaru.go.id');
    });

    $router->group(['prefix' => 'user'], function () use ($router) {
        /** @see \App\Http\Controllers\Base\UserController::forgotPassword() */
        $router->post('forgot-password', 'Base\UserController@forgotPassword');
    });

    $router->group(['middleware' => ['extauth']], function () use ($router) {

        $router->group(['prefix' => 'user'], function () use ($router) {
            $ctrlName = 'Base\UserController';

            $router->get('all', $ctrlName . '@index');
            $router->get('detail/{id}', $ctrlName . '@show');
            $router->get('edit/{id}', $ctrlName . '@edit');
            $router->get('create', $ctrlName . '@create');
            $router->post('baru', $ctrlName . '@store');
            $router->put('update/{id}', $ctrlName . '@update');
            $router->delete('delete/{id}', $ctrlName . '@destroy');
        });

        $router->group(['prefix' => 'roles'], function () use ($router) {
            $ctrlName = 'Base\RoleController';

            $router->get('all', $ctrlName . '@index');
            $router->get('permissions', $ctrlName . '@permissions');
            $router->get('detail/{id}', $ctrlName . '@show');
            $router->post('baru', $ctrlName . '@store');
            $router->put('update/{id}', $ctrlName . '@update');
            $router->delete('delete/{id}', $ctrlName . '@destroy');

        });

        $router->group(['prefix' => 'suratkeluar'], function () use ($router) {

            $router->get('all', 'SuratKeluarController@index');
            $router->post('ttd', 'SuratKeluarController@ttd');
            $router->get('detail/{id}', 'SuratKeluarController@show');
            $router->post('baru', 'SuratKeluarController@store');
            $router->put('update/{id}', 'SuratKeluarController@update');
            $router->delete('delete/{id}', 'SuratKeluarController@destroy');


        });

        $router->group(['prefix' => 'nomorsuratterakhir'], function () use ($router) {

            $router->get('all', 'NomorSuratTerakhirController@index');
            $router->get('all/{id_opd}', 'NomorSuratTerakhirController@indexByOPD');
            $router->get('getnomor/{id_opd}/{id_jenis_surat}', 'NomorSuratTerakhirController@getNomorTerakhir');
            $router->post('baru', 'NomorSuratTerakhirController@store');
            $router->put('edit', 'NomorSuratTerakhirController@edit');
            $router->delete('delete/{id_nomor_surat_terakhir}', 'NomorSuratTerakhirController@destroy');

        });

        /** @see \App\Http\Controllers\Base\ExtAuthController::refresh() */
        $router->get('auth/refresh', 'Base\ExtAuthController@refresh');

        $router->group(['prefix' => 'sinergi'], function () use ($router) {

            /** @see \App\Http\Controllers\Base\SinergiController */
            $ctrlName = 'Base\SinergiController';

            $router->post('opd', $ctrlName . '@listOpd');
            $router->post('opd-by-id', $ctrlName . '@getOpdById');
            $router->post('pegawai-by-opd', $ctrlName . '@listPegawaiByOpd');
            $router->post('pegawai-by-nip', $ctrlName . '@getPegawaiByNip');

        });

        include "fitures.php";
    });
});
