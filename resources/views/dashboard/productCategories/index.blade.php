<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-tag me-1"></i> Productos Categorías @isset($subtitle) <i class="fa-solid fa-right-long fa-xs"></i> {{ $subtitle }} @endisset
            </h2>
            @include('dashboard.partials.submenu', ['resource' => 'productCategories', 'push_buttons' => [
                ['icon' => 'fa-barcode', 'text' => 'Productos', 'route_name' => 'products.index']
            ]])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="productCategories-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Destacado</th>
                <th>Productos</th>
                <th>Subcategorías</th>
                <th>Vista Previa</th>
                <th>Orden</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.productCategories.datatable') }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/productCategories.js'])
    @endpush
</x-app-layout>
