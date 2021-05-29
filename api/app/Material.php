<?php

namespace App;

use App\Traits\Searchable;

/**
 * App\Material
 *
 * @property int $id
 * @property string|null $nama
 * @property string|null $satuan
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 */
class Material extends SelfModel
{
    use Searchable;

    protected $table = 'material';
    protected $primaryKey = 'id';
    public $incrementing = true;

    public $searchable = [
        'id',
        'nama',
        'satuan',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'nama',
        'satuan',
    ];


}
