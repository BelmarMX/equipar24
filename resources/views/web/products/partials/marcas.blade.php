@php
    $count_brands   = count($brands);
	$slides         = ceil($count_brands / 40);
	$counter        = 1;
	$count_slides   = 0;
	$total_brands   = 1;
@endphp
<div class="marcas-wrap-grid">
    <div class="swiper-brands position-relative">
        <div class="swiper-wrapper">
            @foreach($brands->sortByDesc('is_featured') AS $brand)
                @if( $counter == 1 )
                <div class="swiper-slide">
                    <div class="marcas-container-grid slide-{{ $count_slides }}">
                @endif
                        <a href="{{ route('brands', $brand->slug) }}"
                           class="col brand-{{ $count_slides }}-{{ $counter }}"
                           data-bs-toggle="tooltip"
                           title="{{$brand->title}}"
                        >
                            @if($brand->is_featured && $brand->image != 'null.webp')
                                <img width="100"
                                     height="25"
                                     src="{{$brand->asset_url.$brand->image}}"
                                     alt="{{$brand->title}}"
                                >
                            @else
                                {{ mb_strtoupper($brand->title) }}
                            @endif
                        </a>
                @if( $counter == 40 || $count_brands == $total_brands )
                    @php
                        $counter    = 0;
                        $count_slides++;
                    @endphp
                    </div>
                </div>
                @endif
                @php
                $counter++;
				$total_brands++;
                @endphp
            @endforeach
        </div>

        <div class="brand-swiper-pagination mt-2 text-center"></div>
    </div>
</div>

@push('customJs')
    @vite(['resources/assets/js/web/brands-swiper.js'])
@endpush