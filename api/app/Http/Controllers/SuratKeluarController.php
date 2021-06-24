<?php
namespace App\Http\Controllers;

use App\Supports\ExtApi;
use App\SuratKeluar;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Gears\Pdf;
use Illuminate\Http\Request;
use NcJoes\OfficeConverter\OfficeConverter;
use PhpOffice\PhpWord\PhpWord;

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
            $namasurat = 'SuratKeluar-'.$data['id_opd'].'-'. time() .'.' . $file_ext;

            if ($request->file('lampiran')->move($destination_path, $namasurat)) {
                $data->lampiran =  $namasurat;

                if ($data->save()) {
                    return [
                        'value' => $data,
                        'msg' => "{$this->title} baru berhasil disimpan"
                    ];
                }

            } else {
                return [
                    'value' => [],
                    'msg' => "{$this->title} baru gagal disimpan"
                ];
            }
        } else {
            return [
                'value' => [],
                'msg' => "{$this->title} baru gagal disimpan"
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

    public function ttd(Request $request){

        $id_surat = $request->input('id_surat_keluar');
        $nama_file_word = $request->input('nama_file_word');
        $nip = $request->input('nip');


        $pegawai =  ExtApi::getPegawaiByNip($request);


        //Save into PDF
        $savePdfPath =  './suratkeluar_pdf/'.$nama_file_word.'.pdf';

        /*@ If already PDF exists then delete it */
        if ( file_exists($savePdfPath) ) {
            unlink($savePdfPath);
        }

        //generate qrcode
        $output_file_qr = 'tte-'.$id_surat;
        $this->generatorQr($savePdfPath,$output_file_qr);


        $path_word_validasi = './suratkeluar_validasi/'.$nama_file_word;
        $template = new \PhpOffice\PhpWord\TemplateProcessor('./suratkeluar/'.$nama_file_word.'');
        $template->setValue('${nomorsurat}',"071/bbp-inotek/10/2021");
        $template->setImageValue('ttdelektronik',"./qrcode/$output_file_qr.jpg");
        $template->setValue('${namalengkap}',$pegawai['nama_pegawai']);
        $template->setValue('${nip}',$pegawai['nip']);

        $template->saveAs($path_word_validasi);





  //      shell_exec('export HOME=./ && libreoffice --headless -convert-to pdf --outdir ./suratkeluar_pdf /suratkeluar/edit.docx');


        return "succes";
    }

    function generatorQr($data,$output_file){

        $writer =  new PngWriter();

       $qrCode = QrCode::create($data)
           ->setEncoding(new Encoding('UTF-8'))
           ->setErrorCorrectionLevel(new ErrorCorrectionLevelLow())
           ->setSize(300)
           ->setMargin(10)
           ->setRoundBlockSizeMode(new RoundBlockSizeModeMargin())
           ->setForegroundColor(new Color(0,0,0))
           ->setBackgroundColor(new Color(255,255,255));


       $result = $writer->write($qrCode);

       //save qrcode
        $result->saveToFile("./qrcode/$output_file.jpg");


    }



}
