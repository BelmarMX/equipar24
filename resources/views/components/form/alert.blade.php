@props(['type', 'title', 'message'])

@php
$title      = !empty($title)    ? $title : NULL;
$max_width  = !empty($message)  ? 'max-w-sm' : 'max-w-2xl';
switch($type)
{
    case 'danger':
        $head           = $title ?? "¡Advertencia!";
        $svg            = "M20 3.36667C10.8167 3.36667 3.3667 10.8167 3.3667 20C3.3667 29.1833 10.8167 36.6333 20 36.6333C29.1834 36.6333 36.6334 29.1833 36.6334 20C36.6334 10.8167 29.1834 3.36667 20 3.36667ZM19.1334 33.3333V22.9H13.3334L21.6667 6.66667V17.1H27.25L19.1334 33.3333Z";
        $bg_color       = "bg-red-500";
        $text_color     = "text-red-500 dark:text-red-400";
    break;
    case 'warning':
        $head           = $title ?? "¡Cuidado!";
        $svg            = "M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z";
        $bg_color       = "bg-amber-400";
        $text_color     = "text-amber-400 dark:text-amber-300";
    break;
    case 'success':
        $head           = $title ??  "Acción completada";
        $svg            = "M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM16.6667 28.3333L8.33337 20L10.6834 17.65L16.6667 23.6166L29.3167 10.9666L31.6667 13.3333L16.6667 28.3333Z";
        $bg_color       = "bg-emerald-500";
        $text_color     = "text-emerald-500 dark:text-emerald-400";
    break;
    default:
    case 'info':
        $head           = $title ?? "Información";
        $svg            = "M20 3.33331C10.8 3.33331 3.33337 10.8 3.33337 20C3.33337 29.2 10.8 36.6666 20 36.6666C29.2 36.6666 36.6667 29.2 36.6667 20C36.6667 10.8 29.2 3.33331 20 3.33331ZM21.6667 28.3333H18.3334V25H21.6667V28.3333ZM21.6667 21.6666H18.3334V11.6666H21.6667V21.6666Z";
        $bg_color       = "bg-blue-500";
        $text_color     = "text-blue-500 dark:text-blue-400";
}
@endphp
<div class="flex w-full {{ $max_width }} overflow-hidden rounded-lg shadow-md bg-white dark:bg-gray-800 transition ease-in-out delay-150 hover:-translate-y-1 hover:scale-110 duration-300 my-2 mx-auto">
    <div class="inline-flex items-center justify-center {{ $bg_color }}" style="min-width: 48px; max-width: 48px">
        <svg class="w-6 h-6 text-white fill-current" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
            <path d="{{ $svg }}" />
        </svg>
    </div>

    <div class="px-4 py-2 -mx-3">
        <div class="mx-3">
            <span class="font-medium {{ $text_color }}">{{ $head }}</span>
            @if( !empty($message) )
            <p class="text-sm text-gray-600 dark:text-gray-200">{{ $message }}</p>
            @endif
        </div>
    </div>
</div>
