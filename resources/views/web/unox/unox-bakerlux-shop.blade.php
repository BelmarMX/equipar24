@section('title',       'Bakerlux SHOP.Pro™ | Unox')
@section('description', 'Perfección inteligente que cuece.')
@section('image',       asset('images/unox/bakerlux-shop/bg-bakerluxshop.webp'))
@extends('web._layout.master.app')

@push('customCss')
    @vite(['resources/assets/scss/web/unox.scss'])
@endpush

@section('content')
    <div class="bg-unox">
        <div class="container-fluid mb-5">
            @include('web._layout.banner.banner-landing', [
                    'slide'         => asset('images/unox/bakerlux-shop/bg-bakerluxshop.webp')
                ,   'slide_alt'     => 'Bakerlux SHOP.Pro™ | Unox'
                ,   'summary'       => TRUE
                ,   'logo_image'    => asset('images/unox/unox.svg')
                ,   'logo_width'    => '50%'
                ,   'logo_height'   => '100%'
                ,   'title'         => "<strong>Bakerlux SHOP.Pro™ | Unox</strong>"
                ,   'h1'            => TRUE
                ,   'cta'           => route('results', ['termino' => 'bakerlux+shop', 'filter' => 'y', 'brand' => 'UNOX'])
            ])
        </div>

        <main class="mt-5 mb-5">
            <section class="container py-3 mb-5">
                <div class="row mb-5">
                    <div class="col-md-6 d-flex align-items-center justify-content-center">
                        <img class="img-fluid" src="{{ asset('images/unox/bakerlux-shop/bakerluxshop.webp') }}" alt="Bakerlux-shop">
                    </div>
                    <div class="col-md-6">
                        <h2>Perfección inteligente que cuece</h2>
                        <p>
                            <strong>BAKERLUX SHOP.Pro&trade;</strong> MASTER es el horno de referencia en términos de rendimiento de horneado, programación automática, inteligencia artificial y conectividad a Internet en espacios comerciales.
                        </p>
                        <p>
                            <strong>BAKERLUX SHOP.Pro&trade;</strong> es la gama de hornos para hornear productos congelados, realizada para los grandes espacios comerciales donde el ritmo es intenso y los volúmenes son elevados.
                        </p>
                        <p>
                            Las versiones de 4 bandejas 660 x 460 son un punto de referencia para producciones de grades cantidades, las versiones de 4 y 3 bandejas 460 x 330 se adaptan perfectamente incluso a tiendas u obradores que no tienen mucho espacio a su disposición. Gracias a la opción de crear columnas según la exigencia específica, se adaptan a cualquier entorno de uso. La posibilidad de elegir entre 4 diferentes versiones del panel de control multiplica las soluciones disponibles para que siempre puedas encontrar el <strong>BAKERLUX SHOP.Pro&trade;</strong> que mejor se adapta a tus exigencias.
                        </p>
                    </div>

                    @include('web.unox.partials.unox-catalogo-download', ['doc' => 'bakerlux-shop'])
                </div>

                <div class="row mb-5">
                    <div class="col-12 mb-4">
                        <p class="medium">
                            Los hornos <strong>BAKERLUX SHOP.Pro&trade;</strong> cuentan con las últimas tecnologías inteligentes para ayudar en el horneado a las tiendas minoristas.
                        </p>
                        <p>
                            Los hornos <strong>BAKERLUX SHOP.Pro&trade;</strong> están diseñados específicamente para hornear productos congelados en espacios comerciales, donde los ritmos son ajustados y los volúmenes son altos.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <span class="big feature">DRY.Plus</span><br>
                        <strong>Expulsión de la humedad para un aroma máximo.</strong>
                        <img class="img-fluid d-block my-2 mx-auto" style="max-width: 85%" src="{{ asset('images/unox/bakerlux-shop/bg-horneado.webp') }}" alt="Horneado">
                        <p>
                            La presencia de humedad durante las fases finales de la cocción de los productos puede comprometer la calidad deseada de los productos. La tecnología DRY.Plus saca el aire húmedo de la cámara de cocción, tanto la liberada de los productos horneados como la producida del sistema STEAM. Plus durante un anterior paso de cocción. La tecnología DRY. Plus permite eliminar la humedad en la cámara de cocción producida por los productos en el horno. Con DRY.Plus el sabor del producto es maximizado, con una estructura interna seca y bien formada y una superficie externa crujiente y dorada. Acostúmbrate a hacer grandes cosas.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <span class="big feature">STEAM.Plus</span><br>
                        <strong>Humedad bajo demanda para cocciones perfectas.</strong>
                        <img class="img-fluid d-block my-2 mx-auto" style="max-width: 85%" src="{{ asset('images/unox/bakerlux-shop/bg-innovacion.webp') }}" alt="Innovación">
                        <p>
                            La introducción de humedad en la cámara en los primeros minutos del proceso de cocción de los productos congelados favorece el desarrollo de la estructura interna y el dorado de la superficie externa del producto. La tecnología UNOX STEAM.Plus permite la producción instantánea de humedad en la cámara de cocción a partir de una temperatura de 90 °C hasta los 260 °C consiguiendo los mejores resultados para cada horneada.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <span class="big feature">AIR.Plus</span><br>
                        <strong>Conduce, une, transforma.</strong>
                        <p>
                            La tecnología AIR.Plus garantiza la perfecta distribución del aire y del calor en el interior de la cámara de cocción, garantizando uniformidad de horneado en todos los puntos de cada bandeja y en todas las bandejas. Gracias a AIR.Plus al finalizar el horneado los alimentos tendrán una coloración externa homogénea, con una integridad y consistencia que harán que el producto se mantenga en perfectas condiciones aun después de varias horas.<br>
                            Con <strong>BAKERLUX SHOP.Pro&trade;</strong> MASTER, TOUCH y LED puedes elegir entre dos diferentes velocidades de ventilación del aire para permitir hornear productos ligeros o pesados sin limitar la variedad de tu oferta.
                        </p>
                    </div>
                    <div class="col-md-6">
                        <span class="big feature">EFFICIENT.Power&trade;</span><br>
                        <strong>Potencia y eficiencia.</strong>
                        <p>
                            <strong>BAKERLUX SHOP.Pro&trade;</strong> significa tener garantía de rendimiento y eficiencia de máximo nivel. Máxima velocidad en el incremento de la temperatura y precisión en su mantenimiento, ahorro de energía garantizado gracias al doble cristal y a los materiales aislantes de alto rendimiento.
                        </p>
                        <p>
                            ¿Hablamos de números?<br>
                            De 60 a 260°C en 300 segundos. La máxima eficiencia en su categoría para el funcionamiento de convección según la certificación ENERGY STAR.
                        </p>
                    </div>
                </div>

                @include('web.unox.partials.unox-intelligent-performance', ['automatic' => TRUE])
                @include('web.unox.partials.unox-intensive-cooking-plus')
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

