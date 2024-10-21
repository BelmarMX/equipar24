@php
    $className = "text-white py-px px-1 rounded-full text-center text-xs uppercase font-semibold ";
    if( $vigency->type == 'success' )
    {
        $className .= "bg-emerald-400";
    }
    elseif( $vigency->type == 'danger' )
    {
        $className .= "bg-red-400";
    }
    elseif( $vigency->type == 'info' )
    {
        $className .= "bg-indigo-400";
    }
@endphp
<div class="{{ $className }}">
    {!! $vigency->html !!}
</div>
