<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\Shift;
use App\Models\Order;

class ShiftController extends Controller
{
    /**
     * Crear nueva sesión de trabajo.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'id_order' => 'required|exists:orders,id_order',
            'shift_date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'status' => 'required|in:pending,completed,canceled,rescheduled',
            'responsible' => 'nullable|string|max:150',
            'description' => 'nullable|string',
        ]);

        // Validar duración mínima de 8 horas
        $this->validateMinimumDuration($request->start_time, $request->end_time);

        try {
            // Crear la nueva sesión
            Shift::create([
                'id_order' => $request->id_order,
                'shift_date' => $request->shift_date,
                'start_time' => $request->start_time . ':00', // Agregar segundos
                'end_time' => $request->end_time ? $request->end_time . ':00' : null,
                'status' => $request->status,
                'responsible' => $request->responsible,
                'description' => $request->description,
            ]);

            return redirect()->back()->with('success', 'Sesión de trabajo agendada exitosamente');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al agendar la sesión: ' . $e->getMessage()]);
        }
    }

    public function updateStatus(Request $request, \App\Models\Shift $shift)
    {
        try {
            $data = $request->validate([
                'status' => 'required|in:pending,completed,canceled,rescheduled',
                'description' => 'nullable|string',
                'responsible' => 'nullable|string|max:150',
                'shift_date' => 'nullable|date',
                'start_time' => 'nullable|date_format:H:i',
                'end_time' => 'nullable|date_format:H:i',
            ]);

            // Si se están actualizando las horas, validar duración mínima
            if (isset($data['start_time']) && isset($data['end_time'])) {
                $this->validateMinimumDuration($data['start_time'], $data['end_time']);
            } elseif (isset($data['start_time']) && $shift->end_time) {
                $this->validateMinimumDuration($data['start_time'], substr($shift->end_time, 0, 5));
            } elseif (isset($data['end_time']) && $shift->start_time) {
                $this->validateMinimumDuration(substr($shift->start_time, 0, 5), $data['end_time']);
            }

            // Normalizar las horas para asegurar formato HH:MM:SS
            if (isset($data['start_time'])) {
                $data['start_time'] = $data['start_time'] . ':00';
            }
            if (isset($data['end_time'])) {
                $data['end_time'] = $data['end_time'] . ':00';
            }

            $shift->fill($data)->save();

            // Si es una petición AJAX, retornar JSON
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Turno actualizado correctamente.',
                    'shift' => $shift->fresh()
                ]);
            }

            return back()->with('success', 'Turno actualizado correctamente.');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error de validación.',
                    'errors' => $e->errors()
                ], 422);
            }
            throw $e;
        } catch (\Exception $e) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Error al actualizar el turno: ' . $e->getMessage()
                ], 500);
            }
            return back()->withErrors(['error' => 'Error al actualizar el turno: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar sesión de trabajo.
     */
    public function destroy(Shift $shift)
    {
        try {
            $orderName = $shift->order->client_name ?? 'Cliente desconocido';
            $shiftDate = $shift->shift_date ? $shift->shift_date->format('d/m/Y') : 'Fecha desconocida';

            $shift->delete();

            return redirect()->back()->with('success', "Sesión del {$shiftDate} para {$orderName} eliminada exitosamente");
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['error' => 'Error al eliminar la sesión: ' . $e->getMessage()]);
        }
    }

    /**
     * Validar que la duración del turno sea mínimo 8 horas.
     */
    private function validateMinimumDuration($startTime, $endTime)
    {
        // Crear objetos Carbon para calcular la diferencia
        $start = Carbon::createFromFormat('H:i', $startTime);
        $end = Carbon::createFromFormat('H:i', $endTime);
        
        // Si la hora de fin es menor que la de inicio, asumimos que es al día siguiente
        if ($end->lessThanOrEqualTo($start)) {
            $end->addDay();
        }
        
        // Calcular diferencia en horas
        $diffInHours = $start->diffInHours($end);
        
        if ($diffInHours < 8) {
            throw new \Illuminate\Validation\ValidationException(
                validator([], []),
                ['end_time' => ['El turno debe tener una duración mínima de 8 horas.']]
            );
        }
    }
}
