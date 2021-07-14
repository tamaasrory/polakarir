<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_opd_bidang
 * @property integer $id_opd
 * @property string $nama_opd_bidang
 * @property string $created_at
 * @property string $updated_at
 */
class OPDBidang extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tb_opd_bidang';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['id_opd', 'nama_opd_bidang', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     * 
     * @var array
     */
    public $searchable = ['id_opd', 'nama_opd_bidang', 'created_at', 'updated_at'];

}
