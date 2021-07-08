<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * App\Material
 *
 * @property int $id_surat_keluar
 * @property string $nip_author
 * @property int $id_opd
 * @property string $kode_jabatan_terusan
 * @property int $id_jenis_surat
 * @property string $nomor_surat
 * @property string $tanggal_surat
 * @property string $perihal_surat
 * @property string $isi_surat_ringkas
 * @property string $kategori_surat
 * @property string $karakteristik_surat
 * @property string $derajat_surat
 * @property string $catatan
 * @property string $lampiran
 * @property string $status
 * @property array $histori_surat
 * @property string $created_at
 * @property string $updated_at
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
        'id_opd',
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

    public $appends = [
        'jenis_surat'
    ];

    public function getJenisSuratAttribute()
    {
        return $this->belongsTo(JenisSurat::class,
            'id_jenis_surat',
            'id_jenis_surat')
            ->first('nama_jenis_surat')->nama_jenis_surat;
    }

    public function getTujuan()
    {
        return $this->belongsTo(TujuanSurat::class,
            'id_surat_keluar',
            'id_surat_keluar')
            ->first([
                'id_tujuan_surat',
                'id_surat_keluar',
                'id_opd',
                'tujuan',
            ]);
    }
}
