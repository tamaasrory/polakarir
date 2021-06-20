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

        /** @see \App\Http\Controllers\Base\ExtAuthController::refresh() */
        $router->get('auth/refresh', 'Base\ExtAuthController@refresh');

        include "fitures.php";
    });
});
