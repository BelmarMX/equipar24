<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Vacantes', 'fa_icon'=>'briefcase', 'subtitle'=>$record->id ? 'Editar' : 'Nuevo'])
            @include('dashboard.partials.submenu', ['resource' => $resource, 'permission' => 'blog'])
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
                        <div class="flex flex-wrap">
                            <x-form.input-text name="title" placeholder="Título de la vacante" value="{{ old('title', $record->title) }}" with_slug="true" required class="mb-6"/>
                            <x-form.input-text name="summary" placeholder="Resumen" value="{{ old('summary', $record->summary) }}" class="mb-6"/>
                        </div>
                        <div class="flex flex-wrap">
                            <x-form.date-range id="date_time_vigency"
                                               start_name="starts_at"
                                               end_name="ends_at"
                                               placeholder="Vigencia"
                                               start_value="{{ old('starts_at', $record->starts_at ?? date('Y-m-d')) }}"
                                               end_value="{{ old('ends_at', $record->ends_at ?? date('Y-m-d')) }}"
                                               required
                                               class="mb-6"
                            />
                        </div>
                    </div>
                    <div class="md:w-4/12 md:ms-[8.333%] w-full">
                        <x-form.file-image name="image"
                                           class="mb-6"
                                           placeholder="Imagen principal"
                                           required
                                           dimensions_tag="mínimo"
                                           :width="$ImagesSettings::VACANCY_WIDTH"
                                           :height="$ImagesSettings::VACANCY_HEIGHT"
                                           :value="$record->id ? $record->asset_url.$record->image : NULL"
                        />
                    </div>
                    <div class="w-full">
                        <x-form.textarea-editor name="raw_editor" class="mb-6" placeholder="Descripción de la oferta" value="{{ old('raw_editor', $record->raw_editor) }}" required/>
                    </div>
                </div>

                @if( $requested )
                    <h3 class="text-2xl subpixel-antialiased font-bold uppercase text-slate-800 mb-4">Solicitudes Recibidas:</h3>
                    <table class="w-full border-">
                        <thead>
                            <tr>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">ID</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Nombre</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Email</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Teléfono</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Currículum</th>
                                <th class="px-6 py-3 border-b-2 border-gray-300 text-left leading-4 text-blue-500 tracking-wider">Recibido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($requested AS $rr)
                                <tr>
                                    <td class="px-3 py-2 whitespace-no-wrap border-b border-gray-500">{{$rr->id}}</td>
                                    <td class="px-3 py-2 whitespace-no-wrap border-b border-gray-500">{{$rr->name}}</td>
                                    <td class="px-3 py-2 whitespace-no-wrap border-b border-gray-500">{{$rr->email}}</td>
                                    <td class="px-3 py-2 whitespace-no-wrap border-b border-gray-500">{{$rr->phone}}</td>
                                    <td class="px-3 py-2 whitespace-no-wrap border-b border-gray-500 text-center">
                                        <a target="_blank" href="{{ url('storage/vacantes/curriculum/'.$rr->file) }}" data-toggle="tooltip" title="Currículum de {{ $rr->name }}">
                                            <i class="fa-solid fa-file"></i>
                                        </a>
                                    </td>
                                    <td class="px-3 py-2 whitespace-no-wrap border-b border-gray-500">{{$rr->created_at}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-4 whitespace-no-wrap border-b border-gray-500 text-center">Sin solicitudes</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                @endif
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
        @if($record->id && is_null($record->raw_editor))
            <script>
                const editor_data_html = `{!! $record->content !!}`
            </script>
        @endif
    @endpush
</x-app-layout>
