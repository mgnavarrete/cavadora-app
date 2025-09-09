<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Shift extends Model
{
    use HasFactory;

    protected $table = 'shifts';
    protected $primaryKey = 'id_shift';
    public $timestamps = true;

    protected $fillable = [
        'id_order',
        'shift_date',
        'start_time',
        'end_time',
        'description',
        'status',
        'responsible',
    ];

    protected $casts = [
        'shift_date' => 'date:Y-m-d', // OK: es DATE
        // NO castear TIME como datetime. Laravel los maneja como string.
        // 'start_time' => 'datetime:H:i:s',
        // 'end_time'   => 'datetime:H:i:s',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /** start_at/end_at listos como Carbon en la timezone de la app */
    public function getStartAtAttribute(): ?Carbon
    {
        if (!$this->shift_date || !$this->start_time) return null;

        // Asegurar que la hora sea solo H:i:s aunque venga como Carbon o con fecha
        $timeStr = $this->start_time instanceof Carbon
            ? $this->start_time->format('H:i:s')
            : (string) $this->start_time;

        // Si por error vino “YYYY-mm-dd HH:ii:ss”, extraer solo la parte de hora:
        if (preg_match('/\b(\d{2}:\d{2}(?::\d{2})?)\b/', $timeStr, $m)) {
            $timeStr = strlen($m[1]) === 5 ? $m[1] . ':00' : $m[1]; // normaliza a H:i:s
        }

        // Componer datetime (fecha + hora)
        $dt = Carbon::createFromFormat('Y-m-d H:i:s', $this->shift_date->format('Y-m-d') . ' ' . $timeStr, config('app.timezone'));
        return $dt; // ya en tz de app
    }

    public function getEndAtAttribute(): ?Carbon
    {
        if (!$this->shift_date || !$this->end_time) return null;

        $timeStr = $this->end_time instanceof Carbon
            ? $this->end_time->format('H:i:s')
            : (string) $this->end_time;

        if (preg_match('/\b(\d{2}:\d{2}(?::\d{2})?)\b/', $timeStr, $m)) {
            $timeStr = strlen($m[1]) === 5 ? $m[1] . ':00' : $m[1];
        }

        $dt = Carbon::createFromFormat('Y-m-d H:i:s', $this->shift_date->format('Y-m-d') . ' ' . $timeStr, config('app.timezone'));
        return $dt;
    }

    /** Accessors adicionales para conveniencia en las vistas */
    public function getIsTodayAttribute(): bool
    {
        $startAt = $this->start_at;
        return $startAt ? $startAt->isToday() : false;
    }

    public function getIsTomorrowAttribute(): bool
    {
        $startAt = $this->start_at;
        return $startAt ? $startAt->isTomorrow() : false;
    }

    /** Relaciones */
    public function order()
    {
        return $this->belongsTo(Order::class, 'id_order', 'id_order');
    }
}
