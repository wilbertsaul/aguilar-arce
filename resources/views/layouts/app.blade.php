<!DOCTYPE html>
<html class="scroll-smooth" lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aguilar & Arce | Consultoría Estratégica')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-background text-on-surface font-sans antialiased selection:bg-navy selection:text-white">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')
    @include('components.whatsapp-float')

    @stack('scripts')
</body>
</html>
