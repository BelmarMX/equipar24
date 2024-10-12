<div id="floating_button">
    <button id="btn__contactanos"
            class="d-flex justify-content-between align-content-center"
            aria-label="Muestra botones de contacto de distinas redes sociales"
    >
        <div>
            <img width="36" height="25" src="{{ asset('images/layout/equipar-icon.svg') }}" alt="Equipar Icono">
        </div>
        <span>
            Contáctanos
        </span>
    </button>

    <div id="btn__contactanos--links" class="black_sheep_wall hide" aria-labelledby="#btn__contactanos">
        <a href="{{ route('contacto') }}"
           class="email"
           data-bs-toggle="tooltip"
           title="Enviar correo electrónico"
        >
            <i class="bi bi-envelope"></i>
        </a>
        <a href="https://api.whatsapp.com/send?phone={{ $Navigation::phone_whats_dial() }}&text=Para%20brindarte%20un%20mejor%20servicio%20por%20favor%20deja%20tus%20datos%20(Nombre,%20Correo%20electr%C3%B3nico,%20%20y%20asunto)"
           class="whatsapp"
           target="_blank"
           data-bs-toggle="tooltip"
           title="Enviar Whatsapp"
        >
            <i class="bi bi-whatsapp"></i>
        </a>
        <a href="{{ env('MESSENGER_LINK') }}"
           class="messenger"
           target="_blank"
           data-bs-toggle="tooltip"
           title="Enviar Messenger"
        >
            <i class="bi bi-messenger"></i>
        </a>
        <a href="{{ env('LOCATION_MATRIZ') }}"
           class="location"
           target="_blank"
           data-bs-toggle="tooltip"
           title="Encuéntranos en Google Maps"
        >
            <i class="bi bi-geo-alt-fill"></i>
        </a>
    </div>
</div>
