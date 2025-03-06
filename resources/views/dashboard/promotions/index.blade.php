<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Promociones', 'fa_icon'=>'money-check-dollar', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'promotions', 'permission' => 'promociones'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="promotions-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th data-orderable="false" style="min-width: 104px">Estatus</th>
                <th style="min-width: 240px">Título</th>
                <th style="min-width: 240px">Descripción</th>
                <th data-orderable="false">Vista previa</th>
                <th data-orderable="false">Descuento</th>
                <th data-orderable="false" style="min-width: 100px">Vigencia</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false"  style="min-width: 106px">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.promotions.datatable') }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/promotions.js'])
    @endpush
</x-app-layout>
