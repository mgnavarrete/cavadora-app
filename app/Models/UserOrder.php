<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOrden extends Model
{
    use HasFactory;

    protected $table = 'user_orden';
    // No hay PK autoincremental, ni timestamps en la tabla
    protected $primaryKey = null;
    public $incrementing = false;
    public $timestamps = false;

    protected $fillable = ['id_user', 'id_orden'];

    /** Relaciones */
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_orden', 'id_order');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }
}
