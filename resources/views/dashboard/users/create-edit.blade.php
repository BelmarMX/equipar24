<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col md:flex-row justify-between items-center">
            @include('dashboard.partials.section-title', ['section_name'=>'Usuarios', 'fa_icon'=>'user', 'subtitle'=>$record->id ? 'Editar' : 'Nuevo'])
            @include('dashboard.partials.submenu', ['resource' => $resource, 'push_buttons' => [
                ['icon' => 'fa-shield-halved', 'text' => 'Roles', 'route_name' => 'roles.index']
            ], 'permission' => 'usuarios'])
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
                        <input type="hidden" name="original_role" value="{{ $record->id ? implode(',', $record->getRoleNames()->toArray()) : null }}">
                        <x-form.input-text name="name" placeholder="Nombre del usuario" value="{{ old('name', $record->name) }}" required class="mb-6"/>
                        <x-form.input-text name="email" placeholder="Email del usuario" value="{{ old('email', $record->email) }}" required class="mb-6"/>
                        <x-form.password name="password" placeholder="Contraseña" value="" :required="empty($record->id)" class="mb-6"/>
                        @error('rol')
                        <x-form.error-field id="role" :error="$message" />
                        @enderror
                        <div class="flex flex-wrap">
                            @foreach($roles AS $role)
                                <div class="inline-block md:w-6/12">
                                    <x-form.radio name="role"
                                                  label="{{ ucfirst($role->name) }}"
                                                  fa_icon="fa-user-tag"
                                                  value="{{ $role->name }}"
                                                  checked="{{ !$record->id ? false : $record->hasRole($role->name) }}"
                                                  :width="100"
                                                  class="mb-6"
                                                  data-permissions="{{ implode('|', array_map(function($r){ return $r['name']; }, $role->permissions->toArray())) }}"
                                    />
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <div class="md:w-6/12 w-full">
                        @php
                        $user_permissions = array_map(function($r){ return $r['name']; }, $record->getPermissionsViaRoles()->toArray());
                        @endphp
                        @foreach($permissions AS $permission)
                            @php
                            $bg_color   = 'bg-sky-500';
                            $opacity    = 'opacity-25';
                            if( Str()->contains($permission->name, 'crear') )
                            {
                                $bg_color = 'bg-blue-500';
                            }
                            elseif( Str()->contains($permission->name, 'editar') )
                            {
                                $bg_color = 'bg-amber-500';
                            }
                            elseif( Str()->contains($permission->name, 'eliminar') )
                            {
                                $bg_color = 'bg-red-500';
                            }

                            if( in_array($permission->name, $user_permissions) )
                            {
                                $opacity = '';
                            }
                            @endphp
                            <small data-permission="{{ $permission->name }}" class="mt-1 px-1 inline-block rounded-xl {{ $bg_color }} text-white uppercase {{ $opacity }}">{{ ucfirst($permission->name) }}</small>
                        @endforeach
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
