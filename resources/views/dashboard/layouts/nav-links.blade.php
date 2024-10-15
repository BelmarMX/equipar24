@if( $Navigation::is_mobile() )
    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <i class="fa-solid fa-chart-line me-1"></i> {{ __('Dashboard') }}
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('dashboard.banner.index')" :active="request()->routeIs('dashboard.banner.index')">
        <i class="fa-solid fa-images me-1"></i> Banner
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('dashboard.reels.index')" :active="request()->routeIs('dashboard.reels.index')">
        <i class="fa-solid fa-clapperboard me-1"></i> Reels
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('dashboard.products.index')" :active="request()->routeIs('dashboard.products.index')">
        <i class="fa-solid fa-barcode me-1"></i> Productos
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('dashboard.promotions.index')" :active="request()->routeIs('dashboard.promotions.index')">
        <i class="fa-solid fa-money-check-dollar me-1"></i> Promociones
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('dashboard.projects.index')" :active="request()->routeIs('dashboard.projects.index')">
        <i class="fa-regular fa-folder-open me-1"></i> Proyectos
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('dashboard.blog.index')" :active="request()->routeIs('dashboard.blog.index')">
        <i class="fa-solid fa-rss me-1"></i> Blog
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('dashboard.contacts.index')" :active="request()->routeIs('dashboard.contacts.index')">
        <i class="fa-solid fa-envelope-open me-1"></i> Contactos
    </x-responsive-nav-link>
    <x-responsive-nav-link :href="route('index')" target="_blank">
        <i class="fa-solid fa-earth-americas"></i> Sitio
    </x-responsive-nav-link>
@else
    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
        <i class="fa-solid fa-chart-line me-1"></i> {{ __('Dashboard') }}
    </x-nav-link>
    <x-nav-link :href="route('dashboard.banner.index')" :active="request()->routeIs('dashboard.banner.index')">
        <i class="fa-solid fa-images me-1"></i> Banner
    </x-nav-link>
    <x-nav-link :href="route('dashboard.reels.index')" :active="request()->routeIs('dashboard.reels.index')">
        <i class="fa-solid fa-clapperboard me-1"></i> Reels
    </x-nav-link>
    <x-nav-link :href="route('dashboard.products.index')" :active="request()->routeIs('dashboard.products.index')">
        <i class="fa-solid fa-barcode me-1"></i> Productos
    </x-nav-link>
    <x-nav-link :href="route('dashboard.promotions.index')" :active="request()->routeIs('dashboard.promotions.index')">
        <i class="fa-solid fa-money-check-dollar me-1"></i> Promociones
    </x-nav-link>
    <x-nav-link :href="route('dashboard.projects.index')" :active="request()->routeIs('dashboard.projects.index')">
        <i class="fa-regular fa-folder-open me-1"></i> Proyectos
    </x-nav-link>
    <x-nav-link :href="route('dashboard.blog.index')" :active="request()->routeIs('dashboard.blog.index')">
        <i class="fa-solid fa-rss me-1"></i> Blog
    </x-nav-link>
    <x-nav-link :href="route('dashboard.contacts.index')" :active="request()->routeIs('dashboard.contacts.index')">
        <i class="fa-solid fa-envelope-open me-1"></i> Contactos
    </x-nav-link>
    <x-nav-link :href="route('index')" target="_blank">
        <i class="fa-solid fa-earth-americas me-1"></i> Sitio
    </x-nav-link>
    <x-nav-link :href="route('index')">
        <i class="fa-regular fa-bell"></i>
    </x-nav-link>
@endif

