<div class="flex justify-center">
    @can('ver estados')
        <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.states')" :active="request()->routeIs('dashboard.states')"><i class="fa-solid fa-earth-americas me-1"></i> Estados</x-nav-link>
    @endcan
    @can('ver ciudades')
        <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.cities')" :active="request()->routeIs(['dashboard.cities', 'dashboard.state-cities'])"><i class="fa-solid fa-tree-city me-1"></i> Ciudades</x-nav-link>
    @endcan
    @can('ver contactos')
        <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.contactList')" :active="request()->routeIs(['dashboard.contactList'])"><i class="fa-solid fa-address-book me-1"></i> Contactos</x-nav-link>
    @endcan
    @can('ver usuarios')
        <x-nav-link class="min-w-32 justify-center" :href="route('users.index')" :active="request()->routeIs(['users.index'])"><i class="fa-solid fa-people-group me-1"></i> Usuarios</x-nav-link>
    @endcan
    @can('ver reportes')
        <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.quotationReport')" :active="request()->routeIs(['dashboard.quotationReport'])"><i class="fa-solid fa-chart-line"></i> Reportes</x-nav-link>
    @endcan
</div>
