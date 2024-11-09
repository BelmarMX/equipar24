<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Productos Categorías', 'fa_icon'=>'tag', 'subtitle'=>$subtitle])
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
