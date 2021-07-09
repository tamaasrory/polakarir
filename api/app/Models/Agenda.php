<?php

namespace App\Models;

use App\Models\Base\SelfModel;
use App\Traits\Searchable;

/**
 * @property integer $id_agenda
 * @property string $nip_pegawai
 * @property integer $id_surat_masuk
 * @property string $nama_kegiatan
 * @property string $waktu
 * @property string $lokasi
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Agenda extends SelfModel
{
    use Searchable;

    /**
     * The table associated with the model.
     * 
     * @var string
     */
    protected $table = 'tb_agenda';
    protected $primaryKey='id_agenda';

    /**
     * The attributes that are mass assignable.
     * 
     * @var array
     */
    protected $fillable = ['nip_pegawai', 'id_surat_masuk', 'nama_kegiatan', 'waktu', 'lokasi', 'id_opd','status', 'created_at', 'updated_at'];

    /**
     * The attributes that are searchable.
     * 
     * @var array
     */
    public $searchable = ['nip_pegawai', 'id_surat_masuk', 'nama_kegiatan', 'waktu', 'lokasi', 'id_opd','status', 'created_at', 'updated_at'];

}
