@section('title',       'Póngase en contacto con nosotros')
@section('description', 'Comuníquese con nosotros para brindarle una mejor atención y cubrir los requerimientos de su empresa.')
@section('image',       asset('images/template/bn-contactanos.jpg'))
@extends('web._layout.master.app')

@section('content')
    <main class="container mt-5 mb-5">

        <div class="row align-items-center mb-5">
            <div class="col-12 mb-5">
                <h1 class="mb-5">Ponte en contacto con nosotros</h1>

                <form class="custom_form mx-auto w-100 px-2 py-4"
                      enctype="multipart/form-data"
                      method="post"
                      action="{{ route('contacto-send') }}"
                      style="max-width: 630px"
                      id="contactForm"
                >
                    {!! csrf_field() !!}
                    @include('web._layout.alerts.alerts')
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="nombre" class="form-label">¿Cuál es tu nombre?</label>
                            <input id="nombre"
                                   name="nombre"
                                   class="form-control"
                                   type="text"
                                   placeholder="Nombre y Apellido"
                                   required
                            >
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="correo" class="form-label">Correo electrónico</label>
                            <input id="correo"
                                   name="correo"
                                   class="form-control"
                                   type="email"
                                   placeholder="mi-email@mi-dominio.com"
                                   required
                            >
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="telefono" class="form-label">Celular (opcional)</label>
                            <input id="telefono"
                                   name="telefono"
                                   class="form-control"
                                   type="number"
                                   min="1000000000"
                                   max="9999999999"
                                   placeholder="Número Celular a 10 digitos"
                            >
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="empresa" class="form-label">Empresa (opcional)</label>
                            <input id="empresa"
                                   name="empresa"
                                   class="form-control"
                                   type="text"
                                   placeholder="Nombre de la empresa"
                            >
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="estado" class="form-label">Estado</label>
                            <select id="estado"
                                    name="estado"
                                    class="form-select"
                                    aria-label="Selecciona un estado"
                            >
                                <option selected>Por favor selecciona un estado</option>
                                @foreach($states AS $state)
                                    <option value="{{ $state -> id }}">{{ $state -> name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <select id="ciudad"
                                    name="ciudad"
                                    class="form-select"
                                    aria-label="Selecciona una ciudad"
                            >
                                <option selected>Por favor selecciona una ciudad</option>
                            </select>
                        </div>

                        <div class="col-md-12 mb-4">
                            <label for="cuerpo" class="form-label">Motivo de contacto</label>
                            <textarea id="cuerpo"
                                      name="cuerpo"
                                      class="form-control"
                                      placeholder="Espacio para tus comentarios, dudas y sugerencias"
                                      rows="5"
                            ></textarea>
                        </div>
                        <div class="col-md-12 mb-4 d-flex justify-content-center">
                            <div class="g-recaptcha" data-sitekey="{{ env('CAPTCHA_PUBLIC') }}"></div>
                        </div>
                        <div class="col-md-12 text-center">
                            <button id="send_form"
                                    class="btn btn-primary"
                                    type="submit"
                            >
                                <i class="bi bi-send-fill"></i> Enviar
                            </button>
                        </div>
                    </div>
                </form>
            </div>

            <div class="col-md-12">
                <div class="col-md-12">
                    <h2>Ubicaciones</h2>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 order-md-2 contact-location">
                        <i class="bi bi-geo-alt-fill"></i> <h3>Guadalajara Matriz</h3>
                        <p class="pt-3">
                            Av. Cvln. Jorge Álvarez del Castillo núm. 1442<br>
                            Col. Lomas del Country<br>
                            Guadalajara, Jalisco. México.<br>
                            <a href="tel:+5213328862661" target="-_blank">
                                +52 1 33 2886 2661
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 order-md-1">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d7464.423907058208!2d-103.36637900000001!3d20.701616!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x8573938c634944dd!2sEqui-par%20Cocinas%20Industriales!5e0!3m2!1ses!2smx!4v1645771932888!5m2!1ses!2smx"
                                width="100%"
                                height="400"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                        >
                        </iframe>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 order-md-2 contact-location">
                        <i class="bi bi-geo-alt-fill"></i> <h3>Sucursal Zapopan</h3>
                        <p class="pt-3">
                            Av. Mariano Otero núm. 3519<br>
                            Col. La Calma<br>
                            Zapopan, Jalisco. México.<br>
                            <a href="tel:+5213335751334" target="-_blank">
                                +52 1 33 3575 1334
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 order-md-1">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d16562.04313701228!2d-103.42620814629664!3d20.637281778034207!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x3c7c1293fe6c83fd!2sEqui-par!5e0!3m2!1ses!2smx!4v1645772008948!5m2!1ses!2smx"
                                width="100%"
                                height="400"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                        >
                        </iframe>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 order-md-2 contact-location">
                        <i class="bi bi-geo-alt-fill"></i> <h3>Sucursal Guadalajara</h3>
                        <p class="pt-3">
                            Av. 16 de septiembre núm. 665<br>
                            Col. Mexicaltzingo<br>
                            Guadalajara, Jalisco. México.<br>
                            <a href="tel:+5213328862661" target="-_blank">
                                +52 1 33 2886 2661
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 order-md-1">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4676.33574189778!2d-103.35068286458595!3d20.665050103700274!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428b300a6ca8bdb%3A0xc9c8ebd1f7c027ca!2sEquipar%20cocinas%20Industriales!5e0!3m2!1ses-419!2smx!4v1651552749341!5m2!1ses-419!2smx"
                                width="100%"
                                height="400"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                        >
                        </iframe>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 order-md-2 contact-location">
                        <i class="bi bi-geo-alt-fill"></i> <h3>Sucursal Guadalajara</h3>
                        <p class="pt-3">
                            Av. Plan de San Luis núm. 1850<br>
                            Col. Lomas del Country<br>
                            Guadalajara, Jalisco. México.<br>
                            <a href="tel:+5213322876603" target="-_blank">
                                +52 1 33 2287 6603
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 order-md-1">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d4084.2490156145327!2d-103.36827142154223!3d20.69742080525417!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8428af5cee6f4d17%3A0xde3443a6033c0b2a!2sEquipar%20cocinas%20industriales!5e0!3m2!1ses!2smx!4v1728539873512!5m2!1ses!2smx"
                                width="100%"
                                height="400"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                        >
                        </iframe>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-6 order-md-2 contact-location">
                        <i class="bi bi-geo-alt-fill"></i> <h3>Sucursal Puerto Vallarta</h3>
                        <p class="pt-3">
                            Plaza El Roble<br>
                            Blvd. Riviera Nayarit Núm. 2. Local 7 y 8<br>
                            Col. Nuevo Vallarta<br>
                            Riviera Nayarit, Nayarit. México.<br>
                            <a href="tel:+5213321128039" target="-_blank">
                                +52 1 329 111 6725
                            </a>
                        </p>
                    </div>
                    <div class="col-md-6 order-md-1">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1660.5055586225783!2d-105.27505461345973!3d20.709479137104474!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842147c84338c56f%3A0x34b397c7230e556d!2sEquipar%20Cocinas%20industriales%20vallarta!5e0!3m2!1ses-419!2smx!4v1677733866626!5m2!1ses-419!2smx"
                                width="100%"
                                height="400"
                                style="border:0;"
                                allowfullscreen=""
                                loading="lazy"
                        >
                        </iframe>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('customCss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush
@push('customJs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/es.min.js" integrity="sha512-xntXNPHoIOoLxuqmYhDB6MA67yimB0HxKb20FTgBcAO7RUk2jwctNYIkencPjG4hdxde8ee6FHqACJqGYYSiSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script>
        document.getElementById('contactForm').addEventListener('submit', () => {
            document.getElementById('load8').removeAttribute('hidden')
        })
    </script>
    @vite(['resources/assets/js/web/contactor.js'])
@endpush
