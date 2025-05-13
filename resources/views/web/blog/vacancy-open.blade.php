@section('title',           $vacancy->title)
@section('description',     $vacancy->summary)
@section('image',           $vacancy->asset_url.$vacancy->image_rx)
@extends('web._layout.master.app')

@section('content')
    <main class="container mt-5">
        <div class="row gx-5">
            <section class="blog__article col-md-8">
                <img width="{{ $ImagesSettings::VACANCY_WIDTH }}"
                     height="{{ $ImagesSettings::VACANCY_HEIGHT }}"
                     class="img-fluid"
                     src="{{ $vacancy->asset_url.$vacancy->image }}"
                     alt="{{ $vacancy->title }}"
                >
                <div class="blog__article__tags p-2 mb-4">
                    <div class="d-inline">
                        <i class="bi bi-clock"></i> {{ $Navigation::split_date($vacancy->starts_at)->large }}
                    </div>
                </div>

                <h1 class="blog__article__title">{{ $vacancy->title }}</h1>

                <div class="blog__article__content">
                    {!! $vacancy -> content !!}
                </div>
            </section>

            <aside class="col-md-4">
                <div class="mb-5">
                    <h2 class="mb-1">Postula para este puesto</h2>

                    <form class="custom_form mx-auto w-100 px-2 py-4"
                          enctype="multipart/form-data"
                          method="POST"
                          action="{{ route('vacante.send', [$vacancy->slug]) }}"
                          style="max-width: 630px"
                          id="vacancyForm"
                    >
                        {!! csrf_field() !!}
                        <input id="vacancy_id" name="vacancy_id" type="hidden" value="{{ $vacancy->id }}">
                        <x-honeypot />
                        @include('web._layout.alerts.alerts')
                        <div class="row">
                            <div class="col-md-12 mb-4">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <input id="email"
                                       name="email"
                                       class="form-control"
                                       type="email"
                                       placeholder="mi-email@mi-dominio.com"
                                       required
                                >
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="name" class="form-label">¿Cuál es tu nombre?</label>
                                <input id="name"
                                       name="name"
                                       class="form-control"
                                       type="text"
                                       placeholder="Nombre y Apellido"
                                       required
                                >
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="phone" class="form-label">Celular</label>
                                <input id="phone"
                                       name="phone"
                                       class="form-control"
                                       type="number"
                                       min="1000000000"
                                       max="9999999999"
                                       placeholder="Número Celular a 10 digitos"
                                >
                            </div>
                            <div class="col-md-12 mb-4">
                                <label for="file" class="form-label">Currículum (PDF, DOC, DOCX)</label>
                                <input id="file"
                                       name="file"
                                       class="form-control"
                                       type="file"
                                       accept="application/pdf, .doc, .docx"
                                       placeholder="Adjunta tu currículum"
                                >
                            </div>
                            <div class="col-md-12 mb-4 d-flex justify-content-center">
                                <div class="cf-turnstile" data-sitekey="{{ env('TURNSTILE_SITEKEY') }}" data-theme="light"></div>
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
                @foreach($latest AS $blog)
                    <div class="mb-5">
                        @include('web.blog.partials.blog-view', [
                                'title'             => $blog->title
                            ,   'link'              => route('vacante-open', [$blog->slug])
                            ,   'image'             => $blog->asset_url.$blog->image_rx
                            ,   'day'               => $Navigation::split_date($blog->stats_at) -> day
                            ,   'month'             => $Navigation::split_date($blog->ends_at) -> short_month
                            ,   'category_title'    => 'Abiertas'
                            ,   'category_link'     => NULL
                            ,   'summary'           => $blog->summary
                        ])
                    </div>
                @endforeach
            </aside>
        </div>
    </main>
@endsection

@push('customJs')
    <script src="https://challenges.cloudflare.com/turnstile/v0/api.js" defer></script>
    <script>
        document.getElementById('vacancyForm').addEventListener('submit', () => {
            document.getElementById('load8').removeAttribute('hidden')
        })
    </script>
@endpush
