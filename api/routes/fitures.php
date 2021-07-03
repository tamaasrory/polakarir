<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 *
 * @var Illuminate\Support\Facades\Route $router
 */

use App\Http\Controllers\JenisSuratController;
use App\Http\Controllers\NomorSuratTerakhirController;
use App\Http\Controllers\SuratKeluarController;
use App\Http\Controllers\TemplateSuratController;

$router->group(['prefix' => 'jenis-surat'], function () use ($router) {
    $router->get('all', [JenisSuratController::class, 'index']);
    $router->get('detail/{id}', [JenisSuratController::class, 'show']);
    $router->get('create', [JenisSuratController::class, 'create']);
    $router->post('baru', [JenisSuratController::class, 'store']);
    $router->get('edit/{id}', [JenisSuratController::class, 'edit']);
    $router->put('update/{id}', [JenisSuratController::class, 'update']);
    $router->delete('delete/{id}', [JenisSuratController::class, 'destroy']);
});

$router->group(['prefix' => 'surat-keluar'], function () use ($router) {
    $router->get('all', [SuratKeluarController::class, 'index']);
    $router->get('detail/{id}', [SuratKeluarController::class, 'show']);
    $router->get('create', [SuratKeluarController::class, 'create']);
    $router->post('baru', [SuratKeluarController::class, 'store']);
    $router->get('edit/{id}', [SuratKeluarController::class, 'edit']);
    $router->post('update', [SuratKeluarController::class, 'update']);
    $router->delete('delete/{id}', [SuratKeluarController::class, 'destroy']);
    $router->post('tte', [SuratKeluarController::class, 'tte']);
    $router->put('validasi-surat', [SuratKeluarController::class, 'validasiSurat']);
});

$router->group(['prefix' => 'nomorsuratterakhir'], function () use ($router) {
    $router->get('all', [NomorSuratTerakhirController::class, 'index']);
    $router->get('all/{id_opd}', [NomorSuratTerakhirController::class, 'indexByOPD']);
    $router->get('getnomor/{id_opd}/{id_jenis_surat}', [NomorSuratTerakhirController::class, 'getNomorTerakhir']);
    $router->post('baru', [NomorSuratTerakhirController::class, 'store']);
    $router->put('edit', [NomorSuratTerakhirController::class, 'edit']);
    $router->delete('delete/{id_nomor_surat_terakhir}', [NomorSuratTerakhirController::class, 'destroy']);
});

$router->group(['prefix' => 'template-surat'], function () use ($router) {
    $router->get('all', [TemplateSuratController::class, 'index']);
    $router->get('detail/{id}', [TemplateSuratController::class, 'show']);
    $router->get('create', [TemplateSuratController::class, 'create']);
    $router->post('baru', [TemplateSuratController::class, 'store']);
    $router->get('edit/{id}', [TemplateSuratController::class, 'edit']);
    $router->put('update/{id}', [TemplateSuratController::class, 'update']);
    $router->delete('delete/{id}', [TemplateSuratController::class, 'destroy']);
    $router->get('download/{id}', [TemplateSuratController::class, 'download_template']);
});

