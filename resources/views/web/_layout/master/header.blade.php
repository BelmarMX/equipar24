<header class="sticky-top">
    <div id="pleca" class="d-flex w-100 align-items-center justify-content-end">
        <div class="contact-links">
            <a href="tel:{{ $Navigation::phone_local_dial() }}"
               data-bs-toggle="tooltip"
               title="Llamanos"
               target="_blank"
            >
                <i class="bi bi-telephone"></i> {{ $Navigation::TEL_LOCAL_SHOW }}
            </a>
            <a href="https://api.whatsapp.com/send?phone={{ $Navigation::phone_whats_dial() }}&text=Para%20brindarte%20un%20mejor%20servicio%20por%20favor%20deja%20tus%20datos%20(Nombre,%20Correo%20electr%C3%B3nico,%20%20y%20asunto)"
               class="whatsapp"
               data-bs-toggle="tooltip"
               title="Escríbenos un Whats"
               target="_blank"
            >
                <i class="bi bi-whatsapp"></i> {{ $Navigation::TEL_WHATS_SHOW }}
            </a>
            <a href="mailto:{{ $Navigation::CONTACT_EMAIL }}"
               data-bs-toggle="tooltip"
               title="Envíanos un correo electrónico"
               target="_blank"
            >
                <i class="bi bi-envelope"></i> {{ $Navigation::CONTACT_EMAIL }}
            </a>
        </div>
        <div class="red-transform">
            <a href="{{ $Navigation::LOCATION_MATRIZ }}" target="_blank" data-bs-toggle="tooltip" title="Encuéntranos en Google Maps">
                <i class="bi bi-geo-alt-fill"></i>
            </a>
            <a href="{{ $Navigation::SOCIAL_FACEBOOK }}" target="_blank" data-bs-toggle="tooltip" title="Visita nuestra página de Facebook">
                <i class="bi bi-facebook"></i>
            </a>
            <a href="{{ $Navigation::SOCIAL_INSTAGRAM }}" target="_blank" data-bs-toggle="tooltip" title="Síguenos en Instagram">
                <i class="bi bi-instagram"></i>
            </a>
            <a href="{{ $Navigation::SOCIAL_LINKEDIN }}" target="_blank" data-bs-toggle="tooltip" title="Conéctate en LinkedIn">
                <i class="bi bi-linkedin"></i>
            </a>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand p-0" href="/">
                <img width="150"
                     height="50"
                     src="{{ asset('images/layout/equipar-minimal-id.svg') }}"
                     alt="Equi-par ID"
                     class="img-fluid"
                >
            </a>
            <button class="navbar-toggler"
                    type="button"
                    data-bs-toggle="collapse"
                    data-bs-target="#main_menu"
                    aria-controls="main_menu"
                    aria-expanded="false"
                    aria-label="Toggle navigation"
            >
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-center" id="main_menu">
                <ul class="navbar-nav navbar-nav-scroll" style="--bs-scroll-height: 350px;">
                    <li class="nav-item">
                        <a class="nav-link nav-link--home @if( Request::is('/') ) active @endif" aria-current="page" href="/">
                            <i class="bi bi-house-door-fill"></i>
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if( Request::is('proyectos') || Request::is('portafolio') || Request::is('portafolio/*') ) active @endif"
                           href="#"
                           id="proyectos__dropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"
                        >
                            Proyectos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="proyectos__dropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('proyectos') }}">Desarrollo de proyectos</a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="{{ route('portafolio') }}">Portafolio</a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle @if( Request::is('productos') || Request::is('productos/*') ) active @endif"
                           href="{{ route('productos') }}"
                           id="productos__dropdown"
                           role="button"
                           data-bs-toggle="dropdown"
                           aria-expanded="false"
                        >
                            Productos
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="productos__dropdown">
                            <li>
                                <a class="dropdown-item" href="{{ route('productos') }}">Todas las categorías</a>
                            </li>
                            @foreach($menu_cat AS $menu_item)
                                <li>
                                    <a class="dropdown-item" href="{{ route('productos-categories', $menu_item -> slug) }}">{{ ucfirst(strtolower($menu_item -> title)) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if( Request::is('unox') || Request::is('unox/*') ) active @endif" href="{{ route('unox') }}">Unox&reg;</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if( Request::is('servicios') ) active @endif" href="{{ route('servicios') }}">Servicios</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if( Request::is('fabricacion-muebles-acero-inoxidable') ) active @endif" href="{{ route('diseno-acero') }}">Diseño en acero</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if( Request::is('blog') || Request::is('blog/*') ) active @endif" href="{{ route('blog') }}">Blog</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if( Request::is('nosotros') ) active @endif" href="{{ route('nosotros') }}">Acerca de</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link @if( Request::is('contacto') || Request::is('cotizar') ) active @endif" href="{{ route('contacto') }}">Contacto</a>
                    </li>
                </ul>
            </div>

            <div id="search-room">
                <a href="https://api.whatsapp.com/send?phone={{ $Navigation::phone_whats_dial() }}&text=Para%20brindarte%20un%20mejor%20servicio%20por%20favor%20deja%20tus%20datos%20(Nombre,%20Correo%20electr%C3%B3nico,%20%20y%20asunto)"
                   class="whatsapp"
                   data-bs-toggle="tooltip"
                   title="Escríbenos un Whats"
                   target="_blank"
                >
                    <i class="bi bi-whatsapp"></i>
                </a>
                <a id="link_quotation"
                   class="position-relative empty"
                   data-bs-toggle="tooltip"
                   title="Solicitar cotización"
                   href="{{ route('cotizar') }}"
                >
                    <i id="empty_cart" class="bi bi-basket3"></i>
                    <i id="not_empty_car" class="bi bi-basket3-fill"></i>
                    <span class="position-absolute top-100 start-100 translate-middle p-1 bg-success border border-light rounded-circle">
                        <span class="visually-hidden">Items en el cotizador</span>
                    </span>
                </a>
            </div>
        </div>
    </nav>
    <div id="search-box" class="bg-light pb-1 px-1">
        <small class="text-center align-self-center" id="eslogan">¡Aseguramos la eficiencia de tu cocina!</small>
        <form id="search-form" action="{{ route('search') }}" method="post" @isset( $promos ) @endif>
            @csrf
            <input id="autocomplete"
                   type="search"
                   name="search"
                   placeholder="Busca por producto, categoría, subcategoría o marca"
            >
            <button id="do-search" type="submit" aria-label="Muestra la barra de búsqueda">
                <span class="d-none d-md-block">Buscar</span>
                <i class="d-block d-md-none bi bi-search"></i>
            </button>
        </form>
        @include('web._layout.partials.button-discounts', ['promos' => $promos])
    </div>
</header>

<div id="load8">
    <div class="text-center">
        <img class="load8" src="{{ asset('images/layout/loader.svg')  }}" alt="Loading..."><br>
        <small>Cargando<span class="grow-text">...</span></small>
    </div>
</div>