{{--<div x-data="{ isOpen: true }" class="relative inline-block">
    <!-- Dropdown toggle button -->
    <button @click="isOpen = !isOpen" class="relative z-10 block p-2 text-gray-700 bg-white border border-transparent rounded-md dark:text-white focus:border-blue-500 focus:ring-opacity-40 dark:focus:ring-opacity-40 focus:ring-blue-300 dark:focus:ring-blue-400 focus:ring dark:bg-gray-800 focus:outline-none">
        <svg class="w-5 h-5 text-gray-800 dark:text-white" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M12 22C10.8954 22 10 21.1046 10 20H14C14 21.1046 13.1046 22 12 22ZM20 19H4V17L6 16V10.5C6 7.038 7.421 4.793 10 4.18V2H13C12.3479 2.86394 11.9967 3.91762 12 5C12 5.25138 12.0187 5.50241 12.056 5.751H12C10.7799 5.67197 9.60301 6.21765 8.875 7.2C8.25255 8.18456 7.94714 9.33638 8 10.5V17H16V10.5C16 10.289 15.993 10.086 15.979 9.9C16.6405 10.0366 17.3226 10.039 17.985 9.907C17.996 10.118 18 10.319 18 10.507V16L20 17V19ZM17 8C16.3958 8.00073 15.8055 7.81839 15.307 7.477C14.1288 6.67158 13.6811 5.14761 14.2365 3.8329C14.7919 2.5182 16.1966 1.77678 17.5954 2.06004C18.9942 2.34329 19.9998 3.5728 20 5C20 6.65685 18.6569 8 17 8Z" fill="currentColor"></path>
        </svg>
    </button>

    <!-- Dropdown menu -->
    <div x-show="isOpen"
         @click.away="isOpen = false"
         x-transition:enter="transition ease-out duration-100"
         x-transition:enter-start="opacity-0 scale-90"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-100"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-90"
         class="absolute right-0 z-20 w-64 mt-2 overflow-hidden origin-top-right bg-white rounded-md shadow-lg sm:w-80 dark:bg-gray-800"
    >
        <div class="py-2">
            <a href="#" class="flex items-center px-4 py-3 -mx-2 transition-colors duration-300 transform border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-700">
                <img class="flex-shrink-0 object-cover w-8 h-8 mx-1 rounded-full" src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" alt="avatar" />
                <p class="mx-2 text-sm text-gray-600 dark:text-white"><span class="font-bold" href="#">Sara Salah</span> replied on the <span class="text-blue-500 hover:underline" href="#">Upload Image</span> artical . 2m</p>
            </a>
            <a href="#" class="flex items-center px-4 py-3 -mx-2 transition-colors duration-300 transform border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-700">
                <img class="flex-shrink-0 object-cover w-8 h-8 mx-1 rounded-full" src="https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=634&q=80" alt="avatar" />
                <p class="mx-2 text-sm text-gray-600 dark:text-white"><span class="font-bold" href="#">Slick Net</span> start following you . 45m</p>
            </a>
            <a href="#" class="flex items-center px-4 py-3 -mx-2 transition-colors duration-300 transform border-b border-gray-100 hover:bg-gray-50 dark:hover:bg-gray-700 dark:border-gray-700">
                <img class="flex-shrink-0 object-cover w-8 h-8 mx-1 rounded-full" src="https://images.unsplash.com/photo-1450297350677-623de575f31c?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=334&q=80" alt="avatar" />
                <p class="mx-2 text-sm text-gray-600 dark:text-white"><span class="font-bold" href="#">Jane Doe</span> Like Your reply on <span class="text-blue-500 hover:underline" href="#">Test with TDD</span> artical . 1h</p>
            </a>
            <a href="#" class="flex items-center px-4 py-3 -mx-2 transition-colors duration-300 transform hover:bg-gray-100 dark:hover:bg-gray-700">
                <img class="flex-shrink-0 object-cover w-8 h-8 mx-1 rounded-full" src="https://images.unsplash.com/photo-1580489944761-15a19d654956?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=crop&w=398&q=80" alt="avatar" />
                <p class="mx-2 text-sm text-gray-600 dark:text-white"><span class="font-bold" href="#">Abigail Bennett</span> start following you . 3h</p>
            </a>
        </div>
        <a href="#" class="block py-2 font-bold text-center text-white bg-gray-800 dark:bg-gray-700 hover:underline">See all notifications</a>
    </div>
</div>--}}
