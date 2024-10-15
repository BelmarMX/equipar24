<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i class="fa-solid fa-square-arrow-up-right"></i> Visor de ciudades @isset($state)<i class="fa-solid fa-arrow-right"></i> {{ $state -> name }} @endisset</h2>
        @include('dashboard.dashboard-items.submenu')
    </x-slot>

    <div class="container mx-auto bg-white p-4">
        <table id="cities-table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Estado</th>
                    <th>Municipio</th>
                    <th>Alta</th>
                    <th data-orderable="false">Acciones</th>
                </tr>
            </thead>
        </table>
    </div>
    @push('ESmodules')
        <script>
            @isset($state)
            const route = '{{ route('dashboard.state-cities.get', $state -> id) }}'
            @else
            const route = '{{ route('dashboard.cities.get') }}'
            @endisset
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/cities.js'])
    @endpush
</x-app-layout>
