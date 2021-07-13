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
            $builder->whereJsonContains('kode_jabatan_terusan', $dataUser['kode_jabatan']);

            // tidak muncul lagi setelah di tolak
            // $builder->where('status', '!=', 'Ditolak ' . $dataUser['nama_jabatan']);

            // tidak muncul lagi setelah di setujui
            // $builder->where('status', '!=', 'Disetujui ' . $dataUser['nama_jabatan']);

            $builder->where('status', 'NOT LIKE', 'Disetujui%');

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
        $jenis_surat = JenisSurat::selectRaw(implode(',', [
            "id_jenis_surat as value",
            "CONCAT(kode_surat,' - ',nama_jenis_surat) as text"
        ]))->get();

        $opd = collect(ExtApi::listOpd())->map(fn($data) => [
            'value' => $data['id_opd'], 'text' => $data['nama']
        ])->toArray();

        $opd = array_merge([['value' => '-1', 'text' => 'Seluruh OPD']], $opd);
        $kepada = $this->getAtasan($request);

        $kepada = array_map(
            fn($data) => [
                'value' => [
                    'kode_jabatan' => $data['kode_jabatan'],
                    'nama_jabatan' => $data['nama_jabatan']
                ],
                'text' => $data['nama_pegawai']
            ],
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

        if ($request->hasFile('lampiran')
            && $request->hasFile('kepada')
            && $request->hasFile('penerima_surat')
        ) {
            $penerima = $request->file('penerima_surat')->get();
            $penerima_arr = json_decode($penerima, true);

            $kepada = json_decode($request->file('kepada')->get(), true);

            $original_filename = $request->file('lampiran')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './suratkeluar/';
            $namasurat = 'SuratKeluar-' . $auth_sinergi['id_opd'] . '-' . time() . '.' . $file_ext;

            if ($request->file('lampiran')->move($destination_path, $namasurat)) {
                $data->id_surat_keluar = KeyGen::randomKey();
                $data->status = 'Diajukan Kpd. ' . ucwords($kepada['nama_jabatan']);
                $data->kode_jabatan_terusan = [$kepada['kode_jabatan']];
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
        $kjt = $surat_keluar->kode_jabatan_terusan;

        // kode jabatan terusak terakhir
        $kjt_terakhir = end($kjt);

        $dataUser = ExtApi::getPegawaiByNip($surat_keluar->nip_author);
        $isRevisi = (bool)strstr(strtolower($surat_keluar->status), 'revisi');

        // button teruskan akan tampil bila bukan si pembuat surat keluar
        $showBtnTeruskan = ($auth['nip'] != $surat_keluar->nip_author)
            && !(strlen($auth['kode_jabatan']) <= 6)
            && ($auth['kode_jabatan'] == $kjt_terakhir)
            && !$isRevisi;

        // button Revisi akan tampil bila bukan si pembuat surat keluar
        $showBtnMemo = ($auth['nip'] != $surat_keluar->nip_author)
            && ($auth['kode_jabatan'] == $kjt_terakhir)
            && !$isRevisi;

        // button tte akan tampil bila kode jabatan <= 6
        $showBtnTte = strlen($auth['kode_jabatan']) <= 6
            && ($auth['kode_jabatan'] == $kjt_terakhir)
            && !$isRevisi;

        // button edit muncul hanya saat ada revisi saja dan yang bisa
        // merevisi hanya si pembuat surat keluar
        $canRevisi = ($auth['nip'] == $surat_keluar->nip_author)
            && $isRevisi;

        $teruskan = [];
        if ($showBtnTeruskan) {
            $teruskan = $this->getAtasan(request());
            $teruskan = array_map(
                fn($data) => [
                    'value' => [
                        'kode_jabatan' => $data['kode_jabatan'],
                        'nama_jabatan' => $data['nama_jabatan']
                    ],
                    'text' => $data['nama_pegawai']
                ],
                $teruskan
            );
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
                    'showBtnTte',
                    'canRevisi'
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

        $jenis_surat = JenisSurat::selectRaw(implode(',', [
            "id_jenis_surat as value",
            "CONCAT(kode_surat,' - ',nama_jenis_surat) as text"
        ]))->get();

        $opd = collect(ExtApi::listOpd())->map(fn($data) => [
            'value' => $data['id_opd'], 'text' => $data['nama']
        ])->toArray();

        $opd = array_merge([
            ['value' => '-1', 'text' => 'Seluruh OPD']
        ], $opd);

        $surat_keluar->penerima_surat = $surat_keluar->getTujuanSurat()->tujuan;

        return [
            'value' => compact(
                'jenis_surat',
                'opd',
                'surat_keluar'
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
        $auth_sinergi = $request->auth['sinergi'];
        $id = $request->input('id_surat_keluar');

        /** @var SuratKeluar $surat_keluar */
        $surat_keluar = SuratKeluar::find($id);

        $surat_keluar->id_jenis_surat = $request->id_jenis_surat;
        $surat_keluar->perihal_surat = $request->perihal_surat;
        $surat_keluar->isi_surat_ringkas = $request->isi_surat_ringkas;
        $surat_keluar->kategori_surat = $request->kategori_surat;
        $surat_keluar->karakteristik_surat = $request->karakteristik_surat;
        $surat_keluar->derajat_surat = $request->derajat_surat;

        if ($request->hasFile('lampiran')) {
            $original_filename = $request->file('lampiran')->getClientOriginalName();
            $original_filename_arr = explode('.', $original_filename);
            $file_ext = end($original_filename_arr);
            $destination_path = './suratkeluar/';
            $namasurat = 'SuratKeluar-' . $auth_sinergi['id_opd'] . '-' . time() . '.' . $file_ext;

            if ($request->file('lampiran')->move($destination_path, $namasurat)) {
                $old_name = $surat_keluar->lampiran;
                $surat_keluar->lampiran = $namasurat;
                // hapus file lama
                @unlink($destination_path . $old_name);
            }
        }

        $penerima = $request->file('penerima_surat')->get();
        $penerima_arr = json_decode($penerima, true);

        /** @var TujuanSurat $tujuanSurat */
        $tujuanSurat = TujuanSurat::where('id_surat_keluar', $id)->first();
        $tujuanSurat->tujuan = $penerima_arr;
        $tujuanSurat->save();

        /*
         * Mencari nama_jabatan berdasarkan kode jabatan terusan index terakhir
         * data yang di cari dari dalam histori surat
         */
        $kjt = $surat_keluar->kode_jabatan_terusan;
        $historis = $surat_keluar->histori_surat;

        $nama_jabatan = null;
        foreach ($historis as $history) {
            if ($history['kode_jabatan'] == end($kjt)) {
                $nama_jabatan = $history['nama_jabatan'];
                break;
            }
        }

        $surat_keluar->status = 'Diajukan Kpd. ' . $nama_jabatan;

        if ($surat_keluar->save()) {
            return [
                'value' => $surat_keluar,
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
            $dataNomorSurat = new FormatPenomoranSuratController();
            $nomor_surat = $dataNomorSurat->getNomorSurat($data['id_opd'],$data['kode_klasifikasi'],$data['opd_bidang']);

            //update template
            $template = new \PhpOffice\PhpWord\TemplateProcessor('./suratkeluar/' . $data['lampiran'] . '');
            $template->setValue('${nomorsurat}', $nomor_surat['nomor_surat']);

            $template->setValue('${namalengkap}', $pegawai['nama_pegawai']);
            $template->setValue('${nip}', $pegawai['nip']);

            //update data format penomoran surat, nomor urut terakhir berubah jadi nomor yang telah dipakai
            $requestPenomoran = new Request(["nomor_urut_terakhir" => $nomor_surat['nomor_urut']]);
            $dataNomorSurat->update($requestPenomoran,$nomor_surat['id_format_penomoran']);

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
            // teruskan
            $teruskan = $request->kode_jabatan_terusan;
            // tampung dan tambah kode jabatan yang dapat melihat surat keluar
            $tmpKjt = $dataSurat->kode_jabatan_terusan;
            $tmpKjt[] = $teruskan['kode_jabatan'];

            // kode_jabatan_terusan menyimpan lebih dari 1 kode jabatan
            // supaya surat keluar dapat tampilkan di tabel mereka
            $dataSurat->kode_jabatan_terusan = $tmpKjt;

            $dataSurat->status = 'Diajukan Kpd. ' . $teruskan['nama_jabatan'];
            $dataSurat->catatan = $request->catatan;
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
            $dataSurat->status = 'Revisi ' . $dataValidator['nama_jabatan'];
            $dataSurat->catatan = $request->catatan;
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

            return "Berhasil ditolak dengan catatan " . $request->catatan;
        }
    }

    public function updateHistori($id_surat_keluar, $status_surat, $nip, $nama_pegawai, $nama_jabatan, $kode_jabatan, $catatan)
    {
        /** @var SuratKeluar $dataSurat */
        $dataSurat = SuratKeluar::find($id_surat_keluar);

        if ($dataSurat) {
            //ditemukan
            if ($dataSurat->histori_surat == "") {
                //jika histori masih kosong, maka lgsung push histori
                $dataHistori = [
                    'nip' => $nip,
                    'nama_pegawai' => $nama_pegawai,
                    'nama_jabatan' => $nama_jabatan,
                    'kode_jabatan' => $kode_jabatan,
                    'status_surat' => $status_surat,
                    'catatan' => $catatan,
                    'waktu' => date('Y-m-d H:i:s')
                ];

                $dataSurat->histori_surat = [$dataHistori];
                $dataSurat->save();
                return "histori berhasil ditambahkan";
            } else {
                //tampung dlu yang lama, setelah itu gabung dengan yang baru
                $dataHistori = $dataSurat->histori_surat;
                //menggabungkan data histori sebelumnya dengan data histori terbaru
                $dataHistori[] = [
                    'nip' => $nip,
                    'nama_pegawai' => $nama_pegawai,
                    'nama_jabatan' => $nama_jabatan,
                    'kode_jabatan' => $kode_jabatan,
                    'status_surat' => $status_surat,
                    'catatan' => $catatan,
                    'waktu' => date('Y-m-d H:i:s')
                ];

                $dataSurat->histori_surat = $dataHistori;
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
                "nama_jabatan" => $tampungAtasan['nama_jabatan'],
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
                    "nama_jabatan" => $tampungAtasan['nama_jabatan'],
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

    public function downloadSurat($id)
    {
        /** @var SuratKeluar $surat_keluar */
        $surat_keluar = SuratKeluar::findOrFail($id);
        $file_path = './suratkeluar/' . $surat_keluar->lampiran;

        if (file_exists($file_path)) {
            return response()->download($file_path);
        } else {
            return response('not found', 404);
        }
    }

}
