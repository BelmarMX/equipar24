<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-envelope-open me-1"></i> Contactos @isset($subtitle) <i class="fa-solid fa-right-long fa-xs"></i> {{ $subtitle }} @endisset
            </h2>
            @include('dashboard.partials.submenu', ['resource' => 'contacts'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="promotions-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th data-orderable="false" style="min-width: 126px">Estatus</th>
                <th>Tipo</th>
                <th data-orderable="false">Contacto</th>
                <th data-orderable="false">Estado</th>
                <th data-orderable="false">Ciudad</th>
                <th data-orderable="false">Estimado</th>
                <th data-orderable="false">Atendido</th>
                <th data-orderable="false">Recibido</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.contacts.datatable') }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/contacts.js'])
    @endpush
</x-app-layout>
