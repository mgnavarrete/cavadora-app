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
        'hour_cost',
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

    /** Métodos para cálculo de total */
    public function getTotalHoursAttribute()
    {
        if (!$this->order) {
            return 0;
        }

        $totalHours = 0;
        foreach ($this->order->shifts as $shift) {
            if ($shift->start_time && $shift->end_time) {
                $start = \Carbon\Carbon::parse($shift->start_time);
                $end = \Carbon\Carbon::parse($shift->end_time);
                
                // Si la hora de fin es menor que la de inicio, asumimos que es al día siguiente
                if ($end->lessThanOrEqualTo($start)) {
                    $end->addDay();
                }
                
                $totalHours += $start->diffInHours($end, true);
            }
        }

        return $totalHours;
    }

    public function getTotalAmountAttribute()
    {
        $laborTotal = ($this->hour_cost ?? 0) * $this->total_hours;
        $extraCost = $this->extra_cost ?? 0;
        
        return $laborTotal + $extraCost;
    }
}
