<div class="flex justify-center">
    <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.states')" :active="request()->routeIs('dashboard.states')"><i class="fa-solid fa-earth-americas me-1"></i> Estados</x-nav-link>
    <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.cities')" :active="request()->routeIs(['dashboard.cities', 'dashboard.state-cities'])"><i class="fa-solid fa-tree-city me-1"></i> Ciudades</x-nav-link>
    <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.contactList')" :active="request()->routeIs(['dashboard.contactList'])"><i class="fa-solid fa-address-book me-1"></i> Contactos</x-nav-link>
</div>
