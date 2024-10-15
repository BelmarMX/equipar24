<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i class="fa-solid fa-square-arrow-up-right"></i> Visor de estados</h2>
        @include('dashboard.dashboard-items.submenu')
    </x-slot>

    <div class="container mx-auto bg-white p-4">
        <table id="states-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Código</th>
                    <th>Alias</th>
                    <th>Estado</th>
                    <th>Variación</th>
                    <th data-orderable="false">Municipios</th>
                    <th>Alta</th>
                    <th data-orderable="false">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
    @push('ESmodules')
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/states.js'])
    @endpush
</x-app-layout>
