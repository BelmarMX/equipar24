<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-mode="{{ Auth::user() -> dark_mode ? 'dark' : 'light'  }}">
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://unpkg.com/tippy.js@6/animations/scale.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <link rel="stylesheet" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <!-- Modules -->
    @vite(['resources/css/app.css', 'resources/assets/scss/dashboard/app.scss', 'resources/js/app.js'])
    @stack('style')
</head>
<body class="font-sans antialiased">
    @include('dashboard.layouts.loader')
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

        @if( env('APP_ENV') == 'local' && env('APP_SHOW_BOTTOM_FORM_ERRORS') )
            <div class="bg-white p-3 mt-3">
                <h3 class="text-red-500 font-bold">ERROR DEBUGGER</h3>
                @if($errors -> any() )
                    <pre class="text-sm">
                        {!! print_r($errors -> all()) !!}
                    </pre>
                @endif
            </div>
        @endif

        <footer class="mt-5 pe-3 text-right">
            @if( !\Illuminate\Support\Str::contains( request() -> path(), ['create', 'edit'] ) )
                <x-secondary-button
                    onclick="history.back()"
                >
                    <i class="fa-solid fa-circle-chevron-left me-1"></i> Regresar
                </x-secondary-button>
            @endif
        </footer>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/v/dt/dt-2.1.8/fc-5.0.3/fh-4.0.1/r-3.0.3/sc-2.4.3/sp-2.3.3/datatables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/dataTables.buttons.js"></script>
    <script src="https://cdn.datatables.net/buttons/3.1.2/js/buttons.dataTables.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" integrity="sha512-2ImtlRlf2VVmiGZsjm9bEyhjGW4dU7B6TNwh/hx/iSByxNENtj3WVE6o/9Lj4TJeVXPi4bnOIMXFIJJAeufa0A==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/i18n/es.min.js" integrity="sha512-xntXNPHoIOoLxuqmYhDB6MA67yimB0HxKb20FTgBcAO7RUk2jwctNYIkencPjG4hdxde8ee6FHqACJqGYYSiSg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="https://unpkg.com/tippy.js@6"></script>
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
    <script>
        tippy.delegate('html', {
                target:         '[data-tooltip]'
            ,   arrow:          true
            ,   allowHTML:      true
            ,   animation:      'scale'
            ,   theme:          'dspx'
            ,   content:        el => el.dataset.tooltip
        })
    </script>
    @vite(['resources/assets/js/dashboard/behavior.js', 'resources/assets/scss/dashboard/swal.scss'])
    @stack('ESmodules')
</body>
</html>
