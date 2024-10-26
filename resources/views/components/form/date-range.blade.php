@props(['id', 'start_name', 'end_name', 'placeholder', 'required', 'start_value', 'end_value', 'readonly', 'disabled'])

<div {{ $attributes->merge(['class' => 'relative z-0 w-full px-2']) }}>
    <input id="{{$id}}"
           class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"
           type="text"
           placeholder="{{ $placeholder }}"
           @if( !empty($start_value) && !empty($end_value) )
           value="{{ \Carbon\Carbon::parse($start_value)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($end_value)->format('d/m/Y') }}"
           @endif
           @isset($required) required @endisset
           @isset($readonly) readonly @endisset
           @isset($disabled) disabled @endisset
           data-range
           data-range-set_start="#{{ $start_name }}"
           data-range-set_end="#{{ $end_name }}"
           data-clear-errors
    />
    <input type="hidden" id="{{ $start_name }}" name="{{ $start_name }}" value="{{ $start_value }}" @isset($required) required @endisset>
    <input type="hidden" id="{{ $end_name }}" name="{{ $end_name }}" value="{{ $end_value }}" @isset($required) required @endisset>
    <label for="{{$id}}" class="absolute duration-300 top-3 pl-2 z-1 origin-0 text-gray-500">
        {{ $placeholder }} @isset($required) <span class="text-red-500"><i class="fa-solid fa-asterisk" style="font-size: 0.7rem"></i></span> @endisset
    </label>
    @error($start_name)
    <x-form.error-field :id="$start_name" :error="$message" />
    @enderror
    @error($end_name)
    <x-form.error-field :id="$end_name" :error="$message" />
    @enderror
</div>
