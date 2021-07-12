<?php
namespace App\Http\Controllers;
use App\Http\Controllers\Base\Controller;
use App\Models\OPDBidang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class OPDBidangController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:opd-bidang-list|opd-bidang-create|opd-bidang-delete', ['only' => 'getList']);
        $this->middleware('permission:opd-bidang-create', ['only' => 'store']);
        $this->middleware('permission:opd-bidang-delete', ['only' => 'destroy']);
    }

    public function getList($id_opd)
    {
        $data = DB::table('tb_opd_bidang')
            ->where('id_opd',$id_opd)
            ->paginate(20);

        if ($data) {
            return [
                'value' => $data,
                'msg' => "Data Ditemukan"
            ];
        }
        return [
            'value' => [],
            'msg' => "Data Tidak Ditemukan"
        ];
    }

    public function destroy($id)
    {
        $data = OPDBidang::find($id);

        if ($data->delete()) {
            return [
                'value' => $data,
                'msg' => "#{$id} berhasil dihapus"
            ];
        }

        return [
            'value' => [],
            'msg' => "#{$id} gagal dihapus"
        ];
    }

    public function store(Request $request)
    {
        $data = new OPDBidang();
        $data->fill($request->all());

        if ($data->save()) {
            return [
                'value' => $data,
                'msg' => "Data baru berhasil disimpan"
            ];
        }

        return [
            'value' => [],
            'msg' => "Data baru gagal disimpan"
        ];
    }

}
