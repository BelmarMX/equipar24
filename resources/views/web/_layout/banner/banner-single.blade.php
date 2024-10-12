<div class="banner__single">
    @if( isMobile() === true && !empty($slide_mobile) )
        <img width="{{ env('BANNER_WIDTH_MV') }}"
             height="{{ env('BANNER_HEIGHT_MV') }}"
             class="img-fluid w-100 @isset($img_class) {{ $img_class }} @endisset"
             src="{{$slide_mobile}}"
             alt="{{ isset($slide_alt) ? $slide_alt : 'Banner image'}}"
        >
    @else
        <img width="{{ env('BANNER_WIDTH') }}"
             height="{{ env('BANNER_HEIGHT') }}"
             class="img-fluid w-100 @isset($img_class) {{ $img_class }} @endisset"
             src="{{$slide}}"
             alt="{{ isset($slide_alt) ? $slide_alt : 'Banner image'}}"
        >
    @endif
    @if( $summary )
    <div class="banner__single__summary">
        @if( isset($h1) && $h1 )
            <h1 class="banner__single__summary--title @if(!isset($description)) alone @endif">
                {!! $title !!}
            </h1>
        @else
            <div class="banner__single__summary--title">
                {!! $title !!}
            </div>
        @endif
        @if( isset($description) && $description )
        <p class="banner__single__summary--description">
            {!! $description !!}
        </p>
        @endif
        @if( isset($cta) && $cta && isset($cta_href) && $cta_href )
        <a href="{{ $cta_href }}" class="banner__single__summary--cta btn btn-primary">
            {!! $cta !!}
        </a>
        @endif
    </div>
    @endif
</div>
