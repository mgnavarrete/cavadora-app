<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $primaryKey = 'id_payment';
    public $timestamps = true;

    protected $fillable = [
        'id_order',
        'labor_cost',
        'machine_cost',
        'fuel_expenses',
        'extra_cost',
        'info_extra_cost',
        'status',
        'emission_date',
        'payment_date',
        'description',
    ];

    protected $casts = [
        'emission_date' => 'date',
        'payment_date'  => 'date',
        'created_at'    => 'datetime',
        'updated_at'    => 'datetime',
    ];

    /** Relaciones */
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }
}
