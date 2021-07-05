<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property string $kode_klasifikasi
 * @property string $nama_klasifikasi
 * @property string $parent_kode
 * @property string $created_at
 * @property string $updated_at
 */
class KlasifikasiSurat extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tb_klasifikasi';
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['kode_klasifikasi','nama_klasifikasi', 'parent_kode', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     * 
     * @var array
     */
    public $searchable = ['kode_klasifikasi','nama_klasifikasi', 'parent_kode', 'created_at', 'updated_at'];

}
