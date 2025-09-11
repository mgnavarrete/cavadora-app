@extends('layouts.custom-master')

@section('styles')
    <style>
        .btn-icon {
            line-height: 10px; /* Adjust line height to match the icon height */
        }

        .custom-icon {
            width: 15px;
            height: 15px;
            vertical-align: middle;
            display: inline-block;
        }

        .adentu-sidebar {
            width: 500px;
            height: 100%;
            vertical-align: middle;
            display: inline-block;
        }

        .form-section {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .form-section h6 {
            color: #495057;
            font-weight: 600;
            margin-bottom: 15px;
            border-bottom: 2px solid #007bff;
            padding-bottom: 8px;
        }
    </style>
@endsection

@section('content')
    @section('error-body')
    <body>
    @endsection

        <div class="container">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xxl-8 col-xl-10 col-lg-10 col-md-10 col-sm-12 col-12">
                    <div class="my-5 d-flex justify-content-center">
                        <a href="{{url('index')}}">
                            <img src="{{asset('build/assets/images/brand-logos/adentu-sidebar.png')}}" alt="logo" class="adentu-sidebar">
                            <img src="{{asset('build/assets/images/brand-logos/desktop-dark.png')}}" alt="logo" class="desktop-dark">
                        </a>
                    </div>
                    <div class="card custom-card">
                        <div class="card-body p-5">
                            <p class="h5 fw-semibold mb-2 text-center">Solicitar Servicio de La Cavadora</p>
                            <p class="mb-4 text-muted op-7 fw-normal text-center">Complete el formulario para solicitar nuestros servicios</p>
                            
                            @if (session('success'))
                                <div class="alert alert-success text-center mb-4">
                                    <i class="ri-check-line me-2"></i>
                                    {{ session('success') }}
                                </div>
                            @endif

                            @if ($errors->any())
                                <div class="alert alert-danger text-center mb-4">
                                    <strong>Error:</strong> {{ $errors->first() }}
                                </div>
                            @endif
                            
                            <div class="row gy-3">
                                <form method="POST" action="{{ route('orders.storeFromClient') }}" id="formCliente">
                                    @csrf
                                    
                                    <!-- Información del Cliente -->
                                    <div class="form-section">
                                        <h6><i class="ri-user-line me-2"></i>Información del Cliente</h6>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="client_name" class="form-label text-default">Nombre del Cliente *</label>
                                                <input type="text" class="form-control form-control-lg" id="client_name" name="client_name" 
                                                       placeholder="Nombre completo" required value="{{ old('client_name') }}">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="cliente_rut" class="form-label text-default">RUT</label>
                                                <input type="text" class="form-control form-control-lg" id="cliente_rut" name="cliente_rut" 
                                                       placeholder="12.345.678-9" oninput="formatRUT(this)" value="{{ old('cliente_rut') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="client_phone" class="form-label text-default">Teléfono</label>
                                                <input type="text" class="form-control form-control-lg" id="client_phone" name="client_phone" 
                                                       placeholder="+56912345678" oninput="addPrefix(this)" value="{{ old('client_phone') }}">
                                            </div>
                                            
                                            <div class="col-md-6 mb-3">
                                                <label for="cliente_email" class="form-label text-default">Email</label>
                                                <input type="email" class="form-control form-control-lg" id="cliente_email" name="cliente_email" 
                                                       placeholder="correo@ejemplo.com" value="{{ old('cliente_email') }}">
                                            </div>
                                        </div>
                                        
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="client_address" class="form-label text-default">Dirección del Trabajo *</label>
                                                <input type="text" class="form-control form-control-lg" id="client_address" name="client_address" 
                                                       placeholder="Dirección completa donde se realizará el trabajo" required value="{{ old('client_address') }}">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Información del Trabajo -->
                                    <div class="form-section">
                                        <h6><i class="ri-tools-line me-2"></i>Descripción del Trabajo</h6>
                                        
                                        <div class="row">
                                            <div class="col-12 mb-3">
                                                <label for="work_info" class="form-label text-default">Descripción del Trabajo *</label>
                                                <textarea class="form-control form-control-lg" id="work_info" name="work_info" 
                                                          placeholder="Describa detalladamente el trabajo de excavación que necesita realizar..." 
                                                          rows="4" required>{{ old('work_info') }}</textarea>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Información de Costos -->
                                    <div class="form-section">
                                        <h6><i class="ri-money-dollar-circle-line me-2"></i>Información de Costos</h6>
                                        
                                        <div class="alert alert-info">
                                            <i class="ri-information-line me-2"></i>
                                            <strong>Información importante:</strong>
                                            <ul class="mb-0 mt-2">
                                                <li><strong>Costo por hora:</strong> $18.750 (valor estándar)</li>
                                                <li><strong>Duración mínima:</strong> 8 horas por turno de trabajo</li>
                                                <li><strong>Costos Extras:</strong>Pueden existir costos adicionales que no dependen de las horas trabajadas</li>
                                            </ul>
                                            <br>
                                            <strong>Despues de enviar la solicitud, nos pondremos en contacto para coordinar más detalles.</strong>
                                        </div>
                                    </div>

                                    <!-- Botones -->
                                    <div class="col-xl-12 d-grid mt-3">
                                        <div class="spinner-border text-primary d-none" role="status" id="spinnerCliente">
                                        </div>
                                        <button type="submit" class="btn btn-lg btn-primary" id="btnCliente">
                                            <i class="ri-send-plane-line me-2"></i>Enviar Solicitud
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection

@section('scripts')
    <script>
        document.getElementById('formCliente').addEventListener('submit', function() {
            document.getElementById('btnCliente').classList.add('d-none');
            document.getElementById('spinnerCliente').classList.remove('d-none');
        });

        function formatRUT(input) {
            let value = input.value.replace(/\./g, '').replace('-', '');
            if (value.length > 1) {
                value = value.slice(0, -1).replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '-' + value.slice(-1);
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

    <!-- SHOW PASSWORD JS -->
    <script src="{{asset('build/assets/show-password.js')}}"></script>

@endsection
