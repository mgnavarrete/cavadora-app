@extends('layouts.landing-master')

@section('title', 'La Cavadora — Arriendo de mini excavadora con operador')
@section('description', 'Arrienda una mini excavadora con operador para jardines, piscinas, zanjas y nivelación. Acceso a espacios reducidos. Cotiza fácil y rápido.')

@section('meta')
    <meta property="og:title" content="La Cavadora — Arriendo de mini excavadora con operador">
    <meta property="og:description" content="Arrienda una mini excavadora con operador para jardines, piscinas, zanjas y nivelación. Acceso a espacios reducidos. Cotiza fácil y rápido.">
    <meta property="og:image" content="{{asset('build/assets/images/landing/cavadora.png')}}">
    <meta property="og:url" content="{{url('/')}}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="La Cavadora — Arriendo de mini excavadora con operador">
    <meta name="twitter:description" content="Arrienda una mini excavadora con operador para jardines, piscinas, zanjas y nivelación. Acceso a espacios reducidos. Cotiza fácil y rápido.">
    <meta name="twitter:image" content="{{asset('build/assets/images/landing/cavadora.png')}}">
@endsection

@section('styles')
 
        <!-- SWIPERJS CSS -->
        <link rel="stylesheet" href="{{asset('build/assets/libs/swiper/swiper-bundle.min.css')}}">
        
        <!-- CUSTOM CAVADORA STYLES -->
        <style>
            :root {
                --cavadora-primary: #EE7B12;
                --cavadora-secondary: #093B53;
                --cavadora-primary-light: #FF8C42;
                --cavadora-secondary-light: #0F4A6B;
            }
            
            /* Botones primarios */
            .btn-primary {
                background-color: var(--cavadora-primary) !important;
                border-color: var(--cavadora-primary) !important;
            }
            
            .btn-primary:hover {
                background-color: var(--cavadora-primary-light) !important;
                border-color: var(--cavadora-primary-light) !important;
            }
            
            .btn-outline-primary {
                color: var(--cavadora-primary) !important;
                border-color: var(--cavadora-primary) !important;
            }
            
            .btn-outline-primary:hover {
                background-color: var(--cavadora-primary) !important;
                border-color: var(--cavadora-primary) !important;
            }
            
            /* Botón secundario personalizado */
            .btn-outline-light {
                background-color: white !important;
                color: var(--cavadora-primary) !important;
                border-color: var(--cavadora-primary) !important;
            }
            
            .btn-outline-light:hover {
                background-color: var(--cavadora-primary) !important;
                color: white !important;
                border-color: var(--cavadora-primary) !important;
            }
            
            /* Texto primario */
            .text-primary {
                color: var(--cavadora-primary) !important;
            }
            
            /* Backgrounds */
            .bg-primary {
                background-color: var(--cavadora-primary) !important;
            }
            
            .bg-primary-transparent {
                background-color: rgba(238, 123, 18, 0.1) !important;
            }
            
            /* Landing banner */
            .landing-banner {
                background: linear-gradient(135deg, var(--cavadora-secondary) 0%, var(--cavadora-secondary-light) 100%) !important;
            }
            
            /* Landing features section */
            .landing-Features {
                background: linear-gradient(135deg, var(--cavadora-secondary) 0%, var(--cavadora-secondary-light) 100%) !important;
            }
            
            /* Landing footer */
            .landing-footer {
                background: linear-gradient(135deg, var(--cavadora-secondary) 0%, var(--cavadora-secondary-light) 100%) !important;
            }
            
            /* Section background */
            .section-bg {
                background-color: rgba(9, 59, 83, 0.05) !important;
            }
            
            /* Cards hover effects */
            .custom-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 8px 25px rgba(238, 123, 18, 0.15) !important;
                transition: all 0.3s ease;
            }
            
            /* Avatar backgrounds */
            .avatar.bg-primary-transparent {
                background-color: rgba(238, 123, 18, 0.1) !important;
                color: var(--cavadora-primary) !important;
            }
            
            /* Sticky CTA */
            .sticky-bottom .bg-primary {
                background-color: var(--cavadora-primary) !important;
            }
            
            /* Success color for headings */
            .text-success {
                color: var(--cavadora-primary) !important;
            }
            
            /* Landing section heading */
            .landing-section-heading {
                color: var(--cavadora-primary) !important;
            }
            
            /* Accordion */
            .accordion-button:not(.collapsed) {
                background-color: rgba(238, 123, 18, 0.1) !important;
                color: var(--cavadora-secondary) !important;
            }
            
            .accordion-button:focus {
                box-shadow: 0 0 0 0.25rem rgba(238, 123, 18, 0.25) !important;
            }
            
            /* Navbar button */
            .btn-outline-primary {
                color: var(--cavadora-primary) !important;
                border-color: var(--cavadora-primary) !important;
            }
            
            .btn-outline-primary:hover {
                background-color: var(--cavadora-primary) !important;
                border-color: var(--cavadora-primary) !important;
            }
            
            /* Asegurar que los enlaces del sidebar sean clickeables */
            .side-menu__item {
                cursor: pointer !important;
                text-decoration: none !important;
                display: block !important;
            }
            
            .side-menu__item:hover {
                text-decoration: none !important;
            }
        </style>
      
