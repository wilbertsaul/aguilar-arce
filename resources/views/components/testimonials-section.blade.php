<section class="py-section-padding bg-surface-container-lowest">
    <div class="max-w-container-max mx-auto px-gutter text-center">
        <span class="font-caps-micro text-secondary uppercase tracking-[0.4em] mb-16 block">Voces de Liderazgo</span>
        <div class="max-w-4xl mx-auto space-y-24">
            @forelse($testimonios as $testimonio)
            <blockquote class="reveal-on-scroll">
                <p class="font-display-lg text-headline-md md:text-[36px] italic text-primary leading-tight mb-8">
                    "{{ $testimonio->texto }}"
                </p>
                <cite class="not-italic">
                    <span class="block font-label-sm text-primary uppercase tracking-widest mb-1">{{ $testimonio->nombre }}</span>
                    <span class="block font-body-md text-on-surface-variant">{{ $testimonio->cargo }}, {{ $testimonio->empresa }}</span>
                </cite>
            </blockquote>
            @empty
            <p class="text-on-surface-variant">No hay testimonios disponibles.</p>
            @endforelse
        </div>
    </div>
</section>
