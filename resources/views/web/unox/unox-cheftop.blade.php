@section('title',       'Cheftop MIND.Maps™ Plus | Unox')
@section('description', 'Hornos mixtos profesionales.')
@section('image',       asset('images/unox/banner/cheftop-chef.webp'))
@extends('web._layout.master.app')

@push('customCss')
    @vite(['resources/assets/scss/web/unox.scss'])
@endpush

@section('content')
    <div class="bg-unox">
        <div class="container-fluid mb-5">
            @include('web._layout.banner.banner-landing', [
                    'slide'         => asset('images/unox/banner/cheftop-chef.webp')
                ,   'slide_alt'     => 'Cheftop MIND.Maps™ Plus | Unox'
                ,   'summary'       => TRUE
                ,   'logo_image'    => asset('images/unox/unox.svg')
                ,   'logo_width'    => '50%'
                ,   'logo_height'   => '100%'
                ,   'title'         => "<strong>Cheftop MIND.Maps™ Plus | Unox</strong>"
                ,   'h1'            => TRUE
                ,   'cta'           => route('results', ['termino' => 'cheftop', 'filter' => 'y', 'brand' => 'UNOX'])
            ])
        </div>

        <main class="mt-5 mb-5">
            <section class="container py-3 mb-5">
                <div class="row mb-5">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <img class="img-fluid" style="width: 32%" src="{{ asset('images/unox/cheftop/cheftop-3.webp') }}" alt="GN 3">
                        <img class="img-fluid" style="width: 32%" src="{{ asset('images/unox/cheftop/cheftop-5.webp') }}" alt="GN 5">
                        <img class="img-fluid" style="width: 32%" src="{{ asset('images/unox/cheftop/cheftop-10.webp') }}" alt="GN 10">
                    </div>
                    <div class="col-md-6">
                        <h2>Hornos Mixtos Profesionales</h2>
                        <p>
                            <strong>CHEFTOP MIND.Maps&trade; PLUS</strong> es el horno combinado inteligente capaz de asar a la parrilla, freír, asar, saltear, ahumar, cocinar al vapor y mucho más. Los ciclos de cocción automáticos y las funciones de inteligencia artificial forman parte del CHEFTOP MIND.Maps&trade; PLUS y son el instrumento fundamental para tu cocina, proporcionando un apoyo concreto para tu trabajo.
                        </p>
                        <p>
                            El horno <strong>MIND.Maps&trade; PLUS</strong> está disponible en tres versiones, respondiendo a las exigencias específicas de cada negocio:
                        </p>
                        <p>
                            <strong>COUNTERTOP</strong> de 3,5,7 y 10 bandejas GN 1/1 y 6 y 10 bandejas GN 2/1 para restauración y gastronomía;
                        </p>
                        <p>
                            <strong>COMPACT</strong> de 5 bandejas GN 2/3 para cocinas profesionales con espacios reducidos o pequeños negocios;
                        </p>
                        <p>
                            <strong>BIG</strong> con carros 20 GN 1/1 y 20 GN 2/1 para grandes cocinas y centros de cocina.
                        </p>
                    </div>

                    @include('web.unox.partials.unox-catalogo-download', ['doc' => 'cheftop'])
                </div>

                <div class="row mb-5">
                    <div class="col-12 mb-4">
                        <p>
                            <strong>CHEFTOP MIND.Maps&trade;</strong> es el horno combinado UNOX con el que podrás alcanzar todas tus ambiciones. Asar a la parrilla, freír, rustir, cocinar al vapor y mucho más. De una forma sencilla e intuitiva. Como a ti te gusta.
                        </p>
                        <p>
                            El horno profesional que anula cualquier distancia entre tus sueños y su realización. CHEFTOP MIND.Maps&trade; PLUS es la síntesis de años de investigación y experiencia de UNOX junto a los chefs más exigentes y comprometidos con el reto de dar forma a sus ideas. Podrá disfrutar de cocinar cada plato con la certeza del máximo resultado todo el tiempo.
                        </p>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <span class="big feature d-block">hasta un 45%</span>
                            Menos energía con respecto<br>
                            a una parrilla tradicional
                        </div>
                        <div class="mb-3">
                            <span class="big feature d-block">hasta un 80%</span>
                            Menos agua con respecto<br>
                            a una cocción en agua en ebullición
                        </div>
                        <div class="mb-3">
                            <span class="big feature d-block">hasta un 90%</span>
                            Menos aceite con respecto<br>
                            a una fritura
                        </div>
                    </div>
                    <div class="col-md-4">
                        <img class="img-fluid" style="width: 100%" src="{{ asset('images/unox/cheftop/bg-horno-unico.webp') }}" alt="Cheftop">
                        <img class="img-fluid" style="width: 100%" src="{{ asset('images/unox/cheftop/bg-dream-big.webp') }}" alt="Dream big">
                    </div>
                    <div class="col-md-4">
                        <div class="bloquecito">
                            <span class="text-black">Perfección en el cocinado</span>
                            Resultado seguro
                            y repetible
                        </div>
                        <div class="bloquecito">
                            <span class="text-black">Versatilidad</span>
                            Distintas comidas cocinadas
                            de manera contemporánea
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

