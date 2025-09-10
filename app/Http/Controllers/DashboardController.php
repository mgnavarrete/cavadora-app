<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Shift;

class DashboardController extends Controller
{
    /**
     * Mostrar el dashboard financiero con métricas de pagos.
     */
    public function index()
    {
        $userId = 9; // Usuario actual (ajustar según tu lógica de auth)
        
        // Zona horaria CL
        $now = Carbon::now('America/Santiago');
        
        // Meses clave
        $mesActual = $now->copy();
        $mesAnterior = $now->copy()->subMonth();
        $mesAnteAnterior = $now->copy()->subMonths(2);
        
        // Calcular métricas principales
        $metricas = $this->calcularMetricas($userId, $mesActual, $mesAnterior, $mesAnteAnterior);
        
        // Datos para gráficos
        $ingresosPorMes = $this->obtenerIngresosPorMes($userId, $now->year);
        $comparacionMensual = $this->obtenerComparacionMensual($userId, $mesActual, $mesAnterior, $mesAnteAnterior);
        $estadosPagos = $this->obtenerEstadosPagos($userId);
        $topClientes = $this->obtenerTopClientes($userId, $now->year);
        $tendenciaAnual = $this->obtenerTendenciaAnual($userId, $now->year);
        $ingresosPorTipo = $this->obtenerIngresosPorTipo($userId, $now->year);
        
        return view('pages.dashboard.index', compact(
            'metricas',
            'ingresosPorMes',
            'comparacionMensual',
            'estadosPagos',
            'topClientes',
            'tendenciaAnual',
            'ingresosPorTipo'
        ));
    }
    
