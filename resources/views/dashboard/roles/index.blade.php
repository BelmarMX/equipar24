<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Roles y Permisos', 'fa_icon'=>'shield-halved', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'roles', 'push_buttons' => [
                ['icon' => 'fa-users', 'text' => 'Usuarios', 'route_name' => 'users.index']
            ], 'permission' => 'roles'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="roles-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th style="min-width: 200px">Rol</th>
                <th data-orderable="false">Permisos</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route = '{{ route('dashboard.roles.datatable') }}';
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/roles.js'])
    @endpush
</x-app-layout>
