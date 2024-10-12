@include('web._layout.partials.floating-contact-button')

<footer class="container-fluid bg-dark text-white pt-4">
    <div class="row px-4">
        <div class="d-flex col-md-4 text-center align-items-center mb-3">
            <ul class="w-100" style="list-style: none; margin: 0; padding: 0; display: grid; grid-template-columns: repeat(2, 1fr)">
                <li><a style="font-size:16px" href="/">Inicio</a></li>
                <li><a style="font-size:16px" href="{{ route('proyectos') }}">Proyectos</a></li>
                <li><a style="font-size:16px" href="{{ route('productos') }}">Productos</a></li>
                <li><a style="font-size:16px" href="{{ route('servicios') }}">Servicios</a></li>
                <li><a style="font-size:16px" href="{{ route('diseno-acero') }}">Diseño en acero</a></li>
                <li><a style="font-size:16px" href="{{ route('blog') }}">Blog</a></li>
                <li><a style="font-size:16px" href="{{ route('nosotros') }}">Nosotros</a></li>
                <li><a style="font-size:16px" href="{{ route('contacto') }}">Contacto</a></li>
            </ul>
        </div>
        <div class="col-md-4 text-center social-media mb-3">
            <div class="pt-2">
                <span class="d-block mb-2">Síguenos en nuestras redes sociales</span>
                <a href="{{ $Navigation::SOCIAL_FACEBOOK }}" target="_blank"
                   data-bs-toggle="tooltip"
                   title="Danos Like en Facebook"
                >
                    <i class="bi bi-facebook"></i>
                </a>
                <a href="{{ $Navigation::SOCIAL_INSTAGRAM }}" target="_blank"
                   data-bs-toggle="tooltip"
                   title="Síguenos en Instagram"
                >
                    <i class="bi bi-instagram"></i>
                </a>
                <a href="{{ $Navigation::SOCIAL_LINKEDIN }}" target="_blank"
                   data-bs-toggle="tooltip"
                   title="Conectar en LinkedIn"
                >
                    <i class="bi bi-linkedin"></i>
                </a>
            </div>
            <a class="mb-sm-3" href="{{ route('aviso-privacidad') }}">Aviso de privacidad</a>
        </div>
        <div class="col-md-4 contact">
            <span class="d-block mb-3 text-center">Contacto y ventas</span>

            <div class="d-flex align-items-center justify-content-end">
                {{ $Navigation::TEL_LOCAL_SHOW }} <i class="bi bi-telephone transform-flip"></i>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                {{ $Navigation::TEL_WHATS_SHOW }} <i class="bi bi-whatsapp"></i>
            </div>
            <div class="d-flex align-items-center justify-content-end">
                {{ $Navigation::CONTACT_EMAIL }} <i class="bi bi-envelope"></i>
            </div>
        </div>
        <hr class="mt-2 mb-4">
    </div>
    <div class="row px-4">
        <!-- Sucursales -->
        <div class="col-sm-12 col-md location">
            <a href="https://maps.app.goo.gl/SkDp2znznD5FjBPv6" target="_blank"><i class="bi bi-geo-alt-fill"></i> <span>Gdl Matriz</span></a>
            <p class="pt-2">
                Av. Cvln. Jorge Álvarez del Castillo<br>
                Núm. 1442<br>
                Col. Lomas del Country<br>
                Guadalajara, Jalisco. México.
            </p>
        </div>
        <div class="col-sm-12 col-md location">
            <a href="https://maps.app.goo.gl/Wm8peAwcUb3paqtz9" target="_blank"><i class="bi bi-geo-alt-fill"></i> <span>Gdl Showroom</span></a>
            <p class="pt-2">
                Av. 16 de septiembre<br>
                Núm. 665<br>
                Col. Mexicaltzingo<br>
                Guadalajara, Jalisco. México.
            </p>
        </div>
        <div class="col-sm-12 col-md location">
            <a href="https://maps.app.goo.gl/ePQWhR2uwJWKjVhbA" target="_blank"><i class="bi bi-geo-alt-fill"></i> <span>Guadalajara</span></a>
            <p class="pt-2">
                Av. Plan de San Luis<br>
                Núm. 1850<br>
                Col. Lomas del Country<br>
                Guadalajara, Jalisco. México.
            </p>
        </div>
        <div class="col-sm-12 col-md location">
            <a href="https://maps.app.goo.gl/B5UKEZ69yei9teLN8" target="_blank"><i class="bi bi-geo-alt-fill"></i> <span>Zapopan</span></a>
            <p class="pt-2">
                Av. Mariano Otero<br>
                Núm. 3519<br>
                Col. La Calma<br>
                Zapopan, Jalisco. México.
            </p>
        </div>
        <div class="col-sm-12 col-md location">
            <a href="https://maps.app.goo.gl/MfFQ4r7kaUumuUGy8" target="_blank"><i class="bi bi-geo-alt-fill"></i> <span>Puerto Vallarta</span></a>
            <p class="pt-2">
                Plaza El Roble<br>
                Blvd. Riviera Nayarit<br>
                Núm. 2, Local 7 y 8<br>
                Col. Nuevo Vallarta<br>
                Riviera Nayarit, Nayarit. México.<br>
            </p>
        </div>
    </div>
    <div class="row bg-black text-white mt-3">
        <div class="col-md-12 text-md-center p-1">
            <small>&copy;{{ date('Y') }} www.equi-par.com</small>
        </div>
    </div>
</footer>
