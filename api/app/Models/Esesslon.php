<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_esselon
 * @property string $nama_esselon
 */
class Esesslon extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tb_esselon';
    protected $primaryKey = 'id_esselon';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['nama_esselon'];

    /**
     * The attributes that are searchable.
     * 
     * @var array
     */
    public $searchable = ['nama_esselon'];

}
