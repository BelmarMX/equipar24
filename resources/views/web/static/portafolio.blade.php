@section('title',       'Portafolio de proyectos')
@section('description', 'Descubra aquí nuevas proyectos y como los hemos desarrollado.')
@section('image',       asset('images/template/render-ejemplo.jpg'))
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => asset('images/samples/banner.jpg')
            ,   'slide_mobile'  => asset('images/samples/banner-mv.jpg')
            ,   'slide_alt'     => 'Proyectos para personas'
            ,   'summary'       => TRUE
            ,   'title'         => 'Proyectos para <strong>Personas</strong>'
            ,   'description'   => 'Aseguramos el correcto diseño y selección de equipo necesarios para la <strong>operación eficiente de su cocina</strong>'
            ,   'h1'            => TRUE
        ])
    </div>

    <main class="container">
        <section>
            <div class="row">
                @foreach($records AS $portafolio)
                    <div class="col-md-4 mb-4">
                        @include('web.portfolio.partials.portfolio-view', [
                                'title'             => $portafolio->title
                            ,   'link'              => route('portafolio-open', $portafolio->slug)
                            ,   'image'             => $portafolio->asset_url.$portafolio->image_rx
                            ,   'summary'           => strip_tags($portafolio -> content)
                        ])
                    </div>
                @endforeach

                <div class="col-12">
                    <div class="table-responsive">
                        {{ $records -> render() }}
                    </div>
                </div>
            </div>
        </section>

        <section id="index__marcas">
            <h2>Nuestras marcas</h2>
            @include('web.products.partials.marcas')
        </section>
    </main>

    <div class="modal fade" id="porfolio_modal" aria-hidden="true" aria-labelledby="portfolioModalLabel" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen"></div>
    </div>
@endsection

@push('customJs')
    @vite(['resources/assets/js/web/projects.js'])
@endpush
