<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-store me-1"></i> Sucursales @isset($subtitle) <i class="fa-solid fa-right-long fa-xs"></i> {{ $subtitle }} @endisset
            </h2>
            @include('dashboard.partials.submenu', ['resource' => 'branches'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="branches-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th data-orderable="false">Dirección</th>
                <th>Ciudad</th>
                <th>Estado</th>
                <th>País</th>
                <th>Teléfono</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>
    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.branches.datatable') }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/branches.js'])
    @endpush
</x-app-layout>
