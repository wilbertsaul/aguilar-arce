<section class="py-section-padding bg-white">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-gutter">
            <div class="md:col-span-4">
                <span class="font-caps-micro text-secondary uppercase tracking-[0.3em] mb-6 block">Nuestra Visión</span>
                <h2 class="font-headline-md text-primary mb-8">{{ $vision['titulo'] ?? 'El Nuevo Paradigma <br/>de la Consultoría' }}</h2>
            </div>
            <div class="md:col-span-8">
                <div class="editorial-text-wrap font-body-lg text-on-surface-variant leading-relaxed">
                    {!! $vision['texto'] ?? 'En Aguilar &amp; Arce no solo gestionamos procesos; redefinimos el potencial de su organización. A través de la integración de <span class="text-primary font-bold">inteligencia analítica</span> y experiencia técnica, hemos facilitado el crecimiento de más de <span class="text-secondary-fixed-variant font-display-lg text-headline-md inline-block align-middle mx-1">500+</span> corporaciones a nivel global. Nuestra metodología ha gestionado activos por un valor superior a los <span class="text-secondary-fixed-variant font-display-lg text-headline-md inline-block align-middle mx-1">1.2k</span> millones de dólares, asegurando que cada cifra sea un peldaño hacia la expansión sostenible.' !!}
                </div>
            </div>
        </div>
    </div>
</section>
