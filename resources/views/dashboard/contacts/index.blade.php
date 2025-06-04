<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Contactos', 'fa_icon'=>'envelope-open', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'contacts', 'permission' => 'contactos', 'hide_new' => true])
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
                <th data-orderable="false">Atendido</th>
                <th data-orderable="false">Estimado</th>
                <th data-orderable="false">Vendido</th>
                <th data-orderable="false">Recibido</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ empty($filter) ? route('dashboard.contacts.datatable') : route('dashboard.contacts.datatable.filter', ['filter'=>$filter]) }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/contacts.js'])
    @endpush
</x-app-layout>
