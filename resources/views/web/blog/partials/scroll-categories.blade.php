<div class="scroll_categories">
    <div id="scroll_categories--tag"
         class="scroll_categories--tag"
    >
        <i class="bi bi-tag-fill pulse"></i> {{ $tag_title }}
    </div>
    <ul class="scroll_categories--list">
        <li>
            <a href="{{ $todas_link  }}" class="active">Todas</a>
        </li>
        @foreach($categories AS $category)
            <li style="border-right: 1px dotted #334155;">
                <a href="{{ $category[1]  }}">{{ $category[0] }}</a>
            </li>
        @endforeach
    </ul>
</div>
