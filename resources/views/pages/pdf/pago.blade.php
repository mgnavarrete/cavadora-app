<!DOCTYPE html>
<html lang="es" dir="ltr" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light" data-menu-styles="dark" data-toggled="close">
    @php
    \Carbon\Carbon::setLocale('es');
    @endphp
    <head>

        <!-- META DATA -->
		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="Description" content="Laravel Bootstrap Responsive Admin Web Dashboard Template">
        <meta name="Author" content="Spruko Technologies Private Limited">
        <meta name="keywords" content="dashboard bootstrap, laravel template, admin panel in laravel, php admin panel, admin panel for laravel, admin template bootstrap 5, laravel admin panel, admin dashboard template, hrm dashboard, vite laravel, admin dashboard, ecommerce admin dashboard, dashboard laravel, analytics dashboard, template dashboard, admin panel template, bootstrap admin panel template">
        
        <!-- TITLE -->
		<title>Pago_{{ $payment->order ? $payment->order->client_name : 'Cliente' }}_{{ ucfirst(\Carbon\Carbon::parse($payment->emission_date)->translatedFormat('F Y')) }}</title>

        <!-- FAVICON -->
        <link rel="icon" href="{{asset('build/assets/images/brand-logos/favicon.png')}}" type="image/x-icon">

        <!-- BOOTSTRAP CSS -->
	    <link  id="style" href="{{asset('build/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- ICONS CSS -->
        <link href="{{asset('build/assets/icon-fonts/icons.css')}}" rel="stylesheet">
        
        <!-- APP SCSS -->
        @vite(['resources/sass/app.scss'])


        @include('layouts.components.styles')

        <!-- MAIN JS -->
        <script src="{{asset('build/assets/main.js')}}"></script>

        <!-- CSS PERSONALIZADO PARA PDF -->
        <style>
            @media print {
                @page {
                    size: letter;
                    margin: 0.5in 0.5in 0.5in 0.5in;
                }
                
                body {
                    font-size: 11px !important;
                    line-height: 1.2 !important;
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                }
                
                .card {
                    box-shadow: none !important;
                    border: none !important;
                    margin: 0 !important;
                    padding: 0 !important;
                }
                
                .card-header, .card-body {
                    padding: 5px !important;
                }
                
                h5, h6 {
                    font-size: 12px !important;
                    margin-bottom: 5px !important;
                }
                
                p, td, th {
                    font-size: 10px !important;
                    margin-bottom: 3px !important;
                    line-height: 1.1 !important;
                }
                
                .table {
                    font-size: 9px !important;
                    margin-bottom: 8px !important;
                }
                
                .table th, .table td {
                    padding: 3px 6px !important;
                    vertical-align: top !important;
                    border: 1px solid #dee2e6 !important;
                }
                
                .fs-15, .fs-16, .fs-17 {
                    font-size: 10px !important;
                }
                
                .mb-1, .mb-2, .mb-3, .mb-4 {
                    margin-bottom: 2px !important;
                }
                
                .mt-3, .mt-4 {
                    margin-top: 8px !important;
                }
                
                .gy-3 > * {
                    margin-bottom: 5px !important;
                }
                
                .avatar {
                    width: 35px !important;
                    height: 35px !important;
                }
                
                .text-truncate {
                    max-width: 150px !important;
                }
                
                /* Ocultar elementos innecesarios en impresión */
                .d-print-none {
                    display: none !important;
                }
                
                /* Asegurar que el contenido no se desborde */
                .container-fluid, .row, .col-xl-12 {
                    max-width: 100% !important;
                    padding: 0 !important;
                    margin: 0 !important;
                }
            }
            
            /* Estilos base para pantalla también */
            body {
                font-size: 12px;
                line-height: 1.3;
            }
            
            .compact-section {
                margin-bottom: 10px;
            }
            
            .compact-table {
                font-size: 11px;
            }
            
            .compact-table th,
            .compact-table td {
                padding: 4px 8px;
                vertical-align: top;
            }
        </style>

        @yield('styles')

	</head>

	<body>


