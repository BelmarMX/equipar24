<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Usuarios', 'fa_icon'=>'people-group', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'users', 'permission' => 'usuarios'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="users-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th style="min-width: 256px">Email</th>
                <th style="min-width: 200px">Nombre</th>
                <th data-orderable="false">Verificado</th>
                <th data-orderable="false">Rol(es)</th>
                <th data-orderable="false">Permisos</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ empty($filter) ? route('dashboard.users.datatable') : route('dashboard.users.datatable.filter', ['filter'=>$filter]) }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/users.js'])
    @endpush
</x-app-layout>
