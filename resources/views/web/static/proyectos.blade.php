@section('title',       'Proyectos para personas')
@section('description', 'Manejamos las mejores marcas en el mercado, con precios competitivos para diseñar la cocina perfecta.')
@section('image',       asset('images/template/bn-acerca-de.jpg'))
@extends('web._layout.master.app')

@section('content')
    <section id="partial__servicios" class="container-fluid mb-5 d-none d-md-block">
        @include('web.services.partials.servicios')
    </section>

    @include('web.services.partials.services-links', ['nth_active' => 1])

    <main class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <p class="text-center col-md-5 mx-auto mb-5">
                    Aseguramos la <strong>eficiencia de tu cocina con servicio profesional y personalizado</strong> a través de la experiencia, excelentes tiempos de respuesta y talento de nuestros colaboradores.
                </p>

                <img width="890"
                     height="300"
                     class="img-fluid mb-5"
                     src="{{ asset('images/layout/sinergia-equipar.png') }}"
                     alt="Sinergia Equipar"
                >

                <p class="text-justify col-md-10 mx-auto mb-3 fs-5">
                    Una cocina eficiente y funcional requiere de gran creatividad en su diseño, conocimiento y un análisis detallado y profundo del equipamiento a utilizar, para lograr éxito en el mercado gastronómico es necesario contar con cocinas autónomas con verdadera capacidad instalada; para lograr esto es muy importante visualizar y determinar claramente qué cantidad y tipo de alimentos vamos a elaborar y así establecer un concepto y diseño único que haga de nuestra cocina, un espacio de trabajo ágil y eficiente para la preparación y transformación de los alimentos.
                </p>
                <p class="col-md-5 mx-auto">
                    El desarrollo de un proyecto de cocina es la planificación y visualización digital anticipada de la misma, la cual se estructura de la siguiente manera:
                </p>
            </div>

            {{-- SERVICIOS DE PROYECTOS --}}
            <div class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="661"
                         height="270"
                         class="img-fluid"
                         src="{{ asset('images/layout/proyectos_levantamiento.jpg') }}"
                         alt="Levantamiento"
                    >
                </div>
                <h2>Levantamiento</h2>
                <p>Reconocimiento del espacio donde se realizará su proyecto de cocina en el cual se recaba información de medidas de cada uno de los muros y espacios para realizar su trazo del área.</p>
            </div>

            <div class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="661"
                         height="270"
                         class="img-fluid"
                         src="{{ asset('images/layout/proyectos_layout.jpg') }}"
                         alt="Layout"
                    >
                </div>
                <h2>Layout</h2>
                <p>Elaboramos tu plano de distribución de equipos de cada área en formato DWG de acuerdo a los siguientes lineamientos:</p>
                <ul>
                    <li>Tiempos y movimientos</li>
                    <li>Análisis de flujo</li>
                    <li>Optimización de espacios</li>
                    <li>Capacidad instalada</li>
                    <li>Contaminación cruzada</li>
                    <li>Certificaciones
                    <li>Tiempos de servicio</li>
                    <li>Tráfico y número de comensales</li>
                    <li>Seguridad Operativa</li>
                    <li>Manejo sanitario de alimentos</li>
                    <li>Oferta de menú</li>
                </ul>
            </div>

            <div class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="661"
                         height="270"
                         class="img-fluid"
                         src="{{ asset('images/layout/proyectos_guia-mecanica.jpg') }}"
                         alt="Guía mecánica"
                    >
                </div>
                <h2>Guía mecánica</h2>
                <p>Se elabora un plano con listado de las acometidas necesarias para la correcta instalación y operación de cada uno de los equipos.</p>
                <ul>
                    <li>Eléctricas</li>
                    <li>Agua</li>
                    <li>Drenajes</li>
                    <li>Gas lp o natural</li>
                    <li>Trayectorias, alturas y distancias</li>
                    <li>Diagramas, dibujos de elevaciones</li>
                    <li>Manuales de instalación</li>
                </ul>
            </div>

            <div class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="661"
                         height="270"
                         class="img-fluid"
                         src="{{ asset('images/layout/proyectos_renderizado.jpg') }}"
                         alt="Renderizado"
                    >
                </div>
                <h2>Renderizado</h2>
                <p>Anticipación y visualización gráfica de su cocina en modelo 3D "imagen realista", con base en el plano autorizado para el aseguramiento de la toma de decisiones.</p>
            </div>

            <div class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="661"
                         height="270"
                         class="img-fluid"
                         src="{{ asset('images/layout/proyectos_isometricos.jpg') }}"
                         alt="Isométricos"
                    >
                </div>
                <h2>Isométricos</h2>
                <p>Por que los detalles son importantes elaboramos dibujos describiendo: Dimensiones, tipo de acero, calibres, acabados, pulido, cortes, complementos etc. Para que La fabricación de sus muebles sean de acuerdo a lo proyectado.</p>
            </div>

            <div class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="661"
                         height="270"
                         class="img-fluid"
                         src="{{ asset('images/layout/proyectos_instalacion.jpg') }}"
                         alt="Instalación y arranque"
                    >
                </div>
                <h2>Instalación y arranque</h2>
                <p>Puesta en marca de la cocina in situ.</p>
            </div>

            <div class="col-md-10 mx-auto mb-4">
                <h3>Puntos clave para el diseño</h3>
                <ul style="list-style: none;" class="m-0 p-0">
                    <li class="fs-5 mb-1"><i class="text-primary fs-1 me-2 bi bi-bezier"></i> Identificar el flujo adecuado para el principio de empuje.</li>
                    <li class="fs-5 mb-1"><i class="text-primary fs-1 me-2 bi bi-bounding-box-circles"></i> Delimitar cada una de las áreas de trabajo.</li>
                    <li class="fs-5 mb-1"><i class="text-primary fs-1 me-2 bi bi-signpost-split"></i> Diseñar el circuito adecuado para la transformación de la materia prima.</li>
                    <li class="fs-5 mb-1"><i class="text-primary fs-1 me-2 bi bi-recycle"></i> Diseñar el circuito para el manejo de desechos con accesos paralelos independientes, esto evitaría la contaminación cruzada.</li>
                </ul>
            </div>

            <div class="col-md-12">
                <div class="row align-items-center">
                    <div class="col-md-6 mb-2">
                        <img width="550"
                             height="300"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/layout/proyectos_fortaleza.jpg') }}"
                             alt="Asesoramos y acompañamos a nuestros clientes"
                        >
                    </div>
                    <div class="col-md-6">
                        <p>
                            En Equipar nuestra mayor fortaleza es la creación de proyectos de cocina, nos damos a la tarea de escuchar con especial importancia y atención a nuestros clientes respecto a sus necesidades y planes de negocio, con quienes, hombro a hombro trabajamos en equipo desde la idea, materialización hasta el inicio de operaciones.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <section id="index__marcas" class="container-fluid">
            <h2>Nuestras marcas</h2>
            @include('web.products.partials.marcas')
        </section>
    </main>
@endsection
