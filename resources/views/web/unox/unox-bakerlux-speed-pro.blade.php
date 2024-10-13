@section('title',       'Bakerlux SPEED.Pro™ | Unox')
@section('description', 'SPEED.Pro™ es el primer baking speed oven: horno de convección y horno de cocción acelerada juntos en un único equipo.')
@section('image',       asset('images/unox/bakerlux-speed-pro/bg-speed-pro.webp'))
@extends('web._layout.master.app')

@push('customCss')
    @vite(['resources/assets/scss/web/unox.scss'])
@endpush

@section('content')
    <div class="bg-unox">
        <div class="container-fluid mb-5">
            @include('web._layout.banner.banner-landing', [
                    'slide'         => asset('images/unox/bakerlux-speed-pro/bg-speed-pro.webp')
                ,   'slide_alt'     => 'Bakerlux SPEED.Pro™ | Unox'
                ,   'summary'       => TRUE
                ,   'logo_image'    => asset('images/unox/unox.svg')
                ,   'logo_width'    => '50%'
                ,   'logo_height'   => '100%'
                ,   'title'         => "<strong>Bakerlux SPEED.Pro™ | Unox</strong>"
                ,   'h1'            => TRUE
                ,   'cta'           => route('results', ['termino' => 'bakerlux+speed', 'filter' => 'y', 'brand' => 'UNOX'])
            ])
        </div>

        <main class="mt-5 mb-5">
            <section class="container py-3 mb-1">
                <div class="row mb-5">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="{{ asset('images/unox/bakerlux-speed-pro/speed-pro.webp') }}" alt="Bakerlux SPEED.Pro">
                    </div>
                    <div class="col-md-6">
                        <h2>Un corazón, dos almas.</h2>
                        <p>
                            SPEED.Pro™ es el primer baking speed oven: horno de convección y horno de cocción acelerada juntos en un único equipo. Mímino espacio, máximo rendimiento.
                        </p>
                    </div>

                    @include('web.unox.partials.unox-catalogo-download', ['doc' => 'bakerlux-speedpro'])
                </div>
            </section>

            <section class="bg-black mb-5 py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 text-center">
                            <img class="img-fluid" src="{{ asset('images/unox/bakerlux-speed-pro/bg-burger.webp') }}" alt="Bakerlux SPEED.Pro">
                        </div>
                        <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                            <span class="normal">Máxima velocidad</span>
                            <span class="big">Triple cocción</span>
                            <div>
                                <strong>1  CONVECCIÓN</strong> - Dorado externo<br><br>
                                <strong>2  MICROONDAS</strong> - Cocción interna<br><br>
                                <strong>3  CONDUCCIÓN</strong> - Dorado por contacto
                            </div>
                        </div>
                        <div class="col-12">
                            <img class="img-fluid" src="{{ asset('images/unox/bakerlux-speed-pro/bg-2in1.webp') }}" alt="Bakerlux SPEED.Pro">
                        </div>
                    </div>
                </div>
            </section>

            <section class="container mb-5">
                <h3 class="speedpro">Modalidad <span class="bake">BAKE</span></h3>

                <div class="row">
                    <div class="col-md-6">
                        <img class="img-fluid" src="{{ asset('images/unox/bakerlux-speed-pro/bg-modo-bake.webp') }}" alt="Bakerlux SPEED.Pro">
                    </div>
                    <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                        <span class="medium">3 bandejas 460 x 330</span>
                        <p>
                            La amplia cámara de cocción con ventilador a doble velocidad es perfecta para dorar productos de horno. Conquista a tus clientes, diversifica tu oferta y aumenta tu rentabilidad.
                        </p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-3 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/bakerlux-speed-pro/ico-croissant.webp') }}" alt="Baker Mode Time"><br>
                        <strong>27 Croissants</strong>
                        <p>en 16 minutos</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/bakerlux-speed-pro/ico-strudel.webp') }}" alt="Baker Mode Time"><br>
                        <strong>27 Mini Strudels</strong>
                        <p>en 25 minutos</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/bakerlux-speed-pro/ico-pastel-danes.webp') }}" alt="Baker Mode Time"><br>
                        <strong>36 Pasteles Daneses</strong>
                        <p>en 20 minutos</p>
                    </div>
                    <div class="col-md-3 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/bakerlux-speed-pro/ico-panecillo.webp') }}" alt="Baker Mode Time"><br>
                        <strong>45 Panecillos</strong>
                        <p>en 16 minutos</p>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                        <span class="yellow-bake big">Cocciones a convección impecables</span>
                        <p>
                            La modalidad BAKE permite realizar cocciones de convección en más pasos, memorizar los programas más utilizados o disponer de los programas automáticos CHEFUNOX.
                        </p>
                        <p>
                            Perfecto para dorar productos de horno congelados y para la cocción de otros alimentos. Permite reducir el tiempo empleado en los procesos de cocción añadiendo uno o varios pasos con combinación de convección y microondas.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <img class="img-fluid" src="{{ asset('images/unox/bakerlux-speed-pro/bg-croissant.webp') }}" alt="Bakerlux SPEED.Pro">
                    </div>
                </div>

                <div class="bg-soft-gray py-3">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <strong>Capacidad</strong>
                            <p>3 bandejas 460 x 330</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <strong>Potencia Convección</strong>
                            <p>3.2 kW</p>
                        </div>
                        <div class="col-md-4 text-center">
                            <strong>Velocidad Ventilador</strong>
                            <p>2750 / 1700 rpm</p>
                        </div>
                    </div>
                </div>
            </section>

            <div class="bg-black py-5 mb-5">
                <section class="container">
                    <h3 class="speedpro">Modalidad <span class="speed">SPEED</span></h3>

                    <div class="row">
                        <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                            <span class="medium">1 bandeja 450 x 330</span>
                            <p>
                                La opción de cocción acelerada permite calentar en pocos segundos tanto raciones individuales como multiples. Los tiempos de servicio disminuyen y las ganancias se multiplican.
                            </p>
                        </div>
                        <div class="col-md-6">
                            <img class="img-fluid" src="{{ asset('images/unox/bakerlux-speed-pro/bg-modo-speed.webp') }}" alt="Bakerlux SPEED.Pro">
                        </div>
                    </div>

                    <div class="row mb-5">
                        <div class="col-md-3 text-center">
                            <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/bakerlux-speed-pro/ico-croissant-relleno.webp') }}" alt="Baker Mode Time"><br>
                            <strong>9 Croissants rellenos</strong>
                            <p>en 50 segundos</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/bakerlux-speed-pro/ico-sandwich.webp') }}" alt="Baker Mode Time"><br>
                            <strong>4 Sandwich club</strong>
                            <p>en 125 segundos</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/bakerlux-speed-pro/ico-sandwich-mixto.webp') }}" alt="Baker Mode Time"><br>
                            <strong>4 Sandwiches mixtos</strong>
                            <p>en 75 segundos</p>
                        </div>
                        <div class="col-md-3 text-center">
                            <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/bakerlux-speed-pro/ico-lasana.webp') }}" alt="Baker Mode Time"><br>
                            <strong>250 gr Lasaña</strong>
                            <p>en 100 segundos</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <img class="img-fluid" src="{{ asset('images/unox/bakerlux-speed-pro/bg-speed-time.webp') }}" alt="Bakerlux SPEED.Pro">
                        </div>
                        <div class="col-md-6 d-flex align-items-center justify-content-center flex-column">
                            <span class="green-speed big">Cocción acelerada multiporción</span>
                            <p>
                                El tamaño limitado de una bandeja de speed-oven tradicional no permite hornear más de un sándwich a la vez. Esto se traduce en largos tiempos de espera en momentos de mucha prisa.
                            </p>
                            <p>
                                Gracias a SPEED.Pro™ y a la superficie de 450 x 330 mm de la bandeja especial SPEED.Plate puedes hornear hasta 4 o más sándwiches al mismo tiempo y conseguir que tus clientes nunca tengan que volver a esperar.
                            </p>
                        </div>
                    </div>

                    <div class="bg-slate py-3">
                        <div class="row">
                            <div class="col-md-4 text-center">
                                <strong>Capacidad speed mode</strong>
                                <p>1 bandeja 450 x 330</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>Convección + microondas</strong>
                                <p>6.5 kW</p>
                            </div>
                            <div class="col-md-4 text-center">
                                <strong>Temperatura máxima<br>funcionamiento continuo </strong>
                                <p>260 °C</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>

            @include('web.unox.partials.unox-products-view', ['featured' => $featured])
            <hr>
            {{-- CATALOGOS --}}
            <section class="container py-5 mb-5">
                @include('web.unox.partials.unox-catalogos')
            </section>
        </main>
    </div>
@endsection

@push('customJs')
    @vite(['resources/assets/js/web/unox-swiper.js'])
@endpush

