<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\User;
use App\Models\Payment;
use App\Models\UserOrder;

class OrderController extends Controller
{
    /**
     * Mostrar listado de todas las órdenes.
     */
    public function index(Request $request)
    {
        $userId = 9; // Usuario actual (ajustar según tu lógica de auth)
        $search = $request->get('search');

        // Crear query builder para las órdenes
        $query = Order::query();

        // Aplicar filtro de búsqueda si existe
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('client_name', 'LIKE', "%{$search}%")
                    ->orWhere('cliente_rut', 'LIKE', "%{$search}%")
                    ->orWhere('client_phone', 'LIKE', "%{$search}%")
                    ->orWhere('cliente_email', 'LIKE', "%{$search}%")
                    ->orWhere('client_address', 'LIKE', "%{$search}%")
                    ->orWhere('work_info', 'LIKE', "%{$search}%");
            });
        }

        // Ordenar órdenes: primero por estado (in_progress, done, canceled) y luego por más recientes
        $orders = $query->orderByRaw("
            CASE estado 
                WHEN 'in_progress' THEN 1 
                WHEN 'done' THEN 2 
                WHEN 'canceled' THEN 3 
                ELSE 4 
            END
        ")
            ->orderBy('created_at', 'desc') // Más recientes primero dentro de cada estado
            ->paginate(12); // 12 órdenes por página

        return view('pages.orders.index', compact('orders', 'search'));
    }


    /**
     * Mostrar formulario para crear nueva orden.
     */
    public function create()
    {
        return view('pages.orders.create');
    }

    /**
     * Guardar nueva orden en la base de datos.
     */
    public function store(Request $request)
    {
        // Validar los datos del formulario
        $request->validate([
            'client_name' => 'required|string|max:255',
            'cliente_rut' => 'nullable|string|max:20',
            'client_phone' => 'nullable|string|max:20',
            'cliente_email' => 'nullable|email|max:255',
            'client_address' => 'required|string|max:500',
            'client_info' => 'nullable|string',
            'work_info' => 'required|string',
            'estado' => 'required|in:in_progress,done,canceled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'hour_cost' => 'required|string',
            'extra_cost' => 'nullable|string',
            'info_extra_cost' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Crear la orden
            $order = Order::create([
                'client_name' => $request->client_name,
                'cliente_rut' => $request->cliente_rut,
                'client_phone' => $request->client_phone,
                'cliente_email' => $request->cliente_email,
                'client_address' => $request->client_address,
                'client_info' => $request->client_info,
                'work_info' => $request->work_info,
                'estado' => $request->estado,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            // Crear el pago asociado con valores automáticos
            Payment::create([
                'id_order' => $order->id_order,
                'hour_cost' => $this->parseCurrency($request->hour_cost),
                'extra_cost' => $this->parseCurrency($request->extra_cost ?? '0'),
                'info_extra_cost' => $request->info_extra_cost,
                'status' => 'pending', // Siempre pendiente al crear
                'emission_date' => $request->start_date, // Fecha de emisión = fecha fin del trabajo
                'payment_date' => null, // Se llena cuando se pague
                'description' => '', // Descripción vacía por defecto
            ]);

            // Asociar la orden con el usuario actual (tabla pivot user_orden)
            $userId = 9; // Usuario actual (ajustar según tu lógica de auth)
            $order->users()->attach($userId);

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Trabajo creado exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al crear el trabajo: ' . $e->getMessage()]);
        }
    }

    /**
     * Función auxiliar para parsear valores de moneda
     */
    private function parseCurrency($value)
    {
        // Remover puntos y convertir a número
        return (float) str_replace('.', '', $value);
    }

    /**
     * Mostrar detalles de una orden específica.
     */
    public function show($id)
    {
        $userId = 9; // Usuario actual

        // Obtener la orden con todas sus relaciones
        $order = Order::with(['shifts', 'payments', 'users'])
            ->whereHas('users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->findOrFail($id);

        // Obtener turnos del mes actual
        $mesActual = Carbon::now('America/Santiago');
        $turnosMesActual = $order->shifts()
            ->whereYear('shift_date', $mesActual->year)
            ->whereMonth('shift_date', $mesActual->month)
            ->orderBy('shift_date')
            ->orderBy('start_time')
            ->get();

        // Obtener todos los pagos de esta orden
        $pagosOrden = $order->payments()
            ->orderBy('emission_date', 'desc')
            ->get();

        // Calcular estadísticas de la orden
        $estadisticas = [
            'total_turnos' => $order->shifts->count(),
            'turnos_completados' => $order->shifts->where('status', 'completed')->count(),
            'turnos_pendientes' => $order->shifts->where('status', 'pending')->count(),
            'turnos_cancelados' => $order->shifts->where('status', 'canceled')->count(),
            'total_facturado' => $pagosOrden->sum(function ($payment) {
                return $payment->total_amount;
            }),
            'total_pagado' => $pagosOrden->where('status', 'paid')->sum(function ($payment) {
                return $payment->total_amount;
            }),
            'pagos_pendientes' => $pagosOrden->whereIn('status', ['pending', 'overdue'])->count(),
        ];

        // Calcular duración estimada del proyecto
        $fechaInicio = $order->start_date;
        $fechaFin = $order->end_date;
        $duracionDias = $fechaInicio && $fechaFin ?
            Carbon::parse($fechaInicio)->diffInDays(Carbon::parse($fechaFin)) : null;

        // Obtener próximos turnos (siguientes 5)
        $proximosTurnos = $order->shifts()
            ->where('shift_date', '>=', Carbon::now('America/Santiago')->toDateString())
            ->where('status', 'pending')
            ->orderBy('shift_date')
            ->orderBy('start_time')
            ->limit(5)
            ->get();

        return view('pages.orders.show', compact(
            'order',
            'turnosMesActual',
            'pagosOrden',
            'estadisticas',
            'duracionDias',
            'proximosTurnos'
        ));
    }

    /**
     * Actualizar información de una orden específica.
     */
    public function update(Request $request, $id)
    {
        $userId = 9; // Usuario actual

        // Verificar que la orden pertenezca al usuario actual
        $order = Order::whereHas('users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->findOrFail($id);

        // Validar los datos del formulario
        $request->validate([
            'client_name' => 'required|string|max:100',
            'cliente_rut' => 'nullable|string|max:12',
            'client_phone' => 'nullable|string|max:15',
            'client_address' => 'nullable|string|max:255',
            'work_info' => 'required|string|max:500',
            'estado' => 'required|in:in_progress,done,canceled',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'hour_cost' => 'nullable|string',
            'extra_cost' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            // Actualizar la orden
            $order->update([
                'client_name' => $request->client_name,
                'cliente_rut' => $request->cliente_rut,
                'client_phone' => $request->client_phone,
                'client_address' => $request->client_address,
                'work_info' => $request->work_info,
                'estado' => $request->estado,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            // Actualizar costos en el pago asociado si existen
            if ($request->hour_cost || $request->extra_cost) {
                $payment = $order->payments()->first();
                if ($payment) {
                    $payment->update([
                        'hour_cost' => $request->hour_cost ? $this->parseCurrency($request->hour_cost) : $payment->hour_cost,
                        'extra_cost' => $request->extra_cost ? $this->parseCurrency($request->extra_cost) : $payment->extra_cost,
                    ]);
                }
            }

            DB::commit();

            return redirect()->route('orders.show', $order->id_order)->with('success', 'Información del cliente actualizada exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withInput()->withErrors(['error' => 'Error al actualizar la información: ' . $e->getMessage()]);
        }
    }

    /**
     * Eliminar completamente una orden y todos sus datos relacionados.
     */
    public function completeDelete($id)
    {
        $userId = 9; // Usuario actual

        // Verificar que la orden pertenezca al usuario actual
        $order = Order::whereHas('users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->findOrFail($id);

        try {
            DB::beginTransaction();

            // 1. Eliminar todos los turnos/sesiones de trabajo
            $order->shifts()->delete();

            // 2. Eliminar todos los pagos
            $order->payments()->delete();

            // 3. Eliminar relaciones usuario-orden (tabla pivot)
            $order->users()->detach();

            // 4. Finalmente eliminar la orden
            $order->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Cliente y toda su información eliminados exitosamente');
        } catch (\Exception $e) {
            DB::rollback();
            return redirect()->back()->withErrors(['error' => 'Error al eliminar la información: ' . $e->getMessage()]);
        }
    }
}
