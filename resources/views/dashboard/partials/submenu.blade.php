<div class="flex justify-end mt-1">
    @isset($push_buttons)
        @foreach($push_buttons AS $button)
            <x-secondary-link class="mx-1" :href="route($button['route_name'])" :active="request()->routeIs($button['route_name'])">
                <i class="fa-solid {{ $button['icon'] }} md:me-1 text-base"></i><span class="hidden md:inline">{{ $button['text'] }}</span>
            </x-secondary-link>
        @endforeach
    @endisset
    @isset($resource)
        @can("ver $permission")
        <x-secondary-link class="mx-1" :href="route($resource.'.index')" :active="request()->routeIs($resource.'.index')">
            <i class="fa-solid fa-clipboard-list md:me-1 text-base"></i><span class="hidden md:inline">Registros</span>
        </x-secondary-link>
        @endcan
        @if( Route::has($resource.'.archived') && Auth()->user()->can("eliminar $permission") )
        <x-secondary-link class="mx-1" :href="route($resource.'.archived')" :active="request()->routeIs($resource.'.archived')">
            <i class="fa-solid fa-box-archive md:me-1 text-base"></i><span class="hidden md:inline">Papelera</span>
        </x-secondary-link>
        @endif

        @if( !isset($hide_new) || !$hide_new )
            @can("crear $permission")
                <x-primary-link class="mx-1 md:ms-20 md:me-10 justify-center" :href="route($resource.'.create')" :active="request()->routeIs($resource.'.create')">
                    <i class="fa-solid fa-circle-plus me-1 text-base"></i><span>Nuevo</span>
                </x-primary-link>
            @endcan
        @endif
    @endif
</div>
