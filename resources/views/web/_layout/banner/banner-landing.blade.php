<div class="banner__single">
    @isset( $video )
        <video autoplay="" playsinline="" muted="" loop="" class="w-100 h-100">
            <source src="{{ $video }}" type="video/mp4">
        </video>
        <div class="position-absolute w-100 h-100 top-0 left-0"></div>
    @else
    <img width="100%"
         height="auto"
         class="img-fluid w-100 {{ $img_class ?? '' }}"
         src="{{$slide}}"
         alt="{{ $slide_alt ?? 'Banner image'}}"
    >
    @endif
    @if( $summary )
    <div class="banner__single__summary">
        @if( !isset($video) )
            <img width="{{ $logo_width }}" height="{{ $logo_height ?? '100%' }}" src="{{ $logo_image }}" alt="{{ $title }}" class="img-fluid">
        @endif
        @if( isset($h1) && $h1 )
            <h1 class="banner__single__summary--title @if(!isset($description)) alone @endif">
                {!! $title !!}
            </h1>
        @else
            <div class="banner__single__summary--title">
                {!! $title !!}
            </div>
        @endif
        @isset($cta)
            <a href="{{ $cta }}" class="banner__single__summary--cta btn btn-primary">
                Visitar productos
            </a>
        @endif
    </div>
    @endif
</div>
