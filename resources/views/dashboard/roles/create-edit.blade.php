<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Roles y Permisos', 'fa_icon'=>'shield-halved', 'subtitle'=>$record->id ? 'Editar' : 'Nuevo'])
            @include('dashboard.partials.submenu', ['resource' => $resource,  'push_buttons' => [
                ['icon' => 'fa-users', 'text' => 'Usuarios', 'route_name' => 'users.index']
            ], 'permission' => 'roles'])
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
                <p class="hidden">{{ json_encode($errors->all()) }}</p>
            @endif
            <hr class="mb-2 border-2 border-slate-50"/>

            <!-- * -------------------------------------------------------------- *
            ? FORM FIELDS
            * -------------------------------------------------------------- * -->
            <div class="bg-neutral-50 px-3 py-10">
                <div class="flex flex-wrap">
                    <div class="md:w-6/12 w-full">
                        <x-form.input-text name="name" placeholder="Nombre del rol" value="{{ old('name', $record->name) }}" required class="mb-6"/>
                    </div>
                    <div class="w-full">
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <h2 class="text-md subpixel-antialiased font-bold uppercase text-sky-500 mb-4">VER</h2>
                            </div>
                            @foreach($permissions AS $permission)
                                @if(Str($permission)->contains('ver'))
                                    <div class="inline-block md:w-3/12">
                                        <x-form.checkbox name="permissions[{{$permission->name}}]"
                                                         label="{{ ucfirst($permission->name) }}"
                                                         fa_icon="fa-eye"
                                                         value="{{ $permission->name }}"
                                                         checked="{{ !$record->id ? false : $record->hasPermissionTo($permission->name) }}"
                                                         :width="100"
                                                         class="mb-6"
                                        />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <h2 class="text-md subpixel-antialiased font-bold uppercase text-blue-500 mb-4">CREAR</h2>
                            </div>
                            @foreach($permissions AS $permission)
                                @if(Str($permission)->contains('crear'))
                                    <div class="inline-block md:w-3/12">
                                        <x-form.checkbox name="permissions[{{$permission->name}}]"
                                                         label="{{ ucfirst($permission->name) }}"
                                                         fa_icon="fa-square-plus"
                                                         value="{{ $permission->name }}"
                                                         checked="{{ !$record->id ? false : $record->hasPermissionTo($permission->name) }}"
                                                         :width="100"
                                                         class="mb-6"
                                        />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <h2 class="text-md subpixel-antialiased font-bold uppercase text-amber-500 mb-4">EDITAR</h2>
                            </div>
                            @foreach($permissions AS $permission)
                                @if(Str($permission)->contains('editar'))
                                    <div class="inline-block md:w-3/12">
                                        <x-form.checkbox name="permissions[{{$permission->name}}]"
                                                         label="{{ ucfirst($permission->name) }}"
                                                         fa_icon="fa-square-pen"
                                                         value="{{ $permission->name }}"
                                                         checked="{{ !$record->id ? false : $record->hasPermissionTo($permission->name) }}"
                                                         :width="100"
                                                         class="mb-6"
                                        />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <h2 class="text-md subpixel-antialiased font-bold uppercase text-red-500 mb-4">ELIMINAR</h2>
                            </div>
                            @foreach($permissions AS $permission)
                                @if(Str($permission)->contains('eliminar'))
                                    <div class="inline-block md:w-3/12">
                                        <x-form.checkbox name="permissions[{{$permission->name}}]"
                                                         label="{{ ucfirst($permission->name) }}"
                                                         fa_icon="fa-square-minus"
                                                         value="{{ $permission->name }}"
                                                         checked="{{ !$record->id ? false : $record->hasPermissionTo($permission->name) }}"
                                                         :width="100"
                                                         class="mb-6"
                                        />
                                    </div>
                                @endif
                            @endforeach
                        </div>
                        <div class="flex flex-wrap">
                            <div class="w-full">
                                <h2 class="text-md subpixel-antialiased font-bold uppercase text-violet-500 mb-4">OTROS</h2>
                            </div>
                            @foreach($permissions AS $permission)
                                @if( !Str($permission)->contains(['ver', 'crear', 'editar', 'eliminar']))
                                    <div class="inline-block md:w-3/12">
                                        <x-form.checkbox name="permissions[{{$permission->name}}]"
                                                         label="{{ ucfirst($permission->name) }}"
                                                         fa_icon="fa-shield-halved"
                                                         value="{{ $permission->name }}"
                                                         checked="{{ !$record->id ? false : $record->hasPermissionTo($permission->name) }}"
                                                         :width="100"
                                                         class="mb-6"
                                        />
                                    </div>
                                @endif
                            @endforeach
                        </div>
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
        <script >
            $(document).on('click', '[data-permissions]', function(e){
                $('[data-permission]').addClass('opacity-25')
                let permissions = $(this).attr('data-permissions').split('|')
                permissions.forEach(permission => {
                    $('[data-permission="'+permission+'"]').removeClass('opacity-25')
                })
            })
        </script>
    @endpush
</x-app-layout>
