@section('title',       'Evereo™ | Unox')
@section('description', 'Elija entre la mejor selección de productos y accesorios para crear la solución de cocina perfecta.')
@section('image',       asset('images/unox/evereo/bg-evereo.webp'))
@extends('web._layout.master.app')

@push('customCss')
    @vite(['resources/assets/scss/web/unox.scss'])
@endpush

@section('content')
    <div class="bg-unox">
        <div class="container-fluid mb-5">
            @include('web._layout.banner.banner-landing', [
                    'slide'         => asset('images/unox/evereo/bg-evereo.webp')
                ,   'slide_alt'     => 'Evereo™ | Unox'
                ,   'summary'       => TRUE
                ,   'logo_image'    => asset('images/unox/unox.svg')
                ,   'logo_width'    => '50%'
                ,   'logo_height'   => '100%'
                ,   'title'         => "<strong>Evereo™ | Unox</strong>"
                ,   'h1'            => TRUE
                ,   'cta'           => route('results', ['termino' => 'evereo', 'filter' => 'y', 'brand' => 'UNOX'])
            ])
        </div>

        <main class="mt-5 mb-5">
            <section class="container py-3 mb-1">
                <div class="row mb-5">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <img class="img-fluid" style="max-width: 70%" src="{{ asset('images/unox/evereo/evereo.webp') }}" alt="El Refrigerador Caliente">
                    </div>
                    <div class="col-md-6">
                        <h2>El Refrigerador Caliente.</h2>
                        <p>
                            <strong>EVEREO&reg;</strong> es el primer Refrigerador Caliente de la historia; un equipo único que conserva las comidas cocinadas durante días a la temperatura a la que se van a servir, usando una combinación de control de temperatura y atmósfera extremadamente preciso.
                        </p>
                    </div>

                    @include('web.unox.partials.unox-catalogo-download', ['doc' => 'evereo'])
                </div>

                <div class="row justify-content-around mb-3">
                    <div class="col-12">
                        <strong class="big">¿Por qué Evereo&reg;?</strong>
                    </div>
                    <div class="col-4 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/evereo/ico-cualidades.webp') }}" alt="Cualidades organolépticas y uniformidad de temperatura"><br>
                        <strong>Cualidades organolépticas y uniformidad de temperatura</strong>
                    </div>
                    <div class="col-4 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/evereo/ico-ahorro-energia.webp') }}" alt="Ahorro de energía"><br>
                        <strong>Ahorro de energía</strong>
                    </div>
                    <div class="col-4 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/evereo/ico-tiempo-servicio.webp') }}" alt="Tiempo de servicio"><br>
                        <strong>Tiempo de servicio</strong>
                    </div>
                    <div class="col-4 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/evereo/ico-cero-desperdicio.webp') }}" alt="Cero desperdicio de comida"><br>
                        <strong>Cero desperdicio de comida</strong>
                    </div>
                    <div class="col-4 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/evereo/ico-restaurante.webp') }}" alt="Restaurante sin cocina"><br>
                        <strong>Restaurante sin cocina</strong>
                    </div>
                    <div class="col-4 text-center">
                        <img class="img-fluid" style="max-width: 75px" src="{{ asset('images/unox/evereo/ico-ahorro-costes.webp') }}" alt="Ahorro de costes de mano de obra"><br>
                        <strong>Ahorro de costes de mano de obra</strong>
                    </div>
                </div>
            </section>

            <section class="bg-black mb-5 py-3">
                <div class="container">
                    <div class="row">
                        <div class="col-12 mt-3 mb-5">
                            <h3>¿Cómo usar Evereo&reg;?</h3>
                        </div>

                        <div class="col-md-6 mb-5 d-flex flex-column justify-content-center align-items-center">
                            <span class="normal">Cocine y conserve por hasta 72 horas</span><br>
                            <span class="big">MULTI.Day</span>
                            <p>
                                En combinación con las BOLSAS MULTI.Day y las BANDEJAS MULTI.Day, <strong>EVEREO&reg;</strong> le permite conservar los alimentos cocinados a la Temperatura de Servicio por hasta 72 horas. Cocine sus platos como siempre lo ha hecho y, siguiendo los consejos de nuestros chefs, consérvelos en <strong>EVEREO&reg;</strong>, así podrá servirlos tan pronto como se pidan, ¡con un tiempo de espera cero para sus clientes y con un aumento de sus ganancias!
                            </p>
                        </div>
                        <div class="col-md-6 mb-5">
                            <img class="img-fluid" src="{{ asset('images/unox/evereo/bg-multi-day.webp') }}" alt="MULTI.Day">
                        </div>

                        <div class="col-12 mb-5">
                            <hr>
                        </div>

                        <div class="col-md-6 mb-5">
                            <img class="img-fluid" src="{{ asset('images/unox/evereo/bg-superholding.webp') }}" alt="Superholding">
                        </div>
                        <div class="col-md-6 mb-5 d-flex flex-column justify-content-center align-items-center">
                            <span class="normal">Mantenga hasta 8 horas</span><br>
                            <span class="big">Superholding</span>
                            <p>
                                Conserve sus platos en <strong>EVEREO&reg;</strong> listos para ser servidos usando recipientes o bandejas sin sellar o abiertos. El control sumamente preciso de la temperatura y la humedad de <strong>EVEREO&reg;</strong> permite mantener la comida impecable hasta 4 veces más tiempo que en los armarios de mantenimiento tradicionales.
                            </p>
                        </div>

                        <div class="col-12 mb-5">
                            <hr>
                        </div>

                        <div class="col-md-6 mb-5 d-flex flex-column justify-content-center align-items-center">
                            <span class="normal">Conserve sin cocinar por hasta 72 horas</span><br>
                            <span class="big">Meal me</span>
                            <p>
                                La revolución es ahora: si usted tiene <strong>EVEREO&reg;</strong> y MEAL ME, puede usar la página de comercio electrónico mealmefood.com para añadir productos geniales a su menú, sin tener que cocinarlos. ¡Mantengan sus comidas siempre listas para ser servidas!
                            </p>
                        </div>
                        <div class="col-md-6 mb-5">
                            <img class="img-fluid" src="{{ asset('images/unox/evereo/bg-meal-me.webp') }}" alt="Meal me">
                        </div>
                    </div>
                </div>
            </section>

            <section class="container py-3 mb-1">
                <div class="row mb-5">
                    <div class="col-md-12">
                        <h2>Reconocimientos</h2>
                    </div>
                    <div class="col-md-3 text-center">
                        <img class="img-fluid" style="max-width: 220px" src="{{ asset('images/unox/evereo/rec-kitchen-innovations.webp') }}" alt="KITCHEN INNOVATIONS AWARDS - 2020"><br>
                        <strong>KITCHEN INNOVATIONS AWARDS - 2020</strong>
                    </div>
                    <div class="col-md-3 text-center">
                        <img class="img-fluid" style="max-width: 220px" src="{{ asset('images/unox/evereo/rec-fcsi.webp') }}" alt="FCSI - THE AMERICAS INNOVATION SHOWCASE 2020 FINALISTA"><br>
                        <strong>FCSI - THE AMERICAS INNOVATION SHOWCASE 2020 FINALISTA</strong>
                    </div>
                    <div class="col-md-3 text-center">
                        <img class="img-fluid" style="max-width: 220px" src="{{ asset('images/unox/evereo/rec-smart-label.webp') }}" alt="SMART LABEL - 2019"><br>
                        <strong>SMART LABEL - 2019</strong>
                    </div>
                    <div class="col-md-3 text-center">
                        <img class="img-fluid" style="max-width: 220px" src="{{ asset('images/unox/evereo/rec-commercial-kitchen.webp') }}" alt="COMMERCIAL KITCHEN SHOW MEDALLA DE ORO Y PLATA - 2018 - 2019"><br>
                        <strong>COMMERCIAL KITCHEN SHOW MEDALLA DE ORO Y PLATA - 2018 - 2019</strong>
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

