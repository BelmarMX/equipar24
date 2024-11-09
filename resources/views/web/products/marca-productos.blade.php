@section('title',           !empty($product_category) ? "Productos {$product_brand->title} en {$product_category->title}" : "Productos de la marca $product_brand->title")
@section('description',     "Todos los productos de la marca {$product_brand->title}")
@section('image',           $product_brand->asset_url.$product_brand->image)
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => asset('images/samples/banner_productos.jpg')
            ,   'slide_mobile'  => asset('images/samples/banner_productos-mv.jpg')
            ,   'slide_alt'     => $product_brand->title
            ,   'summary'       => TRUE
            ,   'title'         => "Productos marca <strong>{$product_brand->title}</strong>"
            ,   'h1'            => TRUE
        ])
    </div>

    <main class="container">
        <section>
            <h1>@yield('title')</h1>

            @include('web.products.partials.scroll-categories', [
                    'tag_title'     => "Marca {$product_brand->title}"
                ,   'todas_link'    => route('brands', $product_brand->slug)
                ,   'categories'    => array_map(function($category) use($product_brand) {
                        return [
                                $category['title']
                            ,   route('brands-categories', [$product_brand->slug, $category['slug']])
                            ,   isset(Route::current()->parameters()['slug_category']) && Route::current()->parameters()['slug_category'] == $category['slug']
                        ];
                    }, $related_categories -> toArray() )
                ,   'subcategories'    => array_map(function($subcategory) use($product_brand, $product_category) {
                        return [
                                $subcategory['title']
                            ,   route('brands-subcategories', [$product_brand->slug, $product_category->slug, $subcategory['slug']])
                            ,   isset(Route::current()->parameters()['slug_subcategory']) && Route::current()->parameters()['slug_subcategory'] == $subcategory['slug']
                        ];
                    }, !empty($related_subcategories) ? $related_subcategories -> toArray() : [] )
            ])

            <div class="row justify-content-center">
                @forelse($entries AS $product)
                    <div class="col-md-3 d-flex justify-content-center mb-4">
                        @include('web.products.partials.product-view', [
                                'id'        => $product->id
                            ,   'title'     => $product->title
                            ,   'model'     => $product->model
                            ,   'brand'     => $product->product_brand->title
                            ,   'price'     => $product->price
                            ,   'promo'     => $product->get_higer_active_promo()
                            ,   'con_flete' => $product->with_freight
                            ,   'tag'       => $product->product_subcategory->title
                            ,   'tag_link'  => route('productos-subcategories', [$product->product_category->slug, $product->product_subcategory->slug])
                            ,   'route'     => route('producto-open', [$product->product_category->slug, $product->product_subcategory->slug, $product->slug])
                            ,   'image'     => $product->asset_url.$product->image_rx
                        ])
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning p-2" role="alert">
                            <h4 class="alert-heading mb-0">
                                <i class="bi bi-exclamation-triangle"></i>No se encontraron productos
                            </h4>
                        </div>
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
