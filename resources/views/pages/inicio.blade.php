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
    </style>
@endsection

@section('content')
    @section('error-body')
    <body>
    @endsection

        <div class="container">
            <div class="row justify-content-center align-items-center authentication authentication-basic h-100">
                <div class="col-xxl-4 col-xl-5 col-lg-5 col-md-6 col-sm-8 col-12">
                    <div class="my-5 d-flex justify-content-center">
                        <a href="{{url('index')}}">
                            <img src="{{asset('build/assets/images/brand-logos/adentu-sidebar.png')}}" alt="logo" class="adentu-sidebar">
                            <img src="{{asset('build/assets/images/brand-logos/desktop-dark.png')}}" alt="logo" class="desktop-dark">
                        </a>
                    </div>
                    <div class="card custom-card">
                        <div class="card-body p-5">
                            <p class="h5 fw-semibold mb-2 text-center">Iniciar Sesión</p>
                            <p class="mb-4 text-muted op-7 fw-normal text-center">¡Bienvenido!</p>
                            <div class="row gy-3">
                                <form method="POST" action="{{ route('login') }}" id="formInicio">
                                    @csrf
                                    <div class="col-xl-12">
                                        <label for="username" class="form-label text-default">Email</label>
                                        <input type="text" class="form-control form-control-lg" id="username" name="username" placeholder="nombre de usuario">
                                    </div>
                                    <div class="col-xl-12 mb-2">
                                        <br>
                                        <!--label for="password" class="form-label text-default d-block">Contraseña<a href="{{ url('resetpassword-basic') }}" class="float-end text-danger">¿Olvidó su contraseña?</a></label-->
                                        <div class="input-group">
                                            <input type="password" class="form-control form-control-lg" id="password" name="password" placeholder="contraseña">
                                            <button class="btn btn-light" type="button" onclick="createpassword('password',this)" id="button-addon2"><i class="ri-eye-off-line align-middle"></i></button>
                                        </div>
                                        <div class="mt-2">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label text-muted fw-normal" for="defaultCheck1">
                                                    ¿Recordar contraseña?
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-12 d-grid mt-2">
                                        <div class="spinner-border text-primary d-none" role="status" id="spinnerInicio">
                                        </div>
                                        <button type="submit" class="btn btn-lg btn-primary" id="btnInicio">Iniciar sesión</button>
                                    </div>
                                    @if ($errors->any())
                                        <div class="alert alert-danger">
                                            {{ $errors->first('error') }}
                                        </div>
                                    @endif
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
            document.getElementById('formInicio').addEventListener('submit', function() {
                document.getElementById('btnInicio').classList.add('d-none');
                document.getElementById('spinnerInicio').classList.remove('d-none');
            });
        </script>

        <!-- SHOW PASSWORD JS -->
        <script src="{{asset('build/assets/show-password.js')}}"></script>

@endsection