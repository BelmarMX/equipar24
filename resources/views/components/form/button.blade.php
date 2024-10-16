@props(['type', 'icon', 'text', 'form', 'href'])

@php
    $clases = 'inline-flex items-center px-4 py-2 uppercase rounded-md border font-semibold text-xs tracking-widest transition ease-in-out duration-150 ';
    if( $type == 'danger-outline' )
    {
        $clases .= "bg-white border-white text-red-400 hover:bg-red-600 hover:text-white focus:bg-red-600 focus:text-white active:bg-red-700 active:text-white focus:outline-none focus:ring-2 focus:ring-red-200 focus:ring-offset-2";
    }
    elseif( $type == 'success' )
    {
        $clases .= "bg-emerald-500 border-emerald-500 text-white shadow-lg hover:bg-emerald-600 hover:border-emerald-600 focus:outline-none focus:ring-2 focus:ring-emerald-200 focus:ring-offset-2 disabled:opacity-25 hover:scale-105 hover:-translate-y-1";
    }
@endphp

@empty($href)
    <button type="{{ $form ?? 'submit' }}"
        {{ $attributes->merge(['class' => $clases]) }}
    >
        <i class="fa-solid {{ $icon }} me-1"></i> {{ $text }}
    </button>
@else
    <a href="{{ $href }}"
        {{ $attributes->merge(['class' => $clases]) }}
    >
        <i class="fa-solid {{ $icon }} me-1"></i> {{ $text }}
    </a>
@endif