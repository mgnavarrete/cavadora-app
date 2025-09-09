<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Permiso extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'prm_id';

    protected $table = 'permiso';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'prm_id',
        'prm_nombre',
        'prm_desc', 
    ];

    public function RolPermiso()
    {
        return $this->hasMany(RolPermiso::class, 'prm_id', 'rp_prm_id');
    }

}
