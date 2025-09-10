@extends('layouts.master')

@section('title', 'Dashboard Financiero')

@section('content')

    <div class="container-fluid">

        <!-- Page Header -->
        <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
            <div>
                <h1 class="page-title fw-semibold fs-18 mb-0">
                    <i class="ri-dashboard-3-line me-2"></i>Dashboard Financiero
                </h1>
                <p class="text-muted mb-0">Análisis y métricas de ingresos</p>
                @if(!$tieneDatosReales)
                    <div class="alert alert-info alert-dismissible fade show mt-2" role="alert">
                        <i class="ri-information-line me-2"></i>
                        <strong>Datos de ejemplo:</strong> Se están mostrando datos de demostración. Una vez que tengas pagos reales, se mostrarán tus datos reales.
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            {{-- <div class="btn-list">
                <button class="btn btn-primary" onclick="window.print()">
                    <i class="ri-printer-line me-1"></i>Imprimir Reporte
                </button>
                <button class="btn btn-success" onclick="exportarDatos()">
                    <i class="ri-download-line me-1"></i>Exportar Datos
                </button>
            </div> --}}
        </div>

        <!-- Métricas Principales -->
        <div class="row">
            <!-- Ingresos Mes Actual -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="d-block mb-1 text-muted fs-12">Ingresos {{ $metricas['mes_actual_nombre'] }}</span>
                                <h4 class="fw-semibold mb-1">${{ number_format($metricas['ingresos_mes_actual'], 0, ',', '.') }}</h4>
                                <div class="d-flex align-items-center">
                                    @if($metricas['variacion_porcentual'] >= 0)
                                        <span class="badge bg-success-transparent fs-11">
                                            <i class="ri-arrow-up-line me-1"></i>{{ $metricas['variacion_porcentual'] }}%
                                        </span>
                                    @else
                                        <span class="badge bg-danger-transparent fs-11">
                                            <i class="ri-arrow-down-line me-1"></i>{{ abs($metricas['variacion_porcentual']) }}%
                                        </span>
                                    @endif
                                    <span class="text-muted fs-11 ms-1">vs mes anterior</span>
                                </div>
                            </div>
                            <div class="avatar avatar-md bg-primary-transparent">
                                <i class="ri-money-dollar-circle-line fs-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Ingresos Anuales -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="d-block mb-1 text-muted fs-12">Ingresos {{ Carbon\Carbon::now()->year }}</span>
                                <h4 class="fw-semibold mb-1">${{ number_format($metricas['ingresos_anuales'], 0, ',', '.') }}</h4>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-info-transparent fs-11">
                                        <i class="ri-calendar-line me-1"></i>Año en curso
                                    </span>
                                </div>
                            </div>
                            <div class="avatar avatar-md bg-success-transparent">
                                <i class="ri-line-chart-line fs-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagos Pendientes -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="d-block mb-1 text-muted fs-12">Pagos Pendientes</span>
                                <h4 class="fw-semibold mb-1">${{ number_format($metricas['pagos_pendientes'], 0, ',', '.') }}</h4>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-warning-transparent fs-11">
                                        <i class="ri-time-line me-1"></i>Por cobrar
                                    </span>
                                </div>
                            </div>
                            <div class="avatar avatar-md bg-warning-transparent">
                                <i class="ti ti-coin-off fs-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pagos Atrasados -->
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12">
                <div class="card custom-card">
                    <div class="card-body">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <span class="d-block mb-1 text-muted fs-12">Pagos Atrasados</span>
                                <h4 class="fw-semibold mb-1">${{ number_format($metricas['pagos_atrasados'], 0, ',', '.') }}</h4>
                                <div class="d-flex align-items-center">
                                    <span class="badge bg-danger-transparent fs-11">
                                        <i class="ri-alert-line me-1"></i>Vencidos
                                    </span>
                                </div>
                            </div>
                            <div class="avatar avatar-md bg-danger-transparent">
                                <i class="ri-error-warning-line fs-18"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráficos Principales -->
        <div class="row">
            <!-- Gráfico de Ingresos Mensuales -->
            <div class="col-xl-12 col-lg-12">
                <div class="card custom-card">
                    <div class="card-header justify-content-between">
                        <div class="card-title">
                            <i class="ri-bar-chart-line me-2"></i>Ingresos por Mes - {{ Carbon\Carbon::now()->year }}
                        </div>
                        <div class="dropdown">
                            <a href="javascript:void(0);" class="btn btn-outline-light btn-icons btn-sm text-muted" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-more-2-fill"></i>
                            </a>
                            <ul class="dropdown-menu" role="menu">
                                <li><a class="dropdown-item" href="javascript:void(0);">Descargar PNG</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Descargar PDF</a></li>
                                <li><a class="dropdown-item" href="javascript:void(0);">Ver Datos</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="ingresosMensualesChart" height="300"></canvas>
                    </div>
                </div>
            </div>

            {{-- <!-- Distribución de Estados de Pagos -->
            <div class="col-xl-4 col-lg-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-pie-chart-line me-2"></i>Estados de Pagos
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="estadosPagosChart" height="300"></canvas>
                        <div class="mt-3">
                            @foreach($estadosPagos as $estado)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <div class="d-flex align-items-center">
                                    <span class="avatar avatar-xs me-2 
                                        @if($estado['estado'] == 'Pagado') bg-success 
                                        @elseif($estado['estado'] == 'Pendiente') bg-warning 
                                        @else bg-danger @endif"></span>
                                    <span class="fs-12">{{ $estado['estado'] }}</span>
                                </div>
                                <div class="text-end">
                                    <span class="fw-semibold">${{ number_format($estado['total'], 0, ',', '.') }}</span>
                                    <small class="text-muted d-block">{{ $estado['cantidad'] }} pagos</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div> --}}
        </div>

        <!-- Segunda Fila de Gráficos -->
        <div class="row">
            <!-- Comparación Mensual -->
            <div class="col-xl-6 col-lg-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-line-chart-line me-2"></i>Comparación Últimos 3 Meses
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="comparacionMensualChart" height="250"></canvas>
                    </div>
                </div>
            </div>

            <!-- Top 5 Pacientes -->
            <div class="col-xl-6 col-lg-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-user-star-line me-2"></i>Top 5 Pacientes por Ingresos
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="topPacientesChart" height="250"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tercera Fila de Gráficos -->
        <div class="row">
            <!-- Tendencia Anual -->
            <div class="col-xl-12 col-lg-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-line-chart-line me-2"></i>Tendencia Anual ({{ Carbon\Carbon::now()->year }} vs {{ Carbon\Carbon::now()->year - 1 }})
                        </div>
                    </div>
                    <div class="card-body">
                        <canvas id="tendenciaAnualChart" height="300"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen Estadístico -->
        <div class="row">
            <div class="col-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <div class="card-title">
                            <i class="ri-bar-chart-box-line me-2"></i>Resumen Estadístico
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="fw-semibold text-primary">${{ number_format($metricas['ingresos_mes_actual'], 0, ',', '.') }}</h4>
                                    <p class="text-muted mb-0">Ingresos del Mes</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="fw-semibold text-success">${{ number_format(collect($ingresosPorMes)->avg('total'), 0, ',', '.') }}</h4>
                                    <p class="text-muted mb-0">Promedio Mensual</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="border-end">
                                    <h4 class="fw-semibold text-warning">{{ $metricas['clientes_activos'] }}</h4>
                                    <p class="text-muted mb-0">Pacientes Activos</p>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <h4 class="fw-semibold text-info">${{ number_format(collect($ingresosPorMes)->max('total'), 0, ',', '.') }}</h4>
                                <p class="text-muted mb-0">Mejor Mes del Año</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

