<section class="container mb-5">
    <div class="row justify-content-center">
        @forelse($featured AS $product)
            @if($loop -> first)
                <div class="col-12">
                    <h2>Encuentra tu producto UNOX&reg; ideal</h2>
                </div>
            @endif
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
            <div class="col-md-4 text-center">
                <a class="btn btn-primary" href="{{ route('results', ['termino' => 'unox', 'filter' => 'y', 'brand' => 'UNOX']) }}">
                    Visita todos los productos UNOX&reg;
                </a>
            </div>
        @endforelse
    </div>
</section>
