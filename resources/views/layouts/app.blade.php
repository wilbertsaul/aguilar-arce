<!DOCTYPE html>
<html class="scroll-smooth" lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="BYT SOLUTION — Contabilidad, tributación, auditoría y facturación electrónica en Puerto Maldonado y Cusco.">
    <title>@yield('title', 'BYT SOLUTION | Contabilidad · Tributación · Auditoría')</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" sizes="any">
    <link rel="icon" type="image/png" href="{{ asset('images/bytsolution/bytsolution-favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/bytsolution/bytsolution-touch-icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('styles')
</head>
<body class="bg-background text-on-surface font-sans antialiased selection:bg-teal-accent selection:text-navy-dark">

    @include('components.top-bar')
    @include('components.navbar')

    <main>
        @yield('content')
    </main>

    @include('components.footer')
    @include('components.whatsapp-float')

    @stack('scripts')
</body>
</html>
