@if( $Navigation::is_mobile() )
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <i class="fa-solid fa-chart-line me-1"></i> {{ __('Dashboard') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('banners.index')" :active="request()->routeIs('banners.index')">
        <i class="fa-solid fa-images me-1"></i> Banners
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('reels.index')" :active="request()->routeIs('reels.index')">
        <i class="fa-solid fa-clapperboard me-1"></i> Reels
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
        <i class="fa-solid fa-barcode me-1"></i> Productos
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('promotions.index')" :active="request()->routeIs('promotions.index')">
        <i class="fa-solid fa-money-check-dollar me-1"></i> Promociones
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')">
        <i class="fa-regular fa-folder-open me-1"></i> Proyectos
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('blog.index')" :active="request()->routeIs('blog.index')">
        <i class="fa-solid fa-rss me-1"></i> Blog
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('contacts.index')" :active="request()->routeIs('contacts.index')">
        <i class="fa-solid fa-envelope-open me-1"></i> Contactos
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('branches.index')" :active="request()->routeIs('branches.index')">
        <i class="fa-solid fa-store me-1"></i> Sucursales
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('index')" target="_blank">
        <i class="fa-solid fa-earth-americas"></i> Sitio
    </x-responsive-nav-link>
@else
    <x-nav-link :href="route('dashboard')" data-tooltip="Notificaciones (próximamente)">
        <i class="fa-regular fa-bell"></i>
    </x-nav-link>
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <i class="fa-solid fa-chart-line me-1"></i> {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('banners.index')" :active="request()->routeIs('banners.index')">
        <i class="fa-solid fa-images me-1"></i> Banners
    </x-nav-link>
    <x-nav-link :href="route('reels.index')" :active="request()->routeIs('reels.index')">
        <i class="fa-solid fa-clapperboard me-1"></i> Reels
    </x-nav-link>
    <x-nav-link :href="route('products.index')" :active="request()->routeIs('products.index')">
        <i class="fa-solid fa-barcode me-1"></i> Productos
    </x-nav-link>
    <x-nav-link :href="route('promotions.index')" :active="request()->routeIs('promotions.index')">
        <i class="fa-solid fa-money-check-dollar me-1"></i> Promociones
    </x-nav-link>
    <x-nav-link :href="route('projects.index')" :active="request()->routeIs('projects.index')">
        <i class="fa-regular fa-folder-open me-1"></i> Proyectos
    </x-nav-link>
    <x-nav-link :href="route('blog.index')" :active="request()->routeIs('blog.index')">
        <i class="fa-solid fa-rss me-1"></i> Blog
    </x-nav-link>
    <x-nav-link :href="route('contacts.index')" :active="request()->routeIs('contacts.index')">
        <i class="fa-solid fa-envelope-open me-1"></i> Contactos
    </x-nav-link>
    <x-nav-link :href="route('branches.index')" :active="request()->routeIs('branches.index')">
        <i class="fa-solid fa-store me-1"></i> Sucursales
    </x-nav-link>
    <x-nav-link :href="route('index')" target="_blank" data-tooltip="Ir al sitio web">
        <i class="fa-solid fa-earth-americas me-1"></i>
    </x-nav-link>
@endif
