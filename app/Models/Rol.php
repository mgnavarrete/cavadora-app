<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Rol extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'rol';
    protected $primaryKey = 'rol_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rol_id',
        'rol_nombre', 
        'rol_desc', 
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'rol_permiso', 'rp_rol_id', 'rp_prm_id', 'rol_id', 'prm_id');
    }

    public function hasRole($roleName)
    {
        return $this->roles()->where('rol_desc', $roleName)->exists();
    }

    public function UserRol()
    {
        return $this->hasMany(UserRol::class, 'rol_id', 'ur_rol_id');
    }
    

}
