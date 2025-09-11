@extends('layouts.master')

@section('styles')
<!-- DATE & TIME PICKER JS -->
<script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="path/to/flatpickr/l10n/es.js"></script>
<link rel="stylesheet" href="{{asset('build/assets/libs/glightbox/css/glightbox.min.css')}}">       
@vite('resources/assets/js/date&time_pickers.js')
<!-- INTERNAL PROFILE JS -->
@vite('resources/assets/js/profile.js')

<style>
    .payment-card {
        transition: all 0.3s ease;
        border: none;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        border-radius: 12px;
        overflow: hidden;
    }
    .payment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 16px rgba(0,0,0,0.15);
    }
    .status-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .status-pending { 
        background-color: rgb(var(--secondary-rgb)); 
        color: white; 
    }
    .status-overdue { 
        background-color: rgb(var(--warning-rgb)); 
        color: #212529; 
    }
    .status-paid { 
        background-color: rgb(var(--success-rgb)); 
        color: white; 
    }
    .status-void { 
        background-color: rgb(var(--danger-rgb)); 
        color: white; 
    }
    
    .payment-amount {
        font-size: 18px;
        font-weight: 700;
        color: #2c3e50;
    }
    .client-name {
        font-size: 16px;
        font-weight: 600;
        color: #34495e;
        margin-bottom: 8px;
    }
    .payment-date {
        font-size: 13px;
        color: #7f8c8d;
        margin-bottom: 12px;
    }
    
    .action-btn {
        background: rgba(108, 117, 125, 0.1);
        border: none;
        border-radius: 8px;
        padding: 8px;
        transition: all 0.2s ease;
    }
    .action-btn:hover {
        background: rgba(108, 117, 125, 0.2);
        transform: scale(1.05);
    }
    
    /* Estados de hover mejorados */
    .payment-card:hover .client-name {
        color: #2c3e50;
    }
    
    .payment-card:hover .payment-amount {
        color: #1a252f;
    }
    
    /* Responsive improvements */
    @media (max-width: 768px) {
        .payment-card .card-body {
            padding: 1.5rem;
        }
    }
</style>
@endsection

@section('content')
@php
    \Carbon\Carbon::setLocale('es');

