<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-money-check-dollar me-1"></i> Promociones @isset($subtitle) <i class="fa-solid fa-right-long fa-xs"></i> {{ $subtitle }} @endisset
            </h2>
            @include('dashboard.partials.submenu', ['resource' => 'promotions'])
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
                <th data-orderable="false" style="min-width: 80px">Vigencia</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false">Acciones</th>
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
