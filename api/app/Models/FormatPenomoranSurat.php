<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_format_penomoran
 * @property integer $id_opd
 * @property string $format_penomoran
 * @property integer $nomor_urut_terakhir
 * @property string $created_at
 * @property string $updated_at
 */
class FormatPenomoranSurat extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_format_penomoran_surat';
    protected $primaryKey = 'id_format_penomoran';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['id_opd', 'format_penomoran', 'nomor_urut_terakhir', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    public $searchable = ['id_opd', 'format_penomoran', 'nomor_urut_terakhir', 'created_at', 'updated_at'];

}
