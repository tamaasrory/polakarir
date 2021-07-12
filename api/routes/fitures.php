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
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AgendaController;
use App\Http\Controllers\OPDBidangController;
use App\Http\Controllers\FormatPenomoranSuratController;

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
    $router->get('get-atasan', [SuratKeluarController::class, 'getAtasan']);
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
    $router->post('update/{id}', [TemplateSuratController::class, 'update']);
    $router->delete('delete/{id}', [TemplateSuratController::class, 'destroy']);
    $router->get('download/{id}', [TemplateSuratController::class, 'download_template']);
});

$router->group(['prefix' => 'agenda'], function () use ($router) {
    $router->get('all', [AgendaController::class, 'index']);
    $router->get('detail/{id}', [AgendaController::class, 'show']);
    $router->get('create', [AgendaController::class, 'create']);
    $router->post('baru', [AgendaController::class, 'store']);
    $router->get('edit/{id}', [AgendaController::class, 'edit']);
    $router->put('update/{id}', [AgendaController::class, 'update']);
    $router->delete('delete/{id}', [AgendaController::class, 'destroy']);
  });

$router->group(['prefix' => 'dashborad'], function () use ($router) {
    $router->get('index', [DashboardController::class, 'index']);
});

$router->group(['prefix' => 'penomoran-surat'], function () use ($router) {
    $router->get('index', [FormatPenomoranSuratController::class, 'index']);
    $router->put('update/{id_format_penomoran}', [FormatPenomoranSuratController::class, 'update']);
    $router->get('get-nomor/{id_opd}/{kode_klasifikasi}/{opd_bidang}', [FormatPenomoranSuratController::class, 'getNomorSurat']);
});

$router->group(['prefix' => 'opd-bidang'], function () use ($router) {
    $router->get('get-list/{id_opd}', [OPDBidangController::class, 'getList']);
    $router->delete('delete/{id}', [OPDBidangController::class, 'destroy']);
    $router->post('baru', [OPDBidangController::class, 'store']);
});
