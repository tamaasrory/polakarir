<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\Controller;
use App\Models\Base\KeyGen;
use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use App\Supports\ExtApi;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{

    public $title = 'Surat Keluar';

    public function __construct()
    {
        $this->middleware('permission:surat-keluar-list|surat-keluar-create|surat-keluar-edit|surat-keluar-delete', ['only' => 'index', 'show']);
        $this->middleware('permission:surat-keluar-create', ['only' => 'create', 'store']);
        $this->middleware('permission:surat-keluar-edit', ['only' => 'edit', 'update']);
        $this->middleware('permission:surat-keluar-delete', ['only' => 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     */
    public function index(Request $request)
    {
        $data = SuratKeluar::search($request, new SuratKeluar());

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
        $jenis_surat = JenisSurat::selectRaw(
            "id_jenis_surat as value, (kode_surat||' - '||nama_jenis_surat) as text")->get();
        $opd = collect(ExtApi::listOpd())->map(function ($data) {
            $tmp = [];
            $tmp['value'] = $data['id_opd'];
            $tmp['text'] = $data['nama'];

            return $tmp;
        })->toArray();

        $opd = array_merge([['value' => '-1', 'text' => 'Seluruh OPD']], $opd);

        return [
            'value' => compact('jenis_surat', 'opd')
        ];
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
            $namasurat = 'SuratKeluar-' . $data['id_opd'] . '-' . time() . '.' . $file_ext;

            if ($request->file('lampiran')->move($destination_path, $namasurat)) {
//                $data->id_surat_keluar = KeyGen::randomKey();
                $data->status = 'Diajukan';
                $data->lampiran = $namasurat;

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
        $data = SuratKeluar::where('id_surat_keluar', $id)->first();
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


    public function tte(Request $request)
    {

        $id_surat = $request->input('id_surat_keluar');


        //data surat keluar
        $data = SuratKeluar::find($id_surat);

        if ($data['status'] != 'Selesai') {

            //data pegawai
            $pegawai = ExtApi::getPegawaiByNip($request);


            //Save into PDF
            $savePdfPath = './suratkeluar_pdf/' . $data['lampiran'] . '.pdf';

            /*@ If already PDF exists then delete it */
            if (file_exists($savePdfPath)) {
                unlink($savePdfPath);
            }

            //generate qrcode
            $output_file_qr = 'tte-' . $id_surat;
            $this->generatorQr($savePdfPath, $output_file_qr);

            //lokasi surat keluar setelah di setujui (.docx)
            $path_word_validasi = './suratkeluar_validasi/' . $data['lampiran'];

            $tanggal = $this->tanggal_indo(date('Y-m-d'));

            //get nomor surat terakhir
            $nomorSuratTerakhir = new NomorSuratTerakhirController;
            $nomor_surat = $nomorSuratTerakhir->getNomorTerakhir($data['id_opd'], $data['id_jenis_surat']);

            //update template
            $template = new \PhpOffice\PhpWord\TemplateProcessor('./suratkeluar/'.$data['lampiran'].'');
            $template->setValue('${nomorsurat}',$nomor_surat['nomor_selanjutnya']);

            $template->setValue('${namalengkap}',$pegawai['nama_pegawai']);
            $template->setValue('${nip}',$pegawai['nip']);

            //update data nomor terakhir surat, nomor autonya berubah jadi nomor yang telah dipakai
            $nomorSuratTerakhir->update($data['id_opd'], $data['id_jenis_surat'], $nomor_surat['nomor_auto_selanjutnya']);

            if ($request->has('hash_tte')) {

                //dengan tte
                $hash_tte = $request->input('hash_tte');
                $template->setImageValue('ttdelektronik', "./qrcode/$output_file_qr.jpg");
                $template->setValue('${tanggal}',$tanggal);
            } else {

                //tanpa tte
                $template->setValue('${ttdelektronik}', ' </w:t><w:br/><w:t> ');
                $template->setValue('${tanggal}', ' </w:t><w:br/><w:t> ');
            }

            $template->saveAs($path_word_validasi);

            //convert to pdf
            $cmd = '/Applications/LibreOffice.app/Contents/MacOS/soffice --headless --convert-to pdf /Users/mrifqiaufaabdika/PhpstormProjects/eoffice/api/public/suratkeluar_validasi/' . $data['lampiran'] . '/ --outdir /Users/mrifqiaufaabdika/PhpstormProjects/eoffice/api/public/suratkeluar_pdf/';
            shell_exec($cmd);

            //update surat keluar
            $data->status = 'Selesai';
            $file = explode('.', $data['lampiran']);
            $data->lampiran = $file[0] . '.pdf';
            $data->update();


            return [
                'value' => $data,
                'msg' => "Surat Keluar Berhasil Disetujui"
            ];
        } else {
            return [
                'value' => $data,
                'msg' => "Gagal,Status Surat Keluar Telah Selesai"
            ];
        }
    }

    function generatorQr($data, $output_file)
    {

        $writer = new PngWriter();

        $qrCode = QrCode::create($data)
            ->setEncoding(new Encoding('UTF-8'))
            ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
            ->setSize(300)
            ->setMargin(-10)
            ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
            ->setForegroundColor(new Color(0, 0, 0))
            ->setBackgroundColor(new Color(255, 255, 255));


        $result = $writer->write($qrCode);

        //save qrcode
        $result->saveToFile("./qrcode/$output_file.jpg");


    }


    function tanggal_indo($tanggal)
    {
        $bulan = array(1 => 'Januari',
            'Februari',
            'Maret',
            'April',
            'Mei',
            'Juni',
            'Juli',
            'Agustus',
            'September',
            'Oktober',
            'November',
            'Desember'
        );
        $split = explode('-', $tanggal);
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }


}
