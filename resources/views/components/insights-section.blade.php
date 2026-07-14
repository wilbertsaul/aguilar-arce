<section class="py-section-padding bg-surface-variant" id="blog">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="mb-12 text-center">
            <span class="text-caps-micro text-grey-metallic uppercase tracking-widest block mb-4 reveal-on-scroll">Perspectivas Estratégicas</span>
            <h2 class="text-headline-lg text-navy reveal-on-scroll">El Pulso del Mercado</h2>
        </div>
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
            @if($articulo_destacado)
            <div class="lg:col-span-8 group cursor-pointer reveal-on-scroll">
                <div class="relative aspect-[16/9] rounded-2xl overflow-hidden mb-6">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('{{ $articulo_destacado->imagen ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCBuuj0NGt4VNyE5sDWrp8_EHS90-1rZoaz_nA52qI99mSkLdSoTS8F9HClGCmDtB8j1DPbmmEhnD7MGIJDH-b2ggUfuSDjIRkDT6tEXRiE7T9DrTTEMR2I5rOnGb4jDRxfno5dm6LuZdZsAk8Cz77MKMKHX7UNjbChIqRdphvNZ7h_0YVCigsHcGaM0aFGaqUwREkWqX-tKdhp3j1F6L9qbW0InCJ8UaaKSrbGdFdJU2N7xmwidMhCePdnqy77J97zZ3zsWj2CROmQ' }}')"></div>
                </div>
                <span class="text-grey-metallic text-sm font-medium uppercase tracking-widest">{{ $articulo_destacado->categoria }}</span>
                <h3 class="text-2xl font-bold text-navy mt-2 group-hover:text-navy-light transition-colors">{{ $articulo_destacado->titulo }}</h3>
                <p class="text-on-surface-variant mt-3 leading-relaxed">{{ $articulo_destacado->resumen }}</p>
            </div>
            @endif
            <div class="lg:col-span-4 space-y-8">
                <div class="glass rounded-2xl p-6 reveal-on-scroll">
                    <h4 class="font-semibold text-navy mb-4">Artículos Recientes</h4>
                    @forelse($articulos_sidebar as $articulo)
                    <div class="border-b border-outline-variant last:border-0 py-4">
                        <span class="text-xs text-grey-metallic uppercase tracking-widest">{{ $articulo->categoria }}</span>
                        <h5 class="font-semibold text-navy mt-1">{{ $articulo->titulo }}</h5>
                    </div>
                    @empty
                    <p class="text-on-surface-variant text-sm">No hay artículos disponibles.</p>
                    @endforelse
                </div>
                <div class="glass rounded-2xl p-6 reveal-on-scroll">
                    <h4 class="font-semibold text-navy mb-4">Tags</h4>
                    <div class="flex flex-wrap gap-2">
                        <span class="px-3 py-1 bg-navy/5 text-navy text-sm rounded-full">Consultoría</span>
                        <span class="px-3 py-1 bg-navy/5 text-navy text-sm rounded-full">Finanzas</span>
                        <span class="px-3 py-1 bg-navy/5 text-navy text-sm rounded-full">Digital</span>
                        <span class="px-3 py-1 bg-navy/5 text-navy text-sm rounded-full">Innovación</span>
                        <span class="px-3 py-1 bg-navy/5 text-navy text-sm rounded-full">Estrategia</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
