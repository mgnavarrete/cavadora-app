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
        
        // Generar chunks de 4
        const chunks = [];
        for (let i = 0; i < filteredOrders.length; i += 4) {
            chunks.push(filteredOrders.slice(i, i + 4));
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
                        <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                            <a href="/orders/${orden.id_order}" class="text-decoration-none">
                                                    <div class="card custom-card team-member-card d-flex flex-column" style="height: 350px; width: 100%; max-width: 300px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    <div class="position-relative">
                                        <div class="teammember-cover-image">
                                            <img src="/build/assets/images/profile/machine.jpg" class="object-fit-cover card-img-top" style="height: 60px;">
                                        </div>
                                        <div class="position-absolute top-0 end-0 m-2">
                                            <span class="badge ${estadoColor} fs-10 px-2 py-1">${estadoTexto}</span>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body p-3 flex-grow-1 d-flex flex-column">
                                        <div class="mb-3">
                                            <h6 class="mb-0 fw-semibold fs-16 text-dark">${orden.client_name}</h6>
                                            ${orden.cliente_rut ? `<small class="text-muted fs-11">${orden.cliente_rut}</small>` : ''}
                                        </div>
                                        
                                        <div class="mb-3 flex-grow-1">
                                            ${orden.client_phone ? `
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="ti ti-phone fs-12 text-primary me-2"></i>
                                                    <div>
                                                        <small class="fs-10 fw-semibold text-primary d-block">Teléfono</small>
                                                        <span class="fs-12 text-muted">${orden.client_phone}</span>
                                                    </div>
                                                </div>
                                            ` : ''}
                                            
                                            ${orden.client_address ? `
                                                <div class="d-flex align-items-start mb-2">
                                                    <i class="ti ti-map-pin fs-12 text-warning me-2 mt-1"></i>
                                                    <div>
                                                        <small class="fs-10 fw-semibold text-warning d-block">Dirección</small>
                                                        <span class="fs-12 text-muted">${orden.client_address.length > 35 ? orden.client_address.substring(0, 35) + '...' : orden.client_address}</span>
                                                    </div>
                                                </div>
                                            ` : ''}
                                            
                                            ${orden.start_date ? `
                                                <div class="d-flex align-items-center mb-2">
                                                    <i class="ti ti-calendar fs-12 text-info me-2"></i>
                                                    <div>
                                                        <small class="fs-10 fw-semibold text-info d-block">Fecha Inscripción</small>
                                                        <span class="fs-12 text-muted">${new Date(orden.start_date).toLocaleDateString('es-ES')}</span>
                                                    </div>
                                                </div>
                                            ` : ''}
                                            
                                            ${orden.work_info ? `
                                                <div class="d-flex align-items-start mb-2">
                                                    <i class="ti ti-tools fs-12 text-primary me-2 mt-1"></i>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-1 fs-11 fw-semibold text-primary">Trabajo:</p>
                                                        <p class="fs-12 text-muted" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; max-height: 2.8em;">${orden.work_info}</p>
                                                    </div>
                                                </div>
                                            ` : ''}
                                        </div>
                                        
                                        
                                        ${orden.client_info ? `
                                            <div class="mt-2">
                                                <div class="d-flex align-items-start">
                                                    <i class="ti ti-note fs-12 text-info me-2 mt-1"></i>
                                                    <div class="flex-grow-1">
                                                        <p class="mb-0 fs-11 text-muted lh-sm">${orden.client_info.length > 50 ? orden.client_info.substring(0, 50) + '...' : orden.client_info}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        ` : ''}
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
                                $chunks = $ordenesActivas->chunk(4); // 3 cards por slide
                            @endphp
                            @foreach($chunks as $index => $chunk)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <div class="row g-3 p-3">
                                        @foreach($chunk as $cliente)
                                            @php
                                                $estadoColor = match(strtolower($cliente->estado)) {
                                                    'not_confirmed' => 'bg-warning',
                                                    'confirmed' => 'bg-primary',
                                                    'in_progress' => 'bg-secondary',
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
                                                $estadoIcon = match($cliente->estado) {
                                                    'confirmed' => 'ri-check-line',
                                                    'done' => 'ri-check-double-line',
                                                    'not_confirmed' => 'ri-time-line',
                                                    'canceled' => 'ri-close-line',
                                                    'in_progress' => 'ri-loader-4-line',
                                                    default => 'ri-question-line'
                                                };
                                            @endphp
                                            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-12">
                                                <a href="{{ route('orders.show', $cliente->id_order) }}" class="text-decoration-none">
                                                    <div class="card custom-card team-member-card d-flex flex-column" style="height: 325px; width: 100%; max-width: 300px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                                        <!-- Header con imagen y estado -->
                                                        <div class="position-relative">
                                                            <div class="teammember-cover-image">
                                                                <img src="{{asset('build/assets/images/profile/machine.jpg')}}" class="object-fit-cover card-img-top" style="height: 60px;">
                                                            </div>
                                                            <div class="position-absolute top-0 end-0 m-2">
                                                                <span class="badge {{ $estadoColor }} fs-10 px-2 py-1 align-items-center">
                                                                    <i class="{{ $estadoIcon }}"></i>
                                                                    {{ $estadoTexto }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        
                                                        <div class="card-body p-3 flex-grow-1 d-flex flex-column">
                                                            <!-- Nombre del cliente -->
                                                            <div class="mb-3">
                                                                <h6 class="mb-0 fw-semibold fs-16 text-dark">{{ $cliente->client_name }}</h6>
                                                                @if($cliente->cliente_rut)
                                                                    <small class="text-muted fs-11">{{ $cliente->cliente_email }}</small>
                                                                @endif
                                                            </div>
                                                            
                                                            <!-- Información vertical -->
                                                            <div class="mb-3 flex-grow-1">
                                                                @if($cliente->client_phone)
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <i class="ti ti-phone fs-12 text-primary me-2"></i>
                                                                        <div>
                                                                            <small class="fs-10 fw-semibold text-primary d-block">Teléfono</small>
                                                                            <span class="fs-12 text-muted">{{ $cliente->client_phone }}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                
                                                                @if($cliente->client_address)
                                                                    <div class="d-flex align-items-start mb-2">
                                                                        <i class="ti ti-map-pin fs-12 text-warning me-2 mt-1"></i>
                                                                        <div>
                                                                            <small class="fs-10 fw-semibold text-warning d-block">Dirección</small>
                                                                            <span class="fs-12 text-muted">{{ Str::limit($cliente->client_address, 35) }}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                
                                                                @if($cliente->start_date)
                                                                    <div class="d-flex align-items-center mb-2">
                                                                        <i class="ti ti-calendar fs-12 text-info me-2"></i>
                                                                        <div>
                                                                            <small class="fs-10 fw-semibold text-info d-block">Fecha Inscripción</small>
                                                                            <span class="fs-12 text-muted">{{ \Carbon\Carbon::parse($cliente->start_date)->format('d/m/Y') }}</span>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                                
                                                                @if($cliente->work_info)
                                                                    <div class="d-flex align-items-start mb-2">
                                                                        <i class="ti ti-tools fs-12 text-primary me-2 mt-1"></i>
                                                                        <div class="flex-grow-1">
                                                                            <p class="mb-1 fs-11 fw-semibold text-primary">Trabajo:</p>
                                                                            <p class="fs-12 text-muted" style="display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; line-height: 1.4; max-height: 2.8em;">{{ $cliente->work_info }}</p>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            </div>
                                                            
                                                            
                                                            <!-- Información adicional del cliente -->
                                                            @if($cliente->client_info)
                                                                <div class="mt-2">
                                                                    <div class="d-flex align-items-start">
                                                                        <i class="ti ti-note fs-12 text-info me-2 mt-1"></i>
                                                                        <div class="flex-grow-1">
                                                                            <p class="mb-0 fs-11 text-muted lh-sm">{{ Str::limit($cliente->client_info, 50) }}</p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
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
                <div class="card custom-card flex-fill timeline-container" style="border: 1px solid #e9ecef; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                        <div class="d-flex align-items-center">
                            <div class="me-3">
                                <i class="ri-calendar-schedule-line text-primary fs-20"></i>
                            </div>
                            <div>
                                <p class="card-title fw-bold fs-18 mb-0 text-dark">Próximos Turnos</p>

                            </div>
                        </div>
                        <div class="dropdown">
                            <button class="btn btn-light btn-wave waves-effect waves-light px-3 py-2" type="button" data-bs-toggle="dropdown" aria-expanded="false" style="border-radius: 8px;">
                                <i class="ri-add-line me-1"></i>
                                <span class="fw-semibold">Agregar</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end" style="border-radius: 8px; box-shadow: 0 4px 15px rgba(0,0,0,0.1);">
                                <li><a class="dropdown-item d-flex align-items-center" href="{{ route('orders.create') }}">
                                    <i class="ri-briefcase-line me-2 text-primary"></i>Nuevo Trabajo
                                </a></li>
                                <li><a class="dropdown-item d-flex align-items-center" href="#" data-bs-toggle="modal" data-bs-target="#createShiftModal">
                                    <i class="ri-calendar-event-line me-2 text-success"></i>Nuevo Turno
                                </a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="card-body p-0" style="height: 600px; overflow-y: auto; background: #f8f9fa;">
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

                        <div class="p-4">
                            @forelse($eventos as $evento)
                                @php
                                    $colorEstado = match(strtolower($evento['status'])) {
                                        'pending'     => 'bg-warning',
                                        'canceled'    => 'bg-danger',
                                        'completed'   => 'bg-success',
                                        'rescheduled' => 'bg-info',
                                        default       => 'bg-light text-muted'
                                    };
                                    $estadoShift = match(strtolower($evento['status'])) {
                                        'pending'     => 'Pendiente',
                                        'canceled'    => 'Cancelado',
                                        'completed'   => 'Completado',
                                        'rescheduled' => 'Reagendado',
                                        default       => $evento['status']
                                    };
                                    $iconoEstado = match(strtolower($evento['status'])) {
                                        'pending'     => 'ri-time-line',
                                        'canceled'    => 'ri-close-line',
                                        'completed'   => 'ri-check-line',
                                        'rescheduled' => 'ri-refresh-line',
                                        default       => 'ri-question-line'
                                    };
                                @endphp
                                <div class="timeline-item mb-4" style="position: relative;">
                                    <a href="javascript:void(0);" data-bs-target="#editShift{{ $evento['id'] }}" data-bs-toggle="modal" class="text-decoration-none">
                                        <div class="card border-0 shadow-sm" style="border-radius: 12px; transition: all 0.3s ease;" 
                                             onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'" 
                                             onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.08)'">
                                            
                                            <!-- Header del turno -->
                                            <div class="card-header d-flex justify-content-between align-items-center border-2">
                                                <div class="d-flex justify-content-between align-items-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="me-3">
                                                            <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                                                                <i class="ri-calendar-event-line text-white fs-16"></i>
                                                            </div>
                                                        </div>
                                                        <div>
                                                            <h6 class="mb-0 fw-bold text-dark">{{ $evento['client'] }}</h6>
                                                            <small class="text-muted">
                                                                <i class="ri-map-pin-line me-1"></i>
                                                                {{ Str::limit($evento['address'], 40) }}
                                                            </small>
                                                        </div>
                                                    </div>
                                            </div>
                                                    <div class="ms-auto d-flex align-items-end text-end">
                                                        <span class="badge {{ $colorEstado }} px-3 py-2 d-flex align-items-between gap-1" style="font-size: 0.75rem;">
                                                            <i class="{{ $iconoEstado }}"></i>
                                                            {{ ucfirst($estadoShift) }}
                                                        </span>
                                                    </div>
                                                
                                            </div>
                                            
                                            <!-- Contenido del turno -->
                                            <div class="card-body p-3">
                                                <div class="row align-items-center">
                                                    <div class="col-8">
                                                        <div class="d-flex align-items-center mb-2">
                                                            <i class="ri-time-line text-primary me-2"></i>
                                                            <span class="fw-semibold text-dark">
                                                                {{ optional($evento['start_at'])->isToday() ? 'Hoy' : optional($evento['start_at'])->translatedFormat('l') }}
                                                            </span>
                                                        </div>
                                                        <div class="d-flex align-items-center">
                                                            <i class="ri-clock-line text-success me-2"></i>
                                                            <span class="text-muted">
                                                                {{ optional($evento['start_at'])->format('H:i') }}
                                                                @if($evento['end_time'])
                                                                    - {{ $evento['end_time'] }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="col-4 text-end">
                                                        <div class="bg-light rounded p-2 text-center">
                                                            <div class="fw-bold text-primary fs-18">
                                                                {{ optional($evento['start_at'])->format('d') }}
                                                            </div>
                                                            <div class="text-muted" style="font-size: 0.75rem;">
                                                                {{ optional($evento['start_at'])->format('M') }}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                
                                                @if($evento['description'])
                                                    <div class="mt-3 pt-3 border-top">
                                                        <small class="text-muted">
                                                            <i class="ri-file-text-line me-1"></i>
                                                            {{ Str::limit($evento['description'], 60) }}
                                                        </small>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @empty
                                <div class="text-center py-5">
                                    <div class="mb-4">
                                        <i class="ri-calendar-event-line text-muted" style="font-size: 4rem;"></i>
                                    </div>
                                    <h5 class="text-muted mb-2">No hay turnos programados</h5>
                                    <p class="text-muted mb-4">Comienza agregando un nuevo turno o trabajo</p>
                                    <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                        <i class="ri-add-line me-1"></i>
                                        Crear Primer Trabajo
                                    </a>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
            <!-- Tabla: Pagos Pendientes -->
            <div class="col-md-5">
                <div class="card custom-card flex-fill" style="border: 1px solid #e9ecef; box-shadow: 0 2px 10px rgba(0,0,0,0.08);">
                    <div class="card-header d-flex justify-content-between align-items-center" style="background: #f8f9fa; border-bottom: 1px solid #e9ecef;">
                        <div class="d-flex align-items-center">
        
                            <div>
                                <p class="card-title fw-bold fs-18 mb-0 text-dark">Pagos del Mes</p>
       
                            </div>
                        </div>
                        <div class="text-muted">
                            <button class="btn btn-light btn-wave waves-effect waves-light px-3 py-2" type="button" style="border-radius: 8px;" onclick="window.location.href='{{ route('dashboard.index') }}'">
                                <i class="ri-bar-chart-line fs-16 me-1"></i>
                               
                                </button>
                          
                        </div>
                    </div>
                    <div class="card-body p-0" style="height: 600px; overflow-y: auto; background: #f8f9fa;">
                        <div class="p-4">
                            <div class="table-responsive">
                                <table class="table table-hover mb-0" style="border-radius: 8px; overflow: hidden;">
                                    <thead style="background: #e9ecef;">
                                        <tr>
                                            <th class="text-dark fw-semibold border-0 py-3 px-3" style="font-size: 0.85rem;">
                                                <i class="ri-user-line me-1 text-primary"></i>Cliente
                                            </th>
                                            <th class="text-dark fw-semibold border-0 py-3 px-3" style="font-size: 0.85rem;">
                                                <i class="ri-calendar-line me-1 text-primary"></i>Fecha
                                            </th>
                                            <th class="text-dark fw-semibold border-0 py-3 px-3" style="font-size: 0.85rem;">
                                                <i class="ri-checkbox-circle-line me-1 text-primary"></i>Estado
                                            </th>
                                            <th class="text-dark fw-semibold border-0 py-3 px-3 text-end" style="font-size: 0.85rem;">
                                                <i class="ri-money-dollar-circle-line me-1 text-primary"></i>Total
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white">
                                    @forelse($pagosPendientes as $pago)
                                    @php
                                        $totalPago = $pago->total_amount;
                                        $colorEstado = match(strtolower($pago->status)) {
                                            'pending'     => 'bg-warning',
                                            'overdue'    => 'bg-danger',
                                            'paid'   => 'bg-success',
                                            'void'   => 'bg-secondary',
                                            default       => 'bg-light text-muted'
                                        };
                                        $estadopago = match(strtolower($pago->status)) {
                                            'pending'     => 'Pendiente',
                                            'overdue'    => 'Atrasado',
                                            'paid'   => 'Pagado',
                                            'void'   => 'Anulado',
                                            default       => $pago->status
                                        };
                                        $iconoEstado = match(strtolower($pago->status)) {
                                            'pending'     => 'ri-time-line',
                                            'overdue'    => 'ri-alarm-warning-line',
                                            'paid'   => 'ri-check-line',
                                            'void'   => 'ri-close-line',
                                            default       => 'ri-question-line'
                                        };
                                    @endphp
                                    <tr style="transition: all 0.3s ease;" 
                                        onmouseover="this.style.backgroundColor='#f8f9fa'" 
                                        onmouseout="this.style.backgroundColor='white'">
                                        <td class="py-3 px-3 border-0">
                                            <div class="d-flex align-items-center">
                                                
                                                <div>
                                                    <div class="fw-semibold text-dark">{{ optional($pago->order)->client_name }}</div>
                                                   
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 border-0">
                                            @php
                                                $em = $pago->emission_date;
                                                if ($em instanceof \Carbon\Carbon) {
                                                    $emFmt = $em->translatedFormat('d M Y');
                                                } else {
                                                    $emStr = is_string($em) ? trim($em) : (string)$em;
                                                    try {
                                                        $emFmt = \Carbon\Carbon::parse($emStr)->translatedFormat('d M Y');
                                                    } catch (\Exception $e) {
                                                        $emFmt = substr($emStr, 0, 10);
                                                    }
                                                }
                                            @endphp
                                            <div class="d-flex align-items-center">
                                                <i class="ri-calendar-line text-muted me-2"></i>
                                                <span class="text-dark fw-medium">{{ $emFmt ?: '-' }}</span>
                                            </div>
                                        </td>
                                        <td class="py-3 px-3 border-0">
                                            <a href="javascript:void(0);" data-bs-target="#editPayment{{ $pago->id_payment }}" data-bs-toggle="modal" class="text-decoration-none">
                                                <span class="badge {{ $colorEstado }} px-3 py-2 d-flex align-items-center gap-1" style="font-size: 0.75rem; border-radius: 20px;">
                                                    <i class="{{ $iconoEstado }}"></i>
                                                    {{ ucfirst($estadopago) }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="py-3 px-3 border-0 text-end">
                                            <div class="d-flex align-items-center justify-content-end">
                                                <i class="ri-money-dollar-circle-line text-success me-2"></i>
                                                <span class="fw-bold text-dark fs-16">${{ number_format($totalPago, 0, ',', '.') }}</span>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="4" class="py-5 text-center border-0">
                                            <div class="d-flex flex-column align-items-center">
                                                <div class="mb-4">
                                                    <i class="ri-money-dollar-circle-line text-muted" style="font-size: 4rem;"></i>
                                                </div>
                                                <h5 class="text-muted mb-2">No hay pagos registrados</h5>
                                                <p class="text-muted mb-4">No se encontraron pagos para este mes</p>
                                                <a href="{{ route('orders.create') }}" class="btn btn-primary">
                                                    <i class="ri-add-line me-1"></i>
                                                    Crear Primer Trabajo
                                                </a>
                                            </div>
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

