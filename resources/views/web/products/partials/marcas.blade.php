<div class="marcas-wrap row justify-content-center align-items-center">
    @foreach($brands AS $brand)
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
    @endforeach
</div>
