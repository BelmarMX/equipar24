<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-clapperboard me-1"></i> Reels @isset($subtitle) <i class="fa-solid fa-right-long fa-xs"></i> {{ $subtitle }} @endisset
            </h2>
            @include('dashboard.partials.submenu', ['resource' => 'reels'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="reels-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th style="min-width: 240px">Título</th>
                <th style="min-width: 160px" data-orderable="false">Enlace</th>
                <th style="min-width: 220px">Promoción</th>
                <th style="min-width: 220px">Producto</th>
                <th style="min-width: 120px" data-orderable="false">Vigencia</th>
                <th data-orderable="false">Reel</th>
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
