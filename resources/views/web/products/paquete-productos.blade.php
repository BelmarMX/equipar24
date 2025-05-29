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
                <h1 class="mb-2 fs-2">{{$package->title}}</h1>
                <p class="mb-2">
                    {{ $package->summary }}
                </p>
                <div class="mb-4">
                    <i class="fa-solid fa-calendar-check"></i> <strong>Vigencia:</strong> <span>{{ \Carbon\Carbon::parse($package->starts_at)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($package->ends_at)->format('d/m/Y') }}</span>
                </div>

                <div class="package__content">
                    {!! $package -> content !!}
                </div>
            </div>
            <div class="col-md-5">
                <div class="row">
                    <div class="col-12 mb-3 text-center">
                        <span class="d-block package__price--tag">Precio del paquete</span>
                        <div class="package__price mb-3">
                            <span class="price">
                                ${{number_format($package->price, 2)}}
                            </span>
                        </div>
                        <div>
                            <a href="https://api.whatsapp.com/send?phone=523322876603&amp;text={!! urlencode("¡Hola! acabo de ver el paquete *{$package->id}: {$package->title}* y estoy interesado en adquirirlo, por favor envienme más información.") !!}"
                               class="btn btn-success text-white"
                               data-bs-toggle="tooltip"
                               title="Contacta a un asesor por whatsapp"
                               target="_blank">
                                <i class="bi bi-whatsapp text-white" style="font-size: 22px;"></i> ¡Quiero comprar el paquete!
                            </a>
                        </div>
                    </div>
                @forelse($entries AS $product)
                    <div class="col-md-6 d-flex justify-content-center mb-4">
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
        .package__price--tag{
            transform: rotate(-5deg);
            font-weight: 600;
        }
        .package__price{
            padding: 6px 30px;
            border: 8px solid #d5ac63;
            border-radius: 40px;
            text-align: center;
            display: inline-block;
            transform: rotate(-5deg);
        }
        .package__price > .price{
            font-weight: 600;
            font-size: 36px;
            background: linear-gradient(to right, #FF0000 20%, #b10000 40%, #b10000 60%, #FF0000 80%);
            background-size: 200% auto;
            background-clip: text;
            animation: lntx 3s infinite linear;
            -webkit-text-fill-color: transparent;
        }
        .package__content img{
            width: 100%;
            height: auto;
        }
        @keyframes hue{
            from{
                -webkit-filter: hue-rotate(0deg);
            }
            to{
                -webkit-filter: hue-rotate(-360deg);
            }
        }
        @keyframes lntx{
            to{
                background-position: 200% center;
            }
        }
        .fa-calendar-check{
            font-size: 20px;
            color: #d5ac63;
        }
    </style>
@endpush
