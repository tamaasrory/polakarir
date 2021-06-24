<?php

namespace App;

use App\Traits\Searchable;

/**
 * App\Material
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class SuratKeluar extends SelfModel
{
    use Searchable;

    protected $table = 'tb_surat_keluar';
    protected $primaryKey = 'id_surat_keluar';
    public $incrementing = true;

    public $searchable = [
        'nomor_surat',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id_surat_keluar',
        'nip_author',
        'id_opd',
        'kode_jabatan_terusan',
        'id_jenis_surat',
        'nomor_surat',
        'tanggal_surat',
        'perihal_surat',
        'isi_surat_ringkas',
        'kategori_surat',
        'karakteristik_surat',
        'derajat_surat',
        'catatan',
        'lampiran',
        'status',
        'histori_surat',
    ];


}
