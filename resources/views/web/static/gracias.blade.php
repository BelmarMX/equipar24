@section('title',       '¡Gracias por contactarnos!')
@section('description', 'Hemos recibido con éxito tu información, en breve un miembro de nuestro equipo se pondrá en contacto contigo.')
@section('image',       asset('images/template/bn-aviso-privacidad.jpg'))
@extends('web._layout.master.app')

@section('content')
    <main class="container p-5">
        <div class="alert alert-success p-4" role="alert">
            <div class="p-3" style="background: rgba(255,255,255,.95); border-radius: 5px;">
                <div class="row">
                    <div class="col-12">
                        <h1 class="alert-heading fs-2 mb-3">@yield('title')</h1>
                        <p>@yield('description')</p>
                        <img width="150" height="50" src="{{ asset('images/layout/equipar-minimal-id.svg') }}" alt="Equi-par ID" class="img-fluid">
                        <hr>
                    </div>
                    <div class="col-md-6 text-end text-dark">
                        <strong>Horarios</strong><br>
                        Lunes a Viernes: 08:00 - 18:00 h<br>
                        Sábados: 09:00 - 14:00 h
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="contact-links">
                            <a href="tel:{{ $Navigation::phone_local_dial() }}"
                               data-bs-toggle="tooltip"
                               title="Llamanos"
                               target="_blank"
                            >
                                <i class="zoom-2 bi bi-telephone"></i> {{ $Navigation::TEL_LOCAL_SHOW }}
                            </a>
                            <br>
                            <a href="https://api.whatsapp.com/send?phone={{ $Navigation::phone_whats_dial() }}&text=Para%20brindarte%20un%20mejor%20servicio%20por%20favor%20deja%20tus%20datos%20(Nombre,%20Correo%20electr%C3%B3nico,%20%20y%20asunto)"
                               class="whatsapp"
                               data-bs-toggle="tooltip"
                               title="Escríbenos un Whats"
                               target="_blank"
                            >
                                <i class="zoom-2 bi bi-whatsapp"></i> {{ $Navigation::TEL_WHATS_SHOW }}
                            </a>
                            <br>
                            <a href="mailto:{{ $Navigation::CONTACT_EMAIL }}"
                               data-bs-toggle="tooltip"
                               title="Envíanos un correo electrónico"
                               target="_blank"
                            >
                                <i class="zoom-2 bi bi-envelope"></i> {{ $Navigation::CONTACT_EMAIL }}
                            </a>
                        </div>
                    </div>
                    <div class="col-md-12 text-center">
                        <a href="{{ $Navigation::LOCATION_MATRIZ }}" target="_blank" data-bs-toggle="tooltip" title="Encuéntranos en Google Maps">
                            <i class="zoom-2 bi bi-geo-alt-fill"></i>
                        </a>
                        <a href="{{ $Navigation::SOCIAL_FACEBOOK }}" target="_blank" data-bs-toggle="tooltip" title="Visita nuestra página de Facebook">
                            <i class="zoom-2 bi bi-facebook"></i>
                        </a>
                        <a href="{{ $Navigation::SOCIAL_INSTAGRAM }}" target="_blank" data-bs-toggle="tooltip" title="Síguenos en Instagram">
                            <i class="zoom-2 bi bi-instagram"></i>
                        </a>
                        <a href="{{ $Navigation::SOCIAL_LINKEDIN }}" target="_blank" data-bs-toggle="tooltip" title="Conéctate en LinkedIn">
                            <i class="zoom-2 bi bi-linkedin"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
@push('customCss')
    <style>
        .zoom-2{
            font-size: 22px;
            margin-right: .5rem;
        }
    </style>
@endpush
@push('customJs')
    <script>
        if( localStorage.getItem('isFromQuota') && localStorage.getItem('isFromQuota') === 'true' )
        {
            localStorage.removeItem('products')
            localStorage.removeItem('isFromQuota')
        }
    </script>
    @vite(['resources/assets/js/web/contactor.js'])
@endpush
