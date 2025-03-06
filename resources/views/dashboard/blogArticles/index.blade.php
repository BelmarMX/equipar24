<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Artículos del blog', 'fa_icon'=>'rss', 'subtitle'=>$subtitle])
            @include('dashboard.partials.submenu', ['resource' => 'blogArticles', 'push_buttons' => [
                ['icon' => 'fa-tag', 'text' => 'Categorías', 'route_name' => 'blogCategories.index']
            ], 'permission' => 'blog'])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="blogArticles-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Categoría</th>
                <th>Resumen</th>
                <th data-orderable="false">Vista previa</th>
                <th>Publicación</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.blogArticles.datatable') }}';
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/datatables/blogArticles.js'])
    @endpush
</x-app-layout>
