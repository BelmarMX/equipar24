@section('title',           'Somos proveedores')
@section('description',     'Manejamos las mejores marcas en el mercado, con precios competitivos para diseñar la cocina perfecta.')
@section('image',           asset('images/template/bn-acerca-de.jpg'))
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @if( $promos )
            @include('web._layout.banner.banner-promos', $promos)
        @else
            @include('web._layout.banner.banner-single', [
                    'slide'         => asset('images/samples/banner_productos.jpg')
                ,   'slide_mobile'  => asset('images/samples/banner_productos-mv.jpg')
                ,   'slide_alt'     => 'Banner de Productos'
                ,   'summary'       => FALSE
            ])
        @endif
    </div>

    <main class="container">
        <section>
            <div class="row justify-content-center">
                @foreach($menu_cat AS $category)
                    <div class="col-md-3 d-flex justify-content-center mb-4">
                        @include('web.products.partials.product-category-view', [
                                'position'  => str_pad($loop->index + 1, 2, '0', STR_PAD_LEFT)
                            ,   'title'     => $category->title
                            ,   'route'     => route('productos-categories', $category->slug)
                            ,   'image'     => $category->asset_url.$category->image_rx
                        ])
                    </div>
                @endforeach
            </div>
        </section>
    </main>

    <section id="products__marcas" class="container-fluid">
        <h3>Productos por marca</h3>
        @include('web.products.partials.marcas')
    </section>
@endsection
