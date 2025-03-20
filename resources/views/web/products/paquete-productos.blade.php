@section('title',           $package->title)
@section('description',     $package->summary)
@section('image',           $package->asset_url.$package->image)
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => $package->asset_url.$package->image
            ,   'slide_mobile'  => $package->asset_url.$package->image_rx
            ,   'slide_alt'     => $package->title
            ,   'summary'       => FALSE
            ,   'title'         => NULL
            ,   'h1'            => FALSE
        ])
    </div>

    <main class="container">
        <section class="row">
            <div class="col-md-7">
                <h1 class="mb-2">{{$package->title}}</h1>

                <strong>Vigencia:</strong> <span>{{ \Carbon\Carbon::parse($package->starts_at)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($package->ends_at)->format('d/m/Y') }}</span><br>
                <strong>Precio:</strong> <span>${{number_format($package->price)}}</span>
                <p>
                    {{ $package->summary }}
                </p>

                <div class="package__content">
                    {!! $package -> content !!}
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                @forelse($entries AS $product)
                    <div class="col-md-6 d-flex justify-content-center mb-4">
                        @include('web.products.partials.product-view', [
                                'id'        => $product->id
                            ,   'title'     => $product->title
                            ,   'model'     => $product->model
                            ,   'brand'     => $product->product_brand->title
                            ,   'price'     => $product->price
                            ,   'in_stock'  => $product->in_stock
                            ,   'promo'     => $product->get_higer_active_promo()
                            ,   'con_flete' => $product->with_freight
                            ,   'tag'       => $product->product_subcategory->title
                            ,   'tag_link'  => route('productos-subcategories', [$product->product_category->slug, $product->product_subcategory->slug])
                            ,   'route'     => route('producto-open', [$product->product_category->slug, $product->product_subcategory->slug, $product->slug])
                            ,   'image'     => $product->asset_url.$product->image_rx
                        ])
                    </div>
                @empty
                    <div class="col-md-12 alert alert-warning p-2" role="alert">
                        <h4 class="alert-heading mb-0">
                            <i class="bi bi-exclamation-triangle"></i>No se encontraron productos
                        </h4>
                    </div>
                @endforelse
                </div>
            </div>
        </section>

        <section id="index__marcas">
            <h2>Nuestras marcas</h2>
            @include('web.products.partials.marcas')
        </section>
    </main>
@endsection
@push('customCss')
    <style>
        .package__content img{
            width: 100%;
            height: auto;
        }
    </style>
@endpush

{{--@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => $package->asset_url.$package->image
            ,   'slide_mobile'  => $package->asset_url.$package->image_mv
            ,   'slide_alt'     => $package->title
            ,   'summary'       => FALSE
            ,   'title'         => NULL
            ,   'h1'            => FALSE
        ])
    </div>

    <main class="container">
        <section>
            <h1 class="mb-0">{{$package->title}}</h1>
            <div class="mb-5">
                <strong>Vigencia:</strong> <span>{{ \Carbon\Carbon::parse($package->starts_at)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($package->ends_at)->format('d/m/Y') }}</span>
            </div>
            <div class="blog__article__content">
                {!! $package -> content !!}
            </div>

            <div class="row justify-content-center">
                @forelse($entries AS $product)
                    <div class="col-md-3 d-flex justify-content-center mb-4">
                        @include('web.products.partials.product-view', [
                                'id'        => $product->id
                            ,   'title'     => $product->title
                            ,   'model'     => $product->model
                            ,   'brand'     => $product->product_brand->title
                            ,   'price'     => $product->price
                            ,   'in_stock'  => $product->in_stock
                            ,   'promo'     => $product->get_higer_active_promo()
                            ,   'con_flete' => $product->with_freight
                            ,   'tag'       => $product->product_subcategory->title
                            ,   'tag_link'  => route('productos-subcategories', [$product->product_category->slug, $product->product_subcategory->slug])
                            ,   'route'     => route('producto-open', [$product->product_category->slug, $product->product_subcategory->slug, $product->slug])
                            ,   'image'     => $product->asset_url.$product->image_rx
                        ])
                    </div>
                @empty
                    <div class="alert alert-warning p-2" role="alert">
                        <h4 class="alert-heading mb-0">
                            <i class="bi bi-exclamation-triangle"></i>No se encontraron productos
                        </h4>
                    </div>
                @endforelse
            </div>

            <div class="col-12">
                <div class="table-responsive">
                    {{ $entries -> render() }}
                </div>
            </div>
        </section>

        <section id="index__marcas">
            <h2>Nuestras marcas</h2>
            @include('web.products.partials.marcas')
        </section>
    </main>
@endsection--}}
