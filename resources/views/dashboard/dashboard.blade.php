<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            <i class="fa-solid fa-chart-line me-1"></i> {{ __('Dashboard') }}
        </h2>
        @include('dashboard.dashboard-items.submenu')
    </x-slot>

    <div class="bg-white dark:bg-gray-900">
        <div class="container px-6 py-8 mx-auto">
            <div class="grid grid-cols-1 gap-8 mt-6 xl:mt-12 xl:gap-12 md:grid-cols-2 lg:grid-cols-3">
                <div class="w-full p-8 space-y-8 text-center border border-gray-200 rounded-lg dark:border-gray-700">
                    <p class="font-medium text-gray-500 uppercase dark:text-gray-300">Cotizaciones</p>

                    <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ number_format($stats -> quotations -> month_attended) }} / {{ number_format($stats -> quotations -> month) }}
                        <x-alert-icons
                            :type="$stats -> quotations -> healt"
                            :tooltip="$stats -> quotations -> tooltip"
                        />
                    </h2>
                    <span class="text-1xl font-medium text-gray-800 uppercase dark:text-gray-100">
                        Atendidas en el mes
                    </span>

                    <h2 class="text-4xl font-semibold text-gray-800 uppercase dark:text-gray-100">
                        {{ number_format($stats -> quotations -> total) }}
                    </h2>
                    <span class="text-1xl font-medium text-gray-800 uppercase dark:text-gray-100">
                        Histórico
                    </span>
                    <br>
                    <x-secondary-button>Ver cotizaciones</x-secondary-button>
                </div>
                <div class="w-full p-8 space-y-8 text-center border border-gray-200 rounded-lg dark:border-gray-700">
                    <p class="font-medium text-gray-500 uppercase dark:text-gray-300">Solicitudes de información</p>

                    <h2 class="text-3xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ number_format($stats -> contact_forms -> month_attended) }} / {{ number_format($stats -> contact_forms -> month) }}
                        <x-alert-icons
                            :type="$stats -> contact_forms -> healt"
                            :tooltip="$stats -> contact_forms -> tooltip"
                        />
                    </h2>
                    <span class="text-1xl font-medium text-gray-800 uppercase dark:text-gray-100">
                        Atendidas en el mes
                    </span>

                    <h2 class="text-4xl font-semibold text-gray-800 dark:text-gray-100">
                        {{ number_format($stats -> contact_forms -> total) }}
                    </h2>
                    <span class="text-1xl font-medium text-gray-800 uppercase dark:text-gray-100">
                        Histórico
                    </span>
                    <br>
                    <x-secondary-button>Ver solicitudes</x-secondary-button>
                </div>
                <div class="w-full p-8 space-y-8 text-center border border-gray-200 rounded-lg dark:border-gray-700">
                    <p class="font-medium text-gray-500 uppercase dark:text-gray-300">Contactos</p>

                    <h2 class="text-3xl font-semibold text-gray-800 uppercase dark:text-gray-100">
                        {{ number_format($stats -> contacts -> month) }}
                    </h2>
                    <span class="text-1xl font-medium text-gray-800 uppercase dark:text-gray-100">
                        Nuevos del mes
                    </span>

                    <h2 class="text-4xl font-semibold text-gray-800 uppercase dark:text-gray-100">
                        {{ number_format($stats -> contacts -> total) }}
                    </h2>
                    <span class="text-1xl font-medium text-gray-800 uppercase dark:text-gray-100">
                        Total
                    </span>
                    <br>
                    <x-secondary-button>Ver contactos</x-secondary-button>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 mt-6 xl:mt-12 xl:gap-12 md:grid-cols-2 lg:grid-cols-3">
                <div class="w-full p-8 space-y-8 text-center border border-gray-200 rounded-lg dark:border-gray-700">
                    <p class="font-medium text-gray-500 uppercase dark:text-gray-300">Promociones activas</p>
                    <span class="text-4xl font-semibold text-gray-800 uppercase dark:text-gray-100">
                        {{ $stats -> active_promotions }}
                    </span>
                    <br>
                    <x-secondary-button>Ir a promociones</x-secondary-button>
                </div>
                <div class="w-full p-8 space-y-8 text-center border border-gray-200 rounded-lg dark:border-gray-700">
                    <p class="font-medium text-gray-500 uppercase dark:text-gray-300">Total de productos</p>
                    <span class="text-4xl font-semibold text-gray-800 uppercase dark:text-gray-100">
                        {{ $stats -> products }}
                    </span>
                    <br>
                    <x-secondary-button>Ir a productos</x-secondary-button>
                </div>
                <div class="w-full p-8 space-y-8 text-center border border-gray-200 rounded-lg dark:border-gray-700">
                    <p class="font-medium text-gray-500 uppercase dark:text-gray-300">Última actualización de precios</p>
                    <span class="text-3xl font-semibold text-gray-800 uppercase dark:text-gray-100">
                        {{ $stats -> prices_last_update  }}
                    </span>
                    <br>
                    <br>
                    <span class="text-1xl font-medium text-gray-800 uppercase dark:text-gray-100">Realizado por:</span>
                    <br>
                    <span class="text-1xl font-medium text-gray-800 uppercase dark:text-gray-100">
                        <i class="fa-solid fa-circle-user"></i> {{ Auth::user()->name }}
                    </span>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
