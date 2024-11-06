@php
    $className = "text-white py-px px-1 rounded-full text-center text-xs uppercase font-semibold ";
    if( $record->status == 'approved' )
    {
        $className .= "bg-emerald-400";
        $text       = 'Aprobado';
        $icon       = '<i class="fa-solid fa-thumbs-up me-1"></i>';
    }
    elseif( $record->status == 'rejected' )
    {
        $className .= "bg-red-400";
        $text       = 'Rechazado';
        $icon       = '<i class="fa-solid fa-thumbs-down me-1"></i>';
    }
    elseif( $record->status == 'pending' )
    {
        $className .= "bg-indigo-400";
        $text       = 'Pendiente';
        $icon       = '<i class="fa-solid fa-stopwatch me-1"></i>';
    }
@endphp
<div class="{{ $className }}">
    {!! $icon !!} {{ $text }}
</div>
