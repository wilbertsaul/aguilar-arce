<style>
    @media (max-width: 767px) {
        #navbar img {
            width: 7.031rem !important;
            height: 7.031rem !important;
            max-width: 7.031rem !important;
            max-height: 7.031rem !important;
        }
    }
</style>
<nav class="fixed top-0 w-full z-50 glass-nav transition-all duration-300" id="navbar">
    <div class="max-w-container-max mx-auto px-gutter flex items-center justify-between h-20 md:h-24">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/AA Consultores.png') }}" alt="Aguilar & Arce" class="w-40 h-40 object-contain">
        </a>
        <div class="hidden md:flex items-center gap-8">
            <a href="{{ route('home') }}#servicios" class="text-sm font-medium text-navy/70 hover:text-navy transition-colors">Servicios</a>
            <a href="{{ route('home') }}#nosotros" class="text-sm font-medium text-navy/70 hover:text-navy transition-colors">Nosotros</a>
            <a href="{{ route('home') }}#transformacion-digital" class="text-sm font-medium text-navy/70 hover:text-navy transition-colors">Transformación Digital</a>
            <a href="{{ route('home') }}#blog" class="text-sm font-medium text-navy/70 hover:text-navy transition-colors">Blog</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="{{ route('consultoria.show') }}" class="hidden md:inline-flex bg-navy text-white px-6 py-2.5 rounded-full text-sm font-semibold hover:bg-navy-light transition-all duration-300">Solicitar Asesoría</a>
            <button class="md:hidden p-2 text-navy" onclick="toggleMenu()" aria-label="Menú">
                <span class="material-symbols-outlined text-2xl">menu</span>
            </button>
        </div>
    </div>
    <div id="mobile-menu" class="hidden md:hidden bg-white border-t border-grey-light/50 px-gutter py-6">
        <div class="flex flex-col gap-4">
            <a href="{{ route('home') }}#servicios" class="text-navy font-medium py-2" onclick="toggleMenu()">Servicios</a>
            <a href="{{ route('home') }}#nosotros" class="text-navy/70 font-medium py-2" onclick="toggleMenu()">Nosotros</a>
            <a href="{{ route('home') }}#transformacion-digital" class="text-navy/70 font-medium py-2" onclick="toggleMenu()">Transformación Digital</a>
            <a href="{{ route('home') }}#blog" class="text-navy/70 font-medium py-2" onclick="toggleMenu()">Blog</a>
            <a href="{{ route('consultoria.show') }}" class="bg-navy text-white px-6 py-3 rounded-full text-center font-semibold" onclick="toggleMenu()">Solicitar Asesoría</a>
        </div>
    </div>
</nav>
