@section('title',       'Servicios especializados')
@section('description', 'Manejamos las mejores marcas en el mercado, con precios competitivos para diseñar la cocina perfecta.')
@section('image',       asset('images/template/bn-acerca-de.jpg'))
@extends('web._layout.master.app')

@section('content')
    <section id="partial__servicios" class="container-fluid mb-5 d-none d-md-block">
        @include('web.services.partials.servicios')
    </section>

    @include('web.services.partials.services-links', ['nth_active' => 2])

    <main class="container">
        <div class="row">
            <div class="col-md-12 text-center mb-5">
                <p class="text-center col-md-5 mx-auto">
                    Asesoramos en la <strong>selección correcta del equipo o producto que realmente necesitas</strong> para realizar tu inversión de acuerdo a un presupuesto definido.
                </p>
            </div>

            {{-- Listado de servicios --}}
            <div id="and-asesoria" class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="660"
                         height="340"
                         class="img-fluid"
                         src="{{ asset('images/layout/servicios_asesoria.png') }}"
                         alt="Asesoría"
                    >
                </div>
                <h2>Asesoría</h2>
                <p>
                    Te ayudamos a crear una cocina eficiente, contamos con talento humano lleno de experiencia y conocimiento en el sector gastronómico, quienes te ayudaran a ejecutar y realizar tus proyectos o ideas de negocio, con especial enfoque en el diseño y equipamiento.
                </p>
            </div>

            <div id="and-diseno" class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="660"
                         height="340"
                         class="img-fluid"
                         src="{{ asset('images/layout/servicios_diseno.png') }}"
                         alt="Diseño"
                    >
                </div>
                <h2>Diseño</h2>
                <p>
                    Creamos soluciones de diseño orientadas a la optimización de los espacios y recursos otorgados por el cliente evitando una mala planeación. El profesionalismo y experiencia de nuestro grupo de colaboradores especializados en proyectos, aseguran el mejor diseño de acuerdo a los lineamientos fundamentales establecidos por la industria gastronómica.
                </p>
                <strong>Puntos clave para el diseño</strong>
                <ul>
                    <li>Identificar el flujo adecuado para el principio de empuje.</li>
                    <li>Delimitar cada una de las áreas de trabajo.</li>
                    <li>Diseñar el circuito adecuado para la transformación de la materia prima.</li>
                    <li>Diseñar el circuito para el manejo de desechos con accesos paralelos independientes, esto evitaría la contaminación cruzada.</li>
                </ul>
                <p>
                    Asegure su Inversión: en repetidas ocasiones al iniciar un proyecto sin planeación y visualización de la idea, terminamos haciendo un gasto fuera del presupuesto original, este servicio le aportará mayor seguridad en la ejecución de su proyecto.
                </p>
            </div>

            <div id="and-equipamiento" class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="660"
                         height="340"
                         class="img-fluid"
                         src="{{ asset('images/layout/servicios_equipamiento.png') }}"
                         alt="Equipamiento"
                    >
                </div>
                <h2>Equipamiento</h2>
                <p>
                    Te asesoramos en la selección correcta del equipo o producto que realmente necesitas, cuidamos de tu inversión adaptándonos eficientemente a un presupuesto definido.
                </p>
                <strong>Puntos clave para el equipo correcto</strong>
                <ul>
                    <li>Que el producto realmente funcione para lo que se requiere.</li>
                    <li>Capacidad instalada.</li>
                    <li>Buena Reputación.</li>
                    <li>Relación Precio-Calidad.</li>
                    <li>Tiempo de entrega.</li>
                    <li>Certificaciones.</li>
                    <li>Póliza de garantía.</li>
                    <li>Acceso a refacciones y soporte técnico.</li>
                    <li>Valor reventa.</li>
                </ul>
            </div>

            <div id="and-fabricacion" class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="660"
                         height="340"
                         class="img-fluid"
                         src="{{ asset('images/layout/servicios_fabricacion.png') }}"
                         alt="Fabricación"
                    >
                </div>
                <h2>Diseño y fabricación de muebles en acero inoxidable</h2>
                <p>
                    Elaboración de diseños en isométrico según la idea de tu negocio, los muebles a medida con diseño especial son mucho más funcionales al fabricarse de acuerdo a cada necesidad de operación, espacio, materiales, calibres, refuerzos etc., sobre todo se convierte en un plus al ser una creación única.
                </p>
                <div class="text-center">
                    <a href="{{ route('diseno-acero') }}" class="btn btn-primary">
                        Conozca más
                    </a>
                </div>
            </div>

            <div id="and-instalacion" class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="660"
                         height="340"
                         class="img-fluid"
                         src="{{ asset('images/layout/servicios_instalacion.png') }}"
                         alt="Instalación"
                    >
                </div>
                <h2>Instalación de equipos</h2>
                <p>
                    Servicio de interconexión de equipos, muebles de acero inoxidable, equipos de refrigeración y cocción, máquinas lavalozas, fabricadoras de hielo, equipos de producción y más. Incluye: revisión y seguimiento a ejecución correcta de guía mecánica, interconexión de equipo a acometida preparada según manual de la marca, materiales necesarios (Mangueras de gas, céspol, contra canastas, llaves mezcladoras, clavijas eléctricas, tornillería y herramientas). Mano de obra certificada para el correcto funcionamiento de los equipos.
                </p>
                <p>
                    <small>* La acometida o disparo la prepara obra civil.</small>
                </p>
            </div>

            <div class="col-md-6 mb-4 service__container">
                <div class="service__container--img">
                    <img width="660"
                         height="340"
                         class="img-fluid"
                         src="{{ asset('images/layout/servicios_mantenimiento-preventivo.png') }}"
                         alt="Mantenimiento Preventivo"
                    >
                </div>
                <h2>Mantenimiento Preventivo</h2>
                <p>
                    Realizamos Mantenimiento de equipos en la mayoría de marcas del mercado, cuide su inversión e incremente la vida útil de sus equipos otorgando de manera periódica su revisión general, cambio de partes desgastadas o calibración de los mismos, esto le aportará mayor eficiencia en la operación, detección anticipada de posibles fallas, menor consumo de energéticos, (Agua, luz, gas) y mayor seguridad al personal que operan la cocina previniendo accidentes dentro de la misma.
                </p>
                <p>
                    Ejemplo:
                </p>
                <ul>
                    <li>Verificación del sistema de encendidoRevisión de termostatos</li>
                    <li>Revisión de conexiones electrónicas.</li>
                    <li>Revisión de conexiones eléctricas, amperaje y voltaje</li>
                    <li>Verificación de quemadores</li>
                    <li>Verificación del funcionamiento de válvulas y perillas</li>
                    <li>Detección de fugas de gas en acometida y equipo</li>
                    <li>Ajuste y nivelación del equipo.</li>
                    <li>Limpieza general Aplicación de agentes químicos.</li>
                    <li>Comprobación del correcto funcionamiento. Limpieza de serpentín de condensador y evaporador. Revisión de presión de gas refrigerante, cargas.</li>
                </ul>
            </div>

            <div class="col-md-6 mb-4 service__container">
                <div class="service__container--img">
                    <img width="660"
                         height="340"
                         class="img-fluid"
                         src="{{ asset('images/layout/servicios_mantenimiento-correctivo.png') }}"
                         alt="Mantenimiento Correctivo"
                    >
                </div>
                <h2>Mantenimiento Correctivo</h2>
                <p>
                    Servicio de evaluación y diagnóstico, posteriormente se presenta un reporte con el problema detectado y las acciones a realizar para corregir la falla, cambio de piezas o únicamente Mano de obra, servicio especializado por marcas o equipos.
                </p>
            </div>

            <div id="and-capacitacion" class="col-md-6 mb-5 service__container">
                <div class="service__container--img">
                    <img width="660"
                         height="340"
                         class="img-fluid"
                         src="{{ asset('images/layout/servicios_capacitacion.png') }}"
                         alt="Capacitación"
                    >
                </div>
                <h2>Capacitación</h2>
                <p>
                    Te apoyamos con inducción en el manejo y cuidado de los equipos adquiridos con nosotros, una capacitación adecuada es clave en la eficiencia de una cocina, contamos con chefs certificados para la correcta operación de equipos con tecnología aplicada.
                </p>
            </div>
        </div>


        <section id="index__marcas">
            <h2>Nuestras marcas</h2>
            @include('web.products.partials.marcas')
        </section>
    </main>
@endsection
