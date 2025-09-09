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
                            'in_progress' => 'bg-success',
                            'done' => 'bg-warning',
                            'canceled' => 'bg-info',
                            default => 'bg-dark'
                        };
                        $estadoTexto = match($cliente->estado) {
                         
                            'done' => 'Completado',
                            'canceled' => 'Cancelado',
                            'in_progress' => 'En Progreso',
                            default => 'Sin Estado'
                        };
                        @endphp
                        <div class="col-xxl-4 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                            <a href="{{ route('orders.show', $cliente->id_order) }}" class="text-decoration-none">
                                <div class="card custom-card team-member-card" style="height: 300px; cursor: pointer; transition: transform 0.2s, box-shadow 0.2s;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 4px 15px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='none'">
                                    <div class="teammember-cover-image">
                                        <img src="{{asset('build/assets/images/profile/machine.jpg')}}" class="object-fit-cover card-img-top" >
                          
                                    </div>
                                    <div class="card-body p-0">
                                    <div class="d-flex flex-wrap mt-0 justify-content-between border-bottom p-3">
                                        
                                        <div style="margin-left: 4.5rem;">
                                            <p class="mb-1 fw-semibold fs-17 text-dark">
                                                {{ $cliente->client_name }}
                                            </p>
                                            <p class="mb-0 fs-12 text-muted text-break">
                                                {{ $cliente->cliente_rut ?? 'Sin RUT' }}
                                            </p>
                                            <p class="mb-0 fs-12 text-muted text-break">
                                                {{ $cliente->client_phone ?? 'Sin teléfono' }}
                                            </p>
                                            <p class="mb-0 fs-12 text-muted text-break">
                                                {{ Str::limit($cliente->client_address ?? 'Sin dirección', 30) }}
                                            </p>    
                                        </div>
                                        <div class="dropdown" onclick="event.stopPropagation(); event.preventDefault();">
                                            {{-- <button class="btn btn-sm btn-icon btn-light btn-wave waves-effect waves-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="ti ti-dots-vertical"></i>
                                            </button> --}}
                                            <ul class="dropdown-menu">
                                                <li><a class="dropdown-item" href="{{ route('orders.show', $cliente->id_order) }}">Ver Detalles</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Nueva Orden</a></li>
                                                <li><a class="dropdown-item" href="javascript:void(0);">Editar Cliente</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="team-member-stats d-sm-flex justify-content-evenly">
                                        <div class="text-center p-3 my-auto">
                                            <p class="fw-semibold mb-0">Fecha Inicio</p>
                                            <span class="text-muted fs-12">
                                                @if($cliente->start_date)
                                                    {{ \Carbon\Carbon::parse($cliente->start_date)->locale('es')->isoFormat('dddd D [de] MMMM YYYY') }}
                                                @else
                                                    Sin fecha
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-center p-3 my-auto">
                                            <p class="fw-semibold mb-0">Fecha Fin</p>
                                            <span class="text-muted fs-12">
                                                @if($cliente->end_date)
                                                    {{ \Carbon\Carbon::parse($cliente->end_date)->locale('es')->isoFormat('dddd D [de] MMMM YYYY') }}
                                                @else
                                                    Sin fecha
                                                @endif
                                            </span>
                                        </div>
                                        <div class="text-center p-3 my-auto">
                                            <p class="fw-semibold mb-0">Estado</p>
                                            <span class="text-muted fs-12">
                                                     
                                    <span class="badge {{ $estadoColor }} m-2">{{ $estadoTexto }}</span>
                                            </span>
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
