<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Banners', 'fa_icon'=>'images', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'banners'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="banners-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Enlace</th>
                <th>Promoción</th>
                <th>Orden</th>
                <th data-orderable="false" style="min-width: 106px;">Vista previa</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false" style="min-width: 106px;">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route         = '{{ route('dashboard.banners.datatable') }}';
            const url_route_order   = '{{ route('dashboard.banners.reorder') }}'
            const with_trashed      = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/banners.js'])
    @endpush
</x-app-layout>
