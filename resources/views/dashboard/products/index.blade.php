<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Productos', 'fa_icon'=>'barcode', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'products', 'push_buttons' => [
                    ['icon' => 'fa-registered', 'text' => 'Marcas', 'route_name' => 'productBrands.index']
                ,   ['icon' => 'fa-tag', 'text' => 'Categorías', 'route_name' => 'productCategories.index']
                ,   ['icon' => 'fa-tags', 'text' => 'Subcategorías', 'route_name' => 'productSubcategories.index']
            ]])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <div class="table-responsivex">
        <table id="products-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th style="min-width: 360px">Título</th>
                <th style="min-width: 140px">Modelo</th>
                <th style="min-width: 120px">Marca</th>
                <th style="min-width: 180px">Categoría</th>
                <th style="min-width: 220px">Subcategoría</th>
                <th>Precio</th>
                <th><i class="fa-solid fa-star fa-lg" data-tooltip="Producto destacado"></i></th>
                <th><i class="fa-solid fa-truck-fast fa-lg" data-tooltip="Incluye flete"></i></th>
                <th data-orderable="false"><i class="fa-solid fa-money-check-dollar fa-lg" data-tooltip="Promociones relacionadas"></i></th>
                <th data-orderable="false"><i class="fa-solid fa-images fa-lg" data-tooltip="Imágenes en galería"></i></th>
                <th style="min-width: 120px">Vista Previa</th>
                <th data-orderable="false" style="min-width: 120px">Alta</th>
                <th data-orderable="false" style="min-width: 120px" data-priority="1">Acciones</th>
            </tr>
            </thead>
        </table>
        </div>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ empty($filter_type) ? route('dashboard.products.datatable') : route('dashboard.products.datatable.filter', ['filter_type'=>$filter_type, 'filter_id'=>$filter_id]) }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/products.js'])
    @endpush
</x-app-layout>
