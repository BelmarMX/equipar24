@if( !empty($actions['restore']) && $actions['restore']['enabled'] )
    <a class="dt-custom-action restore" href="{{ route($actions['restore']['route'], $record -> id) }}" data-confirm-redirect='¿Quieres restaurar "{{ $record -> {$actions['field_name']} }}"?' data-tooltip="Restaurar"><i class="fa-solid fa-trash-arrow-up"></i></a>
@else
    <a class="dt-custom-action watch" href="{{ route($actions['watch']['route'], $record -> id) }}" data-tooltip="Ver detalles""><i class="fa-solid fa-binoculars"></i></a>
    <span class="inline-block ms-1 me-1 w-[0.05rem] h-5 bg-stone-200">&nbsp;</span>
    <a class="dt-custom-action delete @if(!$actions['delete']['enabled']) disabled @endif" @if($actions['delete']['enabled']) href="{{ route($actions['delete']['route'], $record -> id) }}" @endif data-confirm-redirect='¿Quieres eliminar este formulario?' data-tooltip="Eliminar"><i class="fa-solid fa-trash"></i></a>
@endif
