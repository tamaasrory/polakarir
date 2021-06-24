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

    $router->get('create', $ctrlName . '@create');
    $router->post('baru', $ctrlName . '@store');

    $router->get('edit/{id}', $ctrlName . '@edit');
    $router->put('update/{id}', $ctrlName . '@update');

    $router->delete('delete/{id}', $ctrlName . '@destroy');

});

$router->group(['prefix' => 'surat-keluar'], function () use ($router) {

    /** @see \App\Http\Controllers\SuratKeluarController */
    $ctrlName = 'SuratKeluarController';

    $router->get('all', $ctrlName . '@index');
    $router->get('detail/{id}', $ctrlName . '@show');

    $router->get('create', function (\Illuminate\Http\Request $request) {
        $jenis_surat = \App\Models\JenisSurat::selectRaw("id as value, (kode_surat||' - '||nama_jenis_surat) as text")->get();
        $opd = collect(\App\Supports\ExtApi::listOpd())->map(function ($data) {
            $tmp = [];
            $tmp['value'] = $data['id_opd'];
            $tmp['text'] = $data['nama'];

            return $tmp;
        });

        return [
            'value' => compact('jenis_surat', 'opd')
        ];
    });

    $router->post('baru', $ctrlName . '@store');

    $router->get('edit/{id}', $ctrlName . '@edit');
    $router->put('update/{id}', $ctrlName . '@update');

    $router->delete('delete/{id}', $ctrlName . '@destroy');

});
