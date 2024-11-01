<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            <h2 class="mb-3 md:mb-0 font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                <i class="fa-solid fa-money-check-dollar me-1"></i> Promociones <i class="fa-solid fa-right-long fa-xs"></i> {{ $record->id ? 'Editar' : 'Nuevo' }}
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
                        <x-form.input-text name="title" placeholder="Nombre de la promoción" value="{{ old('title', $record->title) }}" with_slug="true" required class="mb-6"/>
                        <x-form.input-text name="description" placeholder="Descripción" value="{{ old('description', $record->description) }}" class="mb-6"/>
                        <div class="flex flex-wrap">
                            <div class="md:w-6/12 w-full">
                                <x-form.select select2 name="discount_type" placeholder="Tipo de descuento" required class="mb-6">
                                    <option value="" selected disabled>Selecciona un tipo</option>
                                    <option value="fixed" @if( old('discount_type', $record->discount_type) == 'fixed') selected @endif>[ $ ] Cantidad fija</option>
                                    <option value="percentage"@if( old('discount_type', $record->discount_type) == 'percentage') selected @endif>[ % ] Porcentaje</option>
                                </x-form.select>
                            </div>
                            <div class="md:w-6/12 w-full">
                                <x-form.input-number name="amount" placeholder="Cantidad" value="{{ old('amount', $record->amount) }}" min="1" decimal="0.01" required class="mb-6"/>
                            </div>
                        </div>
                        <x-form.date-range id="date_time_vigency"
                                           start_name="starts_at"
                                           end_name="ends_at"
                                           placeholder="Vigencia"
                                           min_date="{{ $record->starts_at && $record->starts_at <= date('Y-m-d') ? $record->starts_at : date('Y-m-d 00:00:00') }}"
                                           start_value="{{ old('starts_at', $record->starts_at ?? date('Y-m-d')) }}"
                                           end_value="{{ old('ends_at', $record->ends_at ?? date('Y-m-d')) }}"
                                           required
                                           class="mb-6"
                        />
                    </div>
                    <div class="md:w-4/12 md:ms-[8.333%] w-full">
                        <x-form.file-image name="image"
                                           class="mb-6"
                                           placeholder="Imagen principal"
                                           required
                                           :width="$ImagesSettings::PROMOS_WIDTH"
                                           :height="$ImagesSettings::PROMOS_HEIGHT"
                                           :value="$record->id ? $record->asset_url.$record->image : NULL"
                        />
                        <x-form.file-image name="image_mv"
                                           class="mb-6"
                                           placeholder="Imagen versión móvil"
                                           required
                                           :width="$ImagesSettings::PROMOS_WIDTH_MV"
                                           :height="$ImagesSettings::PROMOS_HEIGHT_MV"
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
    @endpush
</x-app-layout>
