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
        <h1 class="page-title fw-semibold fs-18 mb-0">Listado de Trabajos</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Páginas</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Trabajos</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->
    <div class="row mt-4">
        <div class="col-xl-12">
            <div class="team-members" id="team-members">
                <div class="row">
                    <div class="col-xl-12">
                        <div class="card custom-card">
                            <div class="card-body">
                                <div class="team-header">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between">
                                        <div class="h5 fw-semibold mb-0">Trabajos</div>
                                        <div class="d-flex align-items-center">
                                            <div class="input-group">
                                                <form action="{{ route('orders.index') }}" method="GET" class="d-flex">
                                                    <input type="text" name="search" class="form-control bg-light border-0" placeholder="Buscar cliente" aria-describedby="search-team-member" value="{{ request('search') }}">
                                                    <button class="btn btn-light" type="submit" id="search-team-member"><i class="ri-search-line text-muted"></i></button>
                                                </form>
                                            </div>
                                            <div class="dropdown ms-2">
                                                <button class="btn btn-light btn-wave waves-effect waves-light px-2" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="ti ti-plus fs-18"></i>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li><a class="dropdown-item" href="{{ route('orders.create') }}">Nuevo Trabajo</a></li>
          
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($orders->isEmpty())
                        <div class="col-12">
                            <div class="alert alert-warning text-center mb-3" role="alert">
                                No tienes clientes registrados
                            </div>
                        </div>
                    @else
                        @foreach ($orders as $cliente)
                        @php
                        $coverImageNumber = rand(1, 6);
                        $estadoColor = match($cliente->estado) {
                            'confirmed' => 'bg-primary',
                            'not_confirmed' => 'bg-warning',
                            'in_progress' => 'bg-secondary',
                            'done' => 'bg-success',
                            'canceled' => 'bg-danger',
                            default => 'bg-dark'
                        };
                        $estadoTexto = match($cliente->estado) {
                            'confirmed' => 'Confirmado',
                            'done' => 'Completado',
                            'not_confirmed' => 'No Confirmado',
                            'canceled' => 'Cancelado',
                            'in_progress' => 'En Progreso',
                            default => 'Sin Estado'
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
                        <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12 mb-4">
                            <a href="{{ route('orders.show', $cliente->id_order) }}" class="text-decoration-none">
                                <div class="card custom-card order-card h-100" style="cursor: pointer; transition: all 0.3s ease; border: 1px solid #e9ecef; h" 
                                     onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 8px 25px rgba(0,0,0,0.15)'; this.style.borderColor='#007bff'" 
                                     onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 2px 10px rgba(0,0,0,0.08)'; this.style.borderColor='#e9ecef'">
                                    
                                    <!-- Header con imagen y estado -->
                                    <div class="position-relative">
                                        <div class="teammember-cover-image">
                                            <img src="{{asset('build/assets/images/profile/machine.jpg')}}" class="object-fit-cover card-img-top" 
                                                 >
                                        </div>
                                        <!-- Badge de estado flotante -->
                                        <div class="position-absolute top-0 end-0 m-3">
                                            <span class="badge {{ $estadoColor }} px-3 py-2 rounded-pill d-flex align-items-center gap-1" 
                                                  style="font-size: 0.75rem; font-weight: 600;">
                                                <i class="{{ $estadoIcon }}"></i>
                                                {{ $estadoTexto }}
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Contenido principal -->
                                    <div class="card-body p-4">
                                        <!-- Información del cliente -->
                                        <div class="mb-4">
                                            <h5 class="card-title fw-bold text-dark mb-3 d-flex align-items-center">
                                                <i class="ri-user-3-line text-primary me-2"></i>
                                                {{ $cliente->client_name }}
                                            </h5>
                                            
                                            <div class="row g-3">
                                                <!-- RUT (ancho completo) -->
                                                <div class="col-12">
                                                    <div class="d-flex align-items-center text-muted mb-2">
                                                        <i class="ri-id-card-line me-2 text-secondary"></i>
                                                        <small class="fw-medium">{{ $cliente->cliente_rut ?? 'Sin RUT' }}</small>
                                                    </div>
                                                </div>
                                                
                                                <!-- Columna 1: Teléfono y Dirección -->
                                                <div class="col-6">
                                                    <div class="d-flex align-items-center text-muted mb-2 mb-3">
                                                        <i class="ri-phone-line me-2 text-secondary"></i>
                                                        <small class="fw-medium">{{ $cliente->client_phone ?? 'Sin teléfono' }}</small>
                                                    </div>
                                                    <div class="d-flex align-items-center text-muted mb-3">
                                                        <i class="ri-mail-line me-2  text-secondary"></i>
                                                        <small class="fw-medium">{{ Str::limit($cliente->cliente_email ?? 'Sin email', 25) }}</small>
                                                    </div>
                                                    <div class="d-flex align-items-start text-muted">
                                                        <i class="ri-map-pin-line me-2 text-secondary"></i>
                                                        <small class="fw-medium">{{ $cliente->client_address ?? 'Sin dirección' }}</small>
                                                    </div>
                                                </div>
                                                
                                                <!-- Columna 2: Descripción del trabajo -->
                                                <div class="col-6">
                                                    <div class="mb-2">
                                                        <small class="fw-semibold text-muted d-flex align-items-center mb-1">
                                                            <i class="ri-file-text-line me-1"></i>
                                                            Trabajo
                                                        </small>
                                                        <p class="mb-0 text-dark" style="font-size: 0.8rem; line-height: 1.3;">
                                                            {{ $cliente->work_info ? Str::limit($cliente->work_info, 60) : 'Sin descripción' }}
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Footer con fechas -->
                                    <div class="card-footer bg-light border-0 p-3">
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                                        <i class="ri-calendar-check-line text-success me-1"></i>
                                                        <small class="fw-semibold text-muted">Inicio</small>
                                                    </div>
                                                    <div class="text-dark fw-medium" style="font-size: 0.8rem;">
                                                        @if($cliente->start_date)
                                                            {{ \Carbon\Carbon::parse($cliente->start_date)->locale('es')->isoFormat('D MMM YYYY') }}
                                                        @else
                                                            <span class="text-muted">Sin fecha</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="text-center">
                                                    <div class="d-flex align-items-center justify-content-center mb-1">
                                                        <i class="ri-calendar-check-line text-success me-1"></i>
                                                        <small class="fw-semibold text-muted">Fin</small>
                                                    </div>
                                                    <div class="text-dark fw-medium" style="font-size: 0.8rem;">
                                                        @if($cliente->end_date)
                                                            {{ \Carbon\Carbon::parse($cliente->end_date)->locale('es')->isoFormat('D MMM YYYY') }}
                                                        @else
                                                            <span class="text-muted">Sin fecha</span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        @endforeach
                    @endif
                    <div class="d-flex justify-content-end">
                        <nav aria-label="Page navigation">
                            <ul class="pagination mb-3">
                                {{-- Previous Page Link --}}
                                @if ($orders->onFirstPage())
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Anterior</a></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $orders->appends(request()->query())->previousPageUrl() }}">Anterior</a></li>
                                @endif
    
                                {{-- Pagination Elements --}}
                                @foreach ($orders->appends(request()->query())->links()->elements as $element)
                                {{-- "Three Dots" Separator --}}
                                @if (is_string($element))
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{{ $element }}</a></li>
                                @endif
    
                                {{-- Array Of Links --}}
                                @if (is_array($element))
                                @foreach ($element as $page => $url)
                                @if ($page == $orders->currentPage())
                                <li class="page-item active"><a class="page-link" href="javascript:void(0);">{{ $page }}</a></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                                @endforeach
                                @endif
                                @endforeach
    
                                {{-- Next Page Link --}}
                                @if ($orders->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $orders->appends(request()->query())->nextPageUrl() }}">Siguiente</a></li>
                                @else
                                <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">Siguiente</a></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>

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
