@extends('layouts.master')

@section('styles')
<style>
    /* Estilos para el carrusel de órdenes */
    #ordersCarousel .carousel-control-prev,
    #ordersCarousel .carousel-control-next {
        width: 50px;
        height: 50px;
        background-color: rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    #ordersCarousel .carousel-control-prev:hover,
    #ordersCarousel .carousel-control-next:hover {
        opacity: 1;
        background-color: rgba(0, 0, 0, 0.2);
    }

    #ordersCarousel .carousel-control-prev {
        left: 15px;
    }

    #ordersCarousel .carousel-control-next {
        right: 15px;
    }

    #ordersCarousel .carousel-inner {
        padding: 0 20px;
    }

    /* Mejorar la apariencia de las cards en el carrusel */
    .team-member-card {
        border: 1px solid #e9ecef;
        border-radius: 8px;
        overflow: hidden;
    }

    .team-member-card:hover {
        border-color: #007bff;
    }

    /* Indicadores del carrusel */
    #ordersCarousel .carousel-indicators {
        bottom: -50px;
    }

    #ordersCarousel .carousel-indicators button {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        margin: 0 5px;
        background-color: #dee2e6;
        border: none;
    }

    #ordersCarousel .carousel-indicators button.active {
        background-color: #007bff;
    }

    /* Responsive para móviles */
    @media (max-width: 768px) {
        #ordersCarousel .carousel-control-prev,
        #ordersCarousel .carousel-control-next {
            width: 40px;
            height: 40px;
        }
        
        #ordersCarousel .carousel-control-prev {
            left: 10px;
        }

        #ordersCarousel .carousel-control-next {
            right: 10px;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const filterDropdown = document.getElementById('filterDropdown');
    const filterText = document.getElementById('filterText');
    const filterOptions = document.querySelectorAll('.filter-option');
    const carousel = document.getElementById('ordersCarousel');
    const carouselInner = carousel.querySelector('.carousel-inner');
    
    // Datos de las órdenes (se pasan desde PHP)
    const ordenesActivas = @json($ordenesActivas);
    
    // Función para filtrar y regenerar el carrusel
    function filterCarousel(filter) {
        let filteredOrders = ordenesActivas;
        
        if (filter !== 'all') {
            filteredOrders = ordenesActivas.filter(orden => orden.estado === filter);
        }
        
        // Generar chunks de 3
        const chunks = [];
        for (let i = 0; i < filteredOrders.length; i += 3) {
            chunks.push(filteredOrders.slice(i, i + 3));
        }
        
        // Limpiar carrusel actual
        carouselInner.innerHTML = '';
        
        if (chunks.length === 0) {
            carouselInner.innerHTML = `
                <div class="carousel-item active">
                    <div class="row g-3 p-3">
                        <div class="col-12 text-center">
                            <div class="alert alert-info">
                                No hay órdenes con este filtro
                            </div>
                        </div>
                    </div>
                </div>
            `;
        } else {
            // Generar nuevo carrusel
            chunks.forEach((chunk, index) => {
                const carouselItem = document.createElement('div');
                carouselItem.className = `carousel-item ${index === 0 ? 'active' : ''}`;
                
                let rowContent = '<div class="row g-3 p-3">';
                
                chunk.forEach(orden => {
                    const estadoColor = getEstadoColor(orden.estado);
                    const estadoTexto = getEstadoTexto(orden.estado);
                    
                    rowContent += `
                        <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                            <a href="/orders/${orden.id_order}" class="text-decoration-none">
                                <div class="card custom-card team-member-card" style="height: 250px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    <div class="teammember-cover-image">
                                        <img src="/build/assets/images/profile/machine.jpg" class="object-fit-cover card-img-top" style="height: 80px;">
                                    </div>
                                    <div class="card-body p-3 h-100">
                                        <div class="d-flex justify-content-between align-items-start mb-3">
                                            <h6 class="mb-0 fw-semibold fs-15 text-dark">${orden.client_name}</h6>
                                            <span class="badge ${estadoColor} fs-10">${estadoTexto}</span>
                                        </div>
                                        <div class="row g-2">
                                            <div class="col-6">
                                                ${orden.cliente_rut ? `
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="ti ti-id fs-12 text-muted me-2"></i>
                                                        <span class="fs-12 text-muted">${orden.cliente_rut}</span>
                                                    </div>
                                                ` : ''}
                                                ${orden.client_phone ? `
                                                    <div class="d-flex align-items-center mb-2">
                                                        <i class="ti ti-phone fs-12 text-muted me-2"></i>
                                                        <span class="fs-12 text-muted">${orden.client_phone}</span>
                                                    </div>
                                                ` : ''}
                                                ${orden.client_address ? `
                                                    <div class="d-flex align-items-start">
                                                        <i class="ti ti-map-pin fs-12 text-muted me-2 mt-1"></i>
                                                        <span class="fs-12 text-muted">${orden.client_address.length > 20 ? orden.client_address.substring(0, 20) + '...' : orden.client_address}</span>
                                                    </div>
                                                ` : ''}
                                            </div>
                                            <div class="col-6">
                                                ${orden.work_info ? `
                                                    <div class="d-flex align-items-start h-100">
                                                        <i class="ti ti-tools fs-12 text-primary me-2 mt-1"></i>
                                                        <div class="flex-grow-1">
                                                            <p class="mb-1 fs-11 fw-semibold text-primary">Trabajo:</p>
                                                            <p class="mb-0 fs-12 text-muted lh-sm">${orden.work_info}</p>
                                                        </div>
                                                    </div>
                                                ` : `
                                                    <div class="d-flex align-items-center justify-content-center h-100">
                                                        <span class="fs-12 text-muted">Sin información de trabajo</span>
                                                    </div>
                                                `}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    `;
                });
                
                rowContent += '</div>';
                carouselItem.innerHTML = rowContent;
                carouselInner.appendChild(carouselItem);
            });
        }
        
        // Reiniciar carrusel con velocidad lenta
        const bsCarousel = new bootstrap.Carousel(carousel, { 
            interval: 8000, // 8 segundos entre transiciones
            wrap: true,
            touch: true
        });
    }
    
    // Funciones auxiliares para colores y textos
    function getEstadoColor(estado) {
        const colors = {
            'not_confirmed': 'bg-warning',
            'confirmed': 'bg-info',
            'in_progress': 'bg-primary',
            'done': 'bg-success',
            'canceled': 'bg-danger'
        };
        return colors[estado] || 'bg-secondary';
    }
    
    function getEstadoTexto(estado) {
        const textos = {
            'not_confirmed': 'No Confrimada',
            'confirmed': 'Confirmada',
            'in_progress': 'En Progreso',
            'done': 'Completado',
            'canceled': 'Cancelado'
        };
        return textos[estado] || estado;
    }
    
    // Event listeners para los filtros
    filterOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const filter = this.getAttribute('data-filter');
            const text = this.textContent;
            
            filterText.textContent = text;
            filterCarousel(filter);
        });
    });
});
</script>
@endsection

