@props(['name', 'placeholder', 'required', 'select2'])

<div {{ $attributes->merge(['class' => 'relative z-0 w-full px-2']) }}>
    <select id="{{$id ?? $name}}"
            class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 @isset($select2) select-2 @endisset"
            name="{{ $name }}"
            data-clear-errors
    >
        {{ $slot }}
    </select>
    <label for="{{$name}}" class="absolute duration-300 top-3 pl-2 @isset($select2) left-0 @endisset z-1 origin-0 text-gray-500">
        {{ $placeholder }} @isset($required) <span class="text-red-500"><i class="fa-solid fa-asterisk" style="font-size: 0.7rem"></i></span> @endisset
    </label>
    @error($name)
        <x-form.error-field :id="$name" error="Debes seleccionar un valor para {{ $placeholder }}" />
    @enderror
</div>
