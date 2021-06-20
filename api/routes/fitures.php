<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

$router->group(['prefix' => 'jenis-surat'], function () use ($router) {

    /** @see \App\Http\Controllers\JenisSuratController */
    $ctrlName = 'JenisSuratController';

    $router->get('all', $ctrlName . '@index');
    $router->get('detail/{id}', $ctrlName . '@show');
    $router->post('baru', $ctrlName . '@store');
    $router->put('update/{id}', $ctrlName . '@update');
    $router->delete('delete/{id}', $ctrlName . '@destroy');

});
