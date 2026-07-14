<section class="bg-navy-dark border-t border-white/5">
    <div class="max-w-container-max mx-auto px-gutter py-14">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
            <div class="text-center reveal-on-scroll">
                <span class="block text-3xl sm:text-4xl md:text-5xl font-bold text-white counter" data-target="{{ $stats['clientes'] ?? 500 }}">0</span>
                <span class="block text-grey-metallic text-xs sm:text-sm mt-1">+ Clientes</span>
            </div>
            <div class="text-center reveal-on-scroll">
                <span class="block text-3xl sm:text-4xl md:text-5xl font-bold text-white counter" data-target="{{ $stats['proyectos'] ?? 1200 }}">0</span>
                <span class="block text-grey-metallic text-xs sm:text-sm mt-1">+ Proyectos</span>
            </div>
            <div class="text-center reveal-on-scroll">
                <span class="block text-3xl sm:text-4xl md:text-5xl font-bold text-white counter" data-target="{{ $stats['anos'] ?? 15 }}">0</span>
                <span class="block text-grey-metallic text-xs sm:text-sm mt-1">+ Años de Experiencia</span>
            </div>
            <div class="text-center reveal-on-scroll">
                <span class="block text-3xl sm:text-4xl md:text-5xl font-bold text-white counter" data-target="{{ $stats['satisfaccion'] ?? 99 }}">0</span>
                <span class="block text-grey-metallic text-xs sm:text-sm mt-1">% Satisfacción</span>
            </div>
        </div>
    </div>
</section>
