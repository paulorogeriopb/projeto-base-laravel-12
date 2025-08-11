<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>


    <script src="{{ asset('js/theme-init.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="//unpkg.com/alpinejs" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/bootstrap.js', 'resources/js/app_auth.js', 'resources/js/no-alert.js'])



</head>

<body class="bg-dashboard">
    @include('layouts.navigation') {{-- sua navbar com h-20 fixed top-0 --}}

    <div class="flex">
        @include('components.sidebar')

        <main class="flex-1 p-4">
            @can('dashboard')
                @yield('content')
                @stack('scripts')
            @endcan
        </main>
    </div>

    <footer class="fixed bottom-0 z-50 w-full py-2 pr-4 text-sm text-right text-gray-500">
        Versão: {{ trim(exec('git describe --tags --abbrev=0')) }}
    </footer>


</body>

</html>
