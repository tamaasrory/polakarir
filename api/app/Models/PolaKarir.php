<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_pola_karir
 * @property string $esselon
 * @property string $fungsional
 * @property string $kode_jabatan
 * @property string $url
 * @property string $created_at
 * @property string $updated_at
 * @property array $id_opd
 */
class PolaKarir extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tbl_pola_karir';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['esselon', 'fungsional', 'kode_jabatan', 'url','id_opd', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     * 
     * @var array
     */
    public $searchable = ['esselon', 'fungsional', 'kode_jabatan', 'url','id_opd', 'created_at', 'updated_at'];

    protected $casts = [
        'id_opd' => 'json'
    ];

    public function getNamaFungsionalAttribute()
    {
        return $this->belongsTo(Fungsional::class,
            'fungsional',
            'id_fungsional')->first('nama_fungsional')->nama_fungsional;
    }

    public function getNamaEsselonAttribute()
    {
        return $this->belongsTo(Esesslon::class,
            'esselon',
            'id_esselon')->first('nama_esselon')->nama_esselon;
    }

    public function getNamaJenisJabatanAttribute()
    {
        return $this->belongsTo(JenisJabatan::class,
            'kode_jabatan',
            'id_jenis_jabatan')->first('nama_jenis_jabatan')->nama_jenis_jabatan;
    }



    public $appends = ['nama_fungsional','nama_esselon','nama_jenis_jabatan'];

}
