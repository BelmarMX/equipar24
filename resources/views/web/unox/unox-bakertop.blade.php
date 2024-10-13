@section('title',       'Bakertop MIND.Maps™ Plus | Unox')
@section('description', 'Hornos combinados inteligentes.')
@section('image',       asset('images/unox/bakertop/bg-panadero.webp'))
@extends('web._layout.master.app')

@push('customCss')
    @vite(['resources/assets/scss/web/unox.scss'])
@endpush

@section('content')
    <div class="bg-unox">
        <div class="container-fluid mb-5">
            @include('web._layout.banner.banner-landing', [
                    'slide'         => asset('images/unox/bakertop/bg-panadero.webp')
                ,   'slide_alt'     => 'Bakertop MIND.Maps™ Plus | Unox'
                ,   'summary'       => TRUE
                ,   'logo_image'    => asset('images/unox/unox.svg')
                ,   'logo_width'    => '50%'
                ,   'logo_height'   => '100%'
                ,   'title'         => "<strong>Bakertop MIND.Maps™ Plus | Unox</strong>"
                ,   'h1'            => TRUE
                ,   'cta'           => route('results', ['termino' => 'bakertop', 'filter' => 'y', 'brand' => 'UNOX'])
            ])
        </div>

        <main class="mt-5 mb-5">
            <section class="container py-3 mb-5">
                <div class="row mb-5">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <img class="img-fluid" style="width: 48%" src="{{ asset('images/unox/bakertop/bakertop-countertop.webp') }}" alt="BAKERTOP Countertop">
                        <img class="img-fluid" style="width: 48%" src="{{ asset('images/unox/bakertop/bakertop-big.webp') }}" alt="BAKERTOP Big">
                    </div>
                    <div class="col-md-6">
                        <h2>Hornos Combinados Inteligentes</h2>
                        <p>
                            <strong>BAKERTOP MIND.Maps™ PLUS</strong> es el horno combinado inteligente para pastelería y panadería artesanal, fresca o congelada. Ciclos de cocción automáticos y funciones smart entre las que destaca la inteligencia artifical, que hace de BAKERTOP MIND.Maps™ PLUS el instrumento fundamental para tu obrador. Combinados con las fermentadoras LIEVOX te permiten crear una estación de cocción versátil y multifuncional.
                        </p>
                        <p>
                            Los hornos combinados MIND.Maps™ PLUS están disponibles en dos versiones para responder así a las exigencias específicas de cada negocio:
                        </p>
                        <p>
                            <strong>COUNTERTOP</strong> de 5 y 8 bandejas 660 x 460 para obradores artesanos;
                        </p>
                        <p>
                            <strong>BIG</strong> con carros de 16 bandejas 660 x 460 para grandes panaderías y pastelerías.
                        </p>
                    </div>

                    @include('web.unox.partials.unox-catalogo-download', ['doc' => 'bakertop'])
                </div>

                <div class="row mb-5">
                    <div class="col-12 mb-4">
                        <p>
                            BAKERTOP MIND.Maps™ PLUS es el horno profesional que elimina las distancias entre lo que sueñas y lo que consigues. Descubre el placer de hornear la perfección.
                        </p>
                        <p>
                            BAKERTOP MIND.Maps™ PLUS, junto con sus accesorios, hacen posible crear un único sistema de cocción que normalmente se llevaría a cabo con un equipamiento específico.
                        </p>
                        <p>
                            Cocciones de productos fermentados, panadería y pastelería artesanal o congelada, deshidrataciones, galletas y mucho más. Ciclos de cocinado automáticos y funciones inteligentes para resultados siempre impecables. Fermentaciones gracias a LIEVOX.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <span class="big feature d-block">5 min</span>
                            Tiempo de precalentamiento<br>
                            de 30 °a 200 °C
                        </div>
                        <div class="mb-3">
                            <span class="big feature d-block">hasta un 80%</span>
                            Menos agua con respecto<br>
                            a una cocción en agua en ebullición
                        </div>
                        <div class="mb-3">
                            <span class="big feature d-block">hasta un 45%</span>
                            Más rápido que un horno<br>
                            tradicional o de convección
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img class="img-fluid" style="width: 100%" src="{{ asset('images/unox/bakertop/bg-panaderia.jpeg') }}" alt="Panaderia">
                    </div>
                    <div class="col-md-4">
                        <div class="bloquecito">
                            <span class="text-black">Perfección</span>
                            Resultado de cocción
                            seguro y repetible
                        </div>
                        <div class="bloquecito">
                            <span class="text-black">Uniformidad</span>
                            Color homogéneo
                            y estructura consistente
                        </div>
                        <div class="bloquecito">
                            <span class="text-black">Ahorro</span>
                            Energía, tiempo, materia
                            prima y mano de obra
                        </div>
                        <div class="bloquecito">
                            <span class="text-black">Inteligencia</span>
                            Concéntrate en tus clientes
                            y el horno hará el resto
                        </div>
                    </div>
                </div>

                @include('web.unox.partials.unox-tecnologia')
                @include('web.unox.partials.unox-intelligent-performance')
                @include('web.unox.partials.unox-intensive-cooking')
                @include('web.unox.partials.unox-ai')
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

