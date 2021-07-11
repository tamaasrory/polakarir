<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property int $id
 * @property string $kode_surat
 * @property string $nama_jenis_surat
 * @property string $created_at
 * @property string $updated_at
 */
class JenisSurat extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_jenis_surat';
    protected $primaryKey = 'id_jenis_surat';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['kode_surat', 'nama_jenis_surat', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    public $searchable = ['kode_surat', 'nama_jenis_surat', 'created_at', 'updated_at'];



}
