<div>
    @if( $record->image )
        <button data-lightbox="{{ $record->asset_url.$record->image }}"
           class="cursor-pointer text-blue-400 hover:text-blue-600 disabled:opacity-30"
           data-tooltip="Imagen original"
           data-title="Vista previa '{{ $record->title }}': Original"
           @if( !file_exists('storage/'.$ImagesSettings::BANNER_FOLDER.$record->image) ) disabled @endif
        ><i class="fa-solid fa-panorama fa-lg mx-1"></i></button>
    @endif
    @if( $record->image_rx )
        <button data-lightbox="{{ $record->asset_url.$record->image_rx }}"
           class="cursor-pointer text-blue-400 hover:text-blue-600 disabled:opacity-30"
           data-tooltip="Recorte automático"
           data-title="Vista previa '{{ $record->title }}': Recorte"
           @if( !file_exists('storage/'.$ImagesSettings::BANNER_FOLDER.$record->image_rx) ) disabled @endif
        ><i class="fa-regular fa-image fa-lg mx-1"></i></button>
    @endif
    @if( $record->image_mv )
        <button data-lightbox="{{ $record->asset_url.$record->image_mv }}"
           class="cursor-pointer text-blue-400 hover:text-blue-600 disabled:opacity-30"
           data-tooltip="Versión móvil"
           data-title="Vista previa '{{ $record->title }}': Móvil"
           @if( !file_exists('storage/'.$ImagesSettings::BANNER_FOLDER.$record->image_mv) ) disabled @endif
        ><i class="fa-solid fa-image fa-lg mx-1"></i></button>
    @endif
</div>
