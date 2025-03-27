@section('title',           $product_subcategory->title ?? $product_category->title)
@section('description',     'Todos los productos dentro de la categoría '.$product_category->title)
@section('image',           $product_category->asset_url.$product_category->image)
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @if( $promos )
            @include('web._layout.banner.banner-promos', $promos)
        @else
            @include('web._layout.banner.banner-single', [
                    'slide'         => asset('images/samples/banner_productos.jpg')
                ,   'slide_mobile'  => asset('images/samples/banner_productos-mv.jpg')
                ,   'slide_alt'     => $product_category->title
                ,   'summary'       => FALSE
            ])
        @endif
    </div>

    <main class="container">
        @if( Route::currentRouteName() == 'productos-categories' && !is_null($product_category->description) )
            <div class="row align-items-center mb-5">
                <div class="col-md-6">
                    @if( !empty($has_icon) )
                    <div class="text-center mb-2">
                        <i class="fa-solid {{ $has_icon }}" style="font-size: 28px;"></i>
                    </div>
                    @endif
                    <h1 class="m-0" style="transform: scale(1.75)">{{ $product_subcategory->title ?? $product_category->title }}</h1>
                </div>
                <div class="col-md-6">
                    <p class="text-justify m-0">{{ $product_category->description }}</p>
                </div>
            </div>
        @else
            <h1 @if( Route::currentRouteName() == 'productos-subcategories') class="mb-3 undash" @endif style="transform: scale(1.75)">{{ $product_subcategory->title ?? $product_category->title }}</h1>
            @if( Route::currentRouteName() == 'productos-subcategories')
                <h2>en: {{ $product_category->title  }}</h2>
            @endif
        @endif

        @include('web.products.partials.scroll-categories', [
                'tag_title'     => $product_category->title
            ,   'todas_link'    => route('productos-categories', $product_category->slug)
            ,   'categories'    => array_map(function($category) {
                    return [
                            $category['title']
                        ,   route('productos-categories', $category['slug'])
                        ,   isset(Route::current()->parameters()['slug_category']) && Route::current()->parameters()['slug_category'] == $category['slug']
                    ];
                }, $menu_cat -> toArray() )
            ,   'subcategories' => array_map(function($subcategory) use ($product_category) {
                return [
                        $subcategory['title']
                    ,   route('productos-subcategories', [$product_category->slug, $subcategory['slug']])
                    ,   isset(Route::current()->parameters()['slug_subcategory']) && Route::current()->parameters()['slug_subcategory'] == $subcategory['slug']
                ];
            }, $product_category->subcategories->toArray() )
        ])

        <section id="filter-box" class="row mb-4 pt-2 px-2">
            <div class="col-md-4 offset-md-4">
                <div class="input-group mb-3">
                    <label class="d-block w-100 text-center" for="sel-order">Ver @yield('title') por marca</label>
                    <span class="input-group-text"><i class="bi bi-filter"></i></span>
                    <select data-filterby="brand" id="sel-brand" class="form-select" aria-label="Filtrar por marca">
                        <option value="">Seleccionar marca</option>
                        @foreach($related_brands AS $brand)
                            <option value="{{ $brand->slug  }}">{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
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
                            ,   'tag_link'  => route('productos-subcategories', [$product_category->slug, $product->product_subcategory->slug])
                            ,   'route'     => route('producto-open', [$product_category->slug, $product->product_subcategory->slug, $product->slug])
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
                    {{ $entries  -> render() }}
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

        document.querySelectorAll('[data-filterby]').forEach(element => {
            element.addEventListener('change', event => {
                event.preventDefault()
                let sorted = window.location.search

                location.href = '/marcas/'+element.value+'/{{ $product_category->slug  }}' + sorted
            })
        })
    </script>
@endpush
