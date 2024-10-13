@section('title',       'Servicios expertos y eficientes con capacidad para cubrir necesidades derivadas de la creación de una nueva cocina industrial; en tiempo competitivo, diseño eficaz y adaptación de presupuesto')
@section('description', '')
@section('image',       !empty($banners->first()) ? url('storage/'.$ImagesSettings::BANNER_FOLDER.$banners->first()->image) : NULL)
@extends('web._layout.master.app')

@section('content')
    <section class="container-fluid mt-5 mb-5">
        <div id="banner__acerca" class="container-fluid mb-5">
            <div id="banner_acercade" class="carousel slide"
                 data-bs-ride="carousel"
                 data-bs-touch="true"
                 data-bs-interval="5500"
            >
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img width="1920"
                             height="520"
                             class="w-100 img-fluid"
                             src="{{ asset('images/acerca/equipar-1.jpg') }}"
                             alt="Acerca de Equipar"
                        >
                    </div>
                    <div class="carousel-item">
                        <img width="1920"
                             height="520"
                             class="w-100 img-fluid"
                             src="{{ asset('images/acerca/equipar-2.jpg') }}"
                             alt="Acerca de Equipar"
                        >
                    </div>
                    <div class="carousel-item">
                        <img width="1920"
                             height="520"
                             class="w-100 img-fluid"
                             src="{{ asset('images/acerca/equipar-3.jpg') }}"
                             alt="Acerca de Equipar"
                        >
                    </div>
                    <div class="carousel-item">
                        <img width="1920"
                             height="520"
                             class="w-100 img-fluid"
                             src="{{ asset('images/acerca/equipar-4.jpg') }}"
                             alt="Acerca de Equipar"
                        >
                    </div>
                    <div class="carousel-item">
                        <img width="1920"
                             height="520"
                             class="w-100 img-fluid"
                             src="{{ asset('images/acerca/equipar-5.jpg') }}"
                             alt="Acerca de Equipar"
                        >
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#banner_acercade" data-bs-slide="prev">
                    <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
                    <span class="visually-hidden">Anterior</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#banner_acercade" data-bs-slide="next">
                    <i class="bi bi-arrow-right-circle" aria-hidden="true"></i>
                    <span class="visually-hidden">Siguiente</span>
                </button>
            </div>
        </div>
    </section>
    <main class="container mt-5 mb-5">
        <div class="row align-items-center">
            <div class="col-12">
                <h1 class="mb-3">Identidad</h1>
            </div>
            <div class="col-md-8 order-sm-2 order-md-1">
                <p>
                    Se crea en la ciudad de Guadalajara, Jalisco como una compañía especializada para ofrecer tranquilidad, seguridad y eficiencia personalizada para todo tipo de cocinas industriales y profesionales; la unión de tres personas con espíritu emprendedor, dos de ellas con más de 18 años de experiencia y dominio en el área de proyección y diseño crean <strong>EQUI-PAR</strong> empresa sustentada en el talento humano quienes ejercen con libertad la toma de decisiones, ideas de innovación y desarrollo de equipamiento gastronómico.
                </p>
                <p>
                    El mercado demanda cocinas eficientes y funcionales, y para ello se requiere de gran creatividad en su diseño, conocimiento y análisis detallado del equipamiento a utilizar. Para lograr éxito en el mercado gastronómico es necesario contar con cocinas autónomas con verdadera capacidad instalada, para lograr esto es muy importante visualizar y determinar claramente qué cantidad y tipo de alimentos vamos a elaborar y así establecer un concepto, que haga de nuestra cocina un espacio de trabajo ágil y eficiente para la preparación y transformación de los alimentos.
                </p>
                <p>
                    Acércate con nosotros, aseguramos la eficiencia de tu cocina.
                </p>
            </div>
            <div class="col-md-4 text-center order-sm-1 order-sm-2">
                <img width="258" height="86" src="{{ asset('images/layout/equipar-minimal-id.svg') }}" alt="Equi-par ID">
            </div>
        </div>
    </main>

    <div class="container mb-5">
        <div class="row">
            <div class="col-md-4 mb-5">
                <h2 class="mb-3">Misión</h2>
                <div class="text-center mb-3">
                    <img width="190"
                         height="180"
                         class="img-fluid border-radius-10 with-box-shadow"
                         src="{{ asset('images/acerca/mision.png') }}"
                         alt="Misión"
                    >
                </div>
                <p>
                    Asegurar la eficiencia de las cocinas industriales mediante el talento y pasión de nuestros colaboradores quienes entregan soluciones de diseño y asesoría en la selección correcta del equipamiento gastronómico.
                </p>
            </div>
            <div class="col-md-4 mb-5">
                <h2 class="mb-3">Visión</h2>
                <div class="text-center mb-3">
                    <img width="180"
                         height="180"
                         class="img-fluid border-radius-10 with-box-shadow"
                         src="{{ asset('images/acerca/vision.png') }}"
                         alt="Visión"
                    >
                </div>
                <p>
                    Ser la primera opción en la mente de toda persona que tenga un proyecto gastronómico, contar con la más grande y atractiva sala de exhibición interactiva dentro de las 5 principales ciudades del país, siendo totalmente rentable y autosuficiente.
                </p>
            </div>
            <div class="col-md-4 mb-5">
                <h2 class="mb-3">Valores</h2>
                <div class="text-center mb-3">
                    <img width="180"
                         height="180"
                         class="img-fluid border-radius-10 with-box-shadow"
                         src="{{ asset('images/acerca/valores.png') }}"
                         alt="Valores"
                    >
                </div>
                <p>
                    Íntegramente trabajamos en equipo enfocados en la orientación al servicio y valor a la persona.
                </p>
            </div>

            <div class="col-md-12">
                <div class="col-md-4 mx-auto mb-3">
                    <h2 class="mb-3">Cobertura</h2>
                    <div class="text-center mb-3">
                        <img width="180"
                             height="180"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acerca/cobertura-aux.png') }}"
                             alt="Cobertura"
                        >
                    </div>
                    <p>
                        Cobertura nacional: Mayor posicionamiento en Zona Bajío y occidente del país.
                    </p>
                </div>
                <div class="text-center">
                    <img width="824"
                         height="581"
                         class="img-fluid"
                         src="{{ asset('images/layout/cobertura.png') }}"
                         alt="Mapa de Cobertura Equipar">
                </div>
            </div>
        </div>
    </div>

    <div class="container mb-5">
        <div class="social-media d-flex justify-content-center align-items-center">
            <a href="{{ $Navigation::SOCIAL_FACEBOOK }}"
               target="_blank"
               data-bs-toggle="tooltip"
               title="Danos Like en Facebook"
               class="mx-3"
            >
                <i class="bi bi-facebook" style="font-size: 40px"></i>
            </a>
            <a href="{{ $Navigation::SOCIAL_INSTAGRAM }}"
               target="_blank"
               data-bs-toggle="tooltip"
               title="Síguenos en Instagram"
               class="mx-3"
            >
                <i class="bi bi-instagram" style="font-size: 40px"></i>
            </a>
            <a href="{{ $Navigation::SOCIAL_LINKEDIN }}"
               target="_blank"
               data-bs-toggle="tooltip"
               title="Conectar en LinkedIn"
               class="mx-3"
            >
                <i class="bi bi-linkedin" style="font-size: 40px"></i>
            </a>
        </div>
    </div>

    <section id="partial__servicios" class="container-fluid mb-5">
        @include('web.services.partials.servicios')
    </section>
@endsection
