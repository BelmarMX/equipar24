<section class="container mb-5">
    <div class="row justify-content-center">
        @forelse($featured AS $product)
            @if($loop -> first)
                <div class="col-12">
                    <h2>Encuentra tu producto UNOX&reg; ideal</h2>
                </div>
            @endif
            <div class="col-md-3 d-flex justify-content-center mb-4">
                @include('frontend_v2.partials.product-view', [
                        'id'        => $product -> idP
                    ,   'title'     => $product -> titleP
                    ,   'model'     => $product -> modelo
                    ,   'brand'     => $product -> marca
                    ,   'price'     => $product -> precio
                    ,   'promo'     => $product -> final_price
                    ,   'tag'       => $product -> titleS
                    ,   'tag_link'  => route('productos-category', [$product -> slugC, $product -> slugS])
                    ,   'route'     => route('productos-open', [$product -> slugC, $product -> slugS, $product -> slugP])
                    ,   'image'     => url("storage/productos/{$product -> image_rxP}")
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