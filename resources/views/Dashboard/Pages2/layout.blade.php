<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Tailwind CSS & app JS via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Croppie (Image Cropper) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-guillotine@1.0.1/dist/css/jquery.guillotine.min.css">

    {{-- LEAFLET --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.css" />

    {{-- GUILLOTINE --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/jquery-guillotine@1.0.1/dist/js/jquery.guillotine.min.js"></script> --}}
    <!-- in your <head> or before this script -->

    <!-- Leaflet (Modern Version) -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet.draw/1.0.4/leaflet.draw.js"></script>

    <!-- jQuery -->
</head>

<body class="min-h-screen overflow-x-hidden bg-gray-100">
    <x-toast/>
    <!-- Main Layout -->
    <div class="flex flex-col sm:flex-row min-h-screen">
        <x-sidebar />
        <main class="flex-1 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://js.pusher.com/7.2/pusher.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/laravel-echo/1.11.3/echo.iife.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>

    @stack('scripts')
</body>
</html>
