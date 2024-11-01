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
                <a href="{{ $category[1] }}" @if( isset($category[2]) && $category[2]) class="text-decoration-underline" @endif>{{ $category[0] }}</a>
            </li>
        @endforeach
    </ul>
    @if( !empty($subcategories) )
        <ul class="scroll_categories--list under">
            <li style="border-right: 1px dotted #334155;">
                <a><i class="bi bi-tags-fill"></i></a>
            </li>
            @foreach($subcategories AS $subcategory)
                <li style="border-right: 1px dotted #334155;">
                    <a href="{{ $subcategory[1] }}" @if( isset($subcategory[2]) && $subcategory[2]) class="text-decoration-underline" @endif>{{ $subcategory[0] }}</a>
                </li>
            @endforeach
        </ul>
    @endif
</div>
