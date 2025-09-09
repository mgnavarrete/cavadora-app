@extends('layouts.master')

@section('styles')
<!-- DATE & TIME PICKER JS -->
<script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('build/assets/libs/flatpickr/l10n/es.js')}}"></script>
@vite('resources/assets/js/date&time_pickers.js')

<!-- FULL CALENDAR CSS -->
<link rel="stylesheet" href="{{asset('build/assets/libs/fullcalendar/main.min.css')}}">
<style>
    .fc-event {
        cursor: pointer;
    }
    
    /* Asegurar texto blanco para eventos de turnos */
    .fc-event-title {
        color: #ffffff !important;
        font-weight: 600;
        text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
    }
</style>
@endsection


@section('content')

@php
    \Carbon\Carbon::setLocale('es');
    $hrInicio = '07:00:00';
    $hrFin = '08:30:00';
    $currentYear = now()->year; // Obtener el año actual
@endphp

<div class="container-fluid">

    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Calendario</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Calendario</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <!-- Start::row-1 -->
    <div class="row">
                <div class="col-xl-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <div class="card-title">Semana

                    </div>
                    <div class="dropdown ms-2">
                        <button class="btn btn-light btn-wave waves-effect waves-light px-2 w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="ri-add-line align-middle me-1 fw-semibold d-inline-block fs-18"></i>Crear
                        </button>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('orders.create') }}">Nueva Orden</a></li>
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createShift">Nuevo Turno</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div id='calendar2'></div>
                </div>
            </div>
        </div>
    </div>
    <!--End::row-1 -->
  </div>
  {{-- Modal para editar turnos desde calendario --}}
  @include('pages.modals.editShiftCalendar')
@endsection

@section('scripts')

<!-- MOMENT JS -->
<script src="{{asset('build/assets/libs/moment/moment.js')}}"></script>

