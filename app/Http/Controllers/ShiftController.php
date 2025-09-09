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
            'end_time' => 'nullable|date_format:H:i|after:start_time',
            'status' => 'required|in:pending,completed,canceled,rescheduled',
            'responsible' => 'nullable|string|max:150',
            'description' => 'nullable|string',
        ]);

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
        $data = $request->validate([
            'status' => 'required|in:pending,completed,canceled,rescheduled',
            'description' => 'nullable|string',
            'responsible' => 'nullable|string|max:150',
            'shift_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'nullable|date_format:H:i|after:start_time',
        ]);

        // Normalizar las horas para asegurar formato HH:MM:SS
        if (isset($data['start_time'])) {
            $data['start_time'] = $data['start_time'] . ':00';
        }
        if (isset($data['end_time'])) {
            $data['end_time'] = $data['end_time'] . ':00';
        }

        $shift->fill($data)->save();

        return back()->with('success', 'Turno actualizado correctamente.');
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
}
