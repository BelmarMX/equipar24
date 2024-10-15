<div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="portfolioModalLabel">{{ $entry -> title }}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div id="portfolio_slider" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img width="{{ env('PORTFOLIO_WIDTH') }}"
                         height="{{ env('PORTFOLIO_HEIGHT') }}"
                         src="{{ url("storage/portafolio/{$entry -> image}") }}"
                         class="d-block w-100 img-fluid"
                         alt="{{ $entry -> title }}"
                    >
                    <div class="row mx-0 w-100 p-3">
                        <div class="col-md-6 order-md-2 text-md-end">
                            <h3>{{$entry -> title}}</h3>
                            <small>1 de {{ count($gallery) > 0 ? count($gallery) + 1 : 1  }}</small>
                        </div>
                        <div class="col-md-6 order-md-1">
                            {!! $entry -> summary !!}
                        </div>
                    </div>
                </div>
                @foreach($gallery AS $g => $item)
                    <div class="carousel-item">
                        <img width="{{ env('PORTFOLIO_IMG_WIDTH') }}"
                             height="{{ env('PORTFOLIO_IMG_HEIGHT') }}"
                             src="{{ url("storage/portafolio-images/{$item -> image}") }}"
                             class="d-block w-100 img-fluid"
                             alt="{{ $item -> title }}"
                        >
                        <div class="row mx-0 w-100 p-3">
                            <div class="col-md-6 order-md-2 text-md-end">
                                <h3>{{ $entry -> title }}</h3>
                                <small>{{ $loop -> index + 2 }} de {{ count($gallery) + 1 }}</small>
                            </div>
                            <div class="col-md-6 order-md-1">
                                <p>
                                    {{ $item -> title }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @if( count($gallery) > 0)
            <button class="carousel-control-prev" type="button" data-bs-target="#portfolio_slider" data-bs-slide="prev">
                <i class="bi bi-arrow-left-circle" aria-hidden="true"></i>
                <span class="visually-hidden">Anterior</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#portfolio_slider" data-bs-slide="next">
                <i class="bi bi-arrow-right-circle" aria-hidden="true"></i>
                <span class="visually-hidden">Siguiente</span>
            </button>
            @endif
        </div>
    </div>
</div>