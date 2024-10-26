@props(['name', 'placeholder', 'required', 'value', 'readonly', 'disabled'])

<div {{ $attributes->merge(['class' => 'relative z-0 w-full px-2']) }}>
    <label for="{{$name}}" class="duration-300 top-3 pl-2 z-1 origin-0 text-gray-500">
        {{ $placeholder }} @isset($required) <span class="text-red-500"><i class="fa-solid fa-asterisk" style="font-size: 0.7rem"></i></span> @endisset
    </label>
    <div class="bg-gray-50 py-5 md:px-32">
        <div id="editorjs" class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"></div>
        <textarea id="raw_editor" name="{{$name}}" class="hidden" @isset($required) required @endisset @isset($readonly) readonly @endisset @isset($disabled) disabled @endisset>@isset($value){!! $value !!}@endisset</textarea>
    </div>
    @error($name)
    <x-form.error-field :id="$name" :error="$message" />
    @enderror
</div>
