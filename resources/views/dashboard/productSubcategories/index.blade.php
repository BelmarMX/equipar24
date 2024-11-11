<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Productos Subcategorías', 'fa_icon'=>'tags', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'productSubcategories', 'push_buttons' => [
                    ['icon' => 'fa-barcode', 'text' => 'Productos', 'route_name' => 'products.index']
                ,   ['icon' => 'fa-registered', 'text' => 'Marcas', 'route_name' => 'productBrands.index']
                ,   ['icon' => 'fa-tag', 'text' => 'Categorías', 'route_name' => 'productCategories.index']
            ]])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="productSubcategories-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Destacado</th>
                <th>Categoría</th>
                <th data-orderable="false">Productos</th>
                <th>Orden</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ empty($filter_type) ? route('dashboard.productSubcategories.datatable') : route('dashboard.productSubcategories.datatable.filter', ['filter_type'=>$filter_type, 'filter_id'=>$filter_id]) }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/productSubcategories.js'])
    @endpush
</x-app-layout>
