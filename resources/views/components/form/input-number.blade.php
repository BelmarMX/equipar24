@props(['name', 'placeholder', 'required', 'min', 'max', 'decimal', 'value', 'readonly', 'disabled'])

<div {{ $attributes->merge(['class' => 'relative z-0 w-full px-2 mb-5']) }}>
    <input id="{{$name}}"
           class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 text-right"
           type="number"
           name="{{ $name }}"
           @isset($min) min="{{ $min }}" @endisset
           @isset($max) max="{{ $max }}" @endisset
           @isset($decimal) step=".01" @else step="1" @endisset
           placeholder="{{ $placeholder }}"
           value="{{ $value }}"
           @isset($required) required @endisset
           @isset($readonly) readonly @endisset
           @isset($disabled) disabled @endisset
           data-clear-errors
    >
    <label for="{{$name}}" class="absolute duration-300 top-3 pl-2 z-1 origin-0 text-gray-500" style="right: 19px">
        {{ $placeholder }} @isset($required) <span class="text-red-500"><i class="fa-solid fa-asterisk" style="font-size: 0.7rem"></i></span> @endisset
    </label>
    @error($name)
        <x-form.error-field :id="$name" :error="$message" />
    @enderror
</div>
