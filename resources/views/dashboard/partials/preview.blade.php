<div>
    @if( $record->image )
        <button data-lightbox="{{ $record->asset_url.$record->image }}"
           class="cursor-pointer text-blue-400 hover:text-blue-600 disabled:opacity-30"
           data-tooltip="Imagen original"
           data-title="Vista previa '{{ $record->title }}': Original"
           @if( !file_exists($record->asset_folder.$record->image) ) disabled @endif
        >
            @if(isset($show_thumbnail) && $show_thumbnail)
                <img src="{{ $record->asset_url.$record->image }}" alt="{{ $record->title }}" class="object-cover rounded-lg">
            @else
                <i class="fa-solid fa-panorama fa-lg mx-1"></i>
            @endif

        </button>
    @endif
    @if( $record->image_rx )
        <button data-lightbox="{{ $record->asset_url.$record->image_rx }}"
           class="cursor-pointer text-blue-400 hover:text-blue-600 disabled:opacity-30"
           data-tooltip="Recorte automático"
           data-title="Vista previa '{{ $record->title }}': Recorte"
           @if( !file_exists($record->asset_folder.$record->image_rx) ) disabled @endif
        >
            @if(isset($show_thumbnail) && $show_thumbnail)
                <img src="{{ $record->asset_url.$record->image_rx }}" alt="{{ $record->title }}" class="object-cover rounded-lg">
            @else
                <i class="fa-regular fa-image fa-lg mx-1"></i>
            @endif
        </button>
    @endif
    @if( $record->image_mv )
        <button data-lightbox="{{ $record->asset_url.$record->image_mv }}"
           class="cursor-pointer text-blue-400 hover:text-blue-600 disabled:opacity-30"
           data-tooltip="Versión móvil"
           data-title="Vista previa '{{ $record->title }}': Móvil"
           @if( !file_exists($record->asset_folder.$record->image_mv) ) disabled @endif
        >
            @if(isset($show_thumbnail) && $show_thumbnail)
                <img src="{{ $record->asset_url.$record->image_mv }}" alt="{{ $record->title }}" class="object-cover rounded-lg">
            @else
            <i class="fa-solid fa-image fa-lg mx-1"></i>
            @endif
        </button>
    @endif
    @if( $record->data_sheet )
        <button data-lightbox-embed="{{ $record->asset_url.'fichas/'.$record->data_sheet }}"
                class="cursor-pointer text-blue-400 hover:text-blue-600 disabled:opacity-30"
                data-tooltip="Hoja técnica"
                data-title="Vista previa '{{ $record->title }}': Hoja técnica"
                @if( !file_exists($record->asset_folder.'fichas/'.$record->data_sheet) ) disabled @endif
        >
            @if(isset($show_thumbnail) && $show_thumbnail)
                <embed src="{{ $record->asset_url.'fichas/'.$record->data_sheet }}" alt="{{ $record->title }}" class="object-cover rounded-lg">
            @else
                <i class="fa-solid fa-file-pdf fa-lg mx-1"></i>
            @endif
        </button>
    @endif

</div>
