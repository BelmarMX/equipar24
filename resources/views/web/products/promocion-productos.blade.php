@section('title',           $promotion->title)
@section('description',     $promotion->summary)
@section('image',           $promotion->asset_url.$promotion->image)
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => $promotion->asset_url.$promotion->image
            ,   'slide_mobile'  => $promotion->asset_url.$promotion->image_mv
            ,   'slide_alt'     => $promotion->title
            ,   'summary'       => FALSE
            ,   'title'         => NULL
            ,   'h1'            => FALSE
        ])
    </div>

    <main class="container">
        <section>
            <h1 class="mb-0">{{$promotion->title}}</h1>
            <div class="mb-5">
                <strong>Vigencia:</strong> <span>{{ \Carbon\Carbon::parse($promotion->starts_at)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($promotion->ends_at)->format('d/m/Y') }}</span>
                <p>{{ $promotion->description }}</p>
            </div>

            <div class="row justify-content-center">
                @forelse($entries AS $product)
                    <div class="col-md-3 d-flex justify-content-center mb-4">
                        @include('web.products.partials.product-view', [
                                'id'                    => $product->id
                            ,   'title'                 => $product->title
                            ,   'model'                 => $product->model
                            ,   'brand'                 => $product->product_brand->title
                            ,   'price'                 => $product->price
                            ,   'promotion_price'       => $product->promotion_price
                            ,   'in_stock'              => $product->in_stock
                            ,   'promo'                 => $product->get_higer_active_promo()
                            ,   'con_flete'             => $product->with_freight
                            ,   'tag'                   => $product->product_subcategory->title
                            ,   'tag_link'              => route('productos-subcategories', [$product->product_category->slug, $product->product_subcategory->slug])
                            ,   'route'                 => route('producto-open', [$product->product_category->slug, $product->product_subcategory->slug, $product->slug])
                            ,   'image'                 => $product->asset_url.$product->image_rx
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
@endsection
