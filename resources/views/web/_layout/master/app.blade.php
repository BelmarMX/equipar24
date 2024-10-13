<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app() -> getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        {{-- Seo Tags  --}}
        <title>@yield('title') - Equi-par</title>
        <meta name="description" content="@yield('descripcion')">
        <meta name="author" content="Equi-par">
        {{-- Open Graphs  --}}
        <meta property="og:url" content="{{ url() -> current() }}">
        <meta property="type" content="website">
        <meta property="og:site_name" content="Equi-par">
        <meta property="og:title" content="@yield('title')">
        <meta property="og:description" content="@yield('description')">
        <meta property="og:image" content="@yield('image')">
        {{-- Favicons  --}}
        <link rel="apple-touch-icon-precomposed" sizes="144x144" href="{{ asset('images/ico/apple-touch-icon-144-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="{{ asset('images/ico/apple-touch-icon-114-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="{{ asset('images/ico/apple-touch-icon-72-precomposed.png') }}">
        <link rel="apple-touch-icon-precomposed" href="{{ asset('images/ico/apple-touch-icon-57-precomposed.png') }}">
        <link rel="shortcut icon" href="{{ asset('images/ico/favicon.png') }}">
        {{-- Polyfill --}}
        <script src="{{ asset('js/observer.js') }}"></script>
        <script>IntersectionObserver.prototype.POLL_INTERVAL = 100;</script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;300;400;500;600&display=swap">
        @vite(['resources/assets/scss/web/app.scss'])
        @stack('customCss')
    </head>
    <body>
        @include('web._layout.master.header')

        @yield('content')

        @include('web._layout.master.footer')

        <!-- Scripts -->
        @if( env('APP_ENV') != 'local' )
            @include('web._layout.master.gtag')
        @endif

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
        @vite(['resources/assets/js/web/app.js', 'resources/assets/js/web/search.js', 'resources/assets/js/web/quotator.js'])
        @stack('customJs')
        @vite(['resources/assets/scss/web/swal2.scss'])
    </body>
</html>
