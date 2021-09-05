<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_syarat_jabatan
 * @property string $nama_syarat
 * @property string $jenis_jabatan
 * @property string $kode_jabatan
 * @property string $url_berkas
 * @property string $created_at
 * @property string $updated_at
 */
class SyaratJabatan extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tbl_syarat_jabatan';
    protected $primaryKey = 'id_syarat_jabatan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nama_syarat','jenis_jabatan', 'kode_jabatan','url_berkas', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    public $searchable = ['nama_syarat','jenis_jabatan', 'kode_jabatan','url_berkas', 'created_at', 'updated_at'];


    /*public function getJenisSuratAttribute()
    {
        return $this->belongsTo(JenisSurat::class,
            'id_jenis_surat',
            'id_jenis_surat')->first('nama_jenis_surat')->nama_jenis_surat;
    }

    public $appends = ['jenis_surat'];*/


}
