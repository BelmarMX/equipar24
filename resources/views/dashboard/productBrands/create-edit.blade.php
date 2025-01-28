<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Productos Marcas', 'fa_icon'=>'registered', 'subtitle'=>$record->id ? 'Editar' : 'Nuevo'])
            @include('dashboard.partials.submenu', ['resource' => $resource, 'push_buttons' => [
                ['icon' => 'fa-barcode', 'text' => 'Productos', 'route_name' => 'products.index']
            ]])
        </div>
    </x-slot>

    <div class="container mx-auto bg-gray-200 dark:bg-white p-4">
        <form data-floating-labels
              id="form_create_edit"
              class="w-11/12 mx-auto px-1 py-7"
              method="POST"
              action="{{ $record->id ? route($resource.'.update', $record->id) : route($resource.'.store') }}"
              enctype="multipart/form-data"
              autocomplete="off"
        >
        @empty(!$record->id)
            @method('PUT')
        @endempty
        @csrf
            <h1 class="text-2xl subpixel-antialiased font-bold uppercase text-slate-800 mb-4">
                {!! $record->id ? '<i class="fa-solid fa-file-pen"></i>' : '<i class="fa-solid fa-file-circle-plus"></i>' !!} {{ $record->id ? 'Editar' : 'Nuevo' }} Registro
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
                        <x-form.input-text name="title" placeholder="Marca" value="{{ old('title', $record->title) }}" with_slug="true" required class="mb-6"/>
                        <div class="flex flex-wrap">
                            <div class="md:w-6/12">
                                <x-form.checkbox name="is_featured" label="Marca destacada" fa_icon="fa-star" value="1" checked="{{ old('is_featured', $record->is_featured) }}" :width="100" class="mb-6"/>
                            </div>
                            <div class="md:w-6/12">
                                <x-form.input-number name="order" placeholder="Orden" value="{{ old('order', $record->order ?? 0) }}" required class="mb-6"/>
                            </div>
                        </div>
                        <div class="w-full">
                            <x-form.textarea name="description" placeholder="Descripción" value="{{ old('description', $record->description) }}"/>
                        </div>
                    </div>
                    <div class="md:w-4/12 md:ms-[8.333%] w-full">
                        <x-form.file-image name="image"
                                           class="mb-6"
                                           placeholder="Identificador"
                                           required
                                           :width="$ImagesSettings::PRODUCT_BRAND_WIDTH"
                                           :height="$ImagesSettings::PRODUCT_BRAND_HEIGHT"
                                           :value="$record->id ? $record->asset_url.$record->image : NULL"
                        />
                    </div>
                </div>
            </div>
            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->

            <div class="flex justify-end border-t-4 border-slate-50 mt-2 pt-8">
                <x-form.button class="me-2" type="danger-outline" icon="fa-cancel" text="Cancelar" href="{{ route($resource.'.index') }}" data-confirm-redirect=""/>
                <x-form.button class="ms-1" type="success" icon="{{ $record->id ? 'fa-pencil' : 'fa-save' }}" text="{{$record->id ? 'Editar' : 'Guardar'}}" form="submit"/>
            </div>
        </form>
    </div>

    @push('style')
    @endpush
    @push('ESmodules')
    @endpush
</x-app-layout>
