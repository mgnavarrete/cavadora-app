@extends('layouts.master')

@section('content')
@php
\Carbon\Carbon::setLocale('es');
@endphp

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">
            Pago - {{ $payment->order ? $payment->order->client_name : 'Cliente' }} 
            - {{ ucfirst(\Carbon\Carbon::parse($payment->emission_date)->translatedFormat('F Y')) }}
        </h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{ route('payments.index') }}">Pagos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Detalles del Pago</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
        <div class="">
            <div class="card custom-card">
                <div class="card-header d-md-flex d-block">
                    <div class="h5 mb-0 d-sm-flex d-bllock align-items-center">
                        <div class="avatar avatar-sm me-2 ms-1">
                            <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" style="width: 50px; height: 100%;" alt="">
                        </div>
                        <div class="ms-sm-2 ms-0 mt-sm-0 mt-2">
                            <div class="h6 fw-semibold mb-0">DETALLES DEL PAGO : <span class="text-primary">#{{ $payment->id_payment }}</span></div>
                        </div>
                    </div>
                    <div class="ms-auto mt-md-0 mt-2">
                        <button class="btn btn-success" onclick="window.open('{{ route('payments.pdf', $payment->id_payment) }}', '_blank')">
                            Imprimir PDF <i class="ri-printer-line ms-1 align-middle"></i>
                        </button>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#editPayment{{ $payment->id_payment }}">
                            Editar Pago<i class="ri-edit-line ms-1 align-middle"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row gy-3">
                        <div class="col-xl-12">
                            <div class="row">
                                <!-- Información del Cliente -->
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <p class="text-muted mb-2">
                                        Datos del Cliente :
                                    </p>
                                    <p class="fw-bold mb-1">
                                        {{ $payment->order ? $payment->order->client_name : 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="ri-user-line me-1"></i>
                                        {{ $payment->order ? $payment->order->cliente_rut : 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="ri-phone-line me-1"></i>
                                        {{ $payment->order ? $payment->order->client_phone : 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="ri-mail-line me-1"></i>
                                        {{ $payment->order ? $payment->order->cliente_email : 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="ri-map-pin-line me-1"></i>
                                        {{ $payment->order ? $payment->order->client_address : 'N/A' }}
                                    </p>
                                </div>
                                
                                <!-- Información de la Orden -->
                                <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6">
                                    <p class="text-muted mb-2">
                                        Información del Trabajo :
                                    </p>
                                    <p class="fw-bold mb-1">
                                        Orden #{{ $payment->order ? $payment->order->id_order : 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="ri-calendar-line me-1"></i>
                                        <strong>Inicio:</strong> {{ $payment->order && $payment->order->start_date ? $payment->order->start_date->format('d/m/Y') : 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="ri-calendar-check-line me-1"></i>
                                        <strong>Fin:</strong> {{ $payment->order && $payment->order->end_date ? $payment->order->end_date->format('d/m/Y') : 'N/A' }}
                                    </p>
                                    <p class="mb-1">
                                        <i class="ri-file-text-line me-1"></i>
                                        <strong>Descripción:</strong> {{ $payment->order && $payment->order->work_info ? rtrim($payment->order->work_info, '.') : 'N/A' }}
                                    </p>
                                </div>
                                
                            </div>
                        </div>
                        
                        <!-- Información del Pago -->
                        <div class="row gy-3 mt-3">
                            <div class="col-xl-12">
                                <div class="row">
                                    <div class="col-md-3">
                                        <p class="fw-semibold text-muted mb-1">Estado del Pago :</p>
                                        <span class="fs-17 mb-1 fw-semibold
                                            @if($payment->status === 'overdue') text-warning
                                            @elseif($payment->status === 'pending') text-secondary
                                            @elseif($payment->status === 'paid') text-success
                                            @elseif($payment->status === 'void') text-danger
                                            @endif">
                                            @if($payment->status === 'pending') Pendiente
                                            @elseif($payment->status === 'paid') Pagado
                                            @elseif($payment->status === 'overdue') Atrasado
                                            @elseif($payment->status === 'void') Anulado
                                            @endif
                                        </span>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="fw-semibold text-muted mb-1">Fecha de Emisión :</p>
                                        <p class="fs-15 mb-1">{{ $payment->emission_date ? $payment->emission_date->format('d/m/Y') : 'N/A' }}</p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="fw-semibold text-muted mb-1">Fecha de Pago :</p>
                                        <p class="fs-15 mb-1">
                                            {{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'Pendiente' }}
                                        </p>
                                    </div>
                                    <div class="col-md-3">
                                        <p class="fw-semibold text-muted mb-1">Valor Total:</p>
                                        <p class="fs-16 mb-1 fw-semibold text-success">${{ number_format($totalPago, 0, ',', '.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Registro de Turnos de Trabajo -->
                        <div class="row mt-4">
                            <div class="col-xl-12">
                                <h5 class="fw-semibold mb-3">Registro de Turnos de Trabajo</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered mt-4">
                                        <thead class="table-light">
                                            <tr>
                                                <th>Fecha</th>
                                                <th>Horario</th> 
                                                <th>Responsable</th>
                                                <th>Descripción</th>
                                                <th>Estado</th>
                                                <th class="text-end" >Horas trabajadas</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if($shifts && $shifts->count() > 0)
                                                @foreach($shifts as $shift)
                                                    <tr>
                                                        <td>
                                                            <div class="fw-semibold">
                                                                {{ $shift->shift_date ? $shift->shift_date->format('d/m/Y') : 'N/A' }}
                                                            </div>
                                                            <div class="text-muted fs-12">
                                                                {{ $shift->shift_date ? ucfirst($shift->shift_date->translatedFormat('l')) : '' }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            @if($shift->start_time && $shift->end_time)
                                                                <i class="ri-time-line me-1"></i>
                                                                {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - 
                                                                {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                                            @else
                                                                <span class="text-muted">Sin horario definido</span>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <div class="d-flex align-items-center">
                                                                <i class="ri-user-3-line me-2"></i>
                                                                {{ $shift->responsible ?? 'No asignado' }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <div class="text-truncate" style="max-width: 200px;" title="{{ $shift->description }}">
                                                                {{ $shift->description ?? 'Sin descripción' }}
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <span class="badge 
                                                                @if($shift->status === 'completed') bg-success
                                                                @elseif($shift->status === 'in_progress') bg-info
                                                                @elseif($shift->status === 'pending') bg-warning
                                                                @elseif($shift->status === 'cancelled') bg-danger
                                                                @else bg-secondary
                                                                @endif">
                                                                @if($shift->status === 'completed') Completado
                                                                @elseif($shift->status === 'in_progress') En Proceso
                                                                @elseif($shift->status === 'pending') Pendiente
                                                                @elseif($shift->status === 'cancelled') Cancelado
                                                                @else {{ ucfirst($shift->status) }}
                                                                @endif
                                                            </span>
                                                        </td>
                                                        <td class="text-end">
                                                            @if($shift->start_time && $shift->end_time)
                                                                @php
                                                                    $start = \Carbon\Carbon::parse($shift->start_time);
                                                                    $end = \Carbon\Carbon::parse($shift->end_time);
                                                                    $duration = $start->diffInHours($end, true);
                                                                @endphp
                                                                {{ number_format($duration, 1) }} horas
                                                            @else
                                                                0 horas
                                                            @endif
                                                        </td>
                                                            

                                                       
                                                    </tr>
                                                @endforeach
                                            @else
                                                <tr>
                                                    <td colspan="6" class="text-center text-muted">
                                                        <i class="ri-calendar-line fs-18 mb-2 d-block"></i>
                                                        No hay turnos registrados para esta orden
                                                    </td>
                                                </tr>
                                            @endif
                                        </tbody>
                                        <tfoot class="table-light">
                                       
                                            <tr>
                                                <td colspan="5"></td>
                                                <td>
                                                    <table class="table table-sm text-nowrap mb-0 table-borderless">
                                                        <tbody>
                                                            @php
                                                                $totalShifts = $shifts ? $shifts->count() : 0;
                                                                $completedShifts = $shifts ? $shifts->where('status', 'completed')->count() : 0;
                                                                $pendingShifts = $shifts ? $shifts->where('status', 'pending')->count() : 0;
                                                                $totalHours = 0;
                                                                
                                                                if ($shifts) {
                                                                    foreach ($shifts as $shift) {
                                                                        if ($shift->start_time && $shift->end_time) {
                                                                            $start = \Carbon\Carbon::parse($shift->start_time);
                                                                            $end = \Carbon\Carbon::parse($shift->end_time);
                                                                            $totalHours += $start->diffInHours($end, true);
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                        
                                                            <tr>
                                                                <th scope="row">
                                                                    <p class="mb-0">Horas Trabajadas :</p>
                                                                </th>
                                                                <td class="text-end">
                                                                    <p class="mb-0 fw-semibold fs-15 text-success">{{ number_format($totalHours, 1) }} hrs</p>
                                                                </td>
                                                            </tr>
                                                           
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Desglose de Costos -->
                        <div class="row mt-4">
                            <div class="col-xl-12">
                                <h5 class="fw-semibold mb-3">Desglose de Costos</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="table-light">
                                            <tr>
                                                
                                                <th>Tipo de Costo</th>
                                                <th>Descripción</th>
                                                <th class="text-end">Valor</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                    <i class="ri-user-line me-2 text-primary"></i>
                                                    <strong>Mano de Obra</strong>
                                                </td>
                                                <td>Costo de personal y trabajadores</td>
                                                <td class="text-end">${{ number_format($payment->labor_cost ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="ri-settings-line me-2 text-warning"></i>
                                                    <strong>Maquinaria</strong>
                                                </td>
                                                <td>Costo de equipos y maquinaria utilizada</td>
                                                <td class="text-end">${{ number_format($payment->machine_cost ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="ri-gas-station-line me-2 text-info"></i>
                                                    <strong>Combustible</strong>
                                                </td>
                                                <td>Gastos en combustible y lubricantes</td>
                                                <td class="text-end">${{ number_format($payment->fuel_expenses ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="ri-add-circle-line me-2 text-secondary"></i>
                                                    <strong>Gastos Extras</strong>
                                                </td>
                                                <td>{{ $payment->info_extra_cost ?? 'Gastos adicionales varios' }}</td>
                                                <td class="text-end">${{ number_format($payment->extra_cost ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                        </tbody>
                                        <tfoot class="table-light">
                                       
                                            <tr>
                                                <td colspan="2"></td>
                                                <td>
                                                    <table class="table table-sm text-nowrap mb-0 table-borderless">
                                                        <tbody>
                                                        
                                                            <tr>
                                                                <th scope="row">
                                                                    <p class="mb-0">Costo Total :</p>
                                                                </th>
                                                                <td class="text-end">
                                                                    <p class="mb-0 fw-semibold fs-15 text-success"><strong>${{ number_format($totalPago, 0, ',', '.') }}</p>
                                                                </td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </td>
                                            </tr>
                                        </tfoot>
                                    </table>
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

{{-- Modales necesarios --}}
@include('pages.modals.editPaymentShowModal')

@endsection

@section('scripts')
<script>
    // Función para ver detalles del turno
    function viewShiftDetails(shiftId) {
        // Aquí puedes implementar la lógica para mostrar detalles del turno
        console.log('Ver detalles del turno:', shiftId);
    }
</script>
@endsection