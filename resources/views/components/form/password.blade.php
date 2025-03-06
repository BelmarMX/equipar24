@props(['name', 'placeholder', 'required', 'value', 'readonly', 'bind_readonly', 'disabled', 'with_slug'])

<div {{ $attributes->merge(['class' => 'relative z-0 w-full px-2']) }}>
    <input id="{{$name}}"
           class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 read-only:bg-gray-100 read-only:text-gray-600"
           type="password"
           name="{{ $name }}"
           placeholder="{{ $placeholder }}"
           value="{{ $value }}"
           @if($required) required @endif
           @isset($readonly) readonly @endisset
           @isset($disabled) disabled @endisset
           @isset($bind_readonly) x-bind:readonly="!edit_field" @endisset
           data-clear-errors
    />
    <label for="{{$name}}" class="absolute duration-300 top-3 pl-2 z-1 origin-0 text-gray-500">
        {{ $placeholder }} @if($required) <span class="text-red-500"><i class="fa-solid fa-asterisk" style="font-size: 0.7rem"></i></span> @endif
    </label>
    @error($name)
    <x-form.error-field :id="$name" :error="$message" />
    @enderror
    @if( isset($with_slug) && $with_slug )
        @error('slug')
        <x-form.error-field id="slug" :error="$message" />
        @enderror
    @endif
</div>

<div {{ $attributes->merge(['class' => 'relative z-0 w-full px-2']) }}>
    <input id="{{$name}}_confirmation"
           class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700 read-only:bg-gray-100 read-only:text-gray-600"
           type="password"
           name="{{ $name }}_confirmation"
           placeholder="Confirmar {{ $placeholder }}"
           value="{{ $value }}"
           @if($required) required @endif
           @isset($readonly) readonly @endisset
           @isset($disabled) disabled @endisset
           @isset($bind_readonly) x-bind:readonly="!edit_field" @endisset
           data-clear-errors
    />
    <label for="{{$name}}_confirmation" class="absolute duration-300 top-3 pl-2 z-1 origin-0 text-gray-500">
        Confirmar {{ $placeholder }} @if($required) <span class="text-red-500"><i class="fa-solid fa-asterisk" style="font-size: 0.7rem"></i></span> @endif
    </label>
    @error($name.'_confirmation')
    <x-form.error-field :id="$name.'_confirmation' " :error="$message" />
    @enderror
    @if( isset($with_slug) && $with_slug )
        @error('slug')
        <x-form.error-field id="slug" :error="$message" />
        @enderror
    @endif
</div>
