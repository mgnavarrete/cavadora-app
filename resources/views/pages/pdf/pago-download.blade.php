<!DOCTYPE html>
<html lang="es">
    @php
    \Carbon\Carbon::setLocale('es');
    @endphp
    <head>
        <!-- META DATA -->
		<meta charset="UTF-8">
        <meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=no'>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        
        <!-- TITLE -->
		<title>Pago_{{ $payment->order ? $payment->order->client_name : 'Cliente' }}_{{ ucfirst(\Carbon\Carbon::parse($payment->emission_date)->translatedFormat('F Y')) }}</title>

        <!-- BOOTSTRAP CSS -->
	    <link  id="style" href="{{asset('build/assets/libs/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">

        <!-- ICONS CSS -->
        <link href="{{asset('build/assets/icon-fonts/icons.css')}}" rel="stylesheet">
        
        <!-- CSS OPTIMIZADO PARA PDF PROFESIONAL -->
        <style>
            body {
                font-family: 'DejaVu Sans', sans-serif;
                font-size: 10px;
                line-height: 1.3;
                color: #333;
                margin: 0;
                padding: 15px;
                background: #fff;
            }
            
            .header-company {
                text-align: center;
                border-bottom: 3px solid #2c3e50;
                padding-bottom: 15px;
                margin-bottom: 20px;
            }
            
            .company-name {
                font-size: 24px;
                font-weight: bold;
                color: #2c3e50;
                margin: 0;
                letter-spacing: 1px;
            }
            
            .company-subtitle {
                font-size: 12px;
                color: #7f8c8d;
                margin: 5px 0 0 0;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .document-title {
                text-align: center;
                font-size: 16px;
                font-weight: bold;
                color: #34495e;
                margin: 15px 0;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            
            .invoice-number {
                text-align: right;
                font-size: 14px;
                color: #e74c3c;
                font-weight: bold;
                margin-bottom: 10px;
            }
            
            .info-section {
                border: 1px solid #bdc3c7;
                border-radius: 5px;
                padding: 10px;
                margin-bottom: 15px;
                background-color: #f8f9fa;
            }
            
            .info-section h6 {
                background-color: #34495e;
                color: white;
                margin: -10px -10px 8px -10px;
                padding: 8px 10px;
                font-size: 11px;
                font-weight: bold;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-radius: 4px 4px 0 0;
            }
            
            .status-section {
                background-color: #ecf0f1;
                border: 1px solid #bdc3c7;
                border-radius: 5px;
                padding: 10px;
                margin-bottom: 15px;
            }
            
            .section-title {
                font-size: 12px !important;
                margin-bottom: 8px !important;
                font-weight: bold;
                color: #2c3e50;
                text-transform: uppercase;
                letter-spacing: 0.5px;
                border-bottom: 1px solid #bdc3c7;
                padding-bottom: 3px;
            }
            
            p, td, th {
                font-size: 9px !important;
                margin-bottom: 2px !important;
                line-height: 1.1 !important;
            }
            
            .table {
                font-size: 9px !important;
                margin-bottom: 8px !important;
                width: 100%;
                border-collapse: collapse;
                border: 2px solid #34495e;
            }
            
            .table th {
                padding: 6px 8px !important;
                vertical-align: middle !important;
                background-color: #34495e !important;
                color: white !important;
                font-weight: bold !important;
                text-align: center !important;
                border: 1px solid #2c3e50 !important;
                font-size: 9px !important;
            }
            
            .table td {
                padding: 5px 8px !important;
                vertical-align: top !important;
                border: 1px solid #bdc3c7 !important;
                background-color: #fff !important;
            }
            
            .table tbody tr:nth-child(even) td {
                background-color: #f8f9fa !important;
            }
            
            .table tfoot td {
                background-color: #ecf0f1 !important;
                font-weight: bold !important;
                border-top: 2px solid #34495e !important;
            }
            
            .total-row {
                background-color: #27ae60 !important;
                color: white !important;
                font-weight: bold !important;
                font-size: 10px !important;
            }
            
            .fw-semibold, .fw-bold {
                font-weight: bold !important;
            }
            
            .text-success {
                color: #198754 !important;
            }
            
            .text-muted {
                color: #6c757d !important;
            }
            
            .text-primary {
                color: #0d6efd !important;
            }
            
            .text-warning {
                color: #fd7e14 !important;
            }
            
            .text-danger {
                color: #dc3545 !important;
            }
            
            .text-secondary {
                color: #6c757d !important;
            }
            
            .text-end {
                text-align: right !important;
            }
            
            .text-center {
                text-align: center !important;
            }
            
            .small {
                font-size: 8px !important;
            }
            
            .compact-section {
                margin-bottom: 8px;
            }
            
            .compact-table {
                font-size: 8px !important;
            }
            
            .d-flex {
                display: flex !important;
            }
            
            .justify-content-between {
                justify-content: space-between !important;
            }
            
            .align-items-center {
                align-items: center !important;
            }
            
            .border-top {
                border-top: 1px solid #dee2e6 !important;
            }
            
            .pt-2 {
                padding-top: 4px !important;
            }
            
            .mb-0 {
                margin-bottom: 0 !important;
            }
            
            .mb-1 {
                margin-bottom: 2px !important;
            }
            
            .me-1 {
                margin-right: 2px !important;
            }
            
            .me-2 {
                margin-right: 4px !important;
            }
            
            .avatar {
                width: 30px !important;
                height: 30px !important;
                display: inline-block;
            }
            
            .text-truncate {
                overflow: hidden;
                text-overflow: ellipsis;
                white-space: nowrap;
                max-width: 100px;
            }
            
            .row {
                display: flex;
                flex-wrap: wrap;
                margin: 0;
            }
            
            .col-xl-6, .col-lg-6, .col-md-6 {
                flex: 0 0 50%;
                max-width: 50%;
                padding: 0 5px;
            }
            
            .col-xl-12, .col-lg-12, .col-md-12, .col-12 {
                flex: 0 0 100%;
                max-width: 100%;
                padding: 0;
            }
        </style>
	</head>

	<body>
        <!-- Header de la Empresa -->
        <div class="header-company">
            <h1 class="company-name">LA CAVADORA SERVICIOS</h1>
            <p class="company-subtitle">Servicios Profesionales de Excavación</p>
        </div>

        <!-- Título del Documento y Número -->
        <div class="invoice-number">COMPROBANTE DE PAGO N° {{ $payment->id_payment }}</div>
        <div class="document-title">Desglose de Servicios</div>

        <div class="document-content">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="row">
                            <!-- Información del Cliente -->
                            <div class="col-xl-6">
                                <div class="info-section">
                                    <h6>Datos del Cliente</h6>
                                    <p class="fw-bold mb-1" style="font-size: 11px;">{{ $payment->order ? $payment->order->client_name : 'N/A' }}</p>
                                    <p class="mb-1 small">
                                        <strong>RUT:</strong> {{ $payment->order ? $payment->order->cliente_rut : 'N/A' }}
                                    </p>
                                    <p class="mb-1 small">
                                        <strong>Teléfono:</strong> {{ $payment->order ? $payment->order->client_phone : 'N/A' }}
                                    </p>
                                    @if($payment->order && $payment->order->client_address)
                                    <p class="mb-0 small">
                                        <strong>Dirección:</strong> {{ \Str::limit($payment->order->client_address, 50) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                            
                            <!-- Información del Trabajo -->
                            <div class="col-xl-6">
                                <div class="info-section">
                                    <h6>Información del Trabajo</h6>
                                    <p class="mb-1 small">
                                        <strong>Orden N°:</strong> {{ $payment->order ? $payment->order->id_order : 'N/A' }}
                                    </p>
                                    <p class="mb-1 small">
                                        <strong>Período:</strong><br>
                                        {{ $payment->order && $payment->order->start_date ? $payment->order->start_date->format('d/m/Y') : 'N/A' }} - 
                                        {{ $payment->order && $payment->order->end_date ? $payment->order->end_date->format('d/m/Y') : 'N/A' }}
                                    </p>
                                    @if($payment->order && $payment->order->work_info)
                                    <p class="mb-0 small">
                                        <strong>Descripción:</strong><br>{{ \Str::limit($payment->order->work_info, 80) }}
                                    </p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Estado del Pago -->
                    <div class="status-section">
                        <div class="row">
                            <div class="col-12">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-center">
                                        <small class="text-muted" style="font-size: 8px;"><strong>ESTADO</strong></small><br>
                                        <span class="fw-bold" style="font-size: 10px;
                                            @if($payment->status === 'overdue') color: #f39c12;
                                            @elseif($payment->status === 'pending') color: #95a5a6;
                                            @elseif($payment->status === 'paid') color: #27ae60;
                                            @elseif($payment->status === 'void') color: #e74c3c;
                                            @endif">
                                            @if($payment->status === 'pending') PENDIENTE
                                            @elseif($payment->status === 'paid') PAGADO
                                            @elseif($payment->status === 'overdue') ATRASADO
                                            @elseif($payment->status === 'void') ANULADO
                                            @endif
                                        </span>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted" style="font-size: 8px;"><strong>FECHA EMISIÓN</strong></small><br>
                                        <span class="fw-semibold" style="font-size: 10px;">{{ $payment->emission_date ? $payment->emission_date->format('d/m/Y') : 'N/A' }}</span>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted" style="font-size: 8px;"><strong>FECHA PAGO</strong></small><br>
                                        <span class="fw-semibold" style="font-size: 10px;">{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : 'PENDIENTE' }}</span>
                                    </div>
                                    <div class="text-center">
                                        <small class="text-muted" style="font-size: 8px;"><strong>MONTO TOTAL</strong></small><br>
                                        <span class="fw-bold" style="font-size: 12px; color: #27ae60;">${{ number_format($totalPago, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Registro de Turnos de Trabajo -->
                    <div class="compact-section">
                        <div class="col-xl-12">
                            <h6 class="section-title">Detalle de Servicios Prestados</h6>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th style="width: 20%;">FECHA</th>
                                        <th style="width: 25%;">HORARIO</th> 
                                        <th style="width: 35%;">DESCRIPCIÓN</th>
                                        <th style="width: 20%;">HORAS</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($shifts && $shifts->count() > 0)
                                        @foreach($shifts as $shift)
                                            <tr>
                                                <td>
                                                    <div class="fw-semibold">{{ $shift->shift_date ? $shift->shift_date->format('d/m/Y') : 'N/A' }}</div>
                                                    <div style="font-size: 8px; color: #7f8c8d;">{{ $shift->shift_date ? ucfirst($shift->shift_date->translatedFormat('l')) : '' }}</div>
                                                </td>
                                                <td>
                                                    @if($shift->start_time && $shift->end_time)
                                                        <strong>{{ \Carbon\Carbon::parse($shift->start_time)->format('H:i') }}</strong> a <strong>{{ \Carbon\Carbon::parse($shift->end_time)->format('H:i') }}</strong>
                                                    @else
                                                        <span style="color: #95a5a6;">Sin horario definido</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    {{ $shift->description ? \Str::limit($shift->description, 60) : 'Servicio de excavación general' }}
                                                </td>
                                                <td class="text-center">
                                                    @if($shift->start_time && $shift->end_time)
                                                        @php
                                                            $start = \Carbon\Carbon::parse($shift->start_time);
                                                            $end = \Carbon\Carbon::parse($shift->end_time);
                                                            $duration = $start->diffInHours($end, true);
                                                        @endphp
                                                        <strong>{{ number_format($duration, 1) }}</strong>
                                                    @else
                                                        <strong>0.0</strong>
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td colspan="4" class="text-center" style="color: #95a5a6; font-style: italic;">No hay servicios registrados para este período</td>
                                        </tr>
                                    @endif
                                </tbody>
                                <tfoot>
                                    <tr class="total-row">
                                        <td colspan="3" class="text-end"><strong>TOTAL HORAS TRABAJADAS:</strong></td>
                                        <td class="text-center">
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
                                            <strong>{{ number_format($totalHours, 1) }}</strong>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <!-- Desglose de Costos -->
                    <div class="compact-section">
                        <div class="col-xl-12">
                            <h6 class="fw-semibold mb-1">DESGLOSE DE COSTOS</h6>
                            <table class="table table-bordered compact-table">
                                <tbody>
                                    <tr>
                                        <td class="small"><strong>Costo por Hora</strong></td>
                                        <td class="text-end small">${{ number_format($payment->hour_cost ?? 0, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="small"><strong>Total Horas</strong></td>
                                        <td class="text-end small">{{ number_format($payment->total_hours, 1) }} hrs</td>
                                    </tr>
                                    <tr>
                                        <td class="small"><strong>Subtotal Horas</strong></td>
                                        <td class="text-end small">${{ number_format(($payment->hour_cost ?? 0) * $payment->total_hours, 0, ',', '.') }}</td>
                                    </tr>
                                    <tr>
                                        <td class="small"><strong>Gastos Extras</strong></td>
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
    </body>
</html>
