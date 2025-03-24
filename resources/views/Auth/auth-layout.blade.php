<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Default Title')</title>

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">


    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>
<body>

    <!-- Main Content Section -->
    <div class="container">
        @yield('content')
    </div>

</body>
</html>