@section('content')

@php
    \Carbon\Carbon::setLocale('es');
@endphp

<div class="container-fluid">

<!-- Page Header -->
<div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
    <h1 class="page-title fw-semibold fs-18 mb-0">¡Hola 👋, @auth{{Auth::user()->name}}@endauth!</h1>
    <div class="ms-md-1 ms-0 d-flex align-items-center">
      
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

    <!-- Carrusel de Órdenes Activas -->
    @if($ordenesActivas->count() > 0)
    <div class="row mb-4">
        <div class="col-12">
            <div class="card custom-card border-0 bg-transparent">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title fw-semibold fs-18 mb-0">Órdenes Activas</h5>
                    <div class="d-flex align-items-center gap-2">
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ti ti-filter me-1"></i>
                                <span id="filterText">Todas</span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                                <li><a class="dropdown-item filter-option" href="#" data-filter="all">Todas</a></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="not_confirmed">No Confirmadas</a></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="confirmed">Confirmadas</a></li>
                                <li><a class="dropdown-item filter-option" href="#" data-filter="in_progress">En Progreso</a></li>
                            </ul>
                        </div>
                        <a href="{{ route('orders.index') }}" class="btn btn-sm btn-primary">Ver Todas</a>
                    </div>
                </div>
                <div class="card-body p-0">
                    <div id="ordersCarousel" class="carousel slide border-0" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-inner">
                            @php
                                $chunks = $ordenesActivas->chunk(3); // 3 cards por slide
                            @endphp
                            @foreach($chunks as $index => $chunk)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="row g-3 p-3">
                                        @foreach($chunk as $cliente)
                                            @php
                                                $estadoColor = match(strtolower($cliente->estado)) {
                                                    'not_confirmed' => 'bg-warning',
                                                    'confirmed' => 'bg-info',
                                                    'in_progress' => 'bg-primary',
                                                    'done' => 'bg-success',
                                                    'canceled' => 'bg-danger',
                                                    default => 'bg-secondary'
                                                };
                                                $estadoTexto = match(strtolower($cliente->estado)) {
                                                    'not_confirmed' => 'No Confrimada',
                                                    'confirmed' => 'Confirmada',
                                                    'in_progress' => 'En Progreso',
                                                    'done' => 'Completado',
                                                    'canceled' => 'Cancelado',
                                                    default => ucfirst($cliente->estado)
                                                };
                                            @endphp
                                            <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12">
                                                <a href="{{ route('orders.show', $cliente->id_order) }}" class="text-decoration-none">
                                                    <div class="card custom-card team-member-card" style="height: 250px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <div class="teammember-cover-image">
                                                            <img src="{{asset('build/assets/images/profile/machine.jpg')}}" class="object-fit-cover card-img-top" style="height: 80px;">
                                                        </div> 
                                                        <div class="card-body p-3 h-100">
                                                            <!-- Header con estado y nombre -->
                                                            <div class="d-flex justify-content-between align-items-start mb-3">
                                                                <h6 class="mb-0 fw-semibold fs-15 text-dark">{{ $cliente->client_name }}</h6>
                                                                <span class="badge {{ $estadoColor }} fs-10">{{ $estadoTexto }}</span>
                                                            </div>
                                                            
                                                            <!-- Contenido en dos columnas -->
                                                            <div class="row g-2">
                                                                <!-- Columna izquierda: Información de contacto -->
                                                                <div class="col-6">
                                                                    @if($cliente->cliente_rut)
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <i class="ti ti-id fs-12 text-muted me-2"></i>
                                                                            <span class="fs-12 text-muted">{{ $cliente->cliente_rut }}</span>
                                                                        </div>
                                                                    @endif
                                                                    @if($cliente->client_phone)
                                                                        <div class="d-flex align-items-center mb-2">
                                                                            <i class="ti ti-phone fs-12 text-muted me-2"></i>
                                                                            <span class="fs-12 text-muted">{{ $cliente->client_phone }}</span>
                                                                        </div>
                                                                    @endif
                                                                    @if($cliente->client_address)
                                                                        <div class="d-flex align-items-start">
                                                                            <i class="ti ti-map-pin fs-12 text-muted me-2 mt-1"></i>
                                                                            <span class="fs-12 text-muted">{{ Str::limit($cliente->client_address, 20) }}</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                                
                                                                <!-- Columna derecha: Información de trabajo -->
                                                                <div class="col-6">
                                                                    @if($cliente->work_info)
                                                                        <div class="d-flex align-items-start h-100">
                                                                            <i class="ti ti-tools fs-12 text-primary me-2 mt-1"></i>
                                                                            <div class="flex-grow-1">
                                                                                <p class="mb-1 fs-11 fw-semibold text-primary">Trabajo:</p>
                                                                                <p class="mb-0 fs-12 text-muted lh-sm">{{ $cliente->work_info }}</p>
                                                                            </div>
                                                                        </div>
                                                                    @else
                                                                        <div class="d-flex align-items-center justify-content-center h-100">
                                                                            <span class="fs-12 text-muted">Sin información de trabajo</span>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        @if($chunks->count() > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#ordersCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Anterior</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#ordersCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Siguiente</span>
                            </button>
                            <div class="carousel-indicators">
                                @foreach($chunks as $index => $chunk)
                                    <button type="button" data-bs-target="#ordersCarousel" data-bs-slide-to="{{ $index }}" class="{{ $index === 0 ? 'active' : '' }}" aria-current="{{ $index === 0 ? 'true' : 'false' }}" aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
   
    <div class="container-fluid">
        <div class="row">
           <!-- Timeline: Próximos Eventos (Turnos) -->
            <div class="col-md-7">
                <div class="card custom-card flex-fill timeline-container">
                    <div class="card-header d-flex justify-content-between">
                        <p class="card-title fw-semibold fs-18 mb-0">Próximos Turnos</p>
                        <div class="dropdown ms-2">
                            <button class="btn btn-light btn-wave waves-effect waves-light px-2 w-100" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="ri-add-line align-middle me-1 ms-1 fw-semibold d-inline-block fs-18"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('orders.create') }}">Nuevo Trabajo</a></li>
                                <li><a class="dropdown-item" href="#" data-bs-toggle="modal" data-bs-target="#createShiftModal">Nuevo Turno</a></li>
                            </ul>
                        </div>
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
                                                            <span class=" badge {{ $colorEstado }} mt-0 mt-sm-0">
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
                        <p class="card-title fw-semibold fs-18 mb-0">Pagos del Mes</p>
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
@include('pages.modals.createShiftModal')

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

