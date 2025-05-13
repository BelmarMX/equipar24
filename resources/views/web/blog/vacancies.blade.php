@section('title',           'Vacantes disponibles')
@section('description',     'Encuentra aquí nuevas oportunidades laborales dentro de Equipar y forma parte de nuestro equipo.')
@section('image',           asset('images/samples/banner_productos.jpg'))
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => asset('images/samples/banner.jpg')
            ,   'slide_mobile'  => asset('images/samples/banner-mv.jpg')
            ,   'slide_alt'     => 'Vacantes Banner'
            ,   'summary'       => FALSE
            ,   'title'         => '<strong>Vacantes</strong>'
            ,   'description'   => 'Encuentra aquí nuevas oportunidades laborales dentro de Equipar y forma parte de nuestro equipo.'
            ,   'h1'            => TRUE
        ])
    </div>

    <main class="container">
        <h1>@yield('title')</h1>

        <section>
            <div class="row">
                @foreach($vacancies AS $vacancy)
                    <div class="col-md-4 mb-4">
                        @include('web.blog.partials.blog-view', [
                                'title'             => $vacancy->title
                            ,   'link'              => route('vacante-open', [$vacancy->slug])
                            ,   'image'             => $vacancy->asset_url.$vacancy->image_rx
                            ,   'day'               => $Navigation::split_date($vacancy->starts_at) -> day
                            ,   'month'             => $Navigation::split_date($vacancy->starts_at) -> short_month
                            ,   'category_title'    => 'Abiertas'
                            ,   'category_link'     => NULL
                            ,   'summary'           => $vacancy->summary
                        ])
                    </div>
                @endforeach

                <div class="col-12">
                    <div class="table-responsive">
                        {{ $vacancies -> render() }}
                    </div>
                </div>
            </div>
        </section>

        <section id="index__marcas">
            <h2>Nuestras marcas</h2>
            @include('web.products.partials.marcas')
        </section>
    </main>
@endsection
