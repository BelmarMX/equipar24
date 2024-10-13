@section('title',       'Fabricación de muebles en acero inoxidable')
@section('description', 'Creamos y diseñamos muebles de acero inoxidable a la medida, funcionales de acuerdo a tus necesidades..')
@section('image',       asset('images/template/bn-acerca-de.jpg'))
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => asset('images/samples/banner_acero_inox.jpg')
            ,   'slide_mobile'  => asset('images/samples/banner_acero_inox-mv.jpg')
            ,   'slide_alt'     => 'Fabricación de muebles en acero inoxidable'
            ,   'summary'       => TRUE
            ,   'title'         => "<strong>Fabricación de muebles en acero inoxidable</strong>"
            ,   'h1'            => TRUE
        ])
    </div>
    <main class="container mt-5 mb-5">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <p class="text-center col-md-5 mx-auto">
                    Creamos y diseñamos <strong>muebles de acero inoxidable a la medida</strong>, funcionales de acuerdo a tus necesidades.
                </p>
            </div>

            <div class="col-12">
                <h1>{{ 'Fabricación de muebles en acero inoxidable' }}</h1>
            </div>
            <div class="col-md-8">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 order-md-2 mb-2">
                        <img width="250"
                             height="250"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acero/01_materia-prima.png') }}"
                             alt="Recepción de materia"
                        >
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h3 class="mb-3 text-right-af">Recepción de materia</h3>
                        <p class="text-end">
                            Es aquí donde comienza el proceso utilizando solo material certificado y de primera calidad.<br>
                            Utilizamos aceros austeníticos y ferríticos, aleación 201, 304 y 430 con calibres que van desde el 10 hasta el 22.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-4">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 order-md-1 text-end mb-2">
                        <img width="250"
                             height="250"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acero/02_design.png') }}"
                             alt="Diseño del modelo"
                        >
                    </div>
                    <div class="col-md-8 order-md-2">
                        <h3 class="mb-3 text-left-af">Diseño del modelo</h3>
                        <p>
                            Contamos con un departamento de ingeniería vanguardista, que se encarga de transformar tus ideas en realidad, utilizando software y tecnología en la industria del diseño.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 text-center">
                <h3 class="mb-3">Trazo</h3>
                <img width="250"
                     height="250"
                     class="img-fluid border-radius-10 with-box-shadow"
                     src="{{ asset('images/acero/03_marcado.png') }}"
                     alt="Trazo"
                >
                <p>
                    Marcado de lamina en las zonas a doblar.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <h3 class="mb-3">Corte</h3>
                <img width="250"
                     height="250"
                     class="img-fluid border-radius-10 with-box-shadow"
                     src="{{ asset('images/acero/04_corte.png') }}"
                     alt="Corte"
                >
                <p>
                    Una vez trazada la lámina, se hace el corte de las pizas del mueble.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <h3 class="mb-3">Doblez</h3>
                <img width="250"
                     height="250"
                     class="img-fluid border-radius-10 with-box-shadow"
                     src="{{ asset('images/acero/05_doblez.png') }}"
                     alt="Doblez"
                >
                <p>
                    Cuando las piezas ya están cortadas, estas se doblan siguiendo el marcado del trazo.
                </p>
            </div>
            <div class="col-12 mb-5 text-center">
                <q>Comienza a moldearse el equipo</q>
            </div>

            <div class="col-12">
                <h2>Procesos</h2>
            </div>
            <div class="col-md-8">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 order-md-2 mb-2">
                        <img width="250"
                             height="250"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acero/01_armado.png') }}"
                             alt="Armado"
                        >
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h3 class="mb-3 text-right-af">Armado</h3>
                        <p class="text-end">
                            Aquí se reciben las piezas dobladas y cortadas, se comienza a dar la primer forma, posteriormente continua el proceso de soldadura de las piezas y se montan accesorios como: Ruedas, herrajes, etc.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-4">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 order-md-1 text-end mb-2">
                        <img width="250"
                             height="250"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acero/02_detallado.png') }}"
                             alt="Detallado"
                        >
                    </div>
                    <div class="col-md-8 order-md-2">
                        <h3 class="mb-3 text-left-af">Detallado</h3>
                        <p>
                            Una vez armado el mueble se procese a desbaste de soldadura y a eliminar imperfecciones de las láminas.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 order-md-2 mb-2">
                        <img width="250"
                             height="250"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acero/03_pulido.png') }}"
                             alt="Pulido"
                        >
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h3 class="mb-3 text-right-af">Pulido</h3>
                        <p class="text-end">
                            Finalmente se realiza el proceso de pulido para eliminar imperfecciones en la lámina, otorgando un brillo atractivo.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-4">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 order-md-1 text-end mb-2">
                        <img width="250"
                             height="250"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acero/04_control-calidad.png') }}"
                             alt="Control de calidad"
                        >
                    </div>
                    <div class="col-md-8 order-md-2">
                        <h3 class="mb-3 text-left-af">Control de calidad</h3>
                        <p>
                            Todo mueble fabricado pasa por un proceso de revisión a detalle, asegurando la calidad del producto.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 order-md-2 mb-2">
                        <img width="250"
                             height="250"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acero/05_empaque.png') }}"
                             alt="Empaque"
                        >
                    </div>
                    <div class="col-md-8 order-md-1">
                        <h3 class="mb-3 text-right-af">Empaque</h3>
                        <p class="text-end">
                            El mueble se limpie, detalla y empaca para enviar al almacén de producto terminado.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-8 offset-md-4">
                <div class="row align-items-center mb-3">
                    <div class="col-md-4 order-md-1 text-end mb-2">
                        <img width="250"
                             height="250"
                             class="img-fluid border-radius-10 with-box-shadow"
                             src="{{ asset('images/acero/06_resultado_final.png') }}"
                             alt="Resultado final"
                        >
                    </div>
                    <div class="col-md-8 order-md-2">
                        <h3 class="mb-3 text-left-af">Resultado final</h3>
                        <p class="text-align-left">
                            Producto de excelente calidad y visualmente atractivo.
                        </p>
                    </div>
                    <div class="col-md-12 order-md-3">
                        @include('web._layout.banner.banner-single', [
                                'slide'         => asset('images/samples/banner_acero_inox.jpg')
                            ,   'slide_alt'     => 'Fabricación de muebles en acero inoxidable'
                            ,   'summary'       => FALSE
                            ,   'img_class'     => 'border-radius-10 with-box-shadow'
                        ])
                    </div>
                </div>
            </div>
        </div>
    </main>

    <section id="partial__servicios" class="container-fluid mb-5 d-none d-md-block">
        @include('web.services.partials.servicios')
    </section>
@endsection
