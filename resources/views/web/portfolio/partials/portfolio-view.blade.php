<div class="blog__view">
    <a class="blog__view__link"
       href="{{ $link }}"
       nofollow
       data-bs-toggle="modal"
       data-bs-target="#porfolio_modal"
    >
        <div class="blog__view__link--image">
            <img width=""
                 height=""
                 class="img-fluid"
                 src="{{ $image }}"
                 alt="{{ $title }}"
            >
        </div>
        <h3 class="blog__view__link--title">{{ $title }}</h3>
    </a>
    <p class="blog__view--summary">
        {!! $summary !!}
    </p>
</div>
