@props(['name', 'label', 'required', 'fa_icon', 'description', 'value', 'width'=>100, 'checked' => FALSE])
@php
    $width_class = match($width)
    {
            100 => 'block'
        ,   50  => 'inline-block max-w-[48%]'
    }
@endphp
<div class="{{ $width_class }} w-full px-2">
    <label for="{{ $name }}"
           class="flex justify-between items-center w-full py-2 px-4 mb-3
           rounded-lg cursor-pointer
           text-gray-600
           hover:font-semibold
           border
           border-transparent
           bg-neutral-100
           hover:bg-slate-100
           has-[:checked]:border-pink-200
           has-[:checked]:bg-neutral-100
           has-[:checked]:ring-pink-300"
    >
        <span>@if(!empty($fa_icon)) <i class="fa-solid {{ $fa_icon }} fa-xs"></i> @endif {{ $label }}</span>

        <input type="checkbox"
               id="{{ $name }}" name="{{ $name }}" value="{{ $value }}"
               class="peer size-3.5 appearance-none rounded-sm border border-slate-300 accent-pink-500 dark:accent-pink-600 checked:appearance-auto focus:ring-0"
               @if($checked) checked @endif
               @isset($required) required @endisset
        >
    </label>
</div>

{{--
<div {{ $attributes->merge(['class' => 'inline-block px-2']) }}>
    <input type="checkbox"
           id="{{ $name }}"
           class="hidden peer"
           name="{{ $name }}"
           value="{{ $value }}"
           @isset($required) required @endisset
    >
    <label for="{{ $name }}"
           class="inline-flex items-center justify-between
           w-full p-5
           text-gray-500
           hover:text-gray-600
           dark:text-gray-400
           dark:hover:text-gray-300
           bg-white
           dark:bg-gray-800
           hover:bg-gray-50
           dark:hover:bg-gray-700
           border-2 rounded-lg
           border-gray-200
           dark:border-gray-700
           peer-checked:border-blue-600
           peer-checked:text-gray-600
           dark:peer-checked:text-gray-300
           has-[:checked]:bg-indigo-50 has-[:checked]:text-indigo-900 has-[:checked]:ring-indigo-200
           cursor-pointer"
    >
        <div class="block">
            @isset($fa_icon)
                <i class="fa-solid {{ $fa_icon }} me-1"></i>
            @endisset
            <div class="w-full text-lg font-semibold uppercase">{{ $label }}</div>
            @isset($description)
            <div class="w-full text-sm">{{ $description }}</div>
            @endisset
        </div>
    </label>
</div>--}}
