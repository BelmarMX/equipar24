<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Paquetes', 'fa_icon'=>'box-open', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'productPackages', 'permission' => 'paquetes'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <div class="table-responsivex">
        <table id="productPackages-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th style="min-width: 360px">Título</th>
                <th style="min-width: 360px">URL</th>
                <th data-orderable="false"><i class="fa-solid fa-barcode fa-lg" data-tooltip="Productos en el paquete"></i></th>
                <th style="min-width: 120px">Vista Previa</th>
                <th data-orderable="false" style="min-width: 100px">Vigencia</th>
                <th data-orderable="false" style="min-width: 120px">Alta</th>
                <th data-orderable="false" style="min-width: 120px" data-priority="1">Acciones</th>
            </tr>
            </thead>
        </table>
        </div>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.productPackages.datatable') }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/productPackages.js'])
    @endpush
</x-app-layout>
