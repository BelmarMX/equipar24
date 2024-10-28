@props(['name', 'placeholder', 'required', 'value'])

@php
    $raw_features   = '';
    $features       = [];
    if( !empty($value) )
    {
        $raw_features   = $value;
        $features       = array_reverse(explode('|', $value));
    }
@endphp

<div data-features-wrapper {{ $attributes->merge(['class' => 'relative z-0 w-full p-2 border border-gray-300 rounded-md']) }}>
    <label for="{{$name}}" class="duration-300 top-3 pl-2 z-1 origin-0 text-gray-500">
        {{ $placeholder }} @isset($required) <span class="text-red-500"><i class="fa-solid fa-asterisk" style="font-size: 0.7rem"></i></span> @endisset
    </label>
    <div data-features-control>
        @foreach($features AS $feature)
            <div class="relative flex items-center mt-2">
                <button type="button"
                        class="absolute right-2 focus:outline-none rtl:left-0 rtl:right-auto text-red-400 hover:text-red-600 "
                        data-feature-action-remove
                >
                    <i class="fa-solid fa-trash"></i>
                </button>
                <input type="text"
                       placeholder="Característica"
                       class="block w-full pt-3 pb-2 p-2 mt-0 bg-gray-50 hover:bg-gray-100 border-0 border-b-2 border-violet-50 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"
                       value="{{ $feature }}"
                       data-feature-item
                       readonly
                >
            </div>
        @endforeach
    </div>
    <div>
        <div class="relative flex items-center mt-2">
            <button type="button"
                    class="absolute right-2 focus:outline-none rtl:left-0 rtl:right-auto text-sky-400 hover:text-sky-600"
                    data-feature-action-add
            >
                <i class="fa-solid fa-circle-plus"></i>
            </button>
            <input type="text"
                   placeholder="Agrega una nueva característica"
                   class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"
                   data-feature-input-source
            >
        </div>
        <textarea data-features-raw class="hidden" name="{{ $name }}" id="{{ $name }}" readonly>{{ $raw_features }}</textarea>
    </div>
</div>
