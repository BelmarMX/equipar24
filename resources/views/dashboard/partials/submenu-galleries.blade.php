<div class="flex justify-end mt-1">
    <x-secondary-link class="mx-1" :href="route($resource.'.index')" :active="request()->routeIs($resource.'.index')">
        <i class="fa-solid fa-clipboard-list me-1 text-base"></i> Registros
    </x-secondary-link>
    @if( Route::has($resource.'.archived') )
        @can('editar '.$permission)
            <x-secondary-link class="mx-1" :href="route($resource.'.archived')" :active="request()->routeIs($resource.'.archived')">
                <i class="fa-solid fa-box-archive me-1 text-base"></i> Archivados
            </x-secondary-link>
        @endcan
    @endif
</div>
