@foreach($Navigation::dashboard_menu() AS $menu)
    @if( $Navigation::is_mobile() )
        <x-responsive-nav-link :href="$menu['route']" :active="request()->routeIs($menu['route_is'])">
            {!! $menu['link_text'] !!} {{ !empty($menu['tooltip']) ? $menu['tooltip'] : '' }}
        </x-responsive-nav-link>
    @else
        <x-nav-link :href="$menu['route']" :active="request()->routeIs($menu['route_is'])" :data-tooltip="!empty($menu['tooltip']) ? $menu['tooltip'] : NULL">
            {!! $menu['link_text'] !!}
        </x-nav-link>
    @endif
@endforeach
