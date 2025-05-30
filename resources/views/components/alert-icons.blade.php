@props(['type', 'tooltip'])
@php
    switch ($type)
    {
        case 'success':
            $text_color = 'text-green-500';
            $tooltip_bg = 'bg-green-500';
            $svg_path   = 'M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z';
        break;
        case 'warning':
            $text_color = 'text-yellow-500';
            $tooltip_bg = 'bg-yellow-500';
            $svg_path   = 'M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z';
        break;
        case 'danger':
            $text_color = 'text-red-500';
            $tooltip_bg = 'bg-red-500';
            $svg_path   = 'M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z';
        break;
        default:
        case 'info':
            $text_color = 'text-blue-500';
            $tooltip_bg = 'bg-blue-500';
            $svg_path   = 'M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z';
        break;
    }
@endphp
@if( !empty($tooltip) )
    <div x-data="{ tooltip: false }" class="relative z-30 inline-flex">
        <svg x-on:mouseover="tooltip = true"
             x-on:mouseleave="tooltip = false"
             class="w-5 h-5 {{ $text_color }} fill-current"
             viewBox="0 0 40 40"
             xmlns="http://www.w3.org/2000/svg"
        >
            <path d="{{ $svg_path  }}"/>
        </svg>
        <div class="relative" x-cloak x-show.transition.origin.top="tooltip">
            <div class="absolute top-0 z-10 w-32 p-2 -mt-1 text-sm leading-tight text-white transform -translate-x-1/2 -translate-y-full {{ $tooltip_bg }} rounded-md shadow-lg">
                {{ $tooltip }}
            </div>
            <svg class="absolute z-10 w-6 h-6 {{ $text_color }} transform -translate-x-12 -translate-y-3 fill-current stroke-current" width="8" height="8">
                <rect x="12" y="-10" width="8" height="8" transform="rotate(45)" />
            </svg>
        </div>
    </div>
@else
    <svg class="inline w-5 h-5 {{ $text_color }} fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
        <path d="{{ $svg_path  }}"/>
    </svg>
@endif
