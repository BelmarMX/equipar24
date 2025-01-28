<div class="marcas-wrap row justify-content-center align-items-center">
    @foreach($brands AS $brand)
        @if($brand->is_featured && $brand->image != 'null.webp')
        <a href="{{ route('brands', $brand->slug) }}"
           class="col"
           data-bs-toggle="tooltip"
           title="{{$brand->title}}"
        >
            <img width="100"
                 height="25"
                 src="{{$brand->asset_url.$brand->image}}"
                 alt="{{$brand->title}}"
            >
        </a>
        @endif
    @endforeach
</div>
<div class="marcas-wrap not_featured row justify-content-center align-items-center">
    @foreach($brands AS $brand)
        @if(!$brand->is_featured || $brand->image == 'null.webp')
            <a href="{{ route('brands', $brand->slug) }}"
               class="col"
            >{{ mb_strtoupper($brand->title)}}</a>
        @endif
    @endforeach
</div>
