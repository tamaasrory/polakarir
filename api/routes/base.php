<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

$router->get('/', function () {
    return response()->json(['value' => auth()], 200);
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    /** @see \App\Http\Controllers\ExtAuthController::authenticate() */
    $router->post('auth/login', 'ExtAuthController@authenticate');

    $router->get('/', function () {
        return response()->json(['value' => 'oke'], 200);
    });

    $router->group(['prefix' => 'user'], function () use ($router) {
        /** @see \App\Http\Controllers\UserController::forgotPassword() */
        $router->post('forgot-password', 'UserController@forgotPassword');
    });

    $router->group(['middleware' => ['extauth']], function () use ($router) {

        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->get('all', 'UserController@index');
            $router->get('detail/{id}', 'UserController@show');
            $router->get('edit/{id}', 'UserController@edit');
            $router->get('create', 'UserController@create');
            $router->post('baru', 'UserController@store');
            $router->put('update/{id}', 'UserController@update');
            $router->delete('delete/{id}', 'UserController@destroy');
        });

        $router->group(['prefix' => 'material'], function () use ($router) {

            $router->get('all', 'MaterialController@index');
            $router->get('detail/{id}', 'MaterialController@show');
            $router->post('baru', 'MaterialController@store');
            $router->put('update/{id}', 'MaterialController@update');
            $router->delete('delete/{id}', 'MaterialController@destroy');

        });

        $router->group(['prefix' => 'roles'], function () use ($router) {

            $router->get('all', 'RoleController@index');
            $router->get('permissions', 'RoleController@permissions');
            $router->get('detail/{id}', 'RoleController@show');
            $router->post('baru', 'RoleController@store');
            $router->put('update/{id}', 'RoleController@update');
            $router->delete('delete/{id}', 'RoleController@destroy');

        });

        $router->group(['prefix' => 'suratkeluar'], function () use ($router) {

            $router->get('all', 'SuratKeluarController@index');
            $router->get('detail/{id}', 'SuratKeluarController@show');
            $router->post('baru', 'SuratKeluarController@store');
            $router->put('update/{id}', 'SuratKeluarController@update');
            $router->delete('delete/{id}', 'SuratKeluarController@destroy');

        });
    });
});
