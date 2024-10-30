<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-barcode me-1"></i> Gallería producto<br>"{{ $record->title }}"
            </h2>
            @include('dashboard.partials.submenu-galleries', ['resource' => $resource])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-200 dark:bg-white p-4">
        <form data-floating-labels
              id="form_create_edit"
              class="w-11/12 mx-auto px-1 py-7"
              method="POST"
              action="{{ $gallery->id ? route($gallery_resource.'.update', $gallery->id) : route($gallery_resource.'.store') }}"
              enctype="multipart/form-data"
              autocomplete="off"
        >
        @empty(!$gallery->id)
            @method('PUT')
        @endempty
        @csrf
            <h1 class="text-2xl subpixel-antialiased font-bold uppercase text-slate-800 mb-4">
                {!! $gallery->id ? '<i class="fa-solid fa-file-pen"></i>' : '<i class="fa-solid fa-file-image"></i>' !!} {{ $gallery->id ? 'Editar' : 'Carga' }} de imágenes
            </h1>
            @if($errors -> any() )
                <x-form.alert type="danger" title="Hay errores en el formulario que impidieron su registro." />
            @endif
            <hr class="mb-2 border-2 border-slate-50"/>

            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->
            <div class="bg-neutral-50 px-3 py-10">
                <div class="flex flex-wrap">
                    <div class="md:w-6/12 w-full">
                        <input type="hidden" name="product_id" value="{{ $record->id }}">
                        <x-form.input-text name="title" placeholder="Título de la imagen" value="{{ old('title', $record->title) }}" required class="mb-6"/>
                    </div>
                    <div class="md:w-4/12 md:ms-[8.333%] w-full">
                        <x-form.file-image name="image"
                                           class="mb-6"
                                           placeholder="Imagen principal"
                                           required
                                           dimensions_tag="mínimo: "
                                           :width="$ImagesSettings::PRODUCT_WIDTH"
                                           :height="$ImagesSettings::PRODUCT_HEIGHT"
                                           :value="$gallery->id ? $gallery->asset_url.$gallery->image : NULL"
                        />
                    </div>
                </div>
            </div>
            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->

            <div class="flex justify-end border-t-4 border-slate-50 mt-2 pt-8">
                <x-form.button class="me-2" type="danger-outline" icon="fa-cancel" text="Cancelar" href="{{ route($gallery_resource.'.gallery', $record->id) }}" data-confirm-redirect=""/>
                <x-form.button class="ms-1" type="success" icon="{{ $gallery->id ? 'fa-pencil' : 'fa-save' }}" text="{{$gallery->id ? 'Editar' : 'Guardar'}}" form="submit"/>
            </div>
        </form>
    </div>

    <div class="container mx-auto bg-gray-50 dark:bg-white p-4">
        <table id="productGallery-table" class="display" style="width:100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th data-orderable="false">Vista previa</th>
                <th data-orderable="false">Alta</th>
                <th data-orderable="false">Acciones</th>
            </tr>
            </thead>
        </table>
    </div>

    @push('style')
    @endpush
    @push('ESmodules')
        <script>
            const url_route     = '{{ route('dashboard.productGalleries.datatable', $record->id) }}'
            const with_trashed  = {{ !empty($with_trashed) && $with_trashed ? 'true' : 'false' }}
        </script>
        @vite(['resources/assets/js/dashboard/datatables/common.js', 'resources/assets/js/dashboard/behavior.js', 'resources/assets/js/dashboard/datatables/productGalleries.js'])
    @endpush
</x-app-layout>
