<div class="flex justify-center">
    <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.states')" :active="request()->routeIs('dashboard.states')"><i class="fa-solid fa-square-arrow-up-right me-1"></i> Estados</x-nav-link>
    <x-nav-link class="min-w-32 justify-center" :href="route('dashboard.cities')" :active="request()->routeIs(['dashboard.cities', 'dashboard.state-cities'])"><i class="fa-solid fa-square-arrow-up-right me-1"></i> Ciudades</x-nav-link>
</div>
