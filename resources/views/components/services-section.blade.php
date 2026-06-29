<section class="py-section-padding bg-surface" id="servicios">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="flex flex-col gap-16">
            @forelse($servicios as $index => $servicio)
            <div class="group border-t border-outline-variant/50 pt-12 flex flex-col md:flex-row justify-between items-start transition-all duration-500 hover:pb-8">
                <div class="md:w-1/3">
                    <span class="font-caps-micro text-secondary mb-4 block">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                    <h3 class="font-display-lg text-headline-md text-primary transition-all group-hover:italic group-hover:translate-x-4">{{ $servicio->titulo }}</h3>
                </div>
                <div class="md:w-1/2 mt-4 md:mt-0">
                    <p class="font-body-md text-on-surface-variant mb-6">{{ $servicio->descripcion_corta }}</p>
                    <a class="inline-flex items-center gap-2 text-primary font-label-sm border-b border-primary/20 pb-1 hover:border-primary transition-all" href="{{ route('servicios.show', $servicio->slug) }}">
                        Ver detalle
                    </a>
                </div>
            </div>
            @empty
            <p class="text-on-surface-variant">No hay servicios disponibles.</p>
            @endforelse
        </div>
    </div>
</section>
