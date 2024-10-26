@foreach($Navigation::dashboard_menu() AS $menu)
    @if( isset($menu['dropdown']) && $menu['dropdown'] )
        @if( $Navigation::is_mobile() )
            @foreach($menu['items'] AS $link)
                <x-responsive-nav-link :href="$link['route']" :active="request()->routeIs($link['route_is'])">
                    {!! $menu['link_text'] !!} :: {!! $link['link_text'] !!} {{ !empty($link['tooltip']) ? $link['tooltip'] : '' }}
                </x-responsive-nav-link>
            @endforeach
        @else
        <div class="hidden sm:flex sm:items-center @if(request()->routeIs($menu['route_is'])) border-b-2 border-indigo-700 @endif">
            <x-dropdown align="top" width="48" :is_navbar="true">
                <x-slot name="trigger">
                    <button
                        class="inline-flex items-center px-1 pt-1
                        text-sm leading-4 font-medium rounded-md
                        text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800
                        hover:text-gray-700 dark:hover:text-gray-300
                        focus:outline-none
                        transition ease-in-out duration-150
                        border border-transparent"
                    >
                        <div>{!! $menu['link_text'] !!}</div>

                        <div class="ms-1">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                            </svg>
                        </div>
                    </button>
                </x-slot>
                <x-slot name="content">
                    @foreach($menu['items'] AS $link)
                        <x-dropdown-link :href="$link['route']">{!! $link['link_text'] !!}</x-dropdown-link>
                    @endforeach
                </x-slot>
            </x-dropdown>
        </div>
        @endif
    @else
        @if( $Navigation::is_mobile() )
            <x-responsive-nav-link :href="$menu['route']" :active="request()->routeIs($menu['route_is'])">
                {!! $menu['link_text'] !!} {{ !empty($menu['tooltip']) ? $menu['tooltip'] : '' }}
            </x-responsive-nav-link>
        @else
            <x-nav-link :href="$menu['route']" :active="request()->routeIs($menu['route_is'])" :data-tooltip="!empty($menu['tooltip']) ? $menu['tooltip'] : NULL">
                {!! $menu['link_text'] !!}
            </x-nav-link>
        @endif
    @endif
@endforeach
