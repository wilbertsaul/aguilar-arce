<section class="bg-navy-dark border-t border-white/5 relative overflow-hidden">
    <div class="absolute inset-0 pattern-dots opacity-30"></div>
    <div class="absolute -bottom-24 left-1/2 -translate-x-1/2 w-[30rem] h-[30rem] bg-teal-accent/5 rounded-full blur-3xl"></div>
    <div class="relative max-w-container-max mx-auto px-gutter py-14">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 md:divide-x md:divide-white/10">
            <div class="text-center reveal-on-scroll">
                <span class="block text-3xl sm:text-4xl md:text-5xl font-bold font-title text-white counter" data-target="{{ $stats['clientes'] ?? 500 }}">0</span>
                <span class="block text-teal-accent/80 text-xs sm:text-sm mt-1 font-semibold uppercase tracking-wider">+ Clientes</span>
            </div>
            <div class="text-center reveal-on-scroll">
                <span class="block text-3xl sm:text-4xl md:text-5xl font-bold font-title text-white counter" data-target="{{ $stats['proyectos'] ?? 1200 }}">0</span>
                <span class="block text-teal-accent/80 text-xs sm:text-sm mt-1 font-semibold uppercase tracking-wider">+ Proyectos</span>
            </div>
            <div class="text-center reveal-on-scroll">
                <span class="block text-3xl sm:text-4xl md:text-5xl font-bold font-title text-white counter" data-target="{{ $stats['anos'] ?? 15 }}">0</span>
                <span class="block text-teal-accent/80 text-xs sm:text-sm mt-1 font-semibold uppercase tracking-wider">Años de experiencia</span>
            </div>
            <div class="text-center reveal-on-scroll">
                <span class="block text-3xl sm:text-4xl md:text-5xl font-bold font-title text-white counter" data-target="{{ $stats['satisfaccion'] ?? 99 }}">0</span>
                <span class="block text-teal-accent/80 text-xs sm:text-sm mt-1 font-semibold uppercase tracking-wider">% Satisfacción</span>
            </div>
        </div>
    </div>
</section>