@endphp
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        
        <h1 class="page-title fw-semibold fs-18 mb-0">Detalle de Trabajo <span class="text-muted fs-14">#{{ $order->id_order }}</span> </h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Trabajos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalle</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->
    @php
        $coverImageNumber = rand(1, 6);
        $estadoColor = match(strtolower($order->estado)) {
            'confirmed' => 'bg-warning',
            'not_confirmed' => 'bg-primary',
            'done' => 'bg-success',
            'in_progress' => 'bg-secondary',
            'canceled' => 'bg-danger',
            default => 'bg-secondary'
        };
        $estadoTexto = match(strtolower($order->estado)) {
            'done' => 'Completado',
            'confirmed' => 'Confirmado',
            'not_confirmed' => 'No Confirmado',
            'in_progress' => 'En Progreso',
            'canceled' => 'Cancelado',
            default => $order->estado ?? 'Sin Estado'
        };
    @endphp
  
    <!-- Start::row-1 -->
    <div class="row">
        <div class="col-md-5 d-flex">
            <div class="card custom-card overflow-hidden">
                <div class="card-body p-0">
                    <!-- Header con información del cliente -->
                    <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover position-relative">
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge {{ $estadoColor }} fs-12 px-3 py-2">{{ $estadoTexto }}</span>
                        </div>
                        <div class="flex-fill main-profile-info">
                            <div class="d-flex flex-wrap align-item-center justify-content-between mb-4">
                                <div>
                                    <h5 class="fw-bold mb-1 text-fixed-white">{{ $order->client_name }}</h5>
                                    <span class="text-muted fs-13">Orden #{{ $order->id_order }}</span>
                                </div>
                                <button class="btn btn-sm btn-icon btn-wave waves-effect waves-light fs-12 border-0 p-2" type="button" data-bs-toggle="modal" data-bs-target="#editOrder">
                                    <i class="ri-pencil-line text-white"></i>
                                </button>
                            </div>
                            
                            <!-- Información del cliente en cards más organizadas -->
                            <div class="row g-2 mb-3">
                                <div class="col-12">
                                    <div class="d-flex align-items-center text-fixed-white op-8">
                                        <i class="bx bx-id-card me-2 fs-16"></i>
                                        <span class="fs-13">{{ $order->cliente_rut ?? 'Sin RUT' }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center text-fixed-white op-8">
                                        <i class="ri-phone-line me-2 fs-16"></i>
                                        <span class="fs-13">{{ $order->client_phone ?? 'Sin teléfono' }}</span>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex align-items-center text-fixed-white op-8">
                                        <i class="ri-home-heart-line me-2 fs-16"></i>
                                        <span class="fs-13">{{ $order->client_address ?? 'Sin dirección' }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Fechas en una sola línea más compacta -->
                            <div class="d-flex flex-wrap gap-3 text-fixed-white op-8">
                                <div class="d-flex align-items-center">
                                    <i class="ri-calendar-line me-1 fs-14"></i>
                                    <span class="fs-13">{{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d-m-Y') : 'Sin fecha inicio' }}</span>
                                </div>
                                @if($order->end_date)
                                <div class="d-flex align-items-center">
                                    <i class="ri-calendar-check-line me-1 fs-14"></i>
                                    <span class="fs-13">{{ \Carbon\Carbon::parse($order->end_date)->format('d-m-Y') }}</span>
                                </div>
                                @endif
                                @if($duracionDias)
                                <div class="d-flex align-items-center">
                                    <i class="ri-time-line me-1 fs-14"></i>
                                    <span class="fs-13">{{ $duracionDias }} días</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Descripción del trabajo -->
                    <div class="p-4 border-bottom border-block-end-dashed">
                        <h6 class="fw-semibold mb-3 text-dark">
                            <i class="ri-file-text-line me-2 text-primary"></i>Descripción del Trabajo
                        </h6>
                        <div class="bg-light rounded p-3">
                            <p class="fs-13 text-muted mb-0 lh-base">
                                {{ $order->work_info ?? 'Sin descripción del trabajo especificada.' }}
                            </p>
                        </div>
                    </div>

                    <!-- Estadísticas del trabajo -->
                    <div class="p-4 border-bottom border-block-end-dashed">
                        <h6 class="fw-semibold mb-3 text-dark">
                            <i class="ri-bar-chart-line me-2 text-primary"></i>Estadísticas del Trabajo
                        </h6>
                        
                        <div class="row g-3">
                            <!-- Columna de turnos -->
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3 h-100">
                                    <h6 class="fs-12 fw-semibold text-muted mb-3 text-uppercase">Turnos</h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar avatar-xs avatar-rounded me-2 bg-primary text-white">
                                            <i class="ri-calendar-todo-fill align-middle fs-12"></i>
                                        </div>
                                        <span class="fs-13">Total: <strong class="text-dark">{{ $estadisticas['total_turnos'] }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar avatar-xs avatar-rounded me-2 bg-success text-white">
                                            <i class="ri-checkbox-circle-fill align-middle fs-12"></i>
                                        </div>
                                        <span class="fs-13">Completados: <strong class="text-success">{{ $estadisticas['turnos_completados'] }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs avatar-rounded me-2 bg-warning text-white">
                                            <i class="ri-time-fill align-middle fs-12"></i>
                                        </div>
                                        <span class="fs-13">Pendientes: <strong class="text-warning">{{ $estadisticas['turnos_pendientes'] }}</strong></span>
                                    </div>
                                </div>
                            </div>
                           
                            <!-- Columna de pagos -->
                            <div class="col-md-6">
                                <div class="bg-light rounded p-3 h-100">
                                    <h6 class="fs-12 fw-semibold text-muted mb-3 text-uppercase">Pagos</h6>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar avatar-xs avatar-rounded me-2 bg-info text-white">
                                            <i class="ri-money-dollar-circle-fill align-middle fs-12"></i>
                                        </div>
                                        <span class="fs-13">Facturado: <strong class="text-info">${{ number_format($estadisticas['total_facturado'], 0, ',', '.') }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center mb-2">
                                        <div class="avatar avatar-xs avatar-rounded me-2 bg-success text-white">
                                            <i class="ri-money-dollar-box-fill align-middle fs-12"></i>
                                        </div>
                                        <span class="fs-13">Pagado: <strong class="text-success">${{ number_format($estadisticas['total_pagado'], 0, ',', '.') }}</strong></span>
                                    </div>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar avatar-xs avatar-rounded me-2 bg-danger text-white">
                                            <i class="ri-error-warning-fill align-middle fs-12"></i>
                                        </div>
                                        <span class="fs-13">Pendientes: <strong class="text-danger">{{ $estadisticas['pagos_pendientes'] }}</strong></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Próximos turnos -->
                    <div class="p-4">
                        <h6 class="fw-semibold mb-3 text-dark">
                            <i class="ri-calendar-schedule-line me-2 text-primary"></i>Próximos Turnos
                        </h6>
                        
                        @if($proximosTurnos->isEmpty())
                            <div class="text-center py-4">
                                <div class="avatar avatar-lg avatar-rounded bg-light text-muted mb-3">
                                    <i class="ri-calendar-line align-middle fs-24"></i>
                                </div>
                                <p class="text-muted fs-13 mb-0">No hay turnos programados próximamente</p>
                            </div>
                        @else
                            <div class="space-y-3">
                                @foreach ($proximosTurnos as $turno)
                                    <div class="card border border-light rounded-3 p-3 mb-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div class="flex-grow-1">
                                                <!-- Fecha del turno -->
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar avatar-xs avatar-rounded me-2 bg-primary text-white">
                                                        <i class="ri-calendar-line align-middle fs-12"></i>
                                                    </div>
                                                    <strong class="fs-13 text-dark">{{ $turno->start_at ? $turno->start_at->translatedFormat('l, j \\d\\e F') : $turno->shift_date }}</strong>
                                                </div>
                                                
                                                <!-- Horario -->
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar avatar-xs avatar-rounded me-2 bg-info text-white">
                                                        <i class="ri-time-line align-middle fs-12"></i>
                                                    </div>
                                                    <span class="fs-13 text-muted">
                                                        {{ $turno->start_at ? $turno->start_at->format('H:i') : $turno->start_time }}
                                                        @if($turno->end_time) - {{ $turno->end_at ? $turno->end_at->format('H:i') : $turno->end_time }} @endif
                                                    </span>
                                                </div>
                                                
                                                <!-- Responsable -->
                                                @if($turno->responsible)
                                                <div class="d-flex align-items-center mb-2">
                                                    <div class="avatar avatar-xs avatar-rounded me-2 bg-success text-white">
                                                        <i class="ri-user-line align-middle fs-12"></i>
                                                    </div>
                                                    <span class="fs-13 text-muted">{{ $turno->responsible }}</span>
                                                </div>
                                                @endif
                                                
                                                <!-- Descripción -->
                                                @if($turno->description)
                                                <div class="mt-2">
                                                    <p class="fs-12 text-muted mb-0 lh-base">
                                                        {{ Str::limit($turno->description, 80) }}
                                                    </p>
                                                </div>
                                                @endif
                                            </div>
                                            
                                            <!-- Estado del turno -->
                                            @php
                                            $colorEstado = match(strtolower($turno->status)) {
                                                'pending'     => 'bg-secondary',
                                                'canceled'    => 'bg-danger',
                                                'completed'   => 'bg-success',
                                                'rescheduled' => 'bg-warning',
                                                default       => 'bg-light text-muted'
                                            };
                                            $estadoShift = match(strtolower($turno->status)) {
                                                'pending'     => 'Pendiente',
                                                'canceled'    => 'Cancelado',
                                                'completed'   => 'Completado',
                                                'rescheduled' => 'Reagendado',
                                                default       => $evento['status']
                                            };
                                            @endphp
                                            <span class="badge {{ $colorEstado }} fs-11 px-2 py-1">{{ ucfirst($estadoShift) }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-7 d-flex">
            <div class="card custom-card w-100" style="background-color: transparent; border: none; box-shadow: none;">
                <div class="card-body p-0">
                    <!-- Header con pestañas mejoradas -->
                    <div class="p-4 border-bottom border-block-end-dashed">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <h5 class="mb-0 fw-semibold text-dark">Gestión de Trabajo</h5>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm btn-wave waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ri-add-line me-1"></i>Agregar
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#createShiftModal">
                                        <i class="ri-calendar-todo-line me-2"></i>Agendar Sesión
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                        
                        <!-- Pestañas mejoradas -->
                        <ul class="nav nav-pills nav-pills-custom mb-0" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active d-flex align-items-center" id="turnosMes-tab" data-bs-toggle="tab"
                                    data-bs-target="#turnosMes-tab-pane" type="button" role="tab"
                                    aria-controls="turnosMes-tab-pane" aria-selected="true">
                                    <i class="ri-calendar-todo-line me-2 fs-16"></i>
                                    <span>Sesiones de Trabajo</span>
                                    <span class="badge bg-primary-subtle text-primary ms-2 fs-11">{{ count($turnosMesActual) }}</span>
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link d-flex align-items-center" id="pagos-tab" data-bs-toggle="tab"
                                    data-bs-target="#pagos-tab-pane" type="button" role="tab"
                                    aria-controls="pagos-tab-pane" aria-selected="false">
                                    <i class="ri-money-dollar-box-line me-2 fs-16"></i>
                                    <span>Pagos</span>
                                    <span class="badge bg-success-subtle text-success ms-2 fs-11">{{ count($pagosOrden) }}</span>
                                </button>
                            </li>
                        </ul>
                    </div>

                    <!-- Contenido de las pestañas -->
                    <div class="p-4">
                        <div class="tab-content" id="myTabContent">
                            <!-- Pestaña de Sesiones de Trabajo -->
                            <div class="tab-pane show active fade" id="turnosMes-tab-pane"
                                role="tabpanel" aria-labelledby="turnosMes-tab" tabindex="0">
                                
                                @if($turnosMesActual->isEmpty())
                                    <div class="text-center py-5">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                            <i class="ri-calendar-todo-line text-primary" style="font-size: 32px;"></i>
                                        </div>
                                        <h6 class="text-muted mb-2">No hay sesiones programadas</h6>
                                        <p class="text-muted fs-13 mb-0">Agrega una nueva sesión de trabajo para comenzar</p>
                                    </div>
                                @else
                                    <div class="row g-4">
                                        @foreach ($turnosMesActual as $turno)
                                            <div class="col-lg-6">
                                                <div class="card payment-card h-100"
                                                    data-bs-toggle="modal" data-bs-target="#editShift{{ $turno->id_shift }}" style="cursor: pointer;">
                                                    <div class="card-body p-4">
                                                        <!-- Header with status -->
                                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                                    <i class="ri-calendar-todo-line text-primary fs-5"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="client-name mb-0">
                                                                        {{ $turno->start_at ? ucfirst($turno->start_at->translatedFormat('l')) . ' ' . $turno->start_at->format('j') . ' de ' . ucfirst($turno->start_at->translatedFormat('F')) : $turno->shift_date }}
                                                                    </h6>
                                                                    <small class="payment-date">
                                                                        {{ $turno->start_at ? $turno->start_at->format('H:i') : $turno->start_time }}
                                                                        @if($turno->end_time) - {{ $turno->end_at ? $turno->end_at->format('H:i') : $turno->end_time }} @endif
                                                                    </small>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown">
                                                                <button class="btn action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editShift{{ $turno->id_shift }}">
                                                                            <i class="ri-eye-line me-2 text-primary"></i>Ver Detalles
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <!-- Información adicional -->
                                                        @if($turno->responsible)
                                                        <div class="mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <i class="ri-user-line me-2 fs-14 text-muted"></i>
                                                                <span class="fs-13 text-muted">{{ $turno->responsible }}</span>
                                                            </div>
                                                        </div>
                                                        @endif
                                                        
                                                        @if($turno->description)
                                                        <div class="mb-3">
                                                            <small class="text-muted">Descripción:</small>
                                                            <p class="fs-12 text-muted mb-0 lh-base">
                                                                {{ Str::limit($turno->description, 100) }}
                                                            </p>
                                                        </div>
                                                        @endif

                                                        <!-- Status Badge -->
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="status-badge 
                                                                @if($turno->status === 'completed') status-paid
                                                                @elseif($turno->status === 'pending') status-pending
                                                                @elseif($turno->status === 'canceled') status-void
                                                                @elseif($turno->status === 'rescheduled') status-overdue
                                                                @endif">
                                                                @if($turno->status === 'completed') 
                                                                    <i class="ri-checkbox-circle-line me-1"></i>Completado
                                                                @elseif($turno->status === 'pending') 
                                                                    <i class="ri-time-line me-1"></i>Pendiente
                                                                @elseif($turno->status === 'canceled') 
                                                                    <i class="ri-close-circle-line me-1"></i>Cancelado
                                                                @elseif($turno->status === 'rescheduled') 
                                                                    <i class="ri-alarm-warning-line me-1"></i>Reagendado
                                                                @endif
                                                            </span>
                                                            
                                                            <!-- Status indicator -->
                                                            <div class="d-flex align-items-center">
                                                                @if($turno->status === 'completed')
                                                                    <div class="bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                                                                @elseif($turno->status === 'rescheduled')
                                                                    <div class="bg-warning rounded-circle" style="width: 8px; height: 8px;"></div>
                                                                @elseif($turno->status === 'pending')
                                                                    <div class="bg-secondary rounded-circle" style="width: 8px; height: 8px;"></div>
                                                                @elseif($turno->status === 'canceled')
                                                                    <div class="bg-danger rounded-circle" style="width: 8px; height: 8px;"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>

                            <!-- Pestaña de Pagos -->
                            <div class="tab-pane fade" id="pagos-tab-pane"
                                role="tabpanel" aria-labelledby="pagos-tab" tabindex="0">
                                
                                @if($pagosOrden->isEmpty())
                                    <div class="text-center py-5">
                                        <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 80px; height: 80px;">
                                            <i class="ri-money-dollar-box-line text-primary" style="font-size: 32px;"></i>
                                        </div>
                                        <h6 class="text-muted mb-2">No hay pagos registrados</h6>
                                        <p class="text-muted fs-13 mb-0">Los pagos aparecerán aquí cuando se generen</p>
                                    </div>
                                @else
                                    <div class="row g-4">
                                        @foreach ($pagosOrden as $pago)
                                            <div class="col-lg-6">
                                                <div class="card payment-card h-100">
                                                    <div class="card-body p-4">
                                                        <!-- Header with status -->
                                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                                            <div class="d-flex align-items-center">
                                                                <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                                    <i class="ri-money-dollar-circle-line text-primary fs-5"></i>
                                                                </div>
                                                                <div>
                                                                    <h6 class="client-name mb-0">{{ $order->client_name }}</h6>
                                                                    <small class="payment-date">{{ ucfirst($pago->emission_date ? \Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y') : 'Sin fecha') }}</small>
                                                                </div>
                                                            </div>
                                                            <div class="dropdown">
                                                                <button class="btn action-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </button>
                                                                <ul class="dropdown-menu dropdown-menu-end">
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('payments.show', $pago->id_payment) }}">
                                                                            <i class="ri-eye-line me-2 text-primary"></i>Ver Detalles
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPayment{{ $pago->id_payment }}">
                                                                            <i class="ri-edit-line me-2 text-warning"></i>Editar Pago
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>

                                                        <!-- Amount -->
                                                        @php
                                                            $totalPago = $pago->total_amount;
                                                        @endphp
                                                        <div class="mb-3">
                                                            <div class="payment-amount">${{ number_format($totalPago, 0, ',', '.') }}</div>
                                                            <small class="text-muted">Valor total del pago</small>
                                                        </div>

                                                        <!-- Status Badge -->
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <span class="status-badge 
                                                                @if($pago->status === 'overdue') status-overdue
                                                                @elseif($pago->status === 'pending') status-pending
                                                                @elseif($pago->status === 'paid') status-paid
                                                                @elseif($pago->status === 'void') status-void
                                                                @endif">
                                                                @if($pago->status === 'pending') 
                                                                    <i class="ri-time-line me-1"></i>Pendiente
                                                                @elseif($pago->status === 'paid') 
                                                                    <i class="ri-checkbox-circle-line me-1"></i>Pagado
                                                                @elseif($pago->status === 'overdue') 
                                                                    <i class="ri-alarm-warning-line me-1"></i>Atrasado
                                                                @elseif($pago->status === 'void') 
                                                                    <i class="ri-close-circle-line me-1"></i>Anulado
                                                                @endif
                                                            </span>
                                                            
                                                            <!-- Status indicator -->
                                                            <div class="d-flex align-items-center">
                                                                @if($pago->status === 'paid')
                                                                    <div class="bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                                                                @elseif($pago->status === 'overdue')
                                                                    <div class="bg-warning rounded-circle" style="width: 8px; height: 8px;"></div>
                                                                @elseif($pago->status === 'pending')
                                                                    <div class="bg-secondary rounded-circle" style="width: 8px; height: 8px;"></div>
                                                                @elseif($pago->status === 'void')
                                                                    <div class="bg-danger rounded-circle" style="width: 8px; height: 8px;"></div>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->

</div>
{{-- Mostrar mensaje de éxito
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif --}}

{{-- Mostrar mensaje de error --}}
@if($errors->any())
    <script>
        alert("{{ $errors->first() }}");
    </script>
@endif
<!-- Modals de Edicion, Creacion y Asignacion -->
@include('pages.modals.editShiftShow')
@include('pages.modals.editPaymentShow')
@include('pages.modals.createShift')
@include('pages.modals.editOrder')

@endsection

@section('scripts')

        

        <script>
            // Scripts para la página de órdenes de trabajo
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Página de orden de trabajo cargada correctamente');
            });
        </script>



@endsection