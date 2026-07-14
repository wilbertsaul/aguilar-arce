<section class="relative min-h-[90vh] hero-gradient flex items-center pt-24 md:pt-32 overflow-hidden">
    <div class="absolute inset-0 pattern-dots opacity-30"></div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter w-full py-16">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <div class="text-white">
                <span class="inline-block bg-white/10 text-white/80 text-xs font-semibold px-4 py-1.5 rounded-full mb-6 backdrop-blur-sm border border-white/10 reveal-on-scroll">
                    Consultoría Estratégica
                </span>
                <h1 class="text-headline-md md:text-display-lg lg:text-display-xl text-white leading-tight mb-6 reveal-on-scroll">
                    {{ $hero['titulo'] ?? 'Transformamos números en' }}<br>
                    <span class="text-white/70 font-light">{{ $hero['subtitulo'] ?? 'decisiones estratégicas.' }}</span>
                </h1>
                <p class="text-lg text-white/70 max-w-lg mb-8 reveal-on-scroll">
                    {{ $hero['descripcion'] ?? 'Acompañamos a las empresas líderes en su evolución financiera y tecnológica mediante una visión audaz y datos precisos.' }}
                </p>
                <div class="flex flex-wrap gap-4 reveal-on-scroll">
                    <a href="#servicios" class="inline-flex bg-white text-navy px-8 py-3 rounded-full font-semibold hover:bg-white/90 transition-all duration-300">Explorar Servicios</a>
                    <a href="#contacto" class="inline-flex border-2 border-white/30 text-white px-8 py-3 rounded-full font-semibold hover:bg-white/10 transition-all duration-300">Agendar Cita</a>
                </div>
            </div>
            <div class="hidden md:block relative">
                <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                    <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDUUbCS0pwExAHFQ9iMjpBNW3qWYrZKFxrt27KEYWE-8hMTiNcCqal5o976ULodSPqeL2Z29KHUe67jwGSyNfLM0YiVf-8bTnphCWpnJsM3tbA3Jo0YsAtPAaKBlgdJvG4P-St5Rw3vNSJ3tysiWnO_YGamoFCoJ1MyVyNiIxwu4GwnxsykiKz9t-XquBV6QdZZ91WgVVsuTRjNzVQffqMmvbboSyCDXhsuJZkTcwKtJB4CsonfBCUPeSkSfmGbxRA0P-t7UBfwxn9t" alt="Hero" class="w-full h-auto">
                </div>
                <div class="absolute -top-4 -left-4 glass rounded-xl p-4 shadow-xl animate-bounce-slow">
                    <span class="material-symbols-outlined text-navy text-2xl">trending_up</span>
                    <p class="text-xs font-semibold text-navy mt-1">Crecimiento</p>
                </div>
                <div class="absolute -bottom-4 -right-4 glass rounded-xl p-4 shadow-xl">
                    <span class="material-symbols-outlined text-navy text-2xl">analytics</span>
                    <p class="text-xs font-semibold text-navy mt-1">Analítica</p>
                </div>
                <div class="absolute top-1/3 -right-8 glass rounded-xl p-4 shadow-xl">
                    <span class="material-symbols-outlined text-navy text-2xl">shield</span>
                    <p class="text-xs font-semibold text-navy mt-1">Seguridad</p>
                </div>
            </div>
        </div>
    </div>
</section>
