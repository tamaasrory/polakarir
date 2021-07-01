<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_template_surat
 * @property string $nip_author
 * @property string $nama_template
 * @property string $url_berkas
 * @property string $sumber_hukum
 * @property string $jenis_surat
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class TemplateSurat extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tb_template_surat';
    protected $primaryKey = 'id_template_surat';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['nip_author', 'nama_template', 'url_berkas', 'sumber_hukum', 'jenis_surat', 'status', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     * 
     * @var array
     */
    public $searchable = ['nip_author', 'nama_template', 'url_berkas', 'sumber_hukum', 'jenis_surat', 'status', 'created_at', 'updated_at'];

}
