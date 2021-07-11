<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\Controller;
use App\Models\JenisSurat;
use App\Models\TemplateSurat;
use Illuminate\Http\Request;


class TemplateSuratController extends Controller
{

    public $title = 'Template Surat';

    public function __construct()
    {
        $this->middleware('permission:template-surat-list|jenis-surat-create|jenis-surat-edit|jenis-surat-delete', ['only' => 'index', 'show']);
        $this->middleware('permission:template-surat-create', ['only' => 'create', 'store']);
        $this->middleware('permission:template-surat-edit', ['only' => 'edit', 'update']);
        $this->middleware('permission:template-surat-delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     */
    public function index(Request $request)
    {
        $data = TemplateSurat::search($request, new TemplateSurat());


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
        $data = JenisSurat::all();
        return[
            'data'=>$data
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response|array
     */
    public function store(Request $request)
    {
        $data = new TemplateSurat();
        $data->fill(request()->all());
        $jenis_surat = $data->jenis_surat;


        if ($request->hasFile('draf')) {
            $original_filename = $request->file('draf')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = '/template/' . $this->name_folder_draf($jenis_surat) . '/';
            $nama_template = 'draf-' . time() . '.' . $file_ext;

            if ($request->file('draf')->move('.' . $destination_path, $nama_template)) {

                $data->url_berkas = $destination_path . '' . $nama_template;

                if ($data->save()) {
                    return [
                        'value' => $data,
                        'msg' => "{$this->title} baru berhasil disimpan"
                    ];
                }
            }
        }


        return [
            'value' => [],
            'msg' => "{$this->title} baru gagal disimpan"
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
        $data = TemplateSurat::find($id);
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
        $data_jenis_surat = JenisSurat::all();
        $data = TemplateSurat::find($id);
        return[
            'value'=>$data,
            'jenis_surat'=>$data_jenis_surat
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function update(Request $request,$id)
    {
        $dataOld = TemplateSurat::find($id);
       // $data = new TemplateSurat();

        //$data->fill(request()->all());
        $jenis_surat = $request->jenis_surat;


        if ($request->file('draf') != '') {
            //code for remove old file
            if($dataOld->url_berkas != ''  && $dataOld->url_berkas != null){
                $file_old = '.'.$dataOld->url_berkas;
                unlink($file_old);
            }

            //upload new
            $original_filename = $request->file('draf')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = '/template/' . $this->name_folder_draf($jenis_surat) . '/';
            $nama_template = 'draf-' . time() . '.' . $file_ext;

            if ($request->file('draf')->move('.' . $destination_path, $nama_template)) {

                $dataOld->url_berkas = $destination_path.$nama_template;

                if ($dataOld->update(request()->all())) {
                    return [
                        'value' => $dataOld,
                        'msg' => "{$this->title} baru berhasil disimpan"
                    ];
                }
            }
        }else if ($dataOld->update(request()->all())){
            return [
                'value' => $dataOld,
                'msg' => "{$this->title} #{$id} berhasil diperbarui"
            ];

        }else{
            return [
                'value' => [],
                'msg' => "{$this->title} #{$id} gagal diperbarui"
            ];
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function destroy($id)
    {
        $data = TemplateSurat::find($id);

        if($data->url_berkas != ''  && $data->url_berkas != null){
            $file_old = '.'.$data->url_berkas;
            unlink($file_old);

            if ($data->delete()) {
                return [
                    'value' => $data,
                    'msg' => "{$this->title} #{$id} berhasil dihapus"
                ];
            }
        }


        return [
            'value' => [],
            'msg' => "{$this->title} #{$id} gagal dihapus"
        ];
    }


    function download_template($id){

        $template = TemplateSurat::findOrFail($id);

        //check if file exists in storage
         $file_path = '.'.$template['url_berkas'];
        if (file_exists($file_path)){
            //send download
            //$headers = ['Content-Type: application/msword'];
            //return response()->download($file_path,$template->nama_template."docx",$headers);
            return response()->download($file_path,$template->nama_template."docx");

        }else{
            return [
                'value' => [],
                'msg' => "{$this->title} Tidak Tersedia"
            ];
        }


    }

    function name_folder_draf($jenis_surat)
    {
        $pattern = array(
            '/([^a-zA-Z\+\s])/',
            '/(\+|\s)+/'
        );
        $replacement = array('', '');
        $nama_folder = preg_replace($pattern, $replacement, $jenis_surat);

        return $nama_folder;
    }
}
