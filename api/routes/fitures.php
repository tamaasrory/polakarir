<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

use App\Http\Controllers\PolaKarirController;


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


