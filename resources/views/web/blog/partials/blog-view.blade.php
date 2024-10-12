<div class="blog__view">
    <a class="blog__view__link" href="{{ $link }}">
        <div class="blog__view__link--image">
            <img width="{{ env('ARTICLE_RX_WIDTH') }}"
                 height="{{ env('ARTICLE_RX_HEIGHT') }}"
                 class="img-fluid"
                 src="{{ $image }}"
                 alt="{{ $title }}"
            >
            <div class="blog__view__link__float">
                <span class="blog__view__link__float--day">{{ $day }}</span>
                <span class="blog__view__link__float--month">{{ $month }}</span>
            </div>
        </div>
        <h3 class="blog__view__link--title">{{ $title }}</h3>
    </a>
    <a class="blog__view--category" href="{{ $category_link }}">
        <i class="bi bi-tag" data-bs-toggle="tooltip" title="Categoria: {{ $category_title }}"></i> {{ $category_title }}
    </a>
    <p class="blog__view--summary">
        {!! $summary !!}
    </p>
</div>