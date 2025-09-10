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

        @yield('styles')

	</head>

	<body>


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
                        <div class="h6 mb-0">{{ $payment->order ? $payment->order->client_name : 'Cliente' }} - {{ ucfirst(\Carbon\Carbon::parse($payment->emission_date)->translatedFormat('F Y')) }}</div>
                    </div>
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
                                    <strong>Descripción:</strong> {{ $payment->order && $payment->order->work_info ? \Str::limit($payment->order->work_info, 100) : 'N/A' }}
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
                                      
                                            <th>Descripción</th>
                                         
                                            <th class="text-end">Horas trabajadas</th>
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
                                                        <div class="text-truncate" style="max-width: 200px;" title="{{ $shift->description }}">
                                                            {{ $shift->description ?? 'Sin descripción' }}
                                                        </div>
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
                                                    <i class="ri-time-line me-2 text-primary"></i>
                                                    <strong>Costo por Hora</strong>
                                                </td>
                                                <td>Valor por hora de trabajo</td>
                                                <td class="text-end">${{ number_format($payment->hour_cost ?? 0, 0, ',', '.') }}</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="ri-calendar-line me-2 text-info"></i>
                                                    <strong>Total Horas Trabajadas</strong>
                                                </td>
                                                <td>Suma de todas las horas de los turnos</td>
                                                <td class="text-end">{{ number_format($payment->total_hours, 1) }} hrs</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <i class="ri-calculator-line me-2 text-success"></i>
                                                    <strong>Subtotal por Horas</strong>
                                                </td>
                                                <td>Costo por hora × Total horas</td>
                                                <td class="text-end">${{ number_format(($payment->hour_cost ?? 0) * $payment->total_hours, 0, ',', '.') }}</td>
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
                                                                <p class="mb-0 fw-semibold fs-15 text-success"><strong>${{ number_format($totalPago, 0, ',', '.') }}</strong></p>
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
<script>
    // Espera a que la página se cargue completamente
    window.onload = function() {
        // Llama a la función de impresión
        window.print();
    };
</script>
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

