@props(['id', 'name', 'placeholder', 'required', 'min', 'max', 'value', 'readonly', 'disabled'])
<div {{ $attributes->merge(['class' => 'relative z-0 w-full px-2 mb-5']) }}>
    <input id="{{$id ?? $name}}"
           class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"
           type="number"
           name="{{ $name }}"
           @isset($min) min="{{ $min }}" @endisset
           @isset($max) max="{{ $max }}" @endisset
           placeholder="{{ $placeholder }}"
           value="{{ $value }}"
           @isset($required) required @endisset
           @isset($readonly) readonly @endisset
           @isset($disabled) disabled @endisset
    >
    <label for="{{$id ?? $name}}" class="absolute duration-300 top-3 pl-2 z-1 origin-0 text-gray-500">{{ $placeholder }}</label>
    @if(empty($value) && isset($required) && $required)
        <span id="{{$id ?? $name}}_error" class="text-sm text-red-600 hidden">{{ $placeholder  }} es requerido</span>
    @endif
</div>
