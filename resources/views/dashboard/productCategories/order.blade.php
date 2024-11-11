<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Productos Categorías', 'fa_icon'=>'tag', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'productCategories', 'push_buttons' => [
                    ['icon' => 'fa-barcode', 'text' => 'Productos', 'route_name' => 'products.index']
                ,   ['icon' => 'fa-registered', 'text' => 'Marcas', 'route_name' => 'productBrands.index']
                ,   ['icon' => 'fa-tags', 'text' => 'Subcategorías', 'route_name' => 'productSubcategories.index']
            ]])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <div class="flex flex-wrap items-center justify-center p-6 border-2 border-dotted mb-5" id="orderable">
            @foreach($records AS $record)
                <div class="block draggable is_draggable w-1/5 border-2 p-2 m-2 text-center hover:bg-gray-200 cursor-pointer rounded" data-id="{{$record->id}}" data-position="{{ $record->order }}">
                    {{ $record->title }}
                </div>
            @endforeach
        </div>

        <div class="text-right">
            <x-form.button class="ms-1" type="success" icon="fa-save" text="Actualizar" form="button" data-action-post/>
        </div>
    </div>

    @push('ESmodules')
        <script>
            const url_route         = '{{ route('dashboard.productCategories.sort') }}';
            const url_route_back    = '{{ route('productCategories.index') }}';
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/dragger.js'])
    @endpush
</x-app-layout>
