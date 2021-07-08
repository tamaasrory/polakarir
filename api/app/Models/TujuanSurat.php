<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_tujuan_surat
 * @property integer $id_surat_keluar
 * @property integer $id_opd
 * @property string $tujuan
 * @property string $created_at
 * @property string $updated_at
 */
class TujuanSurat extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tb_tujuan_surat';
    protected $primaryKey = 'id_tujuan_surat';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['id_surat_keluar', 'id_opd', 'tujuan', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     * 
     * @var array
     */
    public $searchable = ['id_surat_keluar', 'id_opd', 'tujuan', 'created_at', 'updated_at'];

}
