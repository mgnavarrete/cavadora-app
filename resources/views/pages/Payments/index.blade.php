@extends('layouts.master')

@section('styles')
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
    
    .filter-sidebar {
        background: #f8f9fa;
        color: #495057;
        border-radius: 12px;
        overflow: hidden;
        border: 1px solid #e9ecef;
    }
    .filter-sidebar .card-body {
        background: transparent;
    }
    .filter-sidebar .form-control {
        background: white;
        border: 1px solid #ced4da;
        color: #495057;
    }
    .filter-sidebar .form-control::placeholder {
        color: #6c757d;
    }
    .filter-sidebar .btn-primary {
        background: #007bff;
        border: 1px solid #007bff;
        color: white;
        font-weight: 600;
    }
    .filter-sidebar .btn-primary:hover {
        background: #0056b3;
        border-color: #0056b3;
    }
    .month-filter {
        background: white;
        border-radius: 8px;
        padding: 15px;
        margin-top: 15px;
        border: 1px solid #e9ecef;
    }
    .month-filter label {
        color: #495057;
        padding: 8px 12px;
        border-radius: 6px;
        transition: all 0.2s ease;
        cursor: pointer;
        margin-bottom: 5px;
    }
    .month-filter label:hover {
        background: #f8f9fa;
    }
    .month-filter input[type="radio"]:checked + span {
        color: #007bff;
        font-weight: 600;
    }
    .month-filter input[type="radio"] {
        accent-color: #007bff;
    }
    
    .stats-header {
        background: white;
        color: white;
        border-radius: 12px;
        margin-bottom: 20px;
    }
    .tab-nav {
        background: white;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    .tab-nav .nav-link {
        border: none;
        color: #6c757d;
        font-weight: 500;
        padding: 12px 20px;
        transition: all 0.3s ease;
    }
    .tab-nav .nav-link.active {
        background: #007bff;
        color: white;
    }
    .tab-nav .nav-link:hover:not(.active) {
        background: #f8f9fa;
        color: #495057;
    }
    
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6c757d;
    }
    .empty-state i {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
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
    
    .section-title {
        font-size: 14px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 1px;
        color: #6c757d;
        margin-bottom: 15px;
    }
    
    /* Animaciones suaves */
    .tab-pane {
        animation: fadeIn 0.3s ease-in-out;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    /* Mejoras en el grid */
    .row.g-4 > * {
        padding: 0.75rem;
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
        .stats-header .row {
            text-align: center;
        }
        
        .stats-header .col-md-4 {
            margin-top: 15px;
        }
        
        .tab-nav .nav-link {
            font-size: 12px;
            padding: 10px 8px;
        }
        
        .payment-card .card-body {
            padding: 1.5rem;
        }
    }
    
    /* Mejoras en el sidebar */
    .filter-sidebar {
        position: sticky;
        top: 20px;
    }
    
    /* Indicadores de estado más visibles */
    .status-badge {
        position: relative;
        overflow: hidden;
    }
    
    .status-badge::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
        transition: left 0.5s;
    }
    
    .status-badge:hover::before {
        left: 100%;
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
        <div>
            <h1 class="page-title fw-bold fs-24 mb-1 text-dark">Gestión de Pagos</h1>
            <p class="text-muted mb-0">Administra y monitorea todos los pagos del sistema</p>
        </div>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('index')}}" class="text-decoration-none">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Pagos</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row -->
    <div class="row g-4">
        <div class="col-xl-3">
            <div class="card filter-sidebar">
                <div class="card-body p-0">
                    <form method="GET" action="{{ route('payments.index') }}">
                        <!-- Search Section -->
                        <div class="p-4 border-bottom">
                            <h6 class="section-title">Búsqueda</h6>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="ri-search-line text-muted"></i>
                                </span>
                                <input type="text" name="search" class="form-control border-start-0" placeholder="Buscar por cliente..." 
                                       value="{{ request('search') }}" aria-describedby="button-addon2">
                            </div>
                        </div>
                        
                        @php
                            // Generamos una lista de meses de marzo a diciembre
                            $mesesAMostrar = [];
                            $inicio = \Carbon\Carbon::create(null, 3, 1); // Marzo
                            $fin = \Carbon\Carbon::create(null, 12, 1); // Diciembre
                            while ($inicio->lessThanOrEqualTo($fin)) {
                                $mesesAMostrar[] = $inicio->copy();
                                $inicio->addMonth();
                            }
                        @endphp
                        
                        <!-- Filter Button -->
                        <div class="p-4 border-bottom">
                            <button type="submit" class="btn btn-primary w-100">
                                <i class="ri-filter-3-line me-2"></i>Aplicar Filtros
                            </button>
                        </div>
                        
                        <!-- Month Filter -->
                        <div class="month-filter">
                            <h6 class="section-title">Filtrar por Mes</h6>
                            <ul class="list-unstyled mb-0">
                                <li>
                                    <label class="d-flex align-items-center w-100">
                                        <input type="radio" name="month_filter" value="todos" class="me-3"
                                            {{ request('month_filter') == 'todos' || !request('month_filter') ? 'checked' : '' }}>
                                        <i class="ri-calendar-line me-2"></i>
                                        <span>Todos los meses</span>
                                    </label>
                                </li>

                                @foreach ($mesesAMostrar as $mes)
                                    <li>
                                        <label class="d-flex align-items-center w-100">
                                            <input type="radio" name="month_filter" value="{{ $mes->format('Y-m-d') }}" class="me-3"
                                                {{ request('month_filter') == $mes->format('Y-m-d') ? 'checked' : '' }}>
                                            <i class="ri-calendar-2-line me-2"></i>
                                            <span>{{ ucfirst($mes->translatedFormat('F Y')) }}</span>
                                        </label>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </form>

                    <!-- Decorative Image -->
                    <div class="p-4 text-center">
                        <div class="bg-white rounded-3 p-4 border">
                            <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3" style="width: 60px; height: 60px;">
                                <i class="ri-money-dollar-circle-line text-primary" style="font-size: 24px;"></i>
                            </div>
                            <p class="text-muted mt-2 mb-0 small">Sistema de Pagos</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <!-- Stats Header -->
            <div class="stats-header p-4 mb-4">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h4 class="mb-1 fw-bold">
                            <i class="ri-dashboard-3-line me-2"></i>Panel de Control de Pagos
                        </h4>
                    </div>
                    <div class="col-md-4 text-end">
                        <div class="d-flex justify-content-end gap-2">
                            <span class="badge bg-primary bg-opacity-20 text-white px-3 py-2 fs-14">
                                <i class="ri-file-list-3-line me-1"></i>
                                {{ $pagos->count() }} Total
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Navigation -->
            <div class="tab-nav mb-4">
                <ul class="nav nav-tabs nav-tabs-header mb-0 d-flex" role="tablist">
                    <li class="nav-item flex-fill">
                        <a class="nav-link active text-center" data-bs-toggle="tab" role="tab" 
                           href="#todos" aria-selected="true">
                            <i class="ri-list-check me-2"></i>Todos
                        </a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link text-center" data-bs-toggle="tab" role="tab" 
                           href="#pendientes" aria-selected="false">
                            <i class="ri-time-line me-2"></i>Pendientes
                        </a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link text-center" data-bs-toggle="tab" role="tab" 
                           href="#atrasados" aria-selected="false">
                            <i class="ri-alarm-warning-line me-2"></i>Atrasados
                        </a>
                    </li>
                    <li class="nav-item flex-fill">
                        <a class="nav-link text-center" data-bs-toggle="tab" role="tab" 
                           href="#pagados" aria-selected="false">
                            <i class="ri-checkbox-circle-line me-2"></i>Pagados
                        </a>
                    </li>
                </ul>
            </div>
            <!-- Tab Content -->
            <div class="tab-content">
                <div class="tab-pane show active" id="todos" role="tabpanel">
                    <div class="row g-4">
                        @if($pagos->isEmpty())
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="ri-file-list-3-line"></i>
                                    <h5 class="mb-2">No hay pagos registrados</h5>
                                    <p class="text-muted">No se encontraron pagos con los filtros aplicados</p>
                                </div>
                            </div>
                        @else
                            @foreach ($pagos as $pago)
                                @php
                                    $totalPago = $pago->total_amount;
                                @endphp
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
                                                        <h6 class="client-name mb-0">{{ optional($pago->order)->client_name ?? 'Cliente' }}</h6>
                                                        <small class="payment-date">{{ ucfirst(\Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y')) }}</small>
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
                        @endif
                    </div>
                </div>
                <div class="tab-pane" id="pendientes" role="tabpanel">
                    <div class="row g-4">
                        @if($pendientes->isEmpty())
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="ri-time-line"></i>
                                    <h5 class="mb-2">No hay pagos pendientes</h5>
                                    <p class="text-muted">No se encontraron pagos con estado pendiente</p>
                                </div>
                            </div>
                        @else
                            @foreach ($pendientes as $pago)
                                @php
                                    $totalPago = $pago->total_amount;
                                @endphp
                                <div class="col-lg-6">
                                    <div class="card payment-card h-100">
                                        <div class="card-body p-4">
                                            <!-- Header with status -->
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="ri-time-line text-secondary fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="client-name mb-0">{{ optional($pago->order)->client_name ?? 'Cliente' }}</h6>
                                                        <small class="payment-date">{{ ucfirst(\Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y')) }}</small>
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
                                            <div class="mb-3">
                                                <div class="payment-amount">${{ number_format($totalPago, 0, ',', '.') }}</div>
                                                <small class="text-muted">Valor total del pago</small>
                                            </div>

                                            <!-- Status Badge -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="status-badge status-pending">
                                                    <i class="ri-time-line me-1"></i>Pendiente
                                                </span>
                                                
                                                <!-- Status indicator -->
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-secondary rounded-circle" style="width: 8px; height: 8px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="tab-pane" id="atrasados" role="tabpanel">
                    <div class="row g-4">
                        @if($atrasados->isEmpty())
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="ri-alarm-warning-line"></i>
                                    <h5 class="mb-2">No hay pagos atrasados</h5>
                                    <p class="text-muted">No se encontraron pagos con estado atrasado</p>
                                </div>
                            </div>
                        @else
                            @foreach ($atrasados as $pago)
                                @php
                                    $totalPago = $pago->total_amount;
                                @endphp
                                <div class="col-lg-6">
                                    <div class="card payment-card h-100">
                                        <div class="card-body p-4">
                                            <!-- Header with status -->
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-warning bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="ri-alarm-warning-line text-warning fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="client-name mb-0">{{ optional($pago->order)->client_name ?? 'Cliente' }}</h6>
                                                        <small class="payment-date">{{ ucfirst(\Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y')) }}</small>
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
                                            <div class="mb-3">
                                                <div class="payment-amount">${{ number_format($totalPago, 0, ',', '.') }}</div>
                                                <small class="text-muted">Valor total del pago</small>
                                            </div>

                                            <!-- Status Badge -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="status-badge status-overdue">
                                                    <i class="ri-alarm-warning-line me-1"></i>Atrasado
                                                </span>
                                                
                                                <!-- Status indicator -->
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-warning rounded-circle" style="width: 8px; height: 8px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="tab-pane" id="pagados" role="tabpanel">
                    <div class="row g-4">
                        @if($pagados->isEmpty())
                            <div class="col-12">
                                <div class="empty-state">
                                    <i class="ri-checkbox-circle-line"></i>
                                    <h5 class="mb-2">No hay pagos completados</h5>
                                    <p class="text-muted">No se encontraron pagos con estado pagado</p>
                                </div>
                            </div>
                        @else
                            @foreach ($pagados as $pago)
                                @php
                                    $totalPago = $pago->total_amount;
                                @endphp
                                <div class="col-lg-6">
                                    <div class="card payment-card h-100">
                                        <div class="card-body p-4">
                                            <!-- Header with status -->
                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                                        <i class="ri-checkbox-circle-line text-success fs-5"></i>
                                                    </div>
                                                    <div>
                                                        <h6 class="client-name mb-0">{{ optional($pago->order)->client_name ?? 'Cliente' }}</h6>
                                                        <small class="payment-date">{{ ucfirst(\Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y')) }}</small>
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
                                                        {{-- <li>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPayment{{ $pago->id_payment }}">
                                                                <i class="ri-edit-line me-2 text-warning"></i>Editar Estado
                                                            </a>
                                                        </li> --}}
                                                    </ul>
                                                </div>
                                            </div>

                                            <!-- Amount -->
                                            <div class="mb-3">
                                                <div class="payment-amount">${{ number_format($totalPago, 0, ',', '.') }}</div>
                                                <small class="text-muted">Valor total del pago</small>
                                            </div>

                                            <!-- Status Badge -->
                                            <div class="d-flex justify-content-between align-items-center">
                                                <span class="status-badge status-paid">
                                                    <i class="ri-checkbox-circle-line me-1"></i>Pagado
                                                </span>
                                                
                                                <!-- Status indicator -->
                                                <div class="d-flex align-items-center">
                                                    <div class="bg-success rounded-circle" style="width: 8px; height: 8px;"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End::row -->
</div>
{{-- Mostrar mensaje de éxito --}}
{{-- @if(session('success'))
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

@endsection
@include('pages.modals.editPaymentPage')

@section('scripts')
    <!-- FLAT PICKER JS -->
    <script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>

    <!-- INTERNAL TO DO LIST JS -->
    @vite('resources/assets/js/todolist.js')

    <!-- GLIGHTBOX JS -->
    <script src="{{asset('build/assets/libs/glightbox/js/glightbox.min.js')}}"></script>

    <!-- INTERNAL PROFILE JS -->
    @vite('resources/assets/js/profile.js')

  

    <!-- JSVECTOR MAPS JS -->
    <script src="{{asset('build/assets/libs/jsvectormap/js/jsvectormap.min.js')}}"></script>
    <script src="{{asset('build/assets/libs/jsvectormap/maps/world-merc.js')}}"></script>

    <!-- APEX CHARTS JS -->
    <script src="{{asset('build/assets/libs/apexcharts/apexcharts.min.js')}}"></script>

    <!-- CHARTJS CHART JS -->
    <script src="{{asset('build/assets/libs/chart.js/chart.min.js')}}"></script>

    <!-- CRM-Dashboard -->
    @vite('resources/assets/js/crm-dashboard.js')

    
@endsection

