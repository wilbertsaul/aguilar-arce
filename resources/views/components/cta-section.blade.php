<section class="relative py-16 md:py-24 lg:py-32 tech-gradient overflow-hidden" id="contacto">
    <div class="absolute inset-0 pattern-dots opacity-20"></div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter text-center">
        <h2 class="text-headline-md md:text-headline-lg lg:text-5xl text-white font-bold mb-6 reveal-on-scroll">
            {{ $cta['titulo'] ?? 'Impulsemos juntos el crecimiento.' }}
        </h2>
        <p class="text-white/70 text-lg max-w-2xl mx-auto mb-10 reveal-on-scroll">
            {{ $cta['descripcion'] ?? 'Estamos listos para transformar su visión en resultados tangibles.' }}
        </p>
        <a href="{{ route('consultoria.show') }}" class="inline-flex bg-white text-navy px-10 py-4 rounded-full font-semibold hover:bg-white/90 hover:scale-105 transition-all duration-300 shadow-xl reveal-on-scroll">
            {{ $cta['boton'] ?? 'Agendar Consultoría' }}
        </a>
    </div>
</section>
