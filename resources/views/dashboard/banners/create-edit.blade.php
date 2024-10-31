<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-images me-1"></i> Banners <i class="fa-solid fa-right-long fa-xs"></i> {{ $record->id ? 'Editar' : 'Nuevo' }}
            </h2>
            @include('dashboard.partials.submenu', ['resource' => $resource])
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
                        <x-form.select select2 name="promotion_id" placeholder="Promoción (opcional)" value="{{ $record->promotion_id }}" class="mb-6">
                            <option value="" selected>Ninguna</option>
                            @foreach($promotions AS $promotion)
                                <option value="{{ $promotion -> id }}" @if( old('promotion_id', $record->promotion_id) == $promotion->id) selected @endif
                                        data-link-href="{{route('promociones-productos', $promotion->slug)}}"
                                        data-link-title="{{ $promotion->title }}"
                                >{{ $promotion->title }}</option>
                            @endforeach
                        </x-form.select>
                        <div class="flex flex-wrap mb-3">
                            <div class="leading-relaxed text-end pr-1 w-full">
                                Autocompletar con:
                                <x-form.button form="button" class="me-2" type="info-outline" icon="fa-money-check-dollar" text="Promoción" onclick="update_with_promotion()"/>
                            </div>
                        </div>
                        <x-form.input-text name="title" placeholder="Título del banner" value="{{ old('title', $record->title) }}" required class="mb-6"/>
                        <x-form.input-text name="link" placeholder="Enlace (opcional)" value="{{ old('link', $record->link) }}" class="mb-6"/>
                    </div>
                    <div class="md:w-4/12 md:ms-[8.333%] w-full">
                        <x-form.file-image name="image"
                                           class="mb-6"
                                           placeholder="Imagen principal"
                                           required
                                           :width="$ImagesSettings::BANNER_WIDTH"
                                           :height="$ImagesSettings::BANNER_HEIGHT"
                                           :value="$record->id ? $record->asset_url.$record->image : NULL"
                        />
                        <x-form.file-image name="image_mv"
                                           class="mb-6"
                                           placeholder="Imagen versión móvil"
                                           required
                                           :width="$ImagesSettings::BANNER_WIDTH_MV"
                                           :height="$ImagesSettings::BANNER_HEIGHT_MV"
                                           :value="$record->id ? $record->asset_url.$record->image_mv : NULL"/>
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
        <script>
            const update_link = option => {
                $('#link').val(option.attr('data-link-href'))
                $('#title').val(option.attr('data-link-title'))
            }

            const update_with_promotion = O => {
                update_link( $('#promotion_id').find('option:selected') )
            }
        </script>
    @endpush
</x-app-layout>