@endsection

@section('content')

                    <!-- Start:: Section-1 -->
                    <div class="landing-banner" id="home">
                        <section class="section">
                            <div class="container main-banner-container pb-lg-0">
                                <div class="row">
                                    <div class="col-xxl-7 col-xl-7 col-lg-7 col-md-8">
                                        <div class="py-lg-5">
                                            <div class="mb-3">
                                            <h5 class="fw-semibold text-fixed-white op-9">LA CAVADORA</h5>
                                            </div>
                                            <p class="landing-banner-heading mb-3">Arrienda una mini excavadora <br><span class="text-primary">fácil, rápido y seguro</span></p>
                                            <div class="fs-16 mb-5 text-fixed-white op-7">Resolvemos excavaciones en jardines, piscinas, zanjas, nivelación de suelos y más. Accedemos a lugares donde una máquina grande no puede.</div>
                                            <div class="d-flex gap-3 flex-wrap">
                                                <a href="{{route('orders.createFromClient')}}" class="btn btn-primary btn-wave">Rellenar formulario</a>
                                                <a href="https://wa.me/5695193903" class="btn btn-outline-light btn-wave" target="_blank"><i class="ti ti-brand-whatsapp fs-15"></i>Agendar por WhatsApp</a>
                                                <a href="https://instagram.com/la.cavadora" class="btn btn-outline-light btn-wave" target="_blank"><i class="ti ti-brand-instagram fs-15"></i>Siguenos</a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xxl-5 col-xl-5 col-lg-5 col-md-4">
                                        <div class="text-end landing-main-image landing-heading-img">
                                            <img src="{{asset('build/assets/images/landing/cavadora.png')}}" alt="Mini excavadora La Cavadora" class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                    <!-- End:: Section-1 -->

                    <!-- Start:: Section-3 -->
                    <section class="section" id="servicios">
                        <div class="container text-center">
                            <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">NUESTROS SERVICIOS</span></p>
                            <h3 class="fw-semibold mb-2">¿Qué podemos hacer por ti?</h3>
                            <div class="row justify-content-center">
                                <div class="col-xl-7">
                                    <p class="text-muted fs-15 mb-5 fw-normal">Ofrecemos servicios especializados de excavación con mini excavadora y operador experimentado para diversos proyectos.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='ti ti-trees fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Jardines</h6>
                                            <p class="text-muted mb-0">Excavación para jardines, huertos y paisajismo</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='bx bx-water fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Piscinas</h6>
                                            <p class="text-muted mb-0">Excavación para piscinas y jacuzzis</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='ti ti-shovel fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Zanjas</h6>
                                            <p class="text-muted mb-0">Zanjas para cables, tuberías y drenajes</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='ti ti-grain fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Nivelación</h6>
                                            <p class="text-muted mb-0">Nivelación de terrenos y preparación de suelos</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='ti ti-golf fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Postes</h6>
                                            <p class="text-muted mb-0">Excavación para postes y cimientos</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='ti ti-hammer fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Demoliciones</h6>
                                            <p class="text-muted mb-0">Demoliciones menores y retiro de estructuras</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='bx bx-package fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Escombros</h6>
                                            <p class="text-muted mb-0">Movimiento y retiro de escombros</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='bx bx-plus-circle fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Otros</h6>
                                            <p class="text-muted mb-0">Proyectos especiales y consultoría</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <a href="{{route('orders.createFromClient')}}" class="btn btn-primary btn-wave">Quiero cotizar</a>
                            </div>
                        </div> 
                    </section>
                    <!-- End:: Section-3 -->

                    <!-- Start:: Section-4 -->
                    <section class="section section-bg" id="proceso">
                        <div class="container text-center">
                            <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">CÓMO FUNCIONA</span></p>
                            <h2 class="fw-semibold mb-2">Proceso simple en 4 pasos</h2>
                            <div class="row justify-content-center mb-5">
                                <div class="col-xl-7">
                                    <p class="text-muted fs-15 mb-0 fw-normal">Hacer realidad tu proyecto es más fácil de lo que piensas. Te acompañamos en cada paso del proceso.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <span class="fw-bold fs-20">1</span>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Mándanos tu solicitud</h6>
                                            <p class="text-muted mb-0">Completa el formulario con los detalles de tu proyecto</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <span class="fw-bold fs-20">2</span>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Te contactamos</h6>
                                            <p class="text-muted mb-0">Revisamos tu solicitud y te llamamos para coordinar</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <span class="fw-bold fs-20">3</span>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Coordinamos día y lugar</h6>
                                            <p class="text-muted mb-0">Acordamos fecha, hora y detalles del trabajo</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-6 col-sm-6 col-12">
                                    <div class="card custom-card text-center">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <span class="fw-bold fs-20">4</span>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Ejecutamos el trabajo</h6>
                                            <p class="text-muted mb-0">Llegamos con la máquina y operador para realizar el trabajo</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <a href="{{route('orders.createFromClient')}}" class="btn btn-primary btn-wave">Agendar mi proyecto</a>
                            </div>
                        </div>
                    </section>
                    <!-- End:: Section-4 -->

                    <!-- Start:: Section-5 -->
                    <section class="section landing-Features" id="quienes-somos">
                        <div class="container">
                            <div class="row align-items-center">
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                    <div class="text-center text-lg-start">
                                        <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">QUIÉNES SOMOS</span></p>
                                        <h2 class="fw-semibold mb-3 text-fixed-white">En La Cavadora acercamos maquinaria compacta a proyectos reales</h2>
                                        <p class="text-fixed-white op-8 fs-15 mb-4 fw-normal">Contamos con operadores experimentados y un enfoque en seguridad, prolijidad y buen trato. Nuestra experiencia nos permite ofrecer soluciones eficientes para proyectos de excavación en espacios reducidos.</p>
                                        <div class="d-flex gap-3 flex-wrap justify-content-center justify-content-lg-start">
                                            <a href="{{route('orders.createFromClient')}}" class="btn btn-primary btn-wave">Rellenar formulario</a>
                                            <a href="https://wa.me/5695193903" class="btn btn-outline-light btn-wave" target="_blank"><i class="ti ti-brand-whatsapp fs-20"></i></a>
                                            <a href="https://instagram.com/la.cavadora" class="btn btn-outline-light btn-wave" target="_blank"><i class="ti ti-brand-instagram fs-20"></i></a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                                    <div class="text-center">
                                        <img src="{{asset('build/assets/images/landing/operador-profesional.png')}}" alt="Operador profesional de La Cavadora" class="img-fluid rounded">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End:: Section-5 -->

                    <!-- Start:: Section-FAQ -->
                    <section class="section section-bg" id="faq">
                        <div class="container">
                            <div class="row justify-content-center">
                                <div class="col-xl-8">
                                    <div class="text-center mb-5">
                                        <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">PREGUNTAS FRECUENTES</span></p>
                                        <h2 class="fw-semibold mb-2">Resolvemos tus dudas</h2>
                                        <p class="text-muted fs-15 mb-0 fw-normal">Aquí tienes las respuestas a las preguntas más comunes sobre nuestros servicios.</p>
                                    </div>
                                    <div class="accordion" id="faq-accordion">
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq1">
                                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse1" aria-expanded="true" aria-controls="collapse1">
                                                    ¿En qué zonas trabajan?
                                                </button>
                                            </h2>
                                            <div id="collapse1" class="accordion-collapse collapse show" aria-labelledby="faq1" data-bs-parent="#faq-accordion">
                                                <div class="accordion-body">
                                                    Trabajamos en la Región Metropolitana y zonas aledañas. Para confirmar disponibilidad en tu comuna, contáctanos directamente.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq2">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse2" aria-expanded="false" aria-controls="collapse2">
                                                    ¿El precio incluye operador?
                                                </button>
                                            </h2>
                                            <div id="collapse2" class="accordion-collapse collapse" aria-labelledby="faq2" data-bs-parent="#faq-accordion">
                                                <div class="accordion-body">
                                                    Sí, todos nuestros servicios incluyen operador experimentado. No necesitas tener conocimientos de maquinaria.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq3">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse3" aria-expanded="false" aria-controls="collapse3">
                                                    ¿Cómo se calculan los precios?
                                                </button>
                                            </h2>
                                            <div id="collapse3" class="accordion-collapse collapse" aria-labelledby="faq3" data-bs-parent="#faq-accordion">
                                                <div class="accordion-body">
                                                    Los precios varían según el tipo de trabajo, duración, dificultad y ubicación. Te damos una cotización personalizada sin compromiso.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq4">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse4" aria-expanded="false" aria-controls="collapse4">
                                                    ¿Qué pasa si llueve el día programado?
                                                </button>
                                            </h2>
                                            <div id="collapse4" class="accordion-collapse collapse" aria-labelledby="faq4" data-bs-parent="#faq-accordion">
                                                <div class="accordion-body">
                                                    Si las condiciones climáticas no permiten trabajar de forma segura, reagendamos sin costo adicional para la primera fecha disponible.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq5">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">
                                                    ¿Pueden enviar fotos del trabajo realizado?
                                                </button>
                                            </h2>
                                            <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="faq5" data-bs-parent="#faq-accordion">
                                                <div class="accordion-body">
                                                    Sí, al finalizar el trabajo te enviamos fotos del antes y después por WhatsApp para que veas el resultado.
                                                </div>
                                            </div>
                                        </div>
                                        <div class="accordion-item">
                                            <h2 class="accordion-header" id="faq6">
                                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">
                                                    ¿Qué formas de pago aceptan?
                                                </button>
                                            </h2>
                                            <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="faq6" data-bs-parent="#faq-accordion">
                                                <div class="accordion-body">
                                                    Aceptamos efectivo, transferencia bancaria y tarjeta de débito/crédito. El pago se realiza al finalizar el trabajo.
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End:: Section-FAQ -->

                    <!-- Start:: Section-10 -->
                    <section class="section" id="contact">
                        <div class="container text-center">
                            <p class="fs-12 fw-semibold text-success mb-1"><span class="landing-section-heading">CONTÁCTANOS</span></p>
                            <h3 class="fw-semibold mb-2">¿Listo para tu proyecto? ¡Hablemos!</h3>
                            <div class="row justify-content-center">
                                <div class="col-xl-9">
                                    <p class="text-muted fs-15 mb-5 fw-normal">Contáctanos para cotizar tu proyecto o resolver cualquier duda. Estamos aquí para ayudarte.</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card custom-card text-center h-100">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='bx bx-phone fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Teléfono / WhatsApp</h6>
                                            <p class="text-muted mb-3">+56 9 5193 903</p>
                                            <a href="https://wa.me/5695193903" class="btn btn-outline-light btn-sm" target="_blank">Escribir por WhatsApp</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card custom-card text-center h-100">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='bx bx-envelope fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Email</h6>
                                            <p class="text-muted mb-3">tu-email@lacavadora.cl</p>
                                            <a href="mailto:tu-email@lacavadora.cl" class="btn btn-outline-light btn-sm">Enviar email</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-6 col-sm-12 mb-4">
                                    <div class="card custom-card text-center h-100">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <span class="avatar avatar-lg avatar-rounded bg-primary-transparent">
                                                    <i class='bx bxl-instagram fs-25'></i>
                                                </span>
                                            </div>
                                            <h6 class="fw-semibold mb-2">Instagram</h6>
                                            <p class="text-muted mb-3">@la.cavadora</p>
                                            <a href="https://instagram.com/la.cavadora" class="btn btn-outline-light btn-sm" target="_blank">Seguir en Instagram</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-5">
                                <a href="{{route('orders.createFromClient')}}" class="btn btn-primary btn-wave btn-lg">Agendar mi proyecto</a>
                            </div>
                        </div>
                    </section>
                    <!-- End:: Section-10 -->

                    <!-- Start:: Section-11 -->
                    <section class="section landing-footer text-fixed-white">
                        <div class="container">
                            <div class="row justify-content-between">
                                <div class="col-md-4 col-sm-6 col-12 mb-md-0 mb-3">
                                    <div class="px-4">
                                        <p class="fw-semibold mb-3"><a href="{{url('/')}}"><img src="{{asset('build/assets/images/brand-logos/desktop-white.png')}}" alt="La Cavadora" style="max-height: 50px;"></a></p>
                                        <p class="mb-2 op-6 fw-normal">
                                            Arriendo de mini excavadora
                                        </p>
                                        <p class="mb-0 op-6 fw-normal"><span class="text-muted fs-15"> Copyright © <span id="year"></span> <a
                                            href="#" class="text-secondary fw-semibold"><u>La Cavadora</u></a>.
                                            <br>
                                            Todos los derechos reservados.
                                        </span></p>
                                    </div>
                                </div>
                                
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="px-4">
                                        <h6 class="fw-semibold text-fixed-white">ENLACES RÁPIDOS</h6>
                                        <ul class="list-unstyled fw-normal landing-footer-list">
                                            <li>
                                                <a href="#servicios" class="text-fixed-white op-6">Servicios</a>
                                            </li>
                                            <li>
                                                <a href="#proceso" class="text-fixed-white op-6">Cómo funciona</a>
                                            </li>
                                            <li>
                                                <a href="#quienes-somos" class="text-fixed-white op-6">Quiénes somos</a>
                                            </li>
                                            <li>
                                                <a href="#faq" class="text-fixed-white op-6">Preguntas frecuentes</a>
                                            </li>
                                            <li>
                                                <a href="{{route('orders.createFromClient')}}" class="text-fixed-white op-6">Pedir servicio</a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                               
                                <div class="col-md-4 col-sm-6 col-12">
                                    <div class="px-4">
                                        <h6 class="fw-semibold text-fixed-white">CONTACTO</h6>
                                        <ul class="list-unstyled fw-normal landing-footer-list">
                                            <li>
                                                <a href="javascript:void(0);" class="text-fixed-white op-6"><i class="ri-home-4-line me-1 align-middle"></i> Región Metropolitana, Chile</a>
                                            </li>
                                            <li>
                                                <a href="micavadora@gmail.com" class="text-fixed-white op-6"><i class="ri-mail-line me-1 align-middle"></i> micavadora@gmail.com</a>
                                            </li>
                                            <li>
                                                <a href="https://wa.me/5695193903" class="text-fixed-white op-6" target="_blank"><i class="ri-phone-line me-1 align-middle"></i> +56 9 5193 903</a>
                                            </li>
                                            <li class="mt-3">
                                                <p class="mb-2 fw-semibold op-8">SÍGUENOS EN:</p>
                                                <div class="mb-0">
                                                    <div class="btn-list">
                                                        <a class="btn btn-sm btn-icon btn-outline-light btn-wave waves-effect waves-light" href="https://instagram.com/la.cavadora" target="_blank">
                                                            <i class="ri-instagram-line fw-bold"></i>
                                                        </a>
                                                        <a class="btn btn-sm btn-icon btn-outline-light btn-wave waves-effect waves-light" href="https://wa.me/5695193903" target="_blank">
                                                            <i class="ri-whatsapp-line fw-bold"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- End:: Section-11 -->

                    <!-- Sticky CTA Mobile -->
                    <div class="d-block d-lg-none sticky-bottom">
                        <div class="bg-primary text-center p-3">
                            <a href="{{route('orders.createFromClient')}}" class="btn btn-light btn-lg w-100 fw-semibold">
                                <i class="ri-phone-line me-2"></i>Pedir servicio
                            </a>
                        </div>
                    </div>

@endsection

@section('scripts')

        <!-- SWIPER JS -->
        <script src="{{asset('build/assets/libs/swiper/swiper-bundle.min.js')}}"></script>

        <!-- INTERNAL LANDING JS -->
        @vite('resources/assets/js/landing.js')


@endsection