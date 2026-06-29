<nav class="fixed top-0 w-full z-50 bg-white/70 backdrop-blur-md border-b border-outline-variant/30 shadow-sm transition-all duration-300 h-20" id="navbar">
    <div class="max-w-container-max mx-auto px-gutter flex justify-between items-center h-full">
        <a href="{{ route('home') }}">
            <img src="{{ asset('images/AA Consultores.png') }}" alt="Aguilar & Arce Consultores" width="128" height="128" class="object-contain">
        </a>
        <div class="hidden md:flex items-center space-x-10">
            <a class="font-body-md text-secondary border-b-2 border-secondary pb-1 font-bold" href="{{ route('home') }}#servicios">Servicios</a>
            <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">¿Por qué nosotros?</a>
            <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">Transformación Digital</a>
            <a class="font-body-md text-on-surface-variant hover:text-secondary transition-colors" href="#">Blog</a>
        </div>
        <button class="bg-primary text-on-primary px-8 py-3 rounded-full font-label-sm hover:opacity-80 transition-opacity">
            Solicitar Asesoría
        </button>
    </div>
</nav>
