@empty(!$actions['custom']['related'])
    <a class="dt-custom-action tooltip" data-tooltip="{{ $actions['custom']['related']['tooltip'] ?? '' }}"
       href="{{ route($actions['custom']['related']['route'], $record -> id) }}"
    >
        <i class="fa-solid fa-circle-nodes"></i>
    </a>
@endempty
@empty(!$actions['custom']['images'])
    <a class="dt-custom-action tooltip" title="{{ $actions['custom']['images']['tooltip'] ?? '' }}"
       href="{{ route($actions['custom']['images']['route'], $record -> id) }}"
    >
        <i class="fa-solid fa-image"></i>
    </a>
@endempty
@empty(!$actions['custom']['video'])
    <a class="dt-custom-action tooltip" title="{{ $actions['custom']['video']['tooltip'] ?? '' }}"
       href="{{ route($actions['custom']['video']['route'], $record -> id) }}"
    >
        <i class="fa-solid fa-film"></i>
    </a>
@endempty
@empty(!$actions['custom']['download'])
    <a class="dt-custom-action tooltip" title="{{ $actions['custom']['download']['tooltip'] ?? '' }}"
       href="{{ route($actions['custom']['download']['route'], $record -> id) }}"
    >
        <i class="fa-solid fa-file-arrow-down"></i>
    </a>
@endempty
@if( $actions['divider'])
<span class="inline-block ms-1 me-1 w-[0.05rem] h-5 bg-stone-200">&nbsp;</span>
@endif
<a class="dt-custom-action edit @if(!$actions['edit']['enabled']) disabled @endif" @if($actions['edit']['enabled']) href="{{ route($actions['edit']['route'], $record -> id) }}" @endif><i class="fa-solid fa-file-pen"></i></a>
<a class="dt-custom-action delete @if(!$actions['delete']['enabled']) disabled @endif" @if($actions['delete']['enabled']) href="{{ route($actions['delete']['route'], $record -> id) }}" @endif><i class="fa-solid fa-trash"></i></a>
