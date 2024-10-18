@if( $banners )
<div id="banner__array" class="container-fluid mb-5">
    <div id="banner__slider" class="carousel slide"
         data-bs-ride="carousel"
         data-bs-touch="true"
         data-bs-interval="5500"
    >
        <div class="carousel-inner">
            @foreach($banners AS $banner)
                <div class="carousel-item @if($loop -> first) active @endif">
                    @include('web._layout.banner.banner-single', [
                            'slide'         => url('storage/banners/'.$banner -> image)
                        ,   'slide_mobile'  => url('storage/banners/'.$banner -> image_mv)
                        ,   'slide_alt'     => $banner -> title
                        ,   'summary'       => TRUE
                        ,   'title'         => $banner -> title
                        ,   'cta'           => 'Ver Proyectos'
                        ,   'cta_href'      => $banner -> link
                    ])
                </div>
            @endforeach
        </div>
        @if( count($banners) > 0 )
        <button class="carousel-control-prev" type="button" data-bs-target="#banner__slider" data-bs-slide="prev">
            <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#banner__slider" data-bs-slide="next">
            <i class="bi bi-arrow-right-circle" aria-hidden="true"></i>
            <span class="visually-hidden">Siguiente</span>
        </button>
        @endif
    </div>
</div>
@endif