<!-- FULLCALENDAR JS -->
<script src="{{asset('build/assets/libs/fullcalendar/main.min.js')}}"></script>
@vite('resources/assets/js/fullcalendar.js')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar2');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            locale: 'es',
            firstDay: 1,
            initialView: 'dayGridMonth',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: 'dayGridMonth,timeGridWeek,timeGridDay,listMonth'
            },
            buttonText: {
                today: 'Hoy',
                month: 'Mes',
                week: 'Semana',
                day: 'Día',
                list: 'Lista'
 
            },
            slotMinTime: '06:00:00',
            slotMaxTime: '20:00:00',
            slotDuration: '00:15:00',
            slotLabelInterval: '01:00',
            displayEventTime: true,
            titleFormat: {
                month: 'long',
                year: 'numeric'
            },
            events: [
                // Solo Turnos de trabajo (sesiones específicas) - COLORES POR ESTADO
                @if(isset($shifts))
                    @foreach($shifts as $shift)
                        @if($shift->status !== 'reagendada')
                        {
                            title: '⚒️ {{ $shift->order->client_name ?? "Turno" }} - {{ $shift->responsible ?? "Sin responsable" }}',
                            start: '{{ $shift->shift_date ? $shift->shift_date->format("Y-m-d") : "" }}T{{ $shift->start_time ? \Carbon\Carbon::parse($shift->start_time)->format("H:i") : "08:00" }}',
                            end: '{{ $shift->shift_date ? $shift->shift_date->format("Y-m-d") : "" }}T{{ $shift->end_time ? \Carbon\Carbon::parse($shift->end_time)->format("H:i") : "17:00" }}',
                            color: '{{ $shift->status == "completed" ? "#28a745" : ($shift->status == "pending" ? "#17a2b8" : ($shift->status == "cancelled" ? "#dc3545" : "#17a2b8")) }}',
                            textColor: '#ffffff',
                            display: 'block',
                            id: '{{ $shift->id_shift }}',
                            tipo: 'shift',
                            description: '{{ $shift->description ?? "" }}',
                            orderId: '{{ $shift->id_order }}',
                            status: '{{ $shift->status }}',
                            statusText: '{{ $shift->status == "completed" ? "Completado" : ($shift->status == "pending" ? "Pendiente" : ($shift->status == "cancelled" ? "Cancelado" : "Pendiente")) }}',
                            responsible: '{{ $shift->responsible ?? "" }}'
                        },
                        @endif
                    @endforeach
                @endif
            ],
            eventClick: function(info) {
                // Solo maneja clicks en turnos (shifts) - Abrir modal de edición
                if (info.event.extendedProps.tipo === 'shift') {
                    // Calcular duración
                    var start = info.event.start;
                    var end = info.event.end;
                    var duration = '';
                    
                    if (start && end) {
                        var diffMs = end - start;
                        var diffHours = Math.round(diffMs / (1000 * 60 * 60) * 10) / 10;
                        duration = diffHours + ' horas';
                    }
                    
                    // Extraer datos del evento
                    var shiftData = {
                        id: info.event.id,
                        orderId: info.event.extendedProps.orderId,
                        clientName: info.event.title.split(' - ')[0].replace('⚒️ ', ''),
                        responsible: info.event.title.split(' - ')[1] || 'Sin responsable',
                        date: info.event.start.toLocaleDateString('es-ES', {
                            weekday: 'long',
                            year: 'numeric',
                            month: 'long',
                            day: 'numeric'
                        }),
                        time: info.event.start.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'}) + 
                              ' - ' + 
                              info.event.end.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'}),
                        duration: duration,
                        status: info.event.extendedProps.status,
                        statusText: info.event.extendedProps.statusText,
                        description: info.event.extendedProps.description || ''
                    };
                    
                    // Abrir modal con datos del turno
                    openShiftModal(shiftData);
                }
            },
            
            // Tooltip mejorado al hacer hover
            eventMouseEnter: function(info) {
                // Calcular duración
                var duration = '';
                if (info.event.start && info.event.end) {
                    var diffMs = info.event.end - info.event.start;
                    var diffHours = Math.round(diffMs / (1000 * 60 * 60) * 10) / 10;
                    duration = diffHours + ' horas';
                }
                
                // Obtener estado en español
                var statusText = '';
                switch(info.event.extendedProps.status) {
                    case 'completed': statusText = 'Completado'; break;
                    case 'in_progress': statusText = 'En Proceso'; break;
                    case 'pending': statusText = 'Pendiente'; break;
                    case 'cancelled': statusText = 'Cancelado'; break;
                    default: statusText = 'Pendiente';
                }
                
                // Crear tooltip con información completa
                var tooltip = document.createElement('div');
                tooltip.className = 'fc-tooltip';
                tooltip.innerHTML = `
                    <div style="font-weight: bold; margin-bottom: 8px; border-bottom: 1px solid #555; padding-bottom: 5px;">
                        ${info.event.title}
                    </div>
                    <div style="margin-bottom: 4px;">
                        <strong>📅 Fecha:</strong> ${info.event.start.toLocaleDateString('es-ES')}
                    </div>
                    <div style="margin-bottom: 4px;">
                        <strong>🕐 Horario:</strong> ${info.event.start.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'})} - ${info.event.end.toLocaleTimeString('es-ES', {hour: '2-digit', minute:'2-digit'})}
                    </div>
                    <div style="margin-bottom: 4px;">
                        <strong>⏱️ Duración:</strong> ${duration}
                    </div>
                    <div style="margin-bottom: 4px;">
                        <strong>📊 Estado:</strong> <span style="color: ${info.event.backgroundColor};">●</span> ${statusText}
                    </div>
                    ${info.event.extendedProps.description ? `
                    <div style="margin-top: 8px; padding-top: 5px; border-top: 1px solid #555;">
                        <strong>📝 Descripción:</strong><br>
                        <span style="font-size: 11px; opacity: 0.9;">${info.event.extendedProps.description}</span>
                    </div>` : ''}
                    <div style="margin-top: 8px; font-size: 10px; opacity: 0.7; text-align: center;">
                        Haz clic para editar
                    </div>
                `;
                
                tooltip.style.position = 'absolute';
                tooltip.style.zIndex = '10001';
                tooltip.style.backgroundColor = '#2c3e50';
                tooltip.style.color = '#fff';
                tooltip.style.padding = '12px';
                tooltip.style.borderRadius = '8px';
                tooltip.style.fontSize = '12px';
                tooltip.style.maxWidth = '280px';
                tooltip.style.boxShadow = '0 4px 12px rgba(0,0,0,0.3)';
                tooltip.style.border = '1px solid #34495e';
                tooltip.style.lineHeight = '1.4';
                
                document.body.appendChild(tooltip);
                
                info.el.addEventListener('mousemove', function(e) {
                    tooltip.style.left = e.pageX + 15 + 'px';
                    tooltip.style.top = e.pageY + 15 + 'px';
                });
                
                info.el.tooltip = tooltip;
            },
            
            eventMouseLeave: function(info) {
                if (info.el.tooltip) {
                    document.body.removeChild(info.el.tooltip);
                    info.el.tooltip = null;
                }
            } 
        });
        calendar.render();
    });
</script>
{{-- Modales comentados para la nueva plataforma --}}
{{-- @include('pages.modals.createOrder') --}}
{{-- @include('pages.modals.createShiftModal') --}}
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
@endsection

@section('scripts')

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