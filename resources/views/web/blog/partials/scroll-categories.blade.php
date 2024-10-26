<div class="scroll_categories">
    <div id="scroll_categories--tag"
         class="scroll_categories--tag"
         data-bs-toggle="tooltip" title="Desliza la barra dorada para ver más items"
         data-bs-trigger="click"
    >
        <i class="bi bi-mouse-fill pulse"></i> {{ $tag_title }}
    </div>
    <ul class="scroll_categories--list">
        <li>
            <a href="{{ $todas_link  }}" class="active">Todas</a>
        </li>
        @foreach($categories AS $category)
            <li>
                <a href="{{ $category[1]  }}">{{ $category[0] }}</a>
            </li>
        @endforeach
    </ul>
</div>