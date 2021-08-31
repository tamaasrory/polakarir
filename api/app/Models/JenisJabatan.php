<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_jenis_jabatan
 * @property string $nama_jenis_jabatan
 */
class JenisJabatan extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tb_jenis_jabatan';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['nama_jenis_jabatan'];

    /**
     * The attributes that are searchable.
     * 
     * @var array
     */
    public $searchable = ['nama_jenis_jabatan'];

}
