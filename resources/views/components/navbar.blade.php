@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
@endphp
<header id="navbar" class="sticky top-0 z-50 glass-nav transition-all duration-300">
    <div class="max-w-container-max mx-auto px-gutter flex items-center justify-between h-20 lg:h-24 gap-4">
        <a href="{{ route('home') }}" class="flex items-center shrink-0 group" aria-label="BYT SOLUTION — Inicio">
            <picture>
                <source media="(min-width: 400px)" srcset="{{ asset('images/bytsolution/bytsolution-logotipo.png') }}">
                <img
                    src="{{ asset('images/bytsolution/bytsolution-logotipo-compacto.png') }}"
                    alt="BYT SOLUTION"
                    class="h-9 sm:h-11 lg:h-12 w-auto transition-transform duration-300 group-hover:scale-[1.03]"
                >
            </picture>
        </a>

        <nav class="hidden lg:flex items-center gap-7 font-title text-sm font-semibold">
            <a href="{{ route('home') }}" class="text-navy border-b-2 border-teal-accent pb-1 transition-colors">Inicio</a>
            <a href="{{ route('home') }}#servicios" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Servicios</a>
            <a href="{{ route('facturador') }}" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Facturador</a>
            <a href="{{ route('descarga-sunat') }}" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Descargas SUNAT</a>
            <a href="{{ route('home') }}#recursos" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Recursos</a>
            <a href="{{ route('home') }}#contacto" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Contacto</a>
        </nav>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('facturador') }}" class="btn-byt !px-3.5 sm:!px-5 !py-2.5 !text-[12px] sm:!text-[13px]" aria-label="Probar BYTFACT">
                <img src="{{ asset('images/bytfact/bytfact-icono-blanco.png') }}" alt="" aria-hidden="true" class="hidden sm:block h-4 w-4 object-contain">
                <span class="hidden sm:inline">Probar BYTFACT</span>
                <span class="sm:hidden">BYTFACT</span>
            </a>
            <button type="button" class="lg:hidden w-11 h-11 flex items-center justify-center rounded-xl hover:bg-surface-variant transition-colors" onclick="toggleMenu()" aria-label="Abrir menú" aria-expanded="false" id="menu-toggle">
                <span class="material-symbols-outlined text-3xl text-navy">menu</span>
            </button>
        </div>
    </div>

    {{-- Mobile menu --}}
    <div id="mobile-menu" class="hidden lg:hidden bg-white border-t border-outline-variant/60 shadow-xl">
        <nav class="max-w-container-max mx-auto px-gutter py-6 flex flex-col gap-4 font-title font-semibold text-navy">
            <a href="{{ route('home') }}" class="flex items-center justify-between py-1">Inicio <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span></a>
            <a href="{{ route('home') }}#servicios" class="flex items-center justify-between py-1">Servicios <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span></a>
            <a href="{{ route('facturador') }}" class="flex items-center justify-between py-1">Facturador Online <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span></a>
            <a href="{{ route('descarga-sunat') }}" class="flex items-center justify-between py-1">Descargas SUNAT <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span></a>
            <a href="{{ route('home') }}#recursos" class="flex items-center justify-between py-1">Centro de Recursos <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span></a>
            <a href="{{ route('home') }}#contacto" class="flex items-center justify-between py-1">Contacto <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span></a>
            <div class="flex flex-col gap-3 pt-4 border-t border-outline-variant/60">
                <a href="{{ route('facturador') }}" class="btn-byt w-full">
                    <img src="{{ asset('images/bytfact/bytfact-icono-blanco.png') }}" alt="" aria-hidden="true" class="h-4 w-4 object-contain">
                    Probar BYTFACT
                </a>
                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-whatsapp w-full">
                    <span class="material-symbols-outlined text-[18px]">forum</span>
                    WhatsApp Corporativo
                </a>
            </div>
        </nav>
    </div>
</header>
