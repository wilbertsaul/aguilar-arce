@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
@endphp
<header id="navbar" class="sticky top-0 z-50 glass-nav transition-all duration-300">
    <div class="max-w-container-max mx-auto px-gutter flex items-center justify-between h-20 lg:h-24 gap-4">
        <a href="{{ route('home') }}" class="flex items-center gap-3 group shrink-0">
            <div class="nav-logo w-14 h-14 rounded-xl bg-white flex items-center justify-center border border-outline-variant/50 shadow-sm overflow-hidden shrink-0 transition-transform duration-300 group-hover:scale-105">
                <img src="{{ asset('images/AA Consultores.png') }}" alt="Aguilar & Arce Consultores" class="w-full h-full object-contain p-1">
            </div>
            <div class="hidden sm:flex flex-col leading-tight">
                <span class="font-title font-bold text-[15px] md:text-[17px] text-navy">AGUILAR &amp; ARCE <span class="font-medium text-navy-light">CONSULTORES</span></span>
                <span class="text-[10px] tracking-[0.18em] text-on-surface-variant font-semibold uppercase mt-0.5">Contabilidad · Tributación · Auditoría</span>
            </div>
        </a>

        <nav class="hidden lg:flex items-center gap-7 font-title text-sm font-semibold">
            <a href="{{ route('home') }}" class="text-navy border-b-2 border-teal-accent pb-1 transition-colors">Inicio</a>
            <a href="{{ route('home') }}#servicios" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Servicios</a>
            <a href="{{ route('facturador') }}" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Facturador</a>
            <a href="{{ route('home') }}#recursos" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Recursos</a>
            <a href="{{ route('home') }}#contacto" class="text-on-surface-variant hover:text-navy transition-colors pb-1">Contacto</a>
        </nav>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('facturador') }}" class="btn-teal !px-4 sm:!px-5 !py-2.5 !text-[12px] sm:!text-[13px]">
                <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                <span class="hidden sm:inline">Simulador GRATIS</span>
                <span class="sm:hidden">Facturador</span>
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
            <a href="{{ route('home') }}#recursos" class="flex items-center justify-between py-1">Centro de Recursos <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span></a>
            <a href="{{ route('home') }}#contacto" class="flex items-center justify-between py-1">Contacto <span class="material-symbols-outlined text-on-surface-variant">chevron_right</span></a>
            <div class="flex flex-col gap-3 pt-4 border-t border-outline-variant/60">
                <a href="{{ route('facturador') }}" class="btn-teal w-full">Probar Simulador de Facturación</a>
                <a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="btn-whatsapp w-full">
                    <span class="material-symbols-outlined text-[18px]">forum</span>
                    WhatsApp Corporativo
                </a>
            </div>
        </nav>
    </div>
</header>
