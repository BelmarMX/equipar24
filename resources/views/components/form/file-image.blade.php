@props(['name', 'placeholder', 'required', 'value', 'readonly', 'disabled', 'width', 'height'])

<div {{ $attributes->merge(['class' => 'flex flex-col justify-center w-full']) }}>
    <label for="{{ $name }}" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-100 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
        <div class="flex flex-col items-center justify-center">
            <div id="vista_previa_{{ $name }}" class="flex mb-4 text-gray-500 dark:text-gray-400 justify-center @empty($value) hidden @endempty" style="max-height: 150px; padding: 0 10px">
                <img class="image_preview h-full" src="@if( !empty($value) ){{ $value }}@endif" alt="Vista Previa de {{ $name }}">
            </div>
            <svg class="svg_load_icon w-8 h-8 mb-4 text-gray-500 dark:text-gray-400 @empty(!$value) hidden @endempty" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
            </svg>
            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">Click para cargar <span class="font-semibold">{{ mb_strtoupper($placeholder) }}</span></p>
            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG o WEBP ({{ $width }}x{{ $height }}px)</p>
            <span class="metadata text-xs text-sky-500 dark:text-sky-400 hidden" style="padding: 1px 10px"></span>
        </div>
        <input id="{{ $name }}" name="{{ $name }}" type="file" class="hidden" data-preview-image="#vista_previa_{{ $name }}" accept="image/jpeg,image/jpg,image/png,image/webp"/>
    </label>
    @error($name)
        <x-form.error-field :id="$name" :error="$message" />
    @enderror
    @if( !empty($value) )
        <button type="button"
                class="mx-auto mt-1 inline-block px-2 py-px border mb-1 rounded text-center text-slate-400 dark:hover:text-white bg-gray-50 dark:bg-gray-100 hover:bg-gray-100 dark:hover:bg-gray-600 max-w-[75%]"
                data-lightbox="{{ $value }}" data-title="Vista previa: {{ $placeholder }}">Ampliar <i class="fa-solid fa-up-right-and-down-left-from-center ms-1"></i>
        </button>
    @endif
</div>
