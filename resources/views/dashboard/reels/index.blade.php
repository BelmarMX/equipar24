<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Reels', 'fa_icon'=>'clapperboard', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'reels', 'permission' => 'reels'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="reels-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th data-orderable="false" style="min-width: 104px">Estatus</th>
                <th style="min-width: 240px">Título</th>
                <th style="min-width: 160px" data-orderable="false">Enlace</th>
                <th style="min-width: 220px">Promoción</th>
                <th style="min-width: 220px">Producto</th>
                <th style="min-width: 220px">Paquete</th>
                <th style="min-width: 120px" data-orderable="false">Vigencia</th>
                <th style="min-width: 120px" data-orderable="false">Reel</th>
                <th style="min-width: 140px" data-orderable="false">Alta</th>
                <th style="min-width: 120px" data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.reels.datatable') }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/reels.js'])
    @endpush
</x-app-layout>
