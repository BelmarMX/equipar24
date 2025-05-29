@section('title',           $termino.': Resultados de la búsqueda')
@section('description',     'Todos los productos encontrados en el término: '.$termino)
@section('image',           asset('images/samples/banner_productos.jpg'))
@extends('web._layout.master.app')

@section('content')
    <div class="container-fluid mb-5">
        @include('web._layout.banner.banner-single', [
                'slide'         => asset('images/samples/banner_productos.jpg')
            ,   'slide_mobile'  => asset('images/samples/banner_productos-mv.jpg')
            ,   'slide_alt'     => 'Resultados de la búsqueda'
            ,   'summary'       => FALSE
            ,   'title'         => "<strong>Resultados para: $termino</strong>"
            ,   'h1'            => FALSE
        ])
    </div>

    <main class="container">
        <h1>Resultado de la búsqueda para: {{$termino}}</h1>

        <section id="filter-box" class="row mb-4 pt-2 px-2">
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <label class="d-block w-100 text-center" for="sel-order">Ordenar por</label>
                    <span class="input-group-text"><i class="bi bi-piggy-bank-fill"></i></span>
                    <select data-filter="orderby" id="sel-order" class="form-select" aria-label="Ordenar por">
                        <option value="">Ordenar por</option>
                        <option value="min" @if(Request::get('orderby') == 'min') selected @endif>Precio menor a mayor</option>
                        <option value="max" @if(Request::get('orderby') == 'max') selected @endif>Precio mayor a menor</option>
                        <option value="az" @if(Request::get('orderby') == 'az') selected @endif>A-Z Alfabético</option>
                        <option value="za" @if(Request::get('orderby') == 'za') selected @endif>Z-A Alfabético</option>
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <label class="d-block w-100 text-center" for="sel-category">Filtrar por categoría</label>
                    <span class="input-group-text"><i class="bi bi-tag-fill"></i></span>
                    <select data-filter="category" id="sel-category" class="form-select" aria-label="Filtro por categoría">
                        <option value="">Todas las categorías</option>
                        @foreach( $filtered_categories AS $c => $category )
                            <option value="{{ $category->slug }}" @if(Request::get('category') == $category->slug) selected @endif>{{ $category->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-4">
                <div class="input-group mb-3">
                    <label class="d-block w-100 text-center" for="sel-brand">Filtrar por marca</label>
                    <span class="input-group-text"><i class="bi bi-patch-check-fill"></i></span>
                    <select data-filter="brand" id="sel-brand" class="form-select" aria-label="Filtro por marca">
                        @if( empty($_GET['brand']) )
                            <option value="">Todas las marcas</option>
                        @endif
                        @foreach( $filtered_brands AS $brand )
                            <option value="{{ $brand->slug }}" @if(Request::get('brand') == $brand->slug) selected @endif>{{ $brand->title }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </section>

        <section id="filter-results">
            <h2>Productos encontrados</h2>
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
                    <div class="alert alert-warning p-2 mb-3" role="alert">
                        <h4 class="alert-heading mb-0">
                            <i class="bi bi-exclamation-triangle"></i> No hay resultados que coincidan con estos parámetros de búsqueda.
                        </h4>
                    </div>

                    <h2>Categorías de productos</h2>
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
                @endforelse
            </div>
            <div class="col-12">
                <div class="table-responsive">
                    {{ $entries->render() }}
                </div>
            </div>
        </section>
    </main>
@endsection

@push('customJs')
<script>
    const current_params    = new URLSearchParams(window.location.search)
    const page              = current_params.get('page')

    @if($filtered_brands)
        @foreach($filtered_brands AS $brand)
            @if($brand->slug == Str::slug($termino) && empty($_GET['brand']) )
                location.href = page
                ? `?page=${page}&filter=y&brand={{$brand->slug}}`
                : '?filter=y&brand={{$brand->slug}}';
            @endif
        @endforeach
    @endif

    document.querySelectorAll('[data-filter]').forEach(element => {
        element.addEventListener('change', event => {
            event.preventDefault()

            let chain = page
                ? `?page=${page}&filter=y`
                : '?filter=y'
            document.querySelectorAll('[data-filter]').forEach(element => {
                if( element.value !== "" )
                {
                    chain += `&${element.getAttribute('data-filter')}=${element.value}`
                }
            })
            location.href = chain;
        })
    })
</script>
@endpush
