@section('title',       'Speed X™ | Unox')
@section('description', 'El primer horno combinado de cocción acelerada con lavado automático.')
@section('image',       asset('images/unox/banner/1655129815233.webp'))
@extends('web._layout.master.app')

@push('customCss')
    @vite(['resources/assets/scss/web/unox.scss'])
@endpush

@section('content')
    <div class="bg-unox">
        <div class="container-fluid mb-5">
            @include('web._layout.banner.banner-landing', [
                    'video'         => url('storage/catalogos/unox/speed-x-reel.mp4')
                ,   'summary'       => TRUE
                ,   'title'         => "<strong>Speed X™ | Unox</strong>"
                ,   'h1'            => TRUE
                ,   'cta'           => route('results', ['termino' => 'speed-x', 'filter' => 'y', 'brand' => 'UNOX'])
            ])
        </div>

        <main class="mt-5 mb-5">
            <section class="container py-3 mb-1">
                <div class="row mb-5">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <img class="img-fluid" style="max-width: 60%" src="{{ asset('images/unox/featured/speed-x.webp') }}" alt="SPEED-X&trade;">
                    </div>
                    <div class="col-md-6">
                        <h2>Bienvenido en la era del servicio hiperacelerado.</h2>
                        <p>
                            <strong>SPEED-X&trade;</strong> es el primer horno combinado de cocción acelerada con lavado automático: la combinación perfecta de calidad y velocidad. Rendimiento inimaginable, sin renuncias.
                        </p>
                        <div class="text-center mb-2">
                            <img width="170" height="98" src="{{ asset('images/unox/reddot-winner-2022-best-of-best.jpeg') }}" alt="RedDot Winner 2022 Best of Best">
                        </div>
                        <p>
                            La limpieza de los hornos de cocción acelerada ya no es un problema.<br>
                            <strong>SPEED-X&trade;</strong> tiene un sistema de lavado automático ROTOR.Klean integrado con un tanque de DET&Rinse™ de 1L y un sistema de filtración de agua RO.Care para garantizar hasta 1300L de agua filtrada. Eso no es todo: gracias al sensor SENSE.Klean, el horno puede detectar cuidadosamente el grado de suciedad y sugerir el modo de lavado más adecuado para evitar desperdicios.<br>
                            <b>¡Lo hace todo!</b>
                        </p>
                    </div>

                    @include('web.unox.partials.unox-catalogo-download', ['doc' => NULL])
                </div>
            </section>

            <section class="bg-black mb-5 py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-12 order-0 text-center">
                            <span class="normal">Cocción Hiperacelerada</span><br>
                            <span class="big">Un horno. Tres modos de cocción.</span>
                        </div>

                        <div class="col-12 order-0 mt-5 mb-3 text-center">
                            <h3 class="speedx mb-1">Cocción <span class="speed">HYPER.Speed.</span></h3>
                            <span class="normal">La revolucionaria tecnología que combina la cocción combinada con las microondas.</span>
                        </div>

                        <div class="col-md-6 order-1 mb-3 text-center d-flex flex-column align-items-center justify-content-center">
                            <span class="big">COMBI.speed</span>
                            <ul class="properties">
                                <li>
                                    <span class="green-speed">✔</span> 200 gramos de chicharrón en <span class="green-speed">120 segundos.</span>
                                </li>
                                <li>
                                    <span class="green-speed">✔</span> 500 gramos de carne asada en <span class="green-speed">150 segundos.</span>
                                </li>
                                <li>
                                    <span class="green-speed">✔</span> 350 gramos de alambre de carne con verduras y queso en <span class="green-speed">230 segundos.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 order-1 mb-3">
                            <img class="img-fluid" src="{{ asset('images/unox/speed-x/bg-combi-speed.webp') }}" alt="COMBI.speed">
                        </div>

                        <div class="col-md-6 order-md-3 order-2 mb-3 text-center d-flex flex-column align-items-center justify-content-center">
                            <span class="big">MULTI.speed</span>
                            <ul class="properties">
                                <li>
                                    <span class="green-speed">✔</span> 300 gramos de nopales en <span class="green-speed">100 segundos.</span>
                                </li>
                                <li>
                                    <span class="green-speed">✔</span> 400 gramos de chorizo con papas en <span class="green-speed">210 segundos.</span>
                                </li>
                                <li>
                                    <span class="green-speed">✔</span> 430 gramos de chiles toreados con cebolla cambray en <span class="green-speed">200 segundos.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 order-md-2 order-3 mb-3">
                            <img class="img-fluid" src="{{ asset('images/unox/speed-x/bg-multi-speed.webp') }}" alt="MULTI.speed">
                        </div>

                        <div class="col-12 order-md-4 text-center mb-4">
                            <span class="big">Cocción</span> <span class="big blue-combi">Combinada</span><br>
                            <span class="normal">La convección y el vapor se combinan para garantizar una cocción perfecta.</span>
                        </div>

                        <div class="col-md-6 order-md-4 mb-3 text-center d-flex flex-column align-items-center justify-content-center">
                            <span class="big">Cocción combinada</span>
                            <ul class="properties">
                                <li>
                                    <span class="blue-combi">✔</span> 200 gramos de camarones para brocheta en <span class="blue-combi">90 segundos.</span>
                                </li>
                                <li>
                                    <span class="blue-combi">✔</span> 300 gramos de tamales oaxaqueños en <span class="blue-combi">220 segundos.</span>
                                </li>
                                <li>
                                    <span class="blue-combi">✔</span> 600 gramos de elotes en <span class="blue-combi">210 segundos.</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6 order-md-4 mb-3">
                            <img class="img-fluid" src="{{ asset('images/unox/speed-x/bg-coccion-combinada.webp') }}" alt="Cocción Combinada">
                        </div>
                    </div>
                </div>
            </section>

            <section class="container mb-5">
                <div class="bg-soft-gray py-3">
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="normal">Lavado automático</span><br>
                            <span class="big">No falta nada, ni siquiera el lavado.</span><br>
                            <p>
                                Autolavado y filtración de agua.
                            </p>
                        </div>
                    </div>
                </div>
            </section>

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

