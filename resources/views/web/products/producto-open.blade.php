@section('title',           $entry->title)
@section('description',     $entry->summary)
@section('image',           $entry->asset_url.$entry->image)
@extends('web._layout.master.app')

@section('content')
    <main class="container-fluid mt-5 px-0">
        <div class="container">
            @include('web.products.partials.scroll-categories', [
                    'tag_title'     => $product_category->title
                ,   'todas_link'    => route('productos-categories', $product_category->slug)
                ,   'categories'    => array_map(function($subcategory) use($product_category) {
                    return [
                            $subcategory['title']
                        ,   route('productos-subcategories', [$product_category->slug, $subcategory['slug']])
                    ];
                }, $product_category->subcategories->toArray() )
            ])
        </div>

        <section id="productos__main_product" class="mb-4">
            <div class="container">
                <div class="row justify-content-center align-items-center">
                    <div class="col-md-6 productos__main_product__slider">
                        <div id="productos__main_product_slider_container">
                            <div id="productos__main_product_slider" class="carousel slide"
                                 data-bs-ride="carousel"
                                 data-bs-touch="true"
                                 data-bs-interval="5500"
                            >
                                <div class="carousel-inner">
                                    <div class="carousel-item active">
                                        <img width="{{ $ImagesSettings::PRODUCT_WIDTH }}"
                                             height="{{ $ImagesSettings::PRODUCT_HEIGHT }}"
                                             class="img-fluid"
                                             src="{{ $entry->asset_url.$entry->image }}"
                                             alt="{{ $entry->title }}">
                                    </div>

                                    @foreach($entry->product_galleries AS $image)
                                        <div class="carousel-item">
                                            <img width="{{ $ImagesSettings::PRODUCT_WIDTH }}"
                                                 height="{{ $ImagesSettings::PRODUCT_HEIGHT }}"
                                                 class="img-fluid"
                                                 src="{{ $image->asset_url.$image->image }}"
                                                 alt="{{ $image->title ?? $entry->title }}">
                                        </div>
                                    @endforeach
                                </div>

                                @if( count($entry->product_galleries) > 0 )
                                <button class="carousel-control-prev" type="button" data-bs-target="#productos__main_product_slider" data-bs-slide="prev">
                                    <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
                                    <span class="visually-hidden">Anterior</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#productos__main_product_slider" data-bs-slide="next">
                                    <i class="bi bi-arrow-right-circle" aria-hidden="true"></i>
                                    <span class="visually-hidden">Siguiente</span>
                                </button>
                                @endif
                            </div>
                        </div>

                    </div>
                    <div class="col-md-6 py-5 ps-md-5">
                        <div class="productos__main_product--belongs-to mb-4">
                            <a href="{{ route('productos-categories', $entry->product_category->slug) }}">{{ $entry->product_category->title }}</a> /
                            <a href="{{ route('productos-subcategories', [$entry->product_category->slug, $entry->product_subcategory->slug]) }}">{{ $entry->product_subcategory->title }}</a>
                        </div>
                        <h1 class="productos__main_product--title">{{ $entry -> title }}</h1>
                        <p class="productos__main_product--summary">
                            {{ $entry->summary }}
                        </p>
                        <div class="productos__main_product--data mb-md-4">
                            <div class="row position-relative">
                                <div class="col-md-6 my-2">
                                    <span>Marca</span>
                                    <h2>{{ $entry->product_brand->title }}</h2>
                                </div>
                                <div class="col-md-6 my-2">
                                    <span>Modelo</span>
                                    <h2>{{ $entry->model }}</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row productos__main_product__price">
                            <div class="col-md-6 mb-2">
                                <div class="productos__main_product__price--price">
                                    @if( $with_discount = $entry -> get_higer_active_promo() )
                                        ${{ number_format($with_discount -> total, 2, '.', ',') }} <span class="productos__main_product__price--currency">MXN</span>
                                    @else
                                        ${{ number_format($entry -> price, 2, '.', ',') }} <span class="productos__main_product__price--currency">MXN</span>
                                    @endif
                                    @if( !empty($entry->with_freight) )
                                        <br><span class="productos__main_product__price--flete">
                                            <i class="bi bi-truck"></i>
                                        </span>
                                        <span>¡Incluye flete!</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-6 productos__main_product__price--quote">
                                @if( $with_discount )
                                    <div class="productos__main_product__price--price mb-1">
                                        <small>Antes:</small> <small style="text-decoration: line-through">${{ number_format($with_discount->original_price, 2, '.', ',') }}</small><br>
                                        <strong>Ahorras: ${{ number_format($with_discount->discount, 2, '.', ',') }}</strong>
                                    </div>
                                @endif
                                <button aria-label="Agrega el producto al cotizador"
                                        data-bs-toggle="tooltip"
                                        title="Agregar al cotizador"
                                        class="btn btn-primary"
                                        data-quote-add="{{ json_encode([
                                                'id'    => $entry->id
                                            ,   'model' => $entry->model
                                            ,   'title' => $entry->title
                                            ,   'image' => $entry->asset_url.$entry->image_rx
                                        ]) }}"
                                >
                                    <i class="bi bi-bag-plus-fill"></i> Agregar al cotizador
                                </button>
                            </div>
                        </div>
                        @isset($entry -> final_price)
                            * <small>Producto en promoción con descuento del {{ percent($entry->precio,$entry->final_price) }}%. Precio original: ${{ number_format($entry -> precio,2) }}</small>
                        @endisset
                    </div>
                </div>
            </div>
        </section>

        <section id="productos__technical-information" class="container mb-5">
            <div class="row">
                <div class="col-md-3">
                    <h3 class="text-start mb-3">Información técnica</h3>
                    {!! $entry->description !!}

                    @if( !empty($entry->data_sheet) )
                        <h3 class="text-start mb-3 mt-2">Ficha Técnica</h3>

                        <a class="btn btn-secondary"
                           target="_blank"
                           href="{{ $entry->asset_url.'fichas/'.$entry->data_sheet }}"
                        >
                            <i class="bi bi-filetype-pdf"></i> Descargar Ficha técnica
                        </a>
                    @endif
                </div>
                <div class="col-md-9">
                    <h3 class="text-start mb-3">Características</h3>
                    <ul>
                        @foreach(explode('|', $entry->features) AS $feature)
                            @if( !empty($feature) )
                                <li>{!! ucfirst( trim( mb_strtolower($feature) ) ) !!}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </section>

        <section id="productos__relacionados" class="container mb-5">
            <h4>Productos relacionados</h4>
            <div class="row">
                @foreach($related AS $product)
                    <div class="col-md-3 d-flex justify-content-center mb-4">
                        @include('web.products.partials.product-view', [
                                'id'        => $product->id
                            ,   'title'     => $product->title
                            ,   'model'     => $product->model
                            ,   'brand'     => $product->product_brand->title
                            ,   'price'     => $product->precio
                            ,   'promo'     => $product->get_higer_active_promo()
                            ,   'con_flete' => $product->with_freight
                            ,   'tag'       => $product->product_subcategory->title
                            ,   'tag_link'  => route('productos-subcategories', [$product_category->slug, $product->product_subcategory->slug])
                            ,   'route'     => route('producto-open', [$product_category->slug, $product->product_subcategory->slug, $product->slug])
                            ,   'image'     => $product->asset_url.$product->image_rx
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
