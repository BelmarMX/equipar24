<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard - Equipar Cocinas Industriales</title>

    <!-- Styles -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://cdn.datatables.net">
    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap">
    <link rel="stylesheet" href="https://cdn.datatables.net/v/dt/dt-2.1.8/fc-5.0.3/fh-4.0.1/r-3.0.3/sc-2.4.3/sp-2.3.3/datatables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css">
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css">

    <!-- Modules -->
    @vite(['resources/css/app.css', 'resources/assets/scss/dashboard/app.scss', 'resources/js/app.js'])
    @stack('style')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
        @include('dashboard.layouts.navigation')

        <!-- Page Heading -->
        @isset($header)
            <header class="bg-white dark:bg-gray-800 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>
        @endisset

        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>

        <footer class="mt-5 pe-3 text-right">
            <x-secondary-button
                onclick="history.back()"
            >
                <i class="fa-solid fa-circle-chevron-left me-1"></i> Regresar
            </x-secondary-button>
        </footer>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.8/fc-5.0.3/fh-4.0.1/r-3.0.3/sc-2.4.3/sp-2.3.3/datatables.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script>
        tippy.delegate('html', {
                target:         '[data-tooltip]'
            ,   content:        el => el.dataset.tooltip
            ,   arrow:          true
            ,   allowHtml:      true
            ,   animation:      'scale'
            ,   theme:          'dspx'
        })
    </script>
    @stack('ESmodules')
</body>
</html>
