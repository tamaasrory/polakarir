<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Base\Controller;
use App\Models\Base\KeyGen;
use App\Models\Base\User;
use App\Models\JenisSurat;
use App\Models\SuratKeluar;
use App\Models\TujuanSurat;
use App\Supports\ExtApi;
use App\Supports\Tools;
use Carbon\Carbon;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel\ErrorCorrectionLevelLow;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\RoundBlockSizeMode\RoundBlockSizeModeMargin;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\Request;

class SuratKeluarController extends Controller
{

    public $title = 'Surat Keluar';

    public function __construct()
    {
        $this->middleware('permission:surat-keluar-list|surat-keluar-create|surat-keluar-edit|surat-keluar-delete', ['only' => 'index', 'show', 'getAtasan']);
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
        $customSearch = function ($builder) use ($request) {
            /** @var Builder $builder */
            /** @var User $auth */
            $auth = $request->auth;
            $dataUser = $auth['sinergi'];

            // untuk yang memiliki akses surat-keluar-list-all
            if ($auth->can('surat-keluar-list-all')) {
                // munculkan seluruh data surat keluar
                return $builder;
            }

            // untuk yang memiliki akses surat-keluar-list-opd
            if ($auth->can('surat-keluar-list-opd')) {
                // hanya munculkan surat keluar yang sesuai dengan "id_opd" user yang mengakses
                $builder->where('id_opd', $dataUser['id_opd']);
                return $builder;
            }

            // untuk yang tidak memiliki kedua akses diatas
            $builder->where('kode_jabatan_terusan', $dataUser['kode_jabatan']);
            // tidak muncul lagi setelah di tolak
            $builder->where('status', '!=', 'Ditolak ' . $dataUser['nama_jabatan']);
            // tidak muncul lagi setelah di setujui
            $builder->where('status', '!=', 'Disetujui ' . $dataUser['nama_jabatan']);
            // akan terus muncul di surat keluar pembuat
            $builder->orWhere('nip_author', $dataUser['nip']);

            return $builder;
        };

        $data = SuratKeluar::search($request, new SuratKeluar(), $customSearch);

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
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     */
    public function create(Request $request)
    {
        $jenis_surat = JenisSurat::selectRaw(
            "id_jenis_surat as value, concat(kode_surat,' - ',nama_jenis_surat) as text")->get();
        $opd = collect(ExtApi::listOpd())->map(function ($data) {
            $tmp = [];
            $tmp['value'] = $data['id_opd'];
            $tmp['text'] = $data['nama'];

            return $tmp;
        })->toArray();

        $opd = array_merge([['value' => '-1', 'text' => 'Seluruh OPD']], $opd);
        $kepada = $this->getAtasan($request);
        $kepada = array_map(
            fn($data) => ['value' => $data['kode_jabatan'], 'text' => $data['nama_pegawai']],
            $kepada
        );

        return [
            'value' => compact('jenis_surat', 'opd', 'kepada')
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function store(Request $request)
    {
        $data = new SuratKeluar();
        $data->fill(request()->all());

        $auth_sinergi = $request->auth['sinergi'];


        $penerima = $request->file('penerima_surat')->get();
        $penerima_arr = json_decode($penerima, true);

        if ($request->hasFile('lampiran')) {
            $original_filename = $request->file('lampiran')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './suratkeluar/';
            $namasurat = 'SuratKeluar-' . $auth_sinergi['id_opd'] . '-' . time() . '.' . $file_ext;

            if ($request->file('lampiran')->move($destination_path, $namasurat)) {
                $data->id_surat_keluar = KeyGen::randomKey();
                $data->status = 'Diajukan';
                $data->lampiran = $namasurat;
                $data->id_opd = $auth_sinergi['id_opd'];
                $data->nip_author = $auth_sinergi['nip'];

                TujuanSurat::create([
                    'id_surat_keluar' => $data->id_surat_keluar,
                    'id_opd' => $data->id_opd,
                    'tujuan' => $penerima_arr
                ]);

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
        $auth = request()->auth['sinergi'];

        /** @var SuratKeluar $surat_keluar */
        $surat_keluar = SuratKeluar::find($id);
        $dataUser = ExtApi::getPegawaiByNip($surat_keluar->nip_author);

        $showBtnTeruskan = ($auth['nip'] != $surat_keluar->nip_author)
            && !(strlen($auth['kode_jabatan']) <= 6);
        $showBtnMemo = $auth['nip'] != $surat_keluar->nip_author;
        $showBtnTte = strlen($auth['kode_jabatan']) <= 6;

        $teruskan = [];
        if ($showBtnTeruskan) {
            $teruskan = $this->getAtasan(request());
            $teruskan = array_map(function ($data) {
                return ['value' => $data['kode_jabatan'], 'text' => $data['nama_pegawai']];
            }, $teruskan);
        }

        $memo = [];
        if ($showBtnMemo) {
            $memo = [['value' => $dataUser['kode_jabatan'], 'text' => $dataUser['nama_pegawai']]];
        }

        if ($surat_keluar) {
            return [
                'value' => compact(
                    'surat_keluar',
                    'teruskan',
                    'memo',
                    'showBtnTeruskan',
                    'showBtnMemo',
                    'showBtnTte'
                ),
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
        /** @var SuratKeluar $surat_keluar */
        $surat_keluar = SuratKeluar::find($id);

        $jenis_surat = JenisSurat::selectRaw(
            "id_jenis_surat as value, concat(kode_surat,' - ',nama_jenis_surat) as text")->get();
        $opd = collect(ExtApi::listOpd())->map(function ($data) {
            $tmp = [];
            $tmp['value'] = $data['id_opd'];
            $tmp['text'] = $data['nama'];

            return $tmp;
        })->toArray();

        $opd = array_merge([
            ['value' => '-1', 'text' => 'Seluruh OPD']
        ], $opd);
        $surat_keluar->penerima_surat = $surat_keluar->getTujuan()->tujuan;
        return [
            'value' => compact(
                'jenis_surat',
                'opd',
                'surat_keluar',
//                'tujuan_surat',
            )
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response|array
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    public function update(Request $request)
    {
        $id = $request->input('id');

        /** @var SuratKeluar $data */
        $data = SuratKeluar::find($id);
        $old_name = $data->lampiran;

        $data->fill($request->all());

        $auth_sinergi = $request->auth['sinergi'];

        $penerima = $request->file('penerima_surat')->get();
        $penerima_arr = json_decode($penerima, true);

        if ($request->hasFile('lampiran')) {
            $original_filename = $request->file('lampiran')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './suratkeluar/';
            $namasurat = 'SuratKeluar-' . $auth_sinergi['id_opd'] . '-' . time() . '.' . $file_ext;

            if ($request->file('lampiran')->move($destination_path, $namasurat)) {
                $data->lampiran = $namasurat;
                // hapus file lama
                @unlink($destination_path . $old_name);
            }
        } else {
            $data->lampiran = $old_name;
        }

        TujuanSurat::update([
            'id_surat_keluar' => $id,
            'tujuan' => $penerima_arr,
        ]);

        $data->status = 'Diajukan';

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

        /** @var SuratKeluar $data data surat keluar */
        $data = SuratKeluar::find($id_surat);

        if ($data['status'] != 'Selesai') {

            //data pegawai
            $pegawai = $request->auth['sinergi'];


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
            $template = new \PhpOffice\PhpWord\TemplateProcessor('./suratkeluar/' . $data['lampiran'] . '');
            $template->setValue('${nomorsurat}', $nomor_surat['nomor_selanjutnya']);

            $template->setValue('${namalengkap}', $pegawai['nama_pegawai']);
            $template->setValue('${nip}', $pegawai['nip']);

            //update data nomor terakhir surat, nomor autonya berubah jadi nomor yang telah dipakai
            $nomorSuratTerakhir->update($data['id_opd'], $data['id_jenis_surat'], $nomor_surat['nomor_auto_selanjutnya']);

            if ($request->has('hash_tte')) {

                //dengan tte
                $hash_tte = $request->input('hash_tte');
                $template->setImageValue('ttdelektronik', "./qrcode/$output_file_qr.jpg");
                $template->setValue('${tanggal}', $tanggal);
                $template->setValue('${catatan_tte}', '-UU ITE No 11 Tahun 2008 Pasal 5 Ayat 1 </w:t><w:br/><w:t>
                                                                        "Informasi Elektronik dan/atau Dokumen Elektronik dan/atau hasil cetaknya merupakan alat bukti hukum yang sah ." </w:t><w:br/><w:t>
                                                                     -Dokumen ini telah ditandatangani secara elektronik menggunakan sertifikat elektronik yang diterbitkan BSrE');
            } else {

                //tanpa tte
                $template->setValue('${ttdelektronik}', '');
                $template->setValue('${tanggal}', ' </w:t><w:br/><w:t> ');
                $template->setValue('${catatan_tte}', '');
            }

            $template->saveAs($path_word_validasi);

            $public_path = Tools::publicPath();

            //convert to pdf
            $cmd = [
                '/Applications/LibreOffice.app/Contents/MacOS/soffice',
                '--headless',
                '--convert-to pdf',
                $public_path . 'suratkeluar_validasi/' . $data['lampiran'] . '/',
                '--outdir ' . $public_path . 'suratkeluar_pdf/'
            ];

            shell_exec(implode(' ', $cmd));

            //update surat keluar
            $data->status = 'Selesai';
            $file = explode('.', $data['lampiran']);
            $data->lampiran = $file[0] . '.pdf';
            $data->save();

            $this->updateHistori($id_surat,
                "Disetujui " . $pegawai['nama_jabatan'],
                $pegawai['nip'],
                $pegawai['nama_pegawai'],
                $pegawai['nama_jabatan'],
                $pegawai['kode_jabatan'],
                ""
            );

            return [
                'value' => $data,
                'msg' => "Surat Keluar Berhasil Disetujui"
            ];
        } else {
            return [
                'value' => $data,
                'msg' => "Gagal, Status Surat Keluar Telah Selesai"
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

    public function validasiSurat(Request $request)
    {
        $dataValidator = $request->auth['sinergi'];
        /** @var SuratKeluar $dataSurat */
        $dataSurat = SuratKeluar::find($request->id_surat_keluar);

        if ($request->ket == "Disetujui") {
            //surat disetujui
            $dataSurat->kode_jabatan_terusan = $request->kode_jabatan_terusan;
            $dataSurat->status = 'Disetujui ' . $dataValidator['nama_jabatan'];
            $dataSurat->catatan = "";
            $dataSurat->save();

            //update histori
            $this->updateHistori(
                $dataSurat->id_surat_keluar,
                $dataSurat->status,
                $dataValidator['nip'],
                $dataValidator['nama_pegawai'],
                $dataValidator['nama_jabatan'],
                $dataValidator['kode_jabatan'],
                $dataSurat->catatan
            );

            return "Berhasil disetujui";
        } else {
            //surat ditolak
            $dataSurat->status = 'Ditolak ' . $dataValidator['nama_jabatan'];
            $dataSurat->catatan = $request->catatan;
            $dataSurat->save();

            return "Berhasil ditolak dengan catatan " . $request->catatan;
        }
    }

    public function updateHistori($id_surat_keluar, $status_surat, $nip, $nama_pegawai, $nama_jabatan, $kode_jabatan, $catatan)
    {
        /** @var SuratKeluar $dataSurat */
        $dataSurat = SuratKeluar::find($id_surat_keluar);
        $dataHistori = [];
        if ($dataSurat) {
            //ditemukan
            if ($dataSurat['histori_surat'] == "") {
                //jika histori masih kosong, maka lgsung push histori
                array_push($dataHistori, (object)[
                    'nip' => $nip,
                    'nama_pegawai' => $nama_pegawai,
                    'jabatan' => $nama_jabatan,
                    'kode_jabatan' => $kode_jabatan,
                    'status_surat' => $status_surat,
                    'catatan' => $catatan,
                    'waktu' => Carbon::now()
                ]);
                $dataSurat->histori_surat = $dataHistori;
                $dataSurat->save();
                return "histori berhasil ditambahkan";
            } else {
                //tampung dlu yang lama, setelah itu gabung dengan yang baru
                array_push($dataHistori, (object)[
                    'nip' => $nip,
                    'nama_pegawai' => $nama_pegawai,
                    'jabatan' => $nama_jabatan,
                    'kode_jabatan' => $kode_jabatan,
                    'status_surat' => $status_surat,
                    'catatan' => $catatan,
                    'waktu' => Carbon::now()
                ]);

                //menggabungkan data histori sebelumnya dengan data histori terbaru
                $array1 = json_decode($dataSurat['histori_surat'], true);
                $array2 = json_decode(json_encode($dataHistori), true);

                $res = array_merge($array1, $array2);
                $merged = json_encode($res);

                $dataSurat->histori_surat = $merged;
                $dataSurat->save();

                return "histori berhasil ditambahkan";
            }
        } else {
            //tidak ditemukan
            return "surat keluar tidak ditemukan";
        }
    }

    public function getAtasan(Request $request)
    {
        $dataUser = $request->auth['sinergi'];
        //membuat request dengan parameter 'kj'

        $dataAtasan = [];
        if (strlen($dataUser["kode_jabatan_atasan"]) <= 6) {
            //jika kode atasannya dibawah sama dengan 6 karakter
            $tampungAtasan = ExtApi::getPegawaiByKodeJabatan($dataUser["kode_jabatan_atasan"]);

            array_push($dataAtasan, [
                "kode_jabatan" => $tampungAtasan['kode_jabatan'],
                "nip" => $tampungAtasan['nip'],
                "nama_pegawai" => $tampungAtasan['nama_pegawai']
            ]);
            return $dataAtasan;
        } else {
            $kode_jabatan_atasan = $dataUser["kode_jabatan_atasan"];

            while (1) {
                $tampungAtasan = ExtApi::getPegawaiByKodeJabatan($kode_jabatan_atasan);
                array_push($dataAtasan, [
                    "kode_jabatan" => $tampungAtasan['kode_jabatan'],
                    "nip" => $tampungAtasan['nip'],
                    "nama_pegawai" => $tampungAtasan['nama_pegawai']
                ]);
                if (strlen($kode_jabatan_atasan) <= 6) {
                    break;
                }
                $kode_jabatan_atasan = $tampungAtasan['kode_jabatan_atasan'];
            }
        }

        return $dataAtasan;
    }

}
