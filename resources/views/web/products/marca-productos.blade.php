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
        <section id="filter-box" class="row mb-4 pt-2 px-2">
            @if( !empty($product_category) )
            <div class="col-md-4 offset-md-4">
                <div class="input-group mb-3">
                    <label class="d-block w-100 text-center" for="sel-order">Ver {{ $product_category->title }} por marca</label>
                    <span class="input-group-text"><i class="bi bi-filter"></i></span>
                    <select data-filterby="brand" id="sel-brand" class="form-select" aria-label="Filtrar por marca">
                        <option value="">Seleccionar marca</option>
                        @foreach($related_brands AS $brand)
                            <option value="{{ $brand->slug  }}" @if($brand->id == $product_brand->id) selected @endif>{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            @endif
            <div class="col-md-4 @empty($product_category) offset-md-8 @endempty">
                <div class="input-group mb-3">
                    <label class="d-block w-100 text-center" for="sel-order">Ordenar por</label>
                    <span class="input-group-text"><i class="bi bi-filter"></i></span>
                    <select data-filter="orderby" id="sel-order" class="form-select" aria-label="Ordenar por">
                        <option value="">Ordenar por</option>
                        <option value="min" @if(Request::get('orderby') == 'min') selected @endif>Precio menor a mayor</option>
                        <option value="max" @if(Request::get('orderby') == 'max') selected @endif>Precio mayor a menor</option>
                        <option value="az" @if(Request::get('orderby') == 'az') selected @endif>A-Z Alfabético</option>
                        <option value="za" @if(Request::get('orderby') == 'za') selected @endif>Z-A Alfabético</option>
                    </select>
                </div>
            </div>
        </section>

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

@push('customJs')
    <script>
        document.querySelectorAll('[data-filter]').forEach(element => {
            element.addEventListener('change', event => {
                event.preventDefault()

                let chain = '?sort=y'
                document.querySelectorAll('[data-filter]').forEach(element => {
                    if( element.value !== "" )
                    {
                        chain += `&${element.getAttribute('data-filter')}=${element.value}`
                    }
                })
                location.href = chain;
            })
        })
        @if( !empty($product_category) )
            document.querySelectorAll('[data-filterby]').forEach(element => {
                element.addEventListener('change', event => {
                    event.preventDefault()
                    let sorted = window.location.search

                    location.href = '/marcas/'+element.value+'/{{ $product_category->slug  }}' + sorted
                })
            })
        @endif
    </script>
@endpush