<div class="row">
    <div class="">
        <div class="card custom-card">
            <div class="card-header compact-section">
                <div class="d-flex align-items-center">
                    <div class="avatar avatar-sm me-2">
                        <img src="{{asset('build/assets/images/brand-logos/toggle-logo.png')}}" style="width: 35px; height: 35px;" alt="">
                    </div>
                    <div>
                        <div class="h6 fw-semibold mb-0">PAGO #{{ $payment->id_payment }} - {{ $payment->order ? $payment->order->client_name : 'Cliente' }}</div>
                        <div class="small text-muted">{{ ucfirst(\Carbon\Carbon::parse($payment->emission_date)->translatedFormat('F Y')) }}</div>
                    </div>
                </div>
            </div>
            <div class="card-body compact-section">
                <div class="row gy-3">
                    <div class="col-xl-12">
                        <div class="row">
                            <!-- Información del Cliente y Trabajo -->
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="compact-section">
                                    <h6 class="text-muted mb-1 fw-semibold">CLIENTE</h6>
                                    <p class="fw-bold mb-1">{{ $payment->order ? $payment->order->client_name : 'N/A' }}</p>
                                    <p class="mb-0 small">
                                        <i class="ri-user-line me-1"></i>{{ $payment->order ? $payment->order->cliente_rut : 'N/A' }} | 
                                        <i class="ri-phone-line me-1"></i>{{ $payment->order ? $payment->order->client_phone : 'N/A' }}
                                    </p>
                                    @if($payment->order && $payment->order->client_address)
                                    <p class="mb-0 small"><i class="ri-map-pin-line me-1"></i>{{ \Str::limit($payment->order->client_address, 80) }}</p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Información de la Orden -->
                            <div class="col-xl-6 col-lg-6 col-md-6">
                                <div class="compact-section">
                                    <h6 class="text-muted mb-1 fw-semibold">TRABAJO - ORDEN #{{ $payment->order ? $payment->order->id_order : 'N/A' }}</h6>
                                    <p class="mb-0 small">
                                        <i class="ri-calendar-line me-1"></i>{{ $payment->order && $payment->order->start_date ? $payment->order->start_date->format('d/m/Y') : 'N/A' }} - 
                                        {{ $payment->order && $payment->order->end_date ? $payment->order->end_date->format('d/m/Y') : 'N/A' }}
                                    </p>
                                    @if($payment->order && $payment->order->work_info)
                                    <p class="mb-0 small"><i class="ri-file-text-line me-1"></i>{{ \Str::limit($payment->order->work_info, 120) }}</p>
                                    @endif
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    
                    <!-- Información del Pago -->
                    <div class="compact-section">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                    <div class="text-center">
                                        <small class="text-muted d-block">Estado</small>
                                        <span class="fw-semibold
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
                                    <div class="text-center">
                                        <small class="text-muted d-block">F. Emisión</small>
                                        <span class="fw-semibold">{{ $payment->emission_date ? $payment->emission_date->format('d/m/Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted d-block">F. Pago</small>
                                        <span class="fw-semibold">{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'Pendiente' }}</span>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted d-block">Total</small>
                                        <span class="fw-bold text-success">${{ number_format($totalPago, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Registro de Turnos de Trabajo -->
                    <div class="compact-section">
                        <div class="col-xl-12">
                            <h6 class="fw-semibold mb-1">TURNOS DE TRABAJO</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered compact-table">
                                    <thead class="table-light">
                                        <tr>
                                            <th style="width: 20%;">Fecha</th>
                                            <th style="width: 20%;">Horario</th> 
                                            <th style="width: 40%;">Descripción</th>
                                            <th style="width: 20%;" class="text-end">Horas</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($shifts && $shifts->count() > 0)
                                            @foreach($shifts as $shift)
                                                <tr>
                                                    <td>
                                                        <div class="fw-semibold small">{{ $shift->shift_date ? $shift->shift_date->format('d/m/Y') : 'N/A' }}</div>
                                                        <div class="text-muted" style="font-size: 8px;">{{ $shift->shift_date ? ucfirst($shift->shift_date->translatedFormat('D')) : '' }}</div>
                                                    </td>
                                                    <td class="small">
                                                        @if($shift->start_time && $shift->end_time)
                                                            {{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }} - {{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}
                                                        @else
                                                            <span class="text-muted">Sin horario</span>
                                                        @endif
                                                    </td>
                                                    <td class="small">
                                                        <div class="text-truncate" style="max-width: 120px;" title="{{ $shift->description }}">
                                                            {{ $shift->description ? \Str::limit($shift->description, 60) : 'Sin descripción' }}
                                                        </div>
                                                    </td>
                                                    <td class="text-end small">
                                                        @if($shift->start_time && $shift->end_time)
                                                            @php
                                                                $start = \Carbon\Carbon::parse($shift->start_time);
                                                                $end = \Carbon\Carbon::parse($shift->end_time);
                                                                $duration = $start->diffInHours($end, true);
                                                            @endphp
                                                            {{ number_format($duration, 1) }}h
                                                        @else
                                                            0h
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="4" class="text-center text-muted small">No hay turnos registrados</td>
                                            </tr>
                                        @endif
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td colspan="3" class="text-end fw-semibold small">TOTAL HORAS:</td>
                                            <td class="text-end fw-bold text-success small">
                                                @php
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
                                                {{ number_format($totalHours, 1) }}h
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Desglose de Costos -->
                    <div class="compact-section">
                        <div class="col-xl-12">
                            <h6 class="fw-semibold mb-1">DESGLOSE DE COSTOS</h6>
                            <div class="table-responsive">
                                <table class="table table-bordered compact-table">
                                    <tbody>
                                        <tr>
                                            <td class="small"><i class="ri-time-line me-1"></i><strong>Costo por Hora</strong></td>
                                            <td class="text-end small">${{ number_format($payment->hour_cost ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="small"><i class="ri-calendar-line me-1"></i><strong>Total Horas</strong></td>
                                            <td class="text-end small">{{ number_format($payment->total_hours, 1) }} hrs</td>
                                        </tr>
                                        <tr>
                                            <td class="small"><i class="ri-calculator-line me-1"></i><strong>Subtotal Horas</strong></td>
                                            <td class="text-end small">${{ number_format(($payment->hour_cost ?? 0) * $payment->total_hours, 0, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="small"><i class="ri-add-circle-line me-1"></i><strong>Gastos Extras</strong></td>
                                            <td class="text-end small">${{ number_format($payment->extra_cost ?? 0, 0, ',', '.') }}</td>
                                        </tr>
                                    </tbody>
                                    <tfoot class="table-light">
                                        <tr>
                                            <td class="fw-bold small">TOTAL A PAGAR</td>
                                            <td class="text-end fw-bold text-success small">${{ number_format($totalPago, 0, ',', '.') }}</td>
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
<!-- Script de auto-impresión removido para descarga directa de PDF -->
        @include('layouts.components.scripts')

        @yield('scripts')

        <!-- STICKY JS -->
		<script src="{{asset('build/assets/sticky.js')}}"></script>

        <!-- APP JS -->
		<!--@vite('resources/js/app.js')-->


        <!-- CUSTOM-SWITCHER JS -->
        @vite('resources/assets/js/custom-switcher.js')

        
        <!-- END SCRIPTS -->

	</body>
</html>

