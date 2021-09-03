<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\Controller;
use App\Models\Base\User;
use App\Models\Esesslon;
use App\Models\Fungsional;
use App\Models\JenisJabatan;
use App\Models\PolaKarir;
use Illuminate\Http\Request;

class PolaKarirController extends Controller
{

    public $title = 'PolaKarirController';

//    public function __construct()
//    {
//        $this->middleware('permission:PolaKarirController-list|PolaKarirController-create|PolaKarirController-edit|PolaKarirController-delete', ['only' => 'index', 'show']);
//        $this->middleware('permission:PolaKarirController-create', ['only' => 'create', 'store']);
//        $this->middleware('permission:PolaKarirController-edit', ['only' => 'edit', 'update']);
//        $this->middleware('permission:PolaKarirController-delete', ['only' => 'destroy']);
//    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     */
    public function index(Request $request)
    {
        $data = PolaKarir::search($request, new PolaKarir());

        if ($data) {
            return [
                'value' => $data,
                'msg' => "Data {$this->title} Ditemukan"
            ];
        }

        return [
            'value' => [],
            'msg' => "Data {$this->title} Tidak Ditemukan"
        ];
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response|array
     */
    public function create()
    {
        return [
            'value' => [],
            'msg' => "Data for create {$this->title}"
        ];
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     */
    public function store(Request $request)
    {
        $data = new PolaKarir();

        if ($data->save()) {
            return [
                'value' => $data,
                'msg' => "{$this->title} baru berhasil disimpan"
            ];
        }

        return [
            'value' => [],
            'msg' => "{$this->title} baru gagal disimpan"
        ];
    }

    public function filter(Request $request)
    {
        $auth = $request->auth['user'];
        if (
            $request->has('jenis_jabatan') &&
            $request->has('esselon') &&
            $request->has('fungsional')) {
            $dataUser = $request->all();
        } else {
            $dataUser = $request->auth['sinergi'];
        }
        $filtered = PolaKarir::where('kode_jabatan', '=', $dataUser['jenis_jabatan'])
            ->where('esselon', '=', $dataUser['esselon'])
            ->where('fungsional', '=', $dataUser['fungsional'])
            // ->whereJsonContains('id_opd', (string)$dataUser['id_opd'])
            ->first();
        return [
            'value' => $filtered,
            'msg' => 'filtered',
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function show(Request $request)
    {
        $dataSinergi = $request->auth['sinergi'];
        $items = [
            'jenis_jabatan' => JenisJabatan::select(['id_jenis_jabatan as value', 'nama_jenis_jabatan as text',])->get(),
            'esselon' => Esesslon::select(['id_esselon as value', 'nama_esselon as text',])->get(),
            'fungsional' => Fungsional::select(['id_fungsional as value', 'nama_fungsional as text',])->get(),
        ];

        if ($dataSinergi) {
            return [
                'value' => [
                    'pegawai' => $dataSinergi,
                    'items' => $items
                ],
                'msg' => "{$this->title} # ditemukan"
            ];
        }

        return [
            'value' => [],
            'pegawai' => $dataSinergi,
            'msg' => "{$this->title} # tidak ditemukan"
        ];
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function edit($id)
    {
        /** @var PolaKarir $data */
        $data = PolaKarir::find($id);

        if ($data) {
            return [
                'value' => $data,
                'msg' => "{$this->title} #{$id} ditemukan"
            ];
        }

        return [
            'value' => [],
            'msg' => "{$this->title} #{$id} tidak ditemukan"
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     */
    public function update(Request $request)
    {
        $id = $request->input('_id');
        /** @var PolaKarir $data */
        $data = PolaKarir::find($id);


        if ($data->save()) {
            return [
                'value' => $data,
                'msg' => "{$this->title} #{$id} berhasil diperbarui"
            ];
        }

        return [
            'value' => [],
            'msg' => "{$this->title} #{$id} gagal diperbarui"
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function destroy($id)
    {
        /** @var PolaKarir $data */
        $data = PolaKarir::find($id);

        if ($data->delete()) {
            return [
                'value' => $data,
                'msg' => "{$this->title} #{$id} berhasil dihapus"
            ];
        }

        return [
            'value' => [],
            'msg' => "{$this->title} #{$id} gagal dihapus"
        ];
    }
}
