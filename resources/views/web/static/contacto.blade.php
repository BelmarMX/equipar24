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
                @foreach($branches AS $branch)
                    <div class="col-md-6 contact-location mb-3">
                        <div class="row g-1">
                            <div class="col-md-7">
                                <iframe src="{{ $branch -> embed_code }}"
                                        width="100%"
                                        height="300"
                                        style="border:0; border-radius: 15px"
                                        allowfullscreen=""
                                        loading="lazy"
                                >
                                </iframe>
                            </div>
                            <div class="col-md-5">
                                <i class="bi bi-geo-alt-fill"></i> <h3>{{ $branch -> title }}</h3>
                                <p class="pt-3">
                                    @if( !empty($branch->building) )
                                        {{$branch->building}}<br>
                                    @endif
                                    {{ $branch -> street }} núm. {{ $branch -> number }}<br>
                                    Col. {{ $branch -> neighborhood }}<br>
                                    {{ $branch -> city -> name }}, {{ $branch -> state -> name }}. México.<br>
                                    <a href="tel:{!! $Navigation::mex_phone_number($branch -> phone) -> dial !!}" target="-_blank">
                                        {!! $Navigation::mex_phone_number($branch -> phone) -> display !!}
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                @endforeach
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
