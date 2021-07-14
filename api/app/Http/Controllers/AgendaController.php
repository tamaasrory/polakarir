<?php
namespace App\Http\Controllers;

use App\Models\Agenda;
use App\Http\Controllers\Base\Controller;
use App\Supports\ExtApi;
use App\Traits\Searchable;
use Illuminate\Http\Request;

class AgendaController extends Controller {

    public $title = 'Agenda';

    public function __construct()
    {
        $this->middleware('permission:agenda-list|agenda-create|agenda-edit|agenda-delete', ['only' => 'index', 'show']);
        $this->middleware('permission:agenda-create', ['only' => 'create', 'store']);
        $this->middleware('permission:agenda-edit', ['only' => 'edit', 'update']);
        $this->middleware('permission:agenda-delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     */
    public function index(Request $request)
    {
        $auth=$dataUser = $request->auth;
        $dataUser = $request->auth['sinergi'];
        $from =$request->input('from');
        $to =$request->input('to');
        $data =null;

        //agenda berdasarkan nip
        if ($from != $to) {
            $data = Agenda::where('id_opd', $dataUser['id_opd'])
                    ->where(function ($query) use ($from,$to){
                        $query->whereBetween('waktu_mulai', [$from, $to])
                            ->orWhereBetween('waktu_akhir', [$from, $to]);
                        })->get();

        }else{
            $data = Agenda::where('id_opd', $dataUser['id_opd'])
                ->WhereDate('waktu_mulai','<=',$from)
                ->WhereDate('waktu_akhir','>=',$to)->get();
        }

        //$data=Searchable::simplePaginate($request,$data,new Agenda());



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
    public function create(Request $request)
    {
        $dataOperator = $request->auth['sinergi'];

        $request['id_opd'] = $dataOperator['id_opd'];
        $pegawai_opd = ExtApi::listPegawaiByOpd($request);

        return[
            'value' => $pegawai_opd
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response|array
     */
    public function store(Request $request)
    {
        $data = new Agenda();
        $data->fill(request()->all());

        $dataOperator = $request->auth['sinergi'];

        $data->id_opd = $dataOperator['id_opd'];
        $colors = ['blue', 'indigo', 'deep-purple', 'cyan', 'green', 'orange', 'grey darken-1'];
        $data->status = "aktif";
        $data->color = $colors[rand(0,count($colors)-1)];

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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response|array
     */
    public function show($id)
    {
        $data = Agenda::find($id);
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
    public function update($id)
    {
        $data = Agenda::find($id);

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
    public function destroy($id)
    {
        $data = Agenda::find($id);

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
