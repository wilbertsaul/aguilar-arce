<section class="py-24 bg-white" id="blog">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="flex flex-col md:flex-row items-end justify-between mb-12 gap-4">
            <div class="max-w-xl">
                <h2 class="text-headline-md text-navy mb-4">Perspectivas Estratégicas</h2>
                <p class="text-body-md text-on-surface-variant">Artículos y análisis sobre el futuro de la tributación, auditoría y tecnología empresarial.</p>
            </div>
            <a href="{{ route('blog') }}" class="bg-surface-variant text-navy px-6 py-3 rounded-xl text-label-sm hover:bg-grey-light transition-colors">
                Ver todas las publicaciones
            </a>
        </div>

        @php
        $minutos = $featured ? max(1, (int) round(str_word_count(strip_tags($featured->contenido)) / 200)) : 5;
        @endphp

        <div class="grid grid-cols-1 md:grid-cols-12 gap-8">
            @if($featured)
            <a href="{{ route('articulo.show', $featured->slug) }}" class="md:col-span-8 group">
                <div class="relative overflow-hidden rounded-3xl mb-6 h-[400px]">
                    <img class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700 mix-blend-multiply" alt="{{ $featured->titulo }}" src="{{ $featured->imagen ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCBuuj0NGt4VNyE5sDWrp8_EHS90-1rZoaz_nA52qI99mSkLdSoTS8F9HClGCmDtB8j1DPbmmEhnD7MGIJDH-b2ggUfuSDjIRkDT6tEXRiE7T9DrTTEMR2I5rOnGb4jDRxfno5dm6LuZdZsAk8Cz77MKMKHX7UNjbChIqRdphvNZ7h_0YVCigsHcGaM0aFGaqUwREkWqX-tKdhp3j1F6L9qbW0InCJ8UaaKSrbGdFdJU2N7xmwidMhCePdnqy77J97zZ3zsWj2CROmQ' }}">
                    <div class="absolute top-4 left-4 flex gap-2">
                        <span class="bg-primary text-white px-3 py-1 rounded-full text-xs font-bold">{{ $featured->categoria }}</span>
                        <span class="bg-white/90 backdrop-blur text-primary px-3 py-1 rounded-full text-xs font-bold">Lectura de {{ $minutos }} min</span>
                    </div>
                </div>
                <h3 class="text-3xl md:text-headline-md text-navy group-hover:text-primary/70 transition-colors mb-4">{{ $featured->titulo }}</h3>
                <p class="text-on-surface-variant text-body-md line-clamp-2">{{ $featured->resumen }}</p>
            </a>
            @endif

            <div class="md:col-span-4 space-y-8">
                @foreach($all as $articulo)
                <a href="{{ route('articulo.show', $articulo->slug) }}" class="block group">
                    <span class="text-grey-metallic text-label-sm text-[10px] uppercase tracking-widest block mb-2">{{ $articulo->categoria }}</span>
                    <h4 class="text-body-lg font-semibold text-navy group-hover:text-primary/70 transition-colors mb-2">{{ $articulo->titulo }}</h4>
                    <p class="text-on-surface-variant text-sm line-clamp-2">{{ $articulo->resumen }}</p>
                    @if(!$loop->last)
                    <div class="h-px bg-outline-variant/30 mt-6"></div>
                    @endif
                </a>
                @endforeach
            </div>
        </div>
    </div>
</section>
