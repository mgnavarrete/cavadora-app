@extends('layouts.master')

@section('styles')
@endsection

@section('content')

@php
    \Carbon\Carbon::setLocale('es');
@endphp

<div class="container-fluid">

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">¡Hola 👋, @auth{{Auth::user()->name}}@endauth!</h1>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Páginas</a></li>
                <li class="breadcrumb-item active" aria-current="page">Resumen</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

    <div class="row d-flex align-items-stretch">
        <!-- Total de Órdenes -->
        <div class="col-md-3 d-flex">
            <div class="card custom-card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <p class="mb-2">
                                <span class="fs-14">Total Trabajos</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-20 fw-semibold lh-1 vertical-bottom mb-0">{{ $totalOrdenes }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Este Mes</span>
                            </p>
                            <a href="{{ route('orders.index') }}" class="fs-12 mb-0 text-secondary">Ver Trabajos<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                        <div class="col-6">
                            @php
                                // mantenemos el “badge” con sesiones/turnos pendientes de la semana
                                $diferenciaOrdenes = $sesionesPendientes ?? 0;
                                $iconoOrdenes = $diferenciaOrdenes >= 0 ? 'ti-caret-up' : 'ti-caret-down';
                                $colorOrdenes = $diferenciaOrdenes >= 0 ? 'bg-success-transparent' : 'bg-danger-transparent';
                            @endphp
                            <p class="badge {{ $colorOrdenes }} float-end d-inline-flex">
                                <i class="ti {{ $iconoOrdenes }} me-1"></i>{{ $sesionesPendientes ?? 0 }}
                            </p>
                            <p class="main-card-icon mb-0"><span class="avatar avatar-md avatar-rounded bg-primary">
                                <i class="ti ti-briefcase fs-16"></i>
                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Ganado Mes Actual -->
        <div class="col-md-3 d-flex">
            <div class="card custom-card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <p class="mb-2">
                                <span class="fs-14">Ingresos</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-20 fw-semibold lh-1 vertical-bottom mb-0">${{ number_format($totalGanadoMesActual, 0, ',', '.') }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Este Mes</span>
                            </p>
                            <a href="{{ route('payments.index') }}" class="fs-12 mb-0 text-secondary">Ver Ingresos<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                        <div class="col-6">
                            @php
                                $difPagos = ($totalGanadoMesActual ?? 0) - ($totalGanadoMesPasado ?? 0);
                                $iconoPagos = $difPagos >= 0 ? 'ti-caret-up' : 'ti-caret-down';
                                $colorPagos = $difPagos >= 0 ? 'bg-success-transparent' : 'bg-danger-transparent';
                            @endphp
                            <p class="badge {{ $colorPagos }} float-end d-inline-flex">
                                <i class="ti {{ $iconoPagos }} me-1"></i>
                                ${{ number_format(abs($difPagos), 0, ',', '.') }}
                            </p>
                            <p class="main-card-icon mb-0"><span class="avatar avatar-md avatar-rounded bg-success">
                                <i class="ti ti-coin fs-16"></i>
                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pagos Pendientes -->
        <div class="col-md-3 d-flex">
            <div class="card custom-card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <p class="mb-2">
                                <span class="fs-14">No Pagados</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-20 fw-semibold lh-1 vertical-bottom mb-0">{{ $pagosPendientes->count() }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Este Mes</span>
                            </p>
                            <a href="{{ route('payments.index') }}" class="fs-12 mb-0 text-secondary">Ver Pendientes<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                        <div class="col-6">
                            @php
                                $montoPendiente = $pagosPendientes->sum(function ($pago) {
                                    return $pago->total_amount;
                                });
                                $iconoPend = $montoPendiente <= 0 ? 'ti-caret-up' : 'ti-caret-down';
                                $colorPend = $montoPendiente <= 0 ? 'bg-success-transparent' : 'bg-danger-transparent';
                            @endphp
                            <p class="badge {{ $colorPend }} float-end d-inline-flex">
                                <i class="ti {{ $iconoPend }} me-1"></i>${{ number_format($montoPendiente, 0, ',', '.') }}
                            </p>
                            <p class="main-card-icon mb-0"><span class="avatar avatar-md avatar-rounded bg-warning">
                                <i class="ti ti-coin-off fs-16"></i> 
                            </span> </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Total Ganado Mes Pasado -->
        <div class="col-md-3 d-flex">
            <div class="card custom-card flex-fill">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 pe-0">
                            <p class="mb-2">
                                <span class="fs-14">Pagos Pasados</span>
                            </p>
                            <p class="mb-2 fs-12">
                                <span class="fs-20 fw-semibold lh-1 vertical-bottom mb-0">${{ number_format($totalGanadoMesPasado, 0, ',', '.') }}</span>
                                <span class="d-block fs-10 fw-semibold text-muted">Mes Pasado</span>
                            </p>
                            <a href="{{ route('payments.index') }}" class="fs-12 mb-0 text-secondary">Ver Pagos<i class="ti ti-chevron-right ms-1"></i></a>
                        </div>
                        <div class="col-6">
                            @php
                                $difPasado = $diferenciaIngresos ?? 0;
                                $iconoPas = $difPasado >= 0 ? 'ti-caret-up' : 'ti-caret-down';
                                $colorPas = $difPasado >= 0 ? 'bg-success-transparent' : 'bg-danger-transparent';
                            @endphp
                            <p class="badge {{ $colorPas }} float-end d-inline-flex">
                                <i class="ti {{ $iconoPas }} me-1"></i>
                                ${{ number_format(abs($difPasado), 0, ',', '.') }}
                            </p>
                            <p class="main-card-icon mb-0"><span class="avatar avatar-md avatar-rounded bg-secondary">
                                <i class="ti ti-wallet fs-16"></i>
                            </span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    <div class="container-fluid">
        <div class="row">
           <!-- Timeline: Próximos Eventos (Turnos) -->
            <div class="col-md-7">
                <div class="card custom-card flex-fill timeline-container">
                    <div class="card-header d-flex justify-content-between">
                        <p class="card-title fw-semibold fs-18 mb-0">Próximos Turnos</p>
                    </div>
                    <div class="card-body p-0" style="height: 600px; overflow-y: auto;">
                        @php
                            use Carbon\Carbon;

                            $tz = config('app.timezone', 'America/Santiago');

                            // Procesar turnos de Eloquent a arrays para la vista
                            $eventos = collect($proximosTurnos ?? [])->map(function ($shift) use ($tz) {
                                if (!is_object($shift)) return null;
                                
                                $client = optional($shift->order)->client_name ?? 'Cliente';
                                $address = optional($shift->order)->client_address ?? '';
                                
                                // Usar el accessor start_at del modelo si está disponible
                                $startAt = $shift->start_at ?? null;
                                
                                return [
                                    'id'        => $shift->id_shift,
                                    'status'    => $shift->status ?? 'pending',
                                    'client'    => $client,
                                    'address'   => $address,
                                    'start_at'  => $startAt,
                                    'shift_date' => $shift->shift_date,
                                    'start_time' => $shift->start_time,
                                    'end_time' => $shift->end_time ?? '',
                                    'description' => $shift->description ?? '',
                                    'responsible' => $shift->responsible ?? '',
                                    'created_at' => $shift->created_at ?? '',
                                    'updated_at' => $shift->updated_at ?? '',
                                ];
                            })->filter()->sortBy(fn($ev) => $ev['start_at'] ?? Carbon::now($tz));

                            $ahora = Carbon::now($tz);
                            $eventoMasProximo = $eventos->first(function ($ev) use ($ahora) {
                                return optional($ev['start_at'])->isToday()
                                    && optional($ev['start_at'])->greaterThanOrEqualTo($ahora);
                            }) ?? $eventos->first(function ($ev) {
                                return optional($ev['start_at'])->isTomorrow();
                            });
                        @endphp

                        <ul class="timeline list-unstyled mb-5">
                            @forelse($eventos as $evento)
                                <li>
                                    <div class="timeline-time text-end">
                                        <span class="date">
                                            {{ optional($evento['start_at'])->isToday() ? 'Hoy' : optional($evento['start_at'])->translatedFormat('l') }}
                                        </span>
                                        <span class="time d-inline-block">
                                            {{ optional($evento['start_at'])->format('H:i') }}
                                        </span>
                                    </div>
                                    <div class="timeline-icon"></div>
                                    <div class="timeline-body {{ $evento === $eventoMasProximo ? 'bg-outline-secondary' : 'bg-outline-primary' }}">
                                        <a href="javascript:void(0);" data-bs-target="#editShift{{ $evento['id'] }}" data-bs-toggle="modal">
                                            <div class="d-flex align-items-top timeline-main-content flex-wrap mt-0">
                                                <div class="avatar avatar-md me-3 avatar-rounded mt-sm-0 mt-4">
                                                    <span class="avatar avatar-md avatar-rounded bg-primary d-inline-flex align-items-center justify-content-center">
                                                        <i class="ti ti-calendar-event fs-16"></i>
                                                    </span>
                                                </div>
                                                <div class="flex-fill">
                                                    <div class="d-flex align-items-center">
                                                        <div class="mt-sm-0 mt-2">
                                                            <p class="mb-0 fs-14 fw-semibold">{{ $evento['client'] }}</p>
                                                            <p class="mb-0 text-muted">{{ $evento['address'] }}</p>
                                                        </div>
                                                        <div class="ms-auto">
                                                            @php
                                                                $colorEstado = match(strtolower($evento['status'])) {
                                                                    'pending'     => 'bg-secondary',
                                                                    'canceled'    => 'bg-danger',
                                                                    'completed'   => 'bg-success',
                                                                    'rescheduled' => 'bg-warning',
                                                                    default       => 'bg-light text-muted'
                                                                };
                                                                $estadoShift = match(strtolower($evento['status'])) {
                                                                'pending'     => 'Pendiente',
                                                                'canceled'    => 'Cancelado',
                                                                'completed'   => 'Completado',
                                                                'rescheduled' => 'Reagendado',
                                                                default       => $evento['status']
                                                            };
                                                            @endphp
                                                            <span class="float-end badge {{ $colorEstado }} timeline-badge mt-0 mt-sm-0">
                                                                {{ ucfirst($estadoShift) }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </li>
                            @empty
                                <li>
                                    <div class="text-center">
                                        <div class="alert alert-warning text-center mb-3 ms-3 me-3" role="alert">
                                            No hay eventos agendados para esta semana
                                        </div>
                                    </div>
                                </li>
                            @endforelse
                        </ul>
                    </div>
                </div>
            </div>
            <!-- Tabla: Pagos Pendientes -->
            <div class="col-md-5">
                <div class="card custom-card flex-fill" >
                    <div class="card-header d-flex justify-content-between">
                        <p class="card-title fw-semibold fs-18 mb-0">Pagos del Mes + Pendientes</p>
                    </div>
                    <div class="card-body" style="height: 600px; overflow-y: auto;">
                        <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th>Cliente</th>
                                        <th>Fecha Emisión</th>
                                        <th>Estado</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($pagosPendientes as $pago)
                                    @php
                                        $totalPago = $pago->total_amount;
                                    @endphp
                                    <tr>
                                        <td>{{ optional($pago->order)->client_name }}</td>
                                        <td>
                                            @php
                                                $em = $pago->emission_date;
                                                if ($em instanceof \Carbon\Carbon) {
                                                    $emFmt = $em->translatedFormat('d M Y');
                                                } else {
                                                    // recorta si viene con hora o formatos raros
                                                    $emStr = is_string($em) ? trim($em) : (string)$em;
                                                    // si detecta un datetime, lo intenta parsear; si no, usa substr de fecha
                                                    try {
                                                        $emFmt = \Carbon\Carbon::parse($emStr)->translatedFormat('d M Y');
                                                    } catch (\Exception $e) {
                                                        $emFmt = substr($emStr, 0, 10); // Y-m-d
                                                    }
                                                }
                                            @endphp
                                            {{ $emFmt ?: '-' }}
                                        </td>
                                        <td>
                                            @php
                                                $colorEstado = match(strtolower($pago->status)) {
                                                    'pending'     => 'bg-secondary',
                                                    'overdue'    => 'bg-warning',
                                                    'paid'   => 'bg-success',
                                                    'void'   => 'bg-danger',
                                            
                                                    default       => 'bg-light text-muted'
                                                };
                                                $estadopago = match(strtolower($pago->status)) {
                                                    'pending'     => 'Pendiente',
                                                    'overdue'    => 'Atrasado',
                                                    'paid'   => 'Pagado',
                                                    'void'   => 'Anulado',
                                            
                                                    default       => $pago->status
                                                };
                                            @endphp
                                            <a href="javascript:void(0);" data-bs-target="#editPayment{{ $pago->id_payment }}" data-bs-toggle="modal" class="text-decoration-none">
                                                <span class="badge {{ $colorEstado }} timeline-badge mt-0 mt-sm-0">
                                                    {{ ucfirst($estadopago) }}
                                                </span>
                                            </a>
                                           </td>
                                        <td>${{ number_format($totalPago, 0, ',', '.') }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="alert alert-warning text-center mb-3 ms-1 me-1" role="alert">
                                            No hay pagos para mostrar este mes
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

@include('pages.modals.editShiftIdx')
@include('pages.modals.editPaymentIdx')

{{-- Mostrar mensaje de éxito --}}
{{-- @if(session('success'))
    <script>
        alert(@json(session('success')));
    </script>
@endif --}}

{{-- Mostrar mensaje de error --}}
@if($errors->any())
    <script>
        alert(@json($errors->first()));
    </script>
@endif

{{-- Los modales antiguos de sesiones/reuniones no aplican.
     Si agregarás modales para editar turnos/pagos, inclúyelos aquí. --}}
@endsection
