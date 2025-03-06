<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Productos Marcas', 'fa_icon'=>'registered', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'productBrands', 'push_buttons' => [
                    ['icon' => 'fa-barcode', 'text' => 'Productos', 'route_name' => 'products.index']
                ,   ['icon' => 'fa-tag', 'text' => 'Categorías', 'route_name' => 'productCategories.index']
                ,   ['icon' => 'fa-tags', 'text' => 'Subcategorías', 'route_name' => 'productSubcategories.index']
            ], 'permission' => 'productos'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <div class="flex flex-wrap items-center justify-center p-6 border-2 border-dotted mb-5" id="orderable">
            @foreach($records AS $record)
                <div class="block draggable is_draggable w-1/5 border-2 p-2 m-2 text-center hover:bg-gray-200 cursor-pointer rounded" data-id="{{$record->id}}" data-position="{{ $record->order }}">
                    @if( file_exists($record->asset_folder.$record->image) )
                        <img class="mx-auto" src="{{$record->asset_url.$record->image}}" alt="{{ $record->title }}">
                    @else
                        {{ $record->title }}
                    @endif
                </div>
            @endforeach
        </div>

        @can('editar productos')
            <div class="text-right">
                <x-form.button class="ms-1" type="success" icon="fa-save" text="Actualizar" form="button" data-action-post/>
            </div>
        @endcan
    </div>

    @push('ESmodules')
        <script>
            const url_route         = '{{ route('dashboard.productBrands.sort') }}';
            const url_route_back    = '{{ route('productBrands.index') }}';
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/dragger.js'])
    @endpush
</x-app-layout>
