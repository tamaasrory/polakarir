<?php
/**
 * Copyright (c) 2020. dibuat Oleh Tama Asrory Ridhana, S.T, MTA.
 * Lisensi ini hanya diberikan dan tidak dapat di perjual belikan kembali tanpa izin pembuat
 */

namespace App;

use App\Traits\Searchable;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Laravel\Lumen\Auth\Authorizable;
use Spatie\Permission\Traits\HasRoles;

/**
 * Class User
 *
 * @package App
 * @property string $id
 * @property string $name
 * @property string $no_hp
 * @property array $role
 * @property string $email
 * @property string $email_verified_at
 * @property string $password
 * @property array $detail
 * @property string $remember_token
 * @property string $created_at
 * @property string $updated_at
 * @property string|null $role_id
 */
class User extends SelfModel implements AuthenticatableContract, AuthorizableContract
{
    use Authenticatable, Authorizable, HasRoles, Searchable;

    protected $guard_name = 'api';
    protected $table = 'users';
    protected $primaryKey = 'id';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'detail',
    ];

    /**
     * The attributes that are searchable.
     *
     * @var array
     */
    public $searchable = [
        'id',
        'name',
        'email',
        'email_verified_at',
        'detail',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'roles'
    ];

    protected $casts = [
        'detail' => 'json',
        'email_verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $appends = [
        'role'
    ];

    public function getRoleAttribute()
    {
        return $this->getRoleNames()->toArray();
    }
}
