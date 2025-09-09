<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';
    protected $primaryKey = 'id_order';
    public $timestamps = true;

    protected $fillable = [
        'client_name',
        'cliente_rut',
        'client_phone',
        'cliente_email',
        'client_address',
        'client_info',
        'work_info',
        'estado',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /** Relaciones */
    public function users()
    {
        // pivot user_orden: id_orden (this) <-> id_user
        return $this->belongsToMany(User::class, 'user_orden', 'id_orden', 'id_user');
    }

    public function shifts()
    {
        return $this->hasMany(Shift::class, 'id_order', 'id_order');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'id_order', 'id_order');
    }
}