    /**
     * Calcular métricas principales del dashboard.
     */
    private function calcularMetricas($userId, $mesActual, $mesAnterior, $mesAnteAnterior)
    {
        // Ingresos del mes actual
        $ingresosMesActual = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->whereYear('payment_date', $mesActual->year)
        ->whereMonth('payment_date', $mesActual->month)
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        // Ingresos del mes anterior
        $ingresosMesAnterior = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->whereYear('payment_date', $mesAnterior->year)
        ->whereMonth('payment_date', $mesAnterior->month)
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        // Ingresos anuales
        $ingresosAnuales = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->whereYear('payment_date', $mesActual->year)
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        // Pagos pendientes
        $pagosPendientes = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'pending')
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        // Pagos atrasados
        $pagosAtrasados = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'overdue')
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        // Calcular variación porcentual
        $variacionPorcentual = 0;
        if ($ingresosMesAnterior > 0) {
            $variacionPorcentual = (($ingresosMesActual - $ingresosMesAnterior) / $ingresosMesAnterior) * 100;
        }
        
        // Clientes activos (órdenes con turnos en el mes actual)
        $clientesActivos = Order::whereHas('users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->whereHas('shifts', function ($q) use ($mesActual) {
            $q->whereYear('shift_date', $mesActual->year)
              ->whereMonth('shift_date', $mesActual->month);
        })
        ->distinct()
        ->count('id_order');
        
        return [
            'mes_actual_nombre' => $mesActual->locale('es')->monthName,
            'ingresos_mes_actual' => $ingresosMesActual,
            'ingresos_mes_anterior' => $ingresosMesAnterior,
            'ingresos_anuales' => $ingresosAnuales,
            'pagos_pendientes' => $pagosPendientes,
            'pagos_atrasados' => $pagosAtrasados,
            'variacion_porcentual' => round($variacionPorcentual, 1),
            'clientes_activos' => $clientesActivos,
        ];
    }
    
    /**
     * Obtener ingresos por mes para el gráfico anual.
     */
    private function obtenerIngresosPorMes($userId, $year)
    {
        $ingresos = [];
        $meses = [
            1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
            5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
            9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
        ];
        
        for ($mes = 1; $mes <= 12; $mes++) {
            $total = Payment::whereHas('order.users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->where('status', 'paid')
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $mes)
            ->get()
            ->sum(function ($payment) {
                return $payment->total_amount;
            });
            
            $ingresos[] = [
                'mes' => $meses[$mes],
                'total' => $total
            ];
        }
        
        return $ingresos;
    }
    
    /**
     * Obtener comparación de últimos 3 meses.
     */
    private function obtenerComparacionMensual($userId, $mesActual, $mesAnterior, $mesAnteAnterior)
    {
        $meses = [];
        
        // Mes ante-anterior
        $total = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->whereYear('payment_date', $mesAnteAnterior->year)
        ->whereMonth('payment_date', $mesAnteAnterior->month)
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        $meses[] = [
            'mes' => $mesAnteAnterior->locale('es')->monthName,
            'ingresos' => $total
        ];
        
        // Mes anterior
        $total = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->whereYear('payment_date', $mesAnterior->year)
        ->whereMonth('payment_date', $mesAnterior->month)
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        $meses[] = [
            'mes' => $mesAnterior->locale('es')->monthName,
            'ingresos' => $total
        ];
        
        // Mes actual
        $total = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->whereYear('payment_date', $mesActual->year)
        ->whereMonth('payment_date', $mesActual->month)
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        $meses[] = [
            'mes' => $mesActual->locale('es')->monthName,
            'ingresos' => $total
        ];
        
        return $meses;
    }
    
    /**
     * Obtener distribución de estados de pagos.
     */
    private function obtenerEstadosPagos($userId)
    {
        $estados = [];
        
        // Pagados
        $total = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        $cantidad = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->count();
        
        $estados[] = [
            'estado' => 'Pagado',
            'total' => $total,
            'cantidad' => $cantidad
        ];
        
        // Pendientes
        $total = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'pending')
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        $cantidad = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'pending')
        ->count();
        
        $estados[] = [
            'estado' => 'Pendiente',
            'total' => $total,
            'cantidad' => $cantidad
        ];
        
        // Atrasados
        $total = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'overdue')
        ->get()
        ->sum(function ($payment) {
            return $payment->total_amount;
        });
        
        $cantidad = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'overdue')
        ->count();
        
        $estados[] = [
            'estado' => 'Atrasado',
            'total' => $total,
            'cantidad' => $cantidad
        ];
        
        return $estados;
    }
    
    /**
     * Obtener top 5 clientes por ingresos.
     */
    private function obtenerTopClientes($userId, $year)
    {
        $clientes = Order::whereHas('users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->with(['payments' => function ($query) {
            $query->where('status', 'paid');
        }])
        ->get()
        ->map(function ($order) {
            $total = $order->payments->sum(function ($payment) {
                return $payment->total_amount;
            });
            
            return [
                'nombre' => $order->client_name,
                'total' => $total
            ];
        })
        ->sortByDesc('total')
        ->take(5)
        ->values()
        ->toArray();
        
        return $clientes;
    }
    
    /**
     * Obtener tendencia anual comparando con año anterior.
     */
    private function obtenerTendenciaAnual($userId, $year)
    {
        $tendencia = [];
        $meses = [
            1 => 'Ene', 2 => 'Feb', 3 => 'Mar', 4 => 'Abr',
            5 => 'May', 6 => 'Jun', 7 => 'Jul', 8 => 'Ago',
            9 => 'Sep', 10 => 'Oct', 11 => 'Nov', 12 => 'Dic'
        ];
        
        for ($mes = 1; $mes <= 12; $mes++) {
            // Año actual
            $añoActual = Payment::whereHas('order.users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->where('status', 'paid')
            ->whereYear('payment_date', $year)
            ->whereMonth('payment_date', $mes)
            ->get()
            ->sum(function ($payment) {
                return $payment->total_amount;
            });
            
            // Año anterior
            $añoAnterior = Payment::whereHas('order.users', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            })
            ->where('status', 'paid')
            ->whereYear('payment_date', $year - 1)
            ->whereMonth('payment_date', $mes)
            ->get()
            ->sum(function ($payment) {
                return $payment->total_amount;
            });
            
            $tendencia[] = [
                'mes' => $meses[$mes],
                'año_actual' => $añoActual,
                'año_anterior' => $añoAnterior
            ];
        }
        
        return $tendencia;
    }
    
    /**
     * Obtener ingresos por tipo (mano de obra vs extras).
     */
    private function obtenerIngresosPorTipo($userId, $year)
    {
        $tipos = [];
        
        // Mano de obra (hour_cost * horas trabajadas)
        $manoObra = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->whereYear('payment_date', $year)
        ->get()
        ->sum(function ($payment) {
            return ($payment->hour_cost ?? 0) * $payment->total_hours;
        });
        
        $tipos[] = [
            'tipo' => 'Mano de Obra',
            'valor' => $manoObra
        ];
        
        // Gastos extras
        $extras = Payment::whereHas('order.users', function ($q) use ($userId) {
            $q->where('users.id', $userId);
        })
        ->where('status', 'paid')
        ->whereYear('payment_date', $year)
        ->get()
        ->sum(function ($payment) {
            return $payment->extra_cost ?? 0;
        });
        
        $tipos[] = [
            'tipo' => 'Gastos Extras',
            'valor' => $extras
        ];
        
        return $tipos;
    }
}
