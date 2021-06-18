<?php
namespace App\Http\Controllers;

use App\SuratKeluar;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller {

    public $title = 'Surat Keluar';

    public function __construct()
    {
        $this->middleware('permission:material-list|material-create|material-edit|material-delete', ['only' => 'index', 'show']);
        $this->middleware('permission:material-create', ['only' => 'create', 'store']);
        $this->middleware('permission:material-edit', ['only' => 'edit', 'update']);
        $this->middleware('permission:material-delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response|array
     */
    public function index()
    {
        $data = SuratKeluar::paginate(20);

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

    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response|array
     */
    public function store(Request $request)
    {



        $data = new SuratKeluar();
        $data->fill(request()->all());

        if ($request->hasFile('lampiran')) {
            $original_filename = $request->file('lampiran')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './suratkeluar/';
            $image = 'U-' . time() . '.' . $file_ext;

            if ($request->file('lampiran')->move($destination_path, $image)) {
                $data->lampiran = '/upload/suratkeluar/' . $image;

                if ($data->save()) {
                    return [
                        'value' => $data,
                        'msg' => "{$this->title} baru berhasil disimpan"
                    ];
                }

            } else {
                return [
                    'value' => [],
                    'msg' => "{$this->title} baru gagal disimpan 1"
                ];
            }
        } else {
            return [
                'value' => [],
                'msg' => "{$this->title} baru gagal disimpan2"
            ];
        }






        return [
            'value' => [],
            'msg' => "{$this->title} baru gagal disimpan3"
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function show($id)
    {
        $data = SuratKeluar::findOrFail($id);
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
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function update()
    {
        $id = request()->input('id');
        $data = SuratKeluar::find($id);

        if ($data->update(request()->all())) {
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
    public function destroy()
    {
        $id = request()->input('id');
        $data = SuratKeluar::find($id);

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
