@extends('layouts.master')

@section('styles')
<!-- DATE & TIME PICKER JS -->
<script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="path/to/flatpickr/l10n/es.js"></script>
<link rel="stylesheet" href="{{asset('build/assets/libs/glightbox/css/glightbox.min.css')}}">       
@vite('resources/assets/js/date&time_pickers.js')
<!-- INTERNAL PROFILE JS -->
@vite('resources/assets/js/profile.js')
@endsection

@section('content')
@php
    \Carbon\Carbon::setLocale('es');

@endphp
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        
        <h1 class="page-title fw-semibold fs-18 mb-0">Trabajo: {{ $order->client_name }}</h1>
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
            'done' => 'bg-success',
            'in_progress' => 'bg-secondary',
            'canceled' => 'bg-danger',
            default => 'bg-secondary'
        };
        $estadoTexto = match(strtolower($order->estado)) {
            'done' => 'Completado',
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
                    <div class="d-sm-flex align-items-top p-4 border-bottom-0 main-profile-cover">
                        
                        <div>
                            <span class="badge {{ $estadoColor }} position-absolute mb-5">{{ $estadoTexto }}</span>
                        </div>
                        <div class="flex-fill main-profile-info">
                    
                            <div class="d-flex flex-wrap align-item-center justify-content-between mt-3">
                                <h6 class="fw-semibold mb-3 mt-3 text-fixed-white">{{ $order->client_name }} <span class="text-muted fs-14">#{{ $order->id_order }}</span></h6>
                                <button class="btn btn-sm btn-icon btn-wave waves-effect waves-light fs-10 border-0 p-0" type="button" data-bs-toggle="modal" data-bs-target="#editOrder">
                                    <i class="ri-pencil-line text-white"></i>
                                </button>
                            </div>
                                
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span class="me-2"><i class="bx bx-id-card me-1 align-middle"></i> {{ $order->cliente_rut ?? 'Sin RUT' }}</span> 
                                <span><i class="ri-phone-line me-1 align-middle"></i> {{ $order->client_phone ?? 'Sin teléfono' }}</span> 
                            </p>
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span class="me-2"><i class="ri-home-heart-line me-1 align-middle"></i>{{ $order->client_address ?? 'Sin dirección' }}</span> 
                            </p>
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span class="me-2"><i class="ri-calendar-line me-1 align-middle"></i>
                                    {{ $order->start_date ? \Carbon\Carbon::parse($order->start_date)->format('d-m-Y') : 'Sin fecha inicio' }}
                                </span> 
                                @if($order->end_date)
                                <span><i class="ri-calendar-check-line me-1 align-middle"></i>{{ \Carbon\Carbon::parse($order->end_date)->format('d-m-Y') }}</span>
                                @endif
                            </p>
                            @if($duracionDias)
                            <p class="fs-14 text-fixed-white mb-2 op-6">  
                                <span><i class="ri-time-line me-1 align-middle"></i>Duración estimada: {{ $duracionDias }} días</span>
                            </p>
                            @endif
                        </div>
                    </div>
                    <div class="p-4 border-bottom border-block-end-dashed">
                        <div class="mb-4">
                            <div class="d-flex flex-wrap align-item-center justify-content-between">
                                <p class="fs-15 mb-2 me-4 fw-semibold">Descripción del Trabajo:</p>
                            </div>
                            <p class="fs-12 text-muted op-7 mb-0">
                                {{ $order->work_info ?? 'Sin descripción del trabajo especificada.' }}
                            </p>
                        </div>   
                    </div>  

                    <div class="p-4 border-bottom border-block-end-dashed">
                        <div class="d-flex flex-wrap align-item-center justify-content-between">
                            <p class="fs-15 mb-2 me-4 fw-semibold">Estadísticas del Trabajo:</p>
                        </div>
                        
                        <div class="text-muted">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-primary text-white">
                                            <i class="ri-calendar-todo-fill align-middle fs-14"></i>
                                        </span>
                                        Total Turnos: <strong>{{ $estadisticas['total_turnos'] }}</strong>
                                    </p>
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-success text-white">
                                            <i class="ri-checkbox-circle-fill align-middle fs-14"></i>
                                        </span>
                                        Completados: <strong>{{ $estadisticas['turnos_completados'] }}</strong>
                                    </p>
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-warning text-white">
                                            <i class="ri-time-fill align-middle fs-14"></i>
                                        </span>
                                        Pendientes: <strong>{{ $estadisticas['turnos_pendientes'] }}</strong>
                                    </p>
                                </div>
                               
                                <div class="col-md-6">
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-info text-white">
                                            <i class="ri-money-dollar-circle-fill align-middle fs-14"></i>
                                        </span>
                                        Total Facturado: <strong>${{ number_format($estadisticas['total_facturado'], 0, ',', '.') }}</strong>
                                    </p>
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-success text-white">
                                            <i class="ri-money-dollar-box-fill align-middle fs-14"></i>
                                        </span>
                                        Total Pagado: <strong>${{ number_format($estadisticas['total_pagado'], 0, ',', '.') }}</strong>
                                    </p>
                                    <p class="mb-3">
                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-danger text-white">
                                            <i class="ri-error-warning-fill align-middle fs-14"></i>
                                        </span>
                                        Pagos Pendientes: <strong>{{ $estadisticas['pagos_pendientes'] }}</strong>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="p-4 border-block-end-dashed">
                        <div class="d-flex flex-wrap align-item-center justify-content-between">
                            <p class="fs-15 mb-2 me-4 fw-semibold">Próximos Turnos:</p>
                            
                        </div>
                        <div class="text-muted">
                            <div class="row">
                                @if($proximosTurnos->isEmpty())
                                <p class="mb-3">
                                    No hay turnos programados próximamente.
                                </p>
                                @else
                                    @foreach ($proximosTurnos as $turno)
                                        <div class="col-12 mb-3 pb-3 border-bottom border-block-end-dashed">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <p class="mb-2">
                                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-primary text-white">
                                                            <i class="ri-calendar-line align-middle fs-14"></i>
                                                        </span>
                                                        <strong>{{ $turno->start_at ? $turno->start_at->translatedFormat('l, j \\d\\e F') : $turno->shift_date }}</strong>
                                                    </p>
                                                    <p class="mb-2">
                                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-info text-white">
                                                            <i class="ri-time-line align-middle fs-14"></i>
                                                        </span>
                                                        {{ $turno->start_at ? $turno->start_at->format('H:i') : $turno->start_time }}
                                                        @if($turno->end_time) - {{ $turno->end_at ? $turno->end_at->format('H:i') : $turno->end_time }} @endif
                                                    </p>
                                                    @if($turno->responsible)
                                                    <p class="mb-2">
                                                        <span class="avatar avatar-sm avatar-rounded me-2 bg-success text-white">
                                                            <i class="ri-user-line align-middle fs-14"></i>
                                                        </span>
                                                        {{ $turno->responsible }}
                                                    </p>
                                                    @endif
                                                    @if($turno->description)
                                                    <p class="mb-0 text-muted fs-12">
                                                        {{ Str::limit($turno->description, 80) }}
                                                    </p>
                                                    @endif
                                                </div>
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
                                                <span class="badge {{ $colorEstado }}">{{ ucfirst($estadoShift) }}</span>
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

        <div class="col-md-7 d-flex">
            <div class="card custom-card" style="background-color: transparent;">
                <div class="card-body p-0">
                    <div class="p-3 border-bottom border-block-end-dashed d-flex align-items-center justify-content-between">
                        <div>
                            <ul class="nav nav-tabs mb-0 tab-style-6 justify-content-start" id="myTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="turnosMes-tab" data-bs-toggle="tab"
                                        data-bs-target="#turnosMes-tab-pane" type="button" role="tab"
                                        aria-controls="turnosMes-tab-pane" aria-selected="true"><i
                                            class="ri-calendar-todo-line me-1 align-middle d-inline-block"></i>Sesiones de Trabajo</button>
                                </li>



                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="pagos-tab" data-bs-toggle="tab"
                                        data-bs-target="#pagos-tab-pane" type="button" role="tab"
                                        aria-controls="pagos-tab-pane" aria-selected="false"><i
                                            class="ri-money-dollar-box-line me-1 align-middle d-inline-block"></i>Pago</button>
                                </li>
                                

                            </ul>
                        </div>   
                        <div>
                            <div class="dropdown ms-2">
                                <button class="btn btn-light btn-wave waves-effect waves-light px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="ti ti-plus fs-18"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#createShiftModal">Agendar Sesión</a></li>
        
                                </ul>
                            </div>
                        </div> 
                    </div>
                    <div class="p-3">
                        <div class="tab-content h-100 w-100" id="myTabContent">
                            <div class="tab-pane show active fade p-0 border-0 h-100" id="turnosMes-tab-pane"
                                role="tabpanel" aria-labelledby="turnosMes-tab" tabindex="0">
                                <div class="row d-flex align-items-stretch">
                                    @foreach ($turnosMesActual as $turno)
                                    <div class="col-md-6 d-flex">
                                        <div class="card custom-card flex-fill
                                            @if($turno->status === 'completed') task-completed-card
                                            @elseif($turno->status === 'pending') task-pending-card
                                            @elseif($turno->status === 'canceled') task-inprogress-card
                                            @elseif($turno->status === 'rescheduled') task-inprogress-card
                                            @endif"
                                            data-bs-toggle="modal" data-bs-target="#editShift{{ $turno->id_shift }}" style="cursor: pointer;">
                                            <div class="card-body">
                                                <div class="d-flex justify-content-between flex-wrap gap-2">
                                                    <div>
                                                        <p class="fw-semibold mb-3 d-flex align-items-center">
                                                            <a><i class="ri-calendar-todo-line fs-16 op-5 me-1 text-muted"></i></a>
                                                            {{ $turno->start_at ? ucfirst($turno->start_at->translatedFormat('l')) . ' ' . $turno->start_at->format('j') . ' de ' . ucfirst($turno->start_at->translatedFormat('F')) : $turno->shift_date }}
                                                        </p>

                                                        <p class="mb-3">
                                                            <i class="ri-time-line me-1"></i>
                                                            {{ $turno->start_at ? $turno->start_at->format('H:i') : $turno->start_time }}
                                                            @if($turno->end_time) - {{ $turno->end_at ? $turno->end_at->format('H:i') : $turno->end_time }} @endif
                                                        </p>

                                                        <p class="mb-3">Estado Turno: <span class="fs-12 mb-1 fw-semibold
                                                            @if($turno->status === 'completed') text-success 
                                                            @elseif($turno->status === 'pending') text-secondary
                                                            @elseif($turno->status === 'canceled') text-danger
                                                            @elseif($turno->status === 'rescheduled') text-warning
                                                            @endif">
                                                              {{ ucfirst($turno->status) }}
                                                        </span>
                                                        </p>

                                                        @if($turno->responsible)
                                                        <p class="mb-3">Responsable: 
                                                            <span class="fs-12 mb-1 text-muted">{{ $turno->responsible }}</span>
                                                        </p>
                                                        @endif
                                                        
                                                        <p class="mb-0">Descripción: 
                                                            <span class="fs-12 mb-1 text-muted">{{ $turno->description ?: 'Sin descripción' }}</span>
                                                        </p>
                                                    </div>                                            
                                                </div> 
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                  
                                </div>
                                
                            </div>
                            <div class="tab-pane fade p-0 border-0 h-100" id="pagos-tab-pane"
                                role="tabpanel" aria-labelledby="pagos-tab" tabindex="0">
                                <div class="row d-flex align-items-stretch">
                                    @foreach ($pagosOrden as $pago)
                                            <div class="col-md-6 d-flex">
                                                <div class="card custom-card flex-fill
                                            @if($pago->status === 'overdue') task-pending-card
                                            @elseif($pago->status === 'pending') task-pending-card
                                            @elseif($pago->status === 'paid') task-completed-card
                                            @elseif($pago->status === 'void') task-inprogress-card
                                                    @endif">
                                                    <div class="card-body">
                                                        <div class="d-flex justify-content-between flex-wrap gap-2">
                                                            <div class="flex-grow-1">
                                                                <p class="fw-semibold mb-3 d-flex align-items-center">
                                                                    <i class="ri-money-dollar-box-fill fs-16 op-5 me-1 text-muted"></i>
                                                                    {{ ucfirst($pago->emission_date ? \Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y') : 'Sin fecha') }} - {{ $order->client_name }}
                                                                </p>
                                                                @php
                                                                    $totalPago = $pago->labor_cost + $pago->machine_cost + $pago->fuel_expenses + $pago->extra_cost;
                                                                @endphp
                                                                <p class="mb-2">Valor Total :
                                                                    <span class="fs-12 mb-1 text-muted">${{ number_format($totalPago, 0, ',', '.') }}</span>
                                                                </p>
                                                                <p class="mb-2">Estado Pago: <span class="fs-12 mb-1 fw-semibold
                                                                    @if($pago->status === 'overdue') text-warning
                                                                    @elseif($pago->status === 'pending') text-secondary
                                                                    @elseif($pago->status === 'paid') text-success
                                                                    @elseif($pago->status === 'void') text-danger
                                                                    @endif">
                                                                      @if($pago->status === 'pending') Pendiente
                                                                      @elseif($pago->status === 'paid') Pagado
                                                                      @elseif($pago->status === 'overdue') Atrasado
                                                                      @elseif($pago->status === 'void') Anulado
                                                                      @endif
                                                                </span>
                                                                </p>
                                                            </div>
                                                            <div class="dropdown">
                                                                <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                                    <i class="ri-more-2-fill"></i>
                                                                </button>
                                                                <ul class="dropdown-menu">
                                                                    <li>
                                                                        <a class="dropdown-item" href="{{ route('payments.show', $pago->id_payment) }}">
                                                                            <i class="ri-eye-line me-2"></i>Ver Detalles
                                                                        </a>
                                                                    </li>
                                                                    <li>
                                                                        <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPayment{{ $pago->id_payment }}">
                                                                            <i class="ri-edit-line me-2"></i>Editar Estado
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    @endforeach
                                </div>
                            
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

@endsection

@section('scripts')

        

        <script>
            // Scripts para la página de órdenes de trabajo
            document.addEventListener('DOMContentLoaded', function() {
                console.log('Página de orden de trabajo cargada correctamente');
            });
        </script>



@endsection