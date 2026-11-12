<!DOCTYPE html>
<html class="scroll-smooth" lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @php
        $defaultTitle = 'BYT SOLUTION | Contabilidad · Tributación · Auditoría';
        $defaultDescription = 'Contabilidad, tributación, auditoría y facturación electrónica para empresas en Puerto Maldonado y Cusco.';
        $metaTitle = trim($__env->yieldContent('title')) ?: $defaultTitle;
        $metaDescription = trim($__env->yieldContent('meta_description')) ?: $defaultDescription;
        $ogImage = trim($__env->yieldContent('og_image')) ?: asset('images/bytsolution/og-image.png');
        if (! \Illuminate\Support\Str::startsWith($ogImage, ['http://', 'https://'])) {
            $ogImage = asset($ogImage);
        }
        $ogType = trim($__env->yieldContent('og_type')) ?: 'website';
    @endphp
    <meta name="description" content="{{ $metaDescription }}">
    <title>{{ $metaTitle }}</title>
    <meta property="og:site_name" content="BYT SOLUTION">
    <meta property="og:locale" content="es_PE">
    <meta property="og:type" content="{{ $ogType }}">
    <meta property="og:title" content="{{ $metaTitle }}">
    <meta property="og:description" content="{{ $metaDescription }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:image" content="{{ $ogImage }}">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta property="og:image:alt" content="BYT SOLUTION — Contabilidad, tributación y auditoría">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $metaTitle }}">
    <meta name="twitter:description" content="{{ $metaDescription }}">
    <meta name="twitter:image" content="{{ $ogImage }}">
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
