<!DOCTYPE html>
<html class="scroll-smooth" lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Aguilar & Arce | Consultoría Estratégica')</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&family=Playfair+Display:ital,wght@0,700;1,700&display=swap">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-surface text-on-surface font-body-md selection:bg-primary-fixed selection:text-on-primary-fixed">

    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')

    @stack('scripts')
</body>
</html>
