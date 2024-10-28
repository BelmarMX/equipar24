<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-barcode me-1"></i> Productos @isset($subtitle) <i class="fa-solid fa-right-long fa-xs"></i> {{ $subtitle }} @endisset
            </h2>
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
                <th data-priority="1">Título</th>
                <th data-priority="2">Modelo</th>
                <th data-priority="4">Destacado</th>
                <th data-priority="3">Categoría</th>
                <th data-priority="3">Subcategoría</th>
                <th data-priority="2">Marca</th>
                <th data-priority="2">Precio</th>
                <th data-priority="2">Flete</th>
                <th data-priority="3">Vista Previa</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false" data-priority="1">Acciones</th>
            </tr>
            </thead>
        </table>
        </div>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.products.datatable') }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/products.js'])
    @endpush
</x-app-layout>
