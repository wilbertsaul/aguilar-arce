<section class="relative py-32 bg-primary overflow-hidden">
    <div class="absolute inset-0 opacity-20"></div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter text-center">
        <h2 class="font-display-lg text-display-lg-mobile md:text-display-lg text-white mb-12">
            {!! $cta['titulo'] ?? 'Impulsemos juntos <br/>el crecimiento.' !!}
        </h2>
        <p class="text-on-primary-container font-body-lg max-w-2xl mx-auto mb-16 opacity-80">
            {{ $cta['descripcion'] ?? 'Estamos listos para transformar su visión en resultados tangibles. Agende una sesión de diagnóstico hoy mismo.' }}
        </p>
        <button class="bg-white text-primary px-12 py-5 rounded-full font-label-sm text-lg hover:scale-105 transition-all duration-300 shadow-xl">
            {{ $cta['boton'] ?? 'Agendar Consultoría' }}
        </button>
    </div>
</section>
