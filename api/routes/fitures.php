<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

use App\Http\Controllers\PolaKarirController;
use App\Http\Controllers\SKJController;
use App\Http\Controllers\SyaratJabatanController;


$router->group(['prefix' => 'pola-karir'], function () use ($router) {
    $router->get('all', [PolaKarirController::class, 'index']);
    $router->post('filter', [PolaKarirController::class, 'filter']);
    $router->get('detail', [PolaKarirController::class, 'show']);
    $router->get('create', [PolaKarirController::class, 'create']);
    $router->post('baru', [PolaKarirController::class, 'store']);
    $router->get('edit/{id}', [PolaKarirController::class, 'edit']);
    $router->put('update/{id}', [PolaKarirController::class, 'update']);
    $router->delete('delete/{id}', [PolaKarirController::class, 'destroy']);
});

$router->group(['prefix' => 'standar-kompetensi'], function () use ($router) {
    $router->get('all', [SKJController::class, 'index']);
    $router->get('detail/{id}', [SKJController::class, 'show']);
    $router->get('create', [SKJController::class, 'create']);
    $router->post('baru', [SKJController::class, 'store']);
    $router->get('edit/{id}', [SKJController::class, 'edit']);
    $router->post('update/{id}', [SKJController::class, 'update']);
    $router->delete('delete/{id}', [SKJController::class, 'destroy']);
    $router->get('download/{id}', [SKJController::class, 'download_template']);
});

$router->group(['prefix' => 'syarat-jabatan'], function () use ($router) {
    $router->get('all', [SyaratJabatanController::class, 'index']);
    $router->get('detail/{id}', [SyaratJabatanController::class, 'show']);
    $router->get('create', [SyaratJabatanController::class, 'create']);
    $router->post('baru', [SyaratJabatanController::class, 'store']);
    $router->get('edit/{id}', [SyaratJabatanController::class, 'edit']);
    $router->post('update/{id}', [SyaratJabatanController::class, 'update']);
    $router->delete('delete/{id}', [SyaratJabatanController::class, 'destroy']);
    $router->get('download/{id}', [SyaratJabatanController::class, 'download_template']);
});