<!-- Scripts para los gráficos -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Configuración global de Chart.js
    Chart.defaults.font.family = 'Inter, sans-serif';
    Chart.defaults.color = '#8c9097';
    
    // Datos desde PHP
    const ingresosPorMes = @json($ingresosPorMes);
    const comparacionMensual = @json($comparacionMensual);
    const estadosPagos = @json($estadosPagos);
    const topPacientes = @json($topClientes);
    const tendenciaAnual = @json($tendenciaAnual);
    const ingresosPorTipo = @json($ingresosPorTipo);
    
    // Debug: Mostrar datos en consola
    console.log('Datos del Dashboard:');
    console.log('Ingresos por Mes:', ingresosPorMes);
    console.log('Comparación Mensual:', comparacionMensual);
    console.log('Estados Pagos:', estadosPagos);
    console.log('Top Pacientes:', topPacientes);
    console.log('Tendencia Anual:', tendenciaAnual);
    console.log('Ingresos por Tipo:', ingresosPorTipo);

    // Gráfico de Ingresos Mensuales
    const ctxIngresos = document.getElementById('ingresosMensualesChart').getContext('2d');
    new Chart(ctxIngresos, {
        type: 'bar',
        data: {
            labels: ingresosPorMes.map(item => item.mes),
            datasets: [{
                label: 'Ingresos ($)',
                data: ingresosPorMes.map(item => item.total),
                backgroundColor: 'rgba(79, 70, 229, 0.8)',
                borderColor: 'rgb(79, 70, 229)',
                borderWidth: 1,
                borderRadius: 4,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    callbacks: {
                        label: function(context) {
                            return 'Ingresos: $' + new Intl.NumberFormat().format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + new Intl.NumberFormat().format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(140, 144, 151, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Gráfico de Comparación Mensual
    const ctxComparacion = document.getElementById('comparacionMensualChart').getContext('2d');
    
    // Verificar si hay datos para mostrar
    if (comparacionMensual && comparacionMensual.length > 0) {
        new Chart(ctxComparacion, {
        type: 'line',
        data: {
            labels: comparacionMensual.map(item => item.mes),
            datasets: [{
                label: 'Ingresos ($)',
                data: comparacionMensual.map(item => item.ingresos),
                borderColor: 'rgb(79, 70, 229)',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: 'rgb(79, 70, 229)',
                pointBorderColor: 'white',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    callbacks: {
                        label: function(context) {
                            return 'Ingresos: $' + new Intl.NumberFormat().format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + new Intl.NumberFormat().format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(140, 144, 151, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    } else {
        // Mostrar mensaje si no hay datos
        ctxComparacion.canvas.parentNode.innerHTML = '<div class="text-center text-muted p-4"><i class="ri-bar-chart-line fs-24 mb-2"></i><p>No hay datos disponibles para mostrar</p></div>';
    }

    // Gráfico Top Pacientes
    const ctxTopPacientes = document.getElementById('topPacientesChart').getContext('2d');
    
    if (topPacientes && topPacientes.length > 0) {
        new Chart(ctxTopPacientes, {
        type: 'bar',
        data: {
            labels: topPacientes.map(item => item.nombre),
            datasets: [{
                label: 'Ingresos Totales ($)',
                data: topPacientes.map(item => item.total),
                backgroundColor: [
                    'rgba(34, 197, 94, 0.8)',
                    'rgba(79, 70, 229, 0.8)',
                    'rgba(251, 191, 36, 0.8)',
                    'rgba(14, 165, 233, 0.8)',
                    'rgba(168, 85, 247, 0.8)'
                ],
                borderColor: [
                    'rgb(34, 197, 94)',
                    'rgb(79, 70, 229)',
                    'rgb(251, 191, 36)',
                    'rgb(14, 165, 233)',
                    'rgb(168, 85, 247)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            indexAxis: 'y',
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    callbacks: {
                        label: function(context) {
                            return 'Total: $' + new Intl.NumberFormat().format(context.parsed.x);
                        }
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + new Intl.NumberFormat().format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(140, 144, 151, 0.1)'
                    }
                },
                y: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    } else {
        // Mostrar mensaje si no hay datos
        ctxTopPacientes.canvas.parentNode.innerHTML = '<div class="text-center text-muted p-4"><i class="ri-user-star-line fs-24 mb-2"></i><p>No hay datos disponibles para mostrar</p></div>';
    }

    // Gráfico Tendencia Anual
    const ctxTendencia = document.getElementById('tendenciaAnualChart').getContext('2d');
    
    if (tendenciaAnual && tendenciaAnual.length > 0) {
        new Chart(ctxTendencia, {
        type: 'line',
        data: {
            labels: tendenciaAnual.map(item => item.mes),
            datasets: [{
                label: '{{ Carbon\Carbon::now()->year }}',
                data: tendenciaAnual.map(item => item.año_actual),
                borderColor: 'rgb(79, 70, 229)',
                backgroundColor: 'rgba(79, 70, 229, 0.1)',
                borderWidth: 3,
                fill: false,
                tension: 0.4
            }, {
                label: '{{ Carbon\Carbon::now()->year - 1 }}',
                data: tendenciaAnual.map(item => item.año_anterior),
                borderColor: 'rgb(107, 114, 128)',
                backgroundColor: 'rgba(107, 114, 128, 0.1)',
                borderWidth: 3,
                fill: false,
                tension: 0.4,
                borderDash: [5, 5]
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                },
                tooltip: {
                    backgroundColor: 'rgba(0, 0, 0, 0.8)',
                    titleColor: 'white',
                    bodyColor: 'white',
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ': $' + new Intl.NumberFormat().format(context.parsed.y);
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return '$' + new Intl.NumberFormat().format(value);
                        }
                    },
                    grid: {
                        color: 'rgba(140, 144, 151, 0.1)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });
    } else {
        // Mostrar mensaje si no hay datos
        ctxTendencia.canvas.parentNode.innerHTML = '<div class="text-center text-muted p-4"><i class="ri-line-chart-line fs-24 mb-2"></i><p>No hay datos disponibles para mostrar</p></div>';
    }
});

// Función para exportar datos
function exportarDatos() {
    // Implementar exportación a Excel/CSV
    alert('Funcionalidad de exportación en desarrollo');
}
</script>

<style>
.card {
    border: 1px solid rgba(140, 144, 151, 0.1);
    box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
}

.avatar {
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.avatar-xs {
    width: 1.5rem;
    height: 1.5rem;
}

.avatar-md {
    width: 3rem;
    height: 3rem;
}

@media print {
    .btn-list {
        display: none !important;
    }
    
    .card {
        break-inside: avoid;
        page-break-inside: avoid;
    }
}
</style>

@endsection
