<section class="py-section-padding bg-surface" id="servicios">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-16">
            <span class="text-caps-micro text-grey-metallic uppercase tracking-widest block mb-4 reveal-on-scroll">Nuestros Servicios</span>
            <h2 class="text-headline-lg text-navy reveal-on-scroll">Soluciones que impulsan tu negocio</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($servicios as $servicio)
            <div class="group glass rounded-2xl p-8 hover-lift reveal-on-scroll">
                @if($servicio->icono)
                <div class="w-14 h-14 rounded-xl bg-navy/5 flex items-center justify-center mb-6 group-hover:bg-navy transition-all duration-300">
                    <span class="material-symbols-outlined text-3xl text-navy group-hover:text-white transition-all duration-300">{{ $servicio->icono }}</span>
                </div>
                @endif
                <h3 class="text-headline-md text-navy mb-3">{{ $servicio->titulo }}</h3>
                <p class="text-on-surface-variant">{{ $servicio->descripcion_corta }}</p>
            </div>
            @empty
            <p class="col-span-full text-center text-on-surface-variant">No hay servicios disponibles.</p>
            @endforelse
        </div>
    </div>
</section>
