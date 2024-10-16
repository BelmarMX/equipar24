<div class="flex justify-end mt-1">
    <x-secondary-link class="mx-1" :href="route($resource.'.index')" :active="request()->routeIs($resource.'.index')">
        <i class="fa-solid fa-clipboard-list me-1 text-base"></i> Registros
    </x-secondary-link>
    @if( Route::has($resource.'.archived') )
    <x-secondary-link class="mx-1" :href="route($resource.'.archived')" :active="request()->routeIs($resource.'.archived')">
        <i class="fa-solid fa-box-archive me-1 text-base"></i> Archivados
    </x-secondary-link>
    @endif
    <x-primary-link class="mx-1 md:ms-20 md:me-10 justify-center" :href="route($resource.'.create')" :active="request()->routeIs($resource.'.create')">
        <i class="fa-solid fa-circle-plus me-1 text-base"></i> Nuevo
    </x-primary-link>
</div>
