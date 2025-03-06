@props(['name', 'label', 'required', 'fa_icon', 'description', 'value', 'width'=>100, 'checked' => FALSE])
@php
    $width_class = match($width)
    {
            100 => 'block'
        ,   50  => 'inline-block max-w-[48%]'
    }
@endphp
<div class="{{ $width_class }} w-full px-2">
    <label for="{{ $name }}_{{ $value }}"
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

        <input type="radio"
               id="{{ $name }}_{{ $value }}" name="{{ $name }}" value="{{ $value }}"
               class="peer size-3.5 appearance-none rounded-sm border border-slate-300 accent-pink-500 dark:accent-pink-600 checked:appearance-auto focus:ring-0"
               @if($checked) checked @endif
               @isset($required) required @endisset
               {{ $attributes }}
        >
    </label>
</div>
