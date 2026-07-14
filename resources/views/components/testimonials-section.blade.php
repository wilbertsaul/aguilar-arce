<section class="py-section-padding bg-surface" id="testimonios">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="text-center mb-16">
            <span class="text-caps-micro text-grey-metallic uppercase tracking-widest block mb-4 reveal-on-scroll">Testimonios</span>
            <h2 class="text-headline-lg text-navy reveal-on-scroll">Voces de Liderazgo</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse($testimonios as $testimonio)
            <div class="glass rounded-2xl p-8 reveal-on-scroll">
                <div class="flex items-center gap-0.5 mb-4">
                    @for($i = 0; $i < 5; $i++)
                    <span class="material-symbols-outlined text-lg" style="color: #f59e0b;">star</span>
                    @endfor
                </div>
                <p class="text-on-surface-variant mb-6 leading-relaxed">"{{ $testimonio->texto }}"</p>
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-full bg-navy/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-navy">person</span>
                    </div>
                    <div>
                        <p class="font-semibold text-navy">{{ $testimonio->nombre }}</p>
                        <p class="text-sm text-grey-metallic">{{ $testimonio->cargo }}, {{ $testimonio->empresa }}</p>
                    </div>
                </div>
            </div>
            @empty
            <p class="col-span-full text-center text-on-surface-variant">No hay testimonios disponibles.</p>
            @endforelse
        </div>
    </div>
</section>
