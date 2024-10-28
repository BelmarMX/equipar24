@props(['name', 'placeholder', 'required', 'value'])

<div {{ $attributes->merge(['class' => 'relative z-0 w-full px-2']) }} x-data="{ feature: '' }">
    <div>
        <textarea name="" id="" rows="5" class="w-full" readonly x-text="feature"></textarea>
    </div>
    <div>
        <div class="relative flex items-center mt-2">
            <button type="button"
                    class="absolute right-2 focus:outline-none rtl:left-0 rtl:right-auto text-sky-700 hover:text-sky-900"
                    @click="feature = feature + '|'+ $refs.box.value; $refs.box.value = ''"
            >
                <i class="fa-solid fa-circle-plus"></i>
            </button>
            <input type="text"
                   placeholder="Característica"
                   class="block w-full pt-3 pb-2 p-2 mt-0 bg-white border-0 border-b-2 border-violet-100 rounded appearance-none focus:outline-none focus:ring-0 focus:border-violet-700"
                   x-ref="box"
            >
        </div>
    </div>
</div>
