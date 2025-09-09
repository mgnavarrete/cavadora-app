<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use App\Models\Order;
use App\Models\Payment;
use App\Models\Shift;

class IndexController extends Controller
{
    public function index()
    {
        $this->actualizarPagos();

        $userId = 3;

        // Zona horaria CL
        $now = Carbon::now('America/Santiago');

        // Meses clave
        $mesActual     = $now->copy();
        $mesAnterior   = $now->copy()->subMonth();
        $mesAnteAnterior = $now->copy()->subMonths(2);

        // Helper para sumas de pagos (usa payment_date para "pagado")
        $sumPagosMes = function (int $year, int $month) use ($userId) {
            return Payment::whereHas('order.users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
                ->where('status', 'paid')
                ->whereYear('payment_date', $year)
                ->whereMonth('payment_date', $month)
                ->sum(DB::raw('(labor_cost + machine_cost + fuel_expenses + extra_cost)'));
        };

        // Totales pagados
        $totalGanadoMesPasado       = $sumPagosMes((int)$mesAnterior->year, (int)$mesAnterior->month);
        $totalGanadoMesActual       = $sumPagosMes((int)$mesActual->year, (int)$mesActual->month);
        $totalGanadoMesAnteAnterior = $sumPagosMes((int)$mesAnteAnterior->year, (int)$mesAnteAnterior->month);

        // Diferencia entre el mes anterior y el ante-anterior
        $diferenciaIngresos = $totalGanadoMesPasado - $totalGanadoMesAnteAnterior;

        // Total de órdenes visibles para el usuario (pivot user_orden)
        $totalOrdenes = Order::whereHas('users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })->count();

        // Pagos del mes actual (todos) + pagos pendientes/atrasados de otros meses
        $pagosPendientes = Payment::with('order')
            ->whereHas('order.users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->where(function ($query) use ($mesActual) {
                // Todos los pagos del mes actual (sin importar estado)
                $query->where(function ($q) use ($mesActual) {
                    $q->whereYear('emission_date', $mesActual->year)
                        ->whereMonth('emission_date', $mesActual->month);
                })
                    // O pagos pendientes/atrasados de otros meses
                    ->orWhere(function ($q) use ($mesActual) {
                        $q->whereIn('status', ['pending', 'overdue'])
                            ->where(function ($subQuery) use ($mesActual) {
                                $subQuery->whereYear('emission_date', '!=', $mesActual->year)
                                    ->orWhere(function ($monthQuery) use ($mesActual) {
                                        $monthQuery->whereYear('emission_date', $mesActual->year)
                                            ->whereMonth('emission_date', '!=', $mesActual->month);
                                    });
                            });
                    });
            })
            ->orderBy('emission_date', 'desc')
            ->get();

        // Semana actual (lunes-domingo según config Carbon)
        $inicioSemana = Carbon::now('America/Santiago')->startOfWeek();
        $finSemana    = Carbon::now('America/Santiago')->endOfWeek();

        // Próximos turnos de la semana (de las órdenes del usuario)
        $proximosTurnos = Shift::with('order')
            ->whereHas('order.users', fn($q) => $q->where('users.id', $userId))
            ->whereBetween('shift_date', [$inicioSemana->toDateString(), $finSemana->toDateString()])
            ->orderBy('shift_date')->orderBy('start_time')
            ->get();

        // Turnos pendientes desde hoy hasta fin de semana
        $sesionesPendientes = Shift::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
            ->where('status', 'pending')
            ->where('shift_date', '>', Carbon::now('America/Santiago')->toDateString())
            ->where('shift_date', '<=', $finSemana->toDateString())
            ->count();

        // Turnos completados del mes actual
        $turnosCompletadosMesActual = Shift::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
            ->where('status', 'completed')
            ->whereYear('shift_date', $mesActual->year)
            ->whereMonth('shift_date', $mesActual->month)
            ->count();

        // Facturación "emitida" en el mes actual (por fecha de emisión)
        $totalEmitidoMesActual = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
            ->whereYear('emission_date', $mesActual->year)
            ->whereMonth('emission_date', $mesActual->month)
            ->sum(DB::raw('(labor_cost + machine_cost + fuel_expenses + extra_cost)'));

        // Ya calculado: total pagado en el mes actual ($totalGanadoMesActual)

        // Pasar a la vista (ajusta tu blade para estos nombres)
        return view('pages.index', compact(
            'totalOrdenes',
            'totalGanadoMesPasado',
            'totalGanadoMesActual',
            'totalGanadoMesAnteAnterior',
            'diferenciaIngresos',
            'pagosPendientes',
            'proximosTurnos',
            'sesionesPendientes',
            'turnosCompletadosMesActual',
            'totalEmitidoMesActual'
        ));
    }

    /**
     * Mostrar el calendario con órdenes y turnos.
     */
    public function calendar()
    {
        $userId = 3; // Ajustar según tu lógica de autenticación
        
        // Obtener todas las órdenes del usuario con sus fechas
        $orders = Order::with('users')
            ->whereHas('users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->whereNotNull('start_date')
            ->get();
        
        // Obtener todos los turnos de las órdenes del usuario
        $shifts = Shift::with(['order'])
            ->whereHas('order.users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->whereNotNull('shift_date')
            ->orderBy('shift_date', 'asc')
            ->get();
        
        return view('pages.calendar.index', compact('orders', 'shifts'));
    }

    /**
     * Marca como "overdue" los pagos que llevan demasiado tiempo "pending".
     * Criterio: emission_date <= fin de mes de hace 2 meses.
     */
    public function actualizarPagos()
    {
        $limite = Carbon::now('America/Santiago')->subMonths(2)->endOfMonth()->toDateString();

        Payment::where('status', 'pending')
            ->whereDate('emission_date', '<=', $limite)
            ->update(['status' => 'overdue']);
    }
}
