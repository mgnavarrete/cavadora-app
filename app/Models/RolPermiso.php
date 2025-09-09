<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RolPermiso extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'rp_id';

    protected $table = 'rol_permiso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'rp_id',
        'rp_rol_id',
        'rp_prm_id',
    ];

    public function Rol()
    {
        return $this->belongsTo(Rol::class, 'rp_rol_id', 'rol_id');
    }

    public function Permiso()
    {
        return $this->belongsTo(Permiso::class, 'rp_prm_id', 'prm_id');
    }

}
