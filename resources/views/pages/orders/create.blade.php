@extends('layouts.master')

@section('styles')
<!-- DATE & TIME PICKER JS -->
<script src="{{asset('build/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
<script src="{{asset('build/assets/libs/flatpickr/l10n/es.js')}}"></script>
@vite('resources/assets/js/date&time_pickers.js')
@endsection

@section('content')

@php
    \Carbon\Carbon::setLocale('es');
@endphp

<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-md-flex d-block align-items-center justify-content-between my-4 page-header-breadcrumb">
        <h1 class="page-title fw-semibold fs-18 mb-0">Nuevo Trabajo</h1>
        <div class="ms-md-1 ms-0">
            <nav>
                <ol class="breadcrumb mb-0">
                    <li class="breadcrumb-item"><a href="javascript:void(0);">Páginas</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('orders.index') }}">Trabajos</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo Trabajo</li>
                </ol>
            </nav>
        </div>
    </div>
    <!-- Page Header Close -->

    <form action="{{ route('orders.store') }}" method="POST" id="formOrder">
        @csrf
        <div class="row d-flex align-items-stretch">
            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">Información del Cliente</h5>
                    </div>
                    <div class="card-body">

                        <!-- Nombre del Cliente -->
                        <div class="col-xl-12 mb-3">
                            <label for="client_name" class="form-label text-default">Nombre del Cliente</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="client_name" name="client_name" placeholder="Nombre del cliente" required value="{{ old('client_name') }}">
                        </div>

                        <!-- RUT del Cliente -->
                        <div class="col-xl-12 mb-3">
                            <label for="cliente_rut" class="form-label text-default">RUT</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="cliente_rut" name="cliente_rut" placeholder="RUT del cliente" oninput="formatRUT(this)" value="{{ old('cliente_rut') }}">
                        </div>

                        <!-- Teléfono del Cliente -->
                        <div class="col-xl-12 mb-3">
                            <label for="client_phone" class="form-label text-default">Teléfono</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="client_phone" name="client_phone" placeholder="Teléfono" oninput="addPrefix(this)" value="{{ old('client_phone') }}">
                        </div>

                        <!-- Email del Cliente -->
                        <div class="col-xl-12 mb-3">
                            <label for="cliente_email" class="form-label text-default">Email</label>
                            <input type="email" class="form-control form-control-lg bg-outline-primary" id="cliente_email" name="cliente_email" placeholder="Email del cliente" value="{{ old('cliente_email') }}">
                        </div>

                        <!-- Dirección del Cliente -->
                        <div class="col-xl-12 mb-3">
                            <label for="client_address" class="form-label text-default">Dirección</label>
                            <input type="text" class="form-control form-control-lg bg-outline-primary" id="client_address" name="client_address" placeholder="Dirección del cliente" required value="{{ old('client_address') }}">
                        </div>

                        <!-- Información Adicional del Cliente -->
                        <div class="col-xl-12 h-100">
                            <label for="client_info" class="form-label text-default mb-3">Información Adicional del Cliente <span class="text-muted">(Opcional)</span></label>
                            <textarea class="form-control form-control-lg bg-outline-primary mb-2" id="client_info" name="client_info" placeholder="Información adicional sobre el cliente">{{ old('client_info') }}</textarea>
                        </div>
                        <br>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">Información del Trabajo</h5>
                    </div>
                    <div class="card-body">

                        <!-- Descripción del Trabajo -->
                        <div class="col-xl-12 mb-3">
                            <label for="work_info" class="form-label text-default">Descripción del Trabajo</label>
                            <textarea class="form-control form-control-lg bg-outline-primary" id="work_info" name="work_info" placeholder="Descripción detallada del trabajo a realizar" rows="4" required>{{ old('work_info') }}</textarea>
                        </div>

                        <!-- Estado del Trabajo -->
                        <div class="col-xl-12 mb-3">
                            <label for="estado" class="form-label text-default">Estado</label>
                            <select class="form-select form-select-lg bg-outline-primary" id="estado" name="estado" required>
                                <option value="not_confirmed" {{ old('estado') == 'not_confirmed' ? 'selected' : '' }}>No Confirmado</option>
                                <option value="confirmed" {{ old('estado') == 'confirmed' ? 'selected' : '' }}>Confirmado</option>
                                <option value="in_progress" {{ old('estado') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                                <option value="done" {{ old('estado') == 'done' ? 'selected' : '' }}>Completado</option>
                                <option value="canceled" {{ old('estado') == 'canceled' ? 'selected' : '' }}>Cancelado</option>
                            </select>
                        </div>

                        <!-- Fecha de Inicio -->
                        <div class="col-xl-12 mb-3">
                            <label for="start_date" class="form-label text-default">Fecha de Inicio</label>
                            <div class="form-group bg-outline-primary">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                                    <input type="text" class="form-control" id="start_date" name="start_date" placeholder="Seleccionar fecha de inicio" value="{{ old('start_date') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Fecha de Fin -->
                        <div class="col-xl-12 mb-3">
                            <label for="end_date" class="form-label text-default">Fecha de Fin</label>
                            <div class="form-group bg-outline-primary">
                                <div class="input-group">
                                    <div class="input-group-text text-muted"><i class="ri-calendar-line"></i></div>
                                    <input type="text" class="form-control" id="end_date" name="end_date" placeholder="Seleccionar fecha de fin" value="{{ old('end_date') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Información de Costos -->
        <div class="row d-flex justify-content-end">
            <div class="col-xl-12">
                <div class="card custom-card">
                    <div class="card-header">
                        <h5 class="card-title">Información de Costos</h5>
                        <p class="text-muted mb-0">Los costos se facturarán automáticamente al finalizar el trabajo</p>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Costo por Hora -->
                            <div class="col-md-6 mb-3">
                                <label for="hour_cost" class="form-label text-default">Costo por Hora de Trabajo</label>
                                <input type="text" class="form-control form-control-lg bg-outline-primary" id="hour_cost" name="hour_cost" placeholder="Costo por hora" oninput="formatCurrency(this)" required value="{{ old('hour_cost', '18750') }}">
                                <div class="form-text text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    Este valor se multiplicará por las horas trabajadas en cada turno
                                </div>
                                <div class="form-text text-info">
                                    <i class="ri-calculator-line me-1"></i>
                                    <strong>Referencia:</strong> $18.750 corresponde a $150.000 dividido por 8 horas de trabajo
                                </div>
                            </div>

                            <!-- Costo Extra -->
                            <div class="col-md-6 mb-3">
                                <label for="extra_cost" class="form-label text-default">Costo Extra <span class="text-muted">(Opcional)</span></label>
                                <input type="text" class="form-control form-control-lg bg-outline-primary" id="extra_cost" name="extra_cost" placeholder="Costo extra" oninput="formatCurrency(this)" value="{{ old('extra_cost', '0') }}">
                                <div class="form-text text-muted">
                                    <i class="ri-information-line me-1"></i>
                                    Gastos adicionales que no dependen de las horas trabajadas
                                </div>
                            </div>

                            <!-- Información del Costo Extra -->
                            <div class="col-xl-12 mb-3">
                                <label for="info_extra_cost" class="form-label text-default">Información del Costo Extra <span class="text-muted">(Opcional)</span></label>
                                <textarea class="form-control form-control-lg bg-outline-primary" id="info_extra_cost" name="info_extra_cost" placeholder="Descripción del costo extra" rows="2">{{ old('info_extra_cost') }}</textarea>
                            </div>

                            <!-- Información automática -->
                            <div class="col-xl-12">
                                <div class="alert alert-info">
                                    <i class="ri-information-line me-2"></i>
                                    <strong>Lógica de facturación:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>El costo total se calculará multiplicando el <strong>costo por hora</strong> × <strong>total de horas trabajadas</strong> (de los turnos)</li>
                                        <li>Se sumarán los <strong>costos extras</strong> al total calculado</li>
                                        <li>La fecha de emisión será igual a la fecha de fin del trabajo</li>
                                        <li>El estado del pago será "Pendiente" hasta que se registre el pago</li>
                                        <li>Todos los turnos deben tener <strong>mínimo 8 horas</strong> de duración</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-end">
            <div class="spinner-border text-primary d-none" role="status" id="spinnerOrder">
                <span class="visually-hidden">Loading...</span>
            </div>
            <button type="submit" class="btn btn-primary m-2 mb-5" id="guardarBtnOrder">Guardar Trabajo</button>
            <a href="{{ route('orders.index') }}" class="btn btn-outline-danger m-2 mb-5 me-5">Cancelar</a>
        </div>
    </form>
</div>

{{-- Mostrar mensaje de éxito --}}
@if(session('success'))
    <script>
        alert("{{ session('success') }}");
    </script>
@endif

{{-- Mostrar mensaje de error --}}
@if($errors->any())
    <script>
        alert("{{ $errors->first() }}");
    </script>
@endif

@endsection

@section('scripts')

<!-- Scripts para el formulario -->
<script>
    document.getElementById('formOrder').addEventListener('submit', function() {
        document.getElementById('guardarBtnOrder').classList.add('d-none');
        document.getElementById('spinnerOrder').classList.remove('d-none');
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        flatpickr("#start_date", {
            locale: "es",
            dateFormat: "Y-m-d",
        });
        flatpickr("#end_date", {
            locale: "es",
            dateFormat: "Y-m-d",
        });
    });

    function formatRUT(input) {
        let value = input.value.replace(/\./g, '').replace('-', '');
        if (value.length > 1) {
            value = value.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + value.slice(-1);
        }
        input.value = value;
    }

    function formatCurrency(input) {
        let value = input.value.replace(/\D/g, '');
        if (value) {
            // Agregar separadores de miles
            value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        }
        input.value = value;
    }

    function addPrefix(input) {
        let value = input.value.replace(/\D/g, '');
        if (value && !input.value.startsWith('+569')) {
            input.value = '+569' + value.replace(/^569/, '');
        }
    }
</script>

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
