<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Sucursales', 'fa_icon'=>'store', 'subtitle'=>$record->id ? 'Editar' : 'Nuevo'])
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
                    <x-form.input-text name="title" placeholder="Nombre de la sucursal" value="{{ old('title', $record->title) }}" required class="mb-6 md:w-6/12"/>
                    <x-form.input-text name="country" placeholder="Páis" value="México" readonly class="mb-6 md:w-3/12 md:ms-[25%]"/>
                </div>
                <div class="flex flex-wrap">
                    <x-form.input-text name="building" placeholder="Edificio" value="{{ old('building', $record->building) }}" class="mb-6 md:w-3/12"/>
                    <x-form.input-text name="street" placeholder="Calle" value="{{ old('street', $record->street) }}" required class="mb-6 md:w-4/12"/>
                    <x-form.input-text name="number" placeholder="Número" value="{{ old('number', $record->number) }}" required class="mb-6 md:w-2/12"/>
                    <x-form.input-text name="neighborhood" placeholder="Colonia" value="{{ old('neighborhood', $record->neighborhood) }}" required class="mb-6 md:w-3/12"/>
                </div>
                <div class="flex flex-wrap">
                    <x-form.select select2 data-state-fill="#city_id" name="state_id" placeholder="Estado" value="{{ $record->state }}" required class="mb-6 md:w-4/12">
                        <option selected>Estado</option>
                        @foreach($states AS $state)
                            <option value="{{ $state -> id }}" @if( old('state_id', $record->state_id) == $state -> id) selected @endif>{{ $state->name }}</option>
                        @endforeach
                    </x-form.select>
                    <x-form.select select2 name="city_id" placeholder="Ciudad" value="{{ $record->city }}" required class="mb-6 md:w-4/12">
                        <option selected>Ciudad</option>
                        @if( $record->city )
                            @foreach($record -> state -> cities AS $city)
                                <option value="{{ $city -> id }}" @if( old('city_id', $record->city_id) == $city -> id) selected @endif>{{ $city->name }}</option>
                            @endforeach
                        @endif
                    </x-form.select>
                    <x-form.input-number name="phone" placeholder="Teléfono a 10 dígitos" value="{{ old('phone', $record->phone) }}" min="1000000000" max="9999999999" required class="mb-6 md:w-4/12"/>
                </div>
                <div class="flex flex-wrap">
                    <div class="w-full md:w-6/12">
                        <x-form.input-text name="link" placeholder="Enlace corto a Google Maps" value="{{ old('link', $record->link) }}" required class="mb-6"/>
                        <x-form.input-text name="embed_code" placeholder="Código de incrustación de Google Maps" value="{{ old('embed_code', $record->embed_code) }}" required class="mb-6" load-iframe="#maps_frame"/>
                    </div>
                    <div class="w-full md:w-6/12 p-5 bg-gray-100">
                        <iframe id="maps_frame" src="{{ old('embed_code', $record->embed_code) }}" class="w-full min-h-64 border-0"></iframe>
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
