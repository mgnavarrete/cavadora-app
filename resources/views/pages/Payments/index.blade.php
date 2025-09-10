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
    <h1 class="page-title fw-semibold fs-18 mb-0">Pagos</h1>
    <div class="ms-md-1 ms-0">
        <nav>
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="{{route('index')}}">Inicio</a></li>
                <li class="breadcrumb-item active" aria-current="page">Pagos</li>
            </ol>
        </nav>
    </div>
</div>
<!-- Page Header Close -->

<!-- Start::row -->
<div class="row">
    <div class="col-xl-3">
        <div class="card custom-card">
            <div class="card-body p-0">
                <form method="GET" action="{{ route('payments.index') }}">
                    <div class="p-3 border-bottom border-block-end-dashed">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control bg-light border-0" placeholder="Buscar por Cliente" aria-describedby="button-addon2" value="{{ request('search') }}">
                            <button class="btn btn-light" type="submit" id="button-addon2">
                                <i class="ri-search-line text-muted"></i>
                            </button>
                        </div>
                    </div>
                    
                    @php
                        // Generamos una lista de meses de marzo a diciembre
                        $mesesAMostrar = [];
                        $inicio = \Carbon\Carbon::create(null, 3, 1); // Marzo
                        $fin = \Carbon\Carbon::create(null, 12, 1); // Diciembre
                        while ($inicio->lessThanOrEqualTo($fin)) {
                            $mesesAMostrar[] = $inicio->copy();
                            $inicio->addMonth();
                        }
                    @endphp
                    <div class="p-3 d-grid border-bottom border-block-end-dashed">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                    </div>
                    <div class="p-3 task-navigation border-bottom border-block-end-dashed">
                        <ul class="list-unstyled task-main-nav mb-0">
                            <li class="px-0 pt-2">
                                <span class="fs-11 text-muted op-7 fw-semibold">MESES</span>
                            </li>
                            <li>
                                <label class="d-flex align-items-center cursor-pointer">
                                    <input type="radio" name="month_filter" value="todos" class="me-2"
                                        {{ request('month_filter') == 'todos' || !request('month_filter') ? 'checked' : '' }}>
                                    <i class="align-middle fs-16 me-2"></i>
                                    <span>Todos</span>
                                </label>
                            </li>

                            @foreach ($mesesAMostrar as $mes)
                                <li>
                                    <label class="d-flex align-items-center cursor-pointer">
                                        <input type="radio" name="month_filter" value="{{ $mes->format('Y-m-d') }}" class="me-2"
                                            {{ request('month_filter') == $mes->format('Y-m-d') ? 'checked' : '' }}>
                                        <i class="align-middle fs-16 me-2"></i>
                                        <span>{{ ucfirst($mes->translatedFormat('F')) }}</span>
                                    </label>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    
                </form>

                <div class="p-3 text-center">
                    <img src="https://laravelui.spruko.com/ynex/build/assets/images/media/media-66.png" alt="">
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-9">
        <div class="row">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-body p-0">
                        <div class="d-flex p-3 align-items-center justify-content-between">
                            <div>
                                <h6 class="fw-semibold mb-0">Estados</h6>
                            </div>
                            <div>
                                <ul class="nav nav-tabs nav-tabs-header mb-0 d-sm-flex d-block" role="tablist">
                                    <li class="nav-item m-1">
                                        <a class="nav-link active" data-bs-toggle="tab" role="tab" aria-current="page"
                                        href="#todos" aria-selected="true">Todos</a>
                                    </li>
                                    <li class="nav-item m-1">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                        href="#pendientes" aria-selected="true">Pendientes</a>
                                    </li>
                                    <li class="nav-item m-1">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                        href="#atrasados" aria-selected="true">Atrasados</a>
                                    </li>
                                    <li class="nav-item m-1">
                                        <a class="nav-link" data-bs-toggle="tab" role="tab" aria-current="page"
                                        href="#pagados" aria-selected="true">Pagados</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tab-content task-tabs-container">
                <div class="tab-pane show active p-0" id="todos" role="tabpanel">
                    <div class="row d-flex align-items-stretch">
                        @if($pagos->isEmpty())
                            <p class="text-center">No hay pagos registrados</p>
                        @else
                            @foreach ($pagos as $pago)
                                @php
                                    $totalPago = $pago->total_amount;
                                @endphp
                                <div class="col-md-6 d-flex">
                                    <div class="card custom-card flex-fill
                                        @if($pago->status === 'overdue') task-pending-card
                                        @elseif($pago->status === 'pending') task-pending-card
                                        @elseif($pago->status === 'paid') task-completed-card
                                        @endif
                                    ">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                                <div class="flex-grow-1">
                                                    <p class="fw-semibold mb-3 d-flex align-items-center">
                                                        <i class="ri-bookmark-fill fs-16 op-5 me-1 text-muted"></i>
                                                        {{ ucfirst(\Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y')) }} - {{ optional($pago->order)->client_name ?? 'Cliente' }}
                                                    </p>
                                                    <p class="mb-2">Valor Total :
                                                        <span class="fs-12 mb-1 text-muted">{{ '$' . number_format($totalPago, 0, ',', '.') }}</span>
                                                    </p>
                                                    <p class="mb-2">Estado Pago: <span class="fs-12 mb-1 fw-semibold
                                                        @if($pago->status === 'overdue') text-warning
                                                        @elseif($pago->status === 'pending') text-secondary
                                                        @elseif($pago->status === 'paid') text-success
                                                        @elseif($pago->status === 'void') text-danger
                                                        @endif">
                                                          @if($pago->status === 'pending') Pendiente
                                                          @elseif($pago->status === 'paid') Pagado
                                                          @elseif($pago->status === 'overdue') Atrasado
                                                          @elseif($pago->status === 'void') Anulado
                                                          @endif
                                                    </span>
                                                    </p>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('payments.show', $pago->id_payment) }}">
                                                                <i class="ri-eye-line me-2"></i>Ver Detalles
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPayment{{ $pago->id_payment }}">
                                                                <i class="ri-edit-line me-2"></i>Editar Pago
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="tab-pane p-0" id="pendientes" role="tabpanel">
                    <div class="row d-flex align-items-stretch">
                        @if($pendientes->isEmpty())
                            <p class="text-center">No hay pagos registrados</p>
                        @else
                            @foreach ($pendientes as $pago)
                                @php
                                    $totalPago = $pago->total_amount;
                                @endphp
                                <div class="col-md-6 d-flex">
                                    <div class="card custom-card flex-fill task-pending-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                                <div class="flex-grow-1">
                                                    <p class="fw-semibold mb-3 d-flex align-items-center">
                                                        <i class="ri-bookmark-fill fs-16 op-5 me-1 text-muted"></i>
                                                        {{ ucfirst(\Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y')) }} - {{ optional($pago->order)->client_name ?? 'Cliente' }}
                                                    </p>
                                                    <p class="mb-2">Valor Total :
                                                        <span class="fs-12 mb-1 text-muted">{{ '$' . number_format($totalPago, 0, ',', '.') }}</span>
                                                    </p>
                                                    <p class="mb-2">Estado Pago: <span class="fs-12 mb-1 fw-semibold text-secondary">
                                                          Pendiente
                                                    </span>
                                                    </p>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('payments.show', $pago->id_payment) }}">
                                                                <i class="ri-eye-line me-2"></i>Ver Detalles
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPayment{{ $pago->id_payment }}">
                                                                <i class="ri-edit-line me-2"></i>Editar Pago
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="tab-pane p-0" id="atrasados" role="tabpanel">
                    <div class="row d-flex align-items-stretch">
                        @if($atrasados->isEmpty())
                            <p class="text-center">No hay pagos registrados</p>
                        @else
                            @foreach ($atrasados as $pago)
                                @php
                                    $totalPago = $pago->total_amount;
                                @endphp
                                <div class="col-md-6 d-flex">
                                    <div class="card custom-card flex-fill task-pending-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                                <div class="flex-grow-1">
                                                    <p class="fw-semibold mb-3 d-flex align-items-center">
                                                        <i class="ri-bookmark-fill fs-16 op-5 me-1 text-muted"></i>
                                                        {{ ucfirst(\Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y')) }} - {{ optional($pago->order)->client_name ?? 'Cliente' }}
                                                    </p>
                                                    <p class="mb-2">Valor Total :
                                                        <span class="fs-12 mb-1 text-muted">{{ '$' . number_format($totalPago, 0, ',', '.') }}</span>
                                                    </p>
                                                    <p class="mb-2">Estado Pago: <span class="fs-12 mb-1 fw-semibold text-warning">
                                                          Atrasado
                                                    </span>
                                                    </p>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('payments.show', $pago->id_payment) }}">
                                                                <i class="ri-eye-line me-2"></i>Ver Detalles
                                                            </a>
                                                        </li>
                                                        <li>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPayment{{ $pago->id_payment }}">
                                                                <i class="ri-edit-line me-2"></i>Editar Pago
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="tab-pane p-0" id="pagados" role="tabpanel">
                    <div class="row d-flex align-items-stretch">
                        @if($pagados->isEmpty())
                            <p class="text-center">No hay pagos registrados</p>
                        @else
                            @foreach ($pagados as $pago)
                                @php
                                    $totalPago = $pago->total_amount;
                                @endphp
                                <div class="col-md-6 d-flex">
                                    <div class="card custom-card flex-fill task-completed-card">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between flex-wrap gap-2">
                                                <div class="flex-grow-1">
                                                    <p class="fw-semibold mb-3 d-flex align-items-center">
                                                        <i class="ri-bookmark-fill fs-16 op-5 me-1 text-muted"></i>
                                                        {{ ucfirst(\Carbon\Carbon::parse($pago->emission_date)->translatedFormat('F Y')) }} - {{ optional($pago->order)->client_name ?? 'Cliente' }}
                                                    </p>
                                                    <p class="mb-2">Valor Total :
                                                        <span class="fs-12 mb-1 text-muted">{{ '$' . number_format($totalPago, 0, ',', '.') }}</span>
                                                    </p>
                                                    <p class="mb-2">Estado Pago: <span class="fs-12 mb-1 fw-semibold text-success">
                                                          Pagado
                                                    </span>
                                                    </p>
                                                </div>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm btn-light" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="ri-more-2-fill"></i>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a class="dropdown-item" href="{{ route('payments.show', $pago->id_payment) }}">
                                                                <i class="ri-eye-line me-2"></i>Ver Detalles
                                                            </a>
                                                        </li>
                                                        {{-- <li>
                                                            <a class="dropdown-item" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#editPayment{{ $pago->id_payment }}">
                                                                <i class="ri-edit-line me-2"></i>Editar Estado
                                                            </a>
                                                        </li> --}}
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>        
        </div>
    </div>
</div>
<!--End::row -->
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
@include('pages.modals.editPaymentPage')

@section('scripts')
    <!-- FLAT PICKER JS -->
    <script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>

    <!-- INTERNAL TO DO LIST JS -->
    @vite('resources/assets/js/todolist.js')

    <!-- GLIGHTBOX JS -->
    <script src="{{asset('build/assets/libs/glightbox/js/glightbox.min.js')}}"></script>

    <!-- INTERNAL PROFILE JS -->
    @vite('resources/assets/js/profile.js')

  

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

