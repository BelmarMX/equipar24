<div class="product__card text-center">
    <div class="product__card__wrap position-relative d-inline-block">
        <div class="product__card__behind">
                <span class="product__card__behind--tag">{{ $cat }}</span>
            <div class="product__card__front">
                <a href="{{ $route }}">
                    <img class="product__card__front--image img-fluid"
                         src="{{ $image }}"
                         alt="{{ $title }}"
                    >
                    <span class="product__card__front--model">
                        <strong>{{$title}}</strong>
                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
