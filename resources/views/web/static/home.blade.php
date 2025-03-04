@section('title',       'Equipamiento de cocinas industriales')
@section('description', 'Servicios expertos y eficientes con capacidad para cubrir necesidades derivadas de la creación de una nueva cocina industrial; en tiempo competitivo, diseño eficaz y adaptación de presupuesto')
@section('image',       !empty($banners->first()) ? url('storage/'.$ImagesSettings::BANNER_FOLDER.$banners->first()->image) : NULL)
@extends('web._layout.master.app')

@section('content')
    @include('web._layout.banner.banner-array', ['banners' => $banners])
    @include('web._layout.partials.reels', ['reels' => $reels])

    <main class="container">
        <section id="index__productos_destacados" class="mb-5">
            <h2>Equipamiento Gastronómico</h2>
            <div class="row">
                @foreach($featured AS $category)
                    <div class="col-md-3 d-flex justify-content-center mb-4">
                        @include('web.products.partials.product-category-view', [
                                'position'  => str_pad($loop -> index + 1, 2, '0', STR_PAD_LEFT)
                            ,   'title'     => $category -> title
                            ,   'route'     => route('productos-categories', $category -> slug)
                            ,   'image'     => url("storage/productos-categorias/{$category -> image_rx}")
                        ])
                    </div>
                @endforeach
            </div>
            <div class="text-end">
                @include('web._layout.partials.button-discounts', ['promos' => $promos])
                <a href="{{ route('productos') }}" class="btn btn-primary">
                    Más categorías
                </a>
            </div>
        </section>

        <section id="index__nosotros" class="mb-5">
            <div class="row align-items-center mb-5">
                <div class="col-md-6 mb-4">
                    <h1 id="home_h1">Acerca de <strong>Equi-Par</strong></h1>
                    <div class="text-end">
                        <p class="text-1-1rem">
                            Aseguramos la eficiencia de las cocinas industriales, con servicio profesional y personalizado a través de la experiencia, tiempos de respuesta y talento de nuestros colaboradores.
                        </p>
                        <a href="{{ route('nosotros') }}" class="btn btn-primary">
                            Conócenos
                        </a>
                    </div>
                </div>
                <div class="col-md-6 mb-4">
                    <div id="reel-container" class="position-relative cursor-pointer">
                        <video id="equipar-reel" class="reels__item--video w-100"
                               src="{{ asset('storage/web/equipar_reel.mp4')}}"
                               poster="{{ asset('storage/web/equipar_reel_cover.webp')}}"
                               data-poster="{{ asset('storage/web/equipar_reel_cover.webp')}}"
                               autoplay
                               muted
                        >
                            <source src="{{ asset('storage/web/equipar_reel.mp4')}}">
                        </video>
                        <i class="bi bi-play-circle-fill position-absolute reel-play-btn"></i>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="index__nosotros__summary d-flex align-items-top justify-content-start">
                        <div class="index__nosotros--icon">
                            <i class="bi bi-trophy-fill"></i>
                        </div>
                        <div class="index__nosotros--description">
                            <strong>Más de 19 años de experiencia</strong>
                            <p>
                                Desarrollo de proyectos.<br>
                                Dominio de flujos de operación.<br>
                                Equipamiento gastronómico.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="index__nosotros__summary d-flex align-items-top justify-content-start">
                        <div class="index__nosotros--icon">
                            <i class="bi bi-person-rolodex"></i>
                        </div>
                        <div class="index__nosotros--description">
                            <strong>Asesores profesionales para el sector gastronómico</strong>
                            <p>
                                Restaurantes, Hoteles, Comedores de empleados, Fast food, Dark kitchens, Reposterías, Bares y más.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="index__nosotros__summary d-flex align-items-top justify-content-start">
                        <div class="index__nosotros--icon">
                            <i class="bi bi-award-fill"></i>
                        </div>
                        <div class="index__nosotros--description">
                            <strong>Expertos en soluciones integrales</strong>
                            <p>
                                Nos especializamos en ofrecer seguridad, tranquilidad y eficiencia personalizada a las cocinas industriales y profesionales.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <section id="partial__servicios" class="container-fluid mb-5">
        @include('web.services.partials.servicios')
    </section>

    <div class="container">
        <section id="index__hotspot" class="mb-5">
            <h2>Áreas de una cocina industrial</h2>
            <div class="index__hotspot__background">
                <div class="background-box"></div>
                <div class="index__hotspot--img">
                    <img width="800"
                         height="534"
                         class="img-fluid"
                         src="{{ asset('images/index/areas_de_una_cocina.png') }}"
                         alt="Áreas de una Cocina Industrial"
                    >
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 30%; left: 14%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>RECEPCIÓN DE MERCANCÍA</strong><br>
                                <p class='text-start hint-fs'>Es el área donde se recibe y se desinfectan las materias primas a procesar.</p>
                                <img src='{{ asset('images/partes_cocina/recepcion.png') }}' width='500' height='500' alt='render' class='img-fluid'>
                            "
                    ></span>
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 18%; left: 29%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>LAVADO DE COCHAMBRE</strong><br>
                                <p class='text-start hint-fs'>Lavado y desinfección de los elementos utilizados para la transformación y cocción de alimentos, sartenes, ollas, budineras, utensilios etc. Este proceso no debe de realizarse en la misma zona de limpieza de loza. Todos los residuos sépticos y basura generada debe de concentrarse en un lugar fuera de la cocina.</p>
                                <img src='{{ asset('images/partes_cocina/lavado_ollas.png') }}' width='500' height='500' alt='render' class='img-fluid mb-2'>
                            "
                    ></span>
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 18%; left: 46%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>LAVADO DE LOZA</strong><br>
                                <p class='text-start hint-fs'>Lugar donde recibimos todos los residuos o sobrantes de los platillos, y procedemos a la limpieza y sanitizacion de los elementos usados, platos, vasos, cubiertos, charolas, este proceso para que se eficiente requiere de una temperatura promedio entre 60 y 70 grados centígrados en el lavado.</p>
                                <img src='{{ asset('images/partes_cocina/lavado_loza.png') }}' width='500' height='500' alt='render' class='img-fluid mb-2'>
                            "
                    ></span>
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 52%; left: 12%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>ALMACEN DE SECOS Y CONGELADOS</strong><br>
                                <p class='text-start hint-fs'>Aquí es donde se almacenan toda la materia prima seca no perecedera, latas, cereales, condimentos etc.</p>
                                <img src='{{ asset('images/partes_cocina/almacen_secos_congelados.png') }}' width='500' height='500' alt='render' class='img-fluid mb-2'>
                            "
                    ></span>
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 78%; left: 10%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>ALMACÉN REFRIGERADO</strong><br>
                                <p class='text-start hint-fs'>Lugar donde se almacena la materia prima que requiere de temperaturas bajas para su mayor conservación, ejemplo , lácteos, frutas y verduras, cárnicos, pescado y mariscos etc.</p>
                                <img src='{{ asset('images/partes_cocina/almacen_refrigerado.png') }}' width='500' height='500' alt='render' class='img-fluid mb-2'>
                            "
                    ></span>
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 60%; left: 28%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>ÁREA DE PREPARACIÓN</strong><br>
                                <p class='text-start hint-fs'>En esta área se inicia el proceso de transformación de materia prima mediante la limpieza, corte, sazonado, molido, licuado,  por mencionar algunos. Debe estar cerca de los almacenes.</p>
                                <img src='{{ asset('images/partes_cocina/preparacion.png') }}' width='500' height='500' alt='render' class='img-fluid mb-2'>
                            "
                    ></span>
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 60%; left: 38%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>ÁREA DE COCCIÓN</strong><br>
                                <p class='text-start hint-fs'>Proceso de cocimiento en la preparación de alimentos, esta puede ser en seco, húmedo o combinado, freír, hervir, guisar, saltear, hornear, etc.</p>
                                <img src='{{ asset('images/partes_cocina/coccion.png') }}' width='500' height='500' alt='render' class='img-fluid mb-2'>
                            "
                    ></span>
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 60%; left: 51%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>SERVICIO DE ENTREGA DE ALIMENTOS</strong><br>
                                <p class='text-start hint-fs'>Espacio destinado para el armado y entrega de platillos, el cual puede ser frio o caliente.</p>
                                <img src='{{ asset('images/partes_cocina/entrega.png') }}' width='500' height='500' alt='render' class='img-fluid mb-2'>
                            "
                    ></span>
                    <span class="index__hotspot--spot grow-fast"
                          style="top: 58%; left: 79%;"
                          data-bs-toggle="tooltip"
                          data-bs-html="true"
                          title="<strong>BARRA DE COMPLEMENTOS</strong><br>
                                <p class='text-start hint-fs'>Zona cercana a la zona de entrega donde se suministran complementos como pueden ser, cubiertos, bebidas, especies, hielo, tostadas, salsas, etc.</p>
                                <img src='{{ asset('images/partes_cocina/barra_complementos.png') }}' width='500' height='500' alt='render' class='img-fluid mb-2'>
                            "
                    ></span>
                </div>
            </div>
        </section>

        <section class="mb-5">
            <h3>Algunos de nuestros proyectos</h3>
            <a href="{{ route('portafolio') }}">
                <img width="{{ env('BANNER_WIDTH') }}"
                     height="{{ env('BANNER_HEIGHT') }}"
                     class="img-fluid w-100 border-radius-txb"
                     src="{{ asset('images/index/algunos-proyectos.jpg') }}"
                     alt="Algunos de nuestros proyectos"
                >
            </a>
        </section>

        <section class="mb-5">
            <h3>Algunos de nuestros planos</h3>
            <a href="{{ route('servicios') }}">
                <img width="{{ env('BANNER_WIDTH') }}"
                     height="{{ env('BANNER_HEIGHT') }}"
                     class="img-fluid w-100"
                     src="{{ asset('images/index/algunos-planos.jpg') }}"
                     alt="Algunos de nuestros planos"
                >
            </a>
        </section>

        <section class="mb-5">
            <h3>Algunos de nuestros renders</h3>
            <a href="{{ route('proyectos') }}">
                <img width="{{ env('BANNER_WIDTH') }}"
                     height="{{ env('BANNER_HEIGHT') }}"
                     class="img-fluid w-100 border-radius-bxt"
                     src="{{ asset('images/index/algunos-renders.jpg') }}"
                     alt="Algunos de nuestros renders"
                >
            </a>
        </section>

        <section id="index__clientes">
            <h2>Nuestro valiosos clientes</h2>
            <div id="index__clientes--slide" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner row">
                    <div class="carousel-item active">
                        <div class="row gx-1 justify-content-center align-items-center">
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'HEB'
                                ,   'image' => asset('images/clients/heb.png')
                                ,   'link'  => 'https://www.heb.com.mx/'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Continental'
                                ,   'image' => asset('images/clients/continental.png')
                                ,   'link'  => 'https://www.continental.com/en/'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Atlas Colomos'
                                ,   'image' => asset('images/clients/atlas-colomos.png')
                                ,   'link'  => 'https://colomos.atlas.com.mx/'
                                ,   'dark'  => TRUE
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Grupo Vidanta'
                                ,   'image' => asset('images/clients/grupo-vidanta.png')
                                ,   'link'  => 'https://www.grupovidanta.com/'
                            ])
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row gx-1 justify-content-center align-items-center">
                            @include('web._layout.partials.clientes-anchor', [
                                   'name'  => 'Restaurante Save'
                               ,   'image' => asset('images/clients/save.png')
                               ,   'link'  => 'https://restaurante-save.mx/'
                           ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Panamá Pastelerías'
                                ,   'image' => asset('images/clients/panama.png')
                                ,   'link'  => 'https://panama.com.mx/'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Buffalo Wild Wings'
                                ,   'image' => asset('images/clients/buffalo-wild-wings.png')
                                ,   'link'  => 'https://www.buffalowildwings.com.mx/'
                                ,   'dark'  => TRUE
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Casa Valadez'
                                ,   'image' => asset('images/clients/casa-valadez.webp')
                                ,   'link'  => 'https://www.casavaladez.com/'
                            ])
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row gx-1 justify-content-center align-items-center">
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Sushi Express'
                                ,   'image' => asset('images/clients/sushi-express.svg')
                                ,   'link'  => 'https://sushiexpress.com.mx/#/'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Hyatt Ziva'
                                ,   'image' => asset('images/clients/hyatt-ziva.webp')
                                ,   'link'  => 'https://www.hyatt.com/en-US/hotel/mexico/hyatt-ziva-puerto-vallarta/pvrif'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Bruna'
                                ,   'image' => asset('images/clients/bruna.png')
                                ,   'link'  => 'https://www.bruna.com.mx/bruna.php'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Pachinos'
                                ,   'image' => asset('images/clients/pachinos.png')
                                ,   'link'  => 'https://pachinos.mx/'
                            ])
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row gx-1 justify-content-center align-items-center">
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Ultra Laboratorios'
                                ,   'image' => asset('images/clients/ultra-labs.png')
                                ,   'link'  => 'https://ultralaboratorios.com.mx/en/home/'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'El Ancladero'
                                ,   'image' => asset('images/clients/elancladero.jpeg')
                                ,   'link'  => 'https://www.facebook.com/ElAncladero/'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Mariscos El Burritas'
                                ,   'image' => asset('images/clients/mariscos-el-burritas.jpeg')
                                ,   'link'  => 'https://www.facebook.com/mariscoselburritas/'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'ITT'
                                ,   'image' => asset('images/clients/itt.png')
                                ,   'link'  => 'https://www.itt.com/home'
                            ])

                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="row gx-1 justify-content-center align-items-center">
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Cooper Standard'
                                ,   'image' => asset('images/clients/cooper-standard.svg')
                                ,   'link'  => 'http://www.cooperstandard.com/'
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Sinergia Alimenta'
                                ,   'image' => asset('images/clients/sinergia.svg')
                                ,   'link'  => 'http://www.sinergiaalimenta.com/'
                                ,   'dark'  => TRUE
                            ])
                            @include('web._layout.partials.clientes-anchor', [
                                    'name'  => 'Hirotec'
                                ,   'image' => asset('images/clients/hirotec.png')
                                ,   'link'  => 'https://www.hirotec.co.jp/eng/group/mexico.html'
                            ])
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="index__marcas">
            <h2>Nuestras marcas</h2>
            @include('web.products.partials.marcas')
        </section>

        <section id="index__blog" class="mb-5">
            <h2>Últimas entradas del blog</h2>
            <div class="row">
                @foreach($articles AS $blog)
                    <div class="col-md-4">
                        @include('web.blog.partials.blog-view', [
                                'title'             => $blog -> title
                            ,   'link'              => route('blog-open', [
                                    $blog -> blog_category -> slug, $blog -> slug
                                ])
                            ,   'image'             => $blog->asset_url.$blog -> image_rx
                            ,   'day'               => $Navigation::split_date($blog -> published_at) -> day
                            ,   'month'             => $Navigation::split_date($blog -> published_at) -> short_month
                            ,   'category_title'    => $blog -> blog_category -> title
                            ,   'category_link'     => route('blog-categories', $blog -> blog_category -> slug)
                            ,   'summary'           => $blog -> summary
                        ])
                    </div>
                @endforeach
            </div>
        </section>
    </div>

    @if( \Carbon\Carbon::now()->lt('2025-03-16') )
    <div class="popup" id="announce_popup" style="display: none;">
        <div class="popup__content position-relative">
            <button class="popup__close" type="button">
                <i class="bi bi-x"></i>
            </button>
            <div class="popup__content--invite_cafe popup_2">
                <img src="{{ asset('images/popup/expo_cafe_gourmet_clean.webp') }}" alt="Expo Café & Gourmet 13 al 15 de marzo de 2025" width="434" height="525">
                <a class="position-absolute" href="https://equi-par.com/blog/eventos-y-ferias-de-la-industria/expocafe-y-gourmet-2025-la-cita-imperdible-para-amantes-del-cafe-y-la-gastronomia-y-te-llevamos-gratis">
                    Mas información
                </a>
            </div>
        </div>
    </div>
    @endif
@endsection

@push('customJs')
    <script>
        $('.reel-play-btn').on('click', e => $('#equipar-reel').click() )
    </script>
    @if( \Carbon\Carbon::now()->lt('2025-03-16') )
    <script>
        $(document).ready(function(){
            let popshows = localStorage.getItem('times_popup_has_viewed')
                ? parseInt(localStorage.getItem('times_popup_has_viewed'))
                : 0
            console.log('', popshows)
            if( popshows < 5 )
            {
                localStorage.setItem('times_popup_has_viewed', popshows+1)
                setTimeout(O => {
                    $('.popup').show(); $('.popup_2').show(500)
                }, 1000)
            }

            $('.popup__close').on('click', function(e){
                $('.popup').hide(200)
            })
        })
    </script>
    @endif
@endpush
