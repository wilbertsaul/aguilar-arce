<section class="py-section-padding bg-white overflow-hidden">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="mb-16">
            <span class="font-caps-micro text-secondary uppercase tracking-widest block mb-4">Perspectivas Estratégicas</span>
            <h2 class="font-display-lg text-display-lg-mobile md:text-headline-md">El Pulso del Mercado</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-12 gap-12 items-stretch">
            @if($articulo_destacado)
            <div class="md:col-span-8 group cursor-pointer">
                <div class="relative aspect-[16/9] overflow-hidden mb-8">
                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105" style="background-image: url('{{ $articulo_destacado->imagen ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCBuuj0NGt4VNyE5sDWrp8_EHS90-1rZoaz_nA52qI99mSkLdSoTS8F9HClGCmDtB8j1DPbmmEhnD7MGIJDH-b2ggUfuSDjIRkDT6tEXRiE7T9DrTTEMR2I5rOnGb4jDRxfno5dm6LuZdZsAk8Cz77MKMKHX7UNjbChIqRdphvNZ7h_0YVCigsHcGaM0aFGaqUwREkWqX-tKdhp3j1F6L9qbW0InCJ8UaaKSrbGdFdJU2N7xmwidMhCePdnqy77J97zZ3zsWj2CROmQ' }}')"></div>
                </div>
                <span class="text-secondary font-label-sm mb-2 block">{{ $articulo_destacado->categoria }}</span>
                <h3 class="font-display-lg text-headline-md mb-4 group-hover:text-primary-container transition-colors">{{ $articulo_destacado->titulo }}</h3>
                <p class="font-body-md text-on-surface-variant max-w-2xl leading-relaxed">{{ $articulo_destacado->resumen }}</p>
            </div>
            @endif
            <div class="md:col-span-4 flex flex-col gap-12 justify-between">
                @forelse($articulos_sidebar as $articulo)
                <div class="border-l-2 {{ $loop->first ? 'border-primary' : 'border-outline-variant' }} pl-8 py-2 {{ $loop->first ? '' : 'opacity-60 hover:opacity-100 transition-opacity' }}">
                    <span class="font-caps-micro text-secondary mb-2 block">{{ $articulo->categoria }}</span>
                    <h4 class="font-headline-md text-[20px] mb-2">{{ $articulo->titulo }}</h4>
                    <p class="font-body-md text-on-surface-variant text-sm line-clamp-3">{{ $articulo->resumen }}</p>
                </div>
                @empty
                <p class="text-on-surface-variant">No hay artículos disponibles.</p>
                @endforelse
            </div>
        </div>
    </div>
</section>
