<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserRol extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $primaryKey = 'ur_id';

    protected $table = 'user_rol';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'ur_id',
        'ur_users_id', 
        'ur_rol_id',
    ];

    public function Usuario()
    {
        return $this->belongsTo(User::class, 'ur_users_id', 'id');
    }

    public function Rol()
    {
        return $this->belongsTo(Rol::class, 'ur_rol_id', 'rol_id');
    }

}
