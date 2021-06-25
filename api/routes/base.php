<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

use App\Http\Controllers\Base\ExtAuthController;
use App\Http\Controllers\Base\RoleController;
use App\Http\Controllers\Base\SinergiController;
use App\Http\Controllers\Base\UserController;

$router->get('/', function () {
    header('Location:bpp.pekanbaru.go.id');
});

$router->group(['prefix' => 'api/v1'], function () use ($router) {

    $router->get('/', function () {
        header('Location:bpp.pekanbaru.go.id');
    });

    $router->post('auth/login', [ExtAuthController::class, 'authenticate']);

    $router->group(['prefix' => 'user'], function () use ($router) {
        $router->post('forgot-password', [UserController::class, 'forgotPassword']);
    });

    $router->group(['middleware' => ['extauth']], function () use ($router) {

        $router->group(['prefix' => 'user'], function () use ($router) {
            $router->get('all', [UserController::class, 'index']);
            $router->get('detail/{id}', [UserController::class, 'show']);
            $router->get('edit/{id}', [UserController::class, 'edit']);
            $router->get('create', [UserController::class, 'create']);
            $router->post('baru', [UserController::class, 'store']);
            $router->put('update/{id}', [UserController::class, 'update']);
            $router->delete('delete/{id}', [UserController::class, 'destroy']);
        });

        $router->group(['prefix' => 'roles'], function () use ($router) {
            $router->get('all', [RoleController::class, 'index']);
            $router->get('permissions', [RoleController::class, 'permissions']);
            $router->get('detail/{id}', [RoleController::class, 'show']);
            $router->post('baru', [RoleController::class, 'store']);
            $router->put('update/{id}', [RoleController::class, 'update']);
            $router->delete('delete/{id}', [RoleController::class, 'destroy']);

        });

        $router->group(['prefix' => 'sinergi'], function () use ($router) {
            $router->post('opd', [SinergiController::class, 'listOpd']);
            $router->post('opd-by-id', [SinergiController::class, 'getOpdById']);
            $router->post('pegawai-by-opd', [SinergiController::class, 'listPegawaiByOpd']);
            $router->post('pegawai-by-nip', [SinergiController::class, 'getPegawaiByNip']);
        });

        $router->get('auth/refresh', [ExtAuthController::class, 'refresh']);

        include "fitures.php";
    });
});
