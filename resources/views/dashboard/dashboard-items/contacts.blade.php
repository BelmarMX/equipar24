<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight"><i class="fa-solid fa-address-book"></i> Visor de contactos</h2>
        @include('dashboard.dashboard-items.submenu')
    </x-slot>

    <div class="container mx-auto bg-white p-4">
        <table id="contactList-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Correo electrónico</th>
                <th>Teléfono</th>
                <th>Empresa</th>
                <th>Estado</th>
                <th>Ciudad</th>
                <th>Alta</th>
            </tr>
            </thead>
        </table>
    </div>
    @push('ESmodules')
        <script>
            const route = '{{ route('dashboard.contactList.get') }}'
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/contactList.js'])
    @endpush
</x-app-layout>
