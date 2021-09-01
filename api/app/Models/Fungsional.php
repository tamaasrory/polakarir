<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_fungsional
 * @property string $nama_fungsional
 */
class Fungsional extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tb_fungsional';
    // protected $primaryKey = 'id_fungsional';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['nama_fungsional'];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    public $searchable = ['nama_fungsional'];

}
