@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
@endphp
<section class="py-section-padding bg-surface-container-low" id="recursos">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="max-w-2xl mb-12">
            <span class="text-caps-micro font-title font-bold uppercase tracking-[0.2em] text-teal-deep block mb-3 reveal-on-scroll">CONOCIMIENTO APLICADO</span>
            <h2 class="text-headline-lg font-title font-bold text-navy tracking-tight reveal-on-scroll">Centro de Recursos BYT SOLUTION</h2>
            <p class="text-body-md text-on-surface-variant mt-3 reveal-on-scroll">
                Información, herramientas y aprendizaje para gestionar mejor su empresa.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            {{-- 1. ACTUALIDAD (artículos reales del blog) --}}
            <div class="bg-white border border-outline-variant rounded-2xl p-6 shadow-sm flex flex-col justify-between reveal-on-scroll">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <span class="w-9 h-9 rounded-lg bg-navy text-white flex items-center justify-center">
                            <span class="material-symbols-outlined text-[19px]">newspaper</span>
                        </span>
                        <h3 class="font-title font-bold text-base text-navy">1. ACTUALIDAD</h3>
                    </div>
                    <p class="text-[13px] text-on-surface-variant mb-4">
                        Cambios normativos, novedades, vencimientos y alertas tributarias de aplicación inmediata.
                    </p>
                    <ul class="space-y-2.5 text-[12px]">
                        @forelse($all->take(2) as $articulo)
                        <li>
                            <a href="{{ route('articulo.show', $articulo->slug) }}" class="p-2.5 bg-surface-variant rounded-lg border border-outline-variant/60 block hover:border-teal-accent transition-colors group">
                                <span class="font-bold block text-xs text-navy group-hover:text-teal-deep transition-colors">{{ $articulo->titulo }}</span>
                                <span class="text-on-surface-variant">{{ $articulo->categoria }}</span>
                            </a>
                        </li>
                        @empty
                        <li class="p-2.5 bg-surface-variant rounded-lg border border-outline-variant/60">
                            <span class="font-bold block text-xs text-navy">Novedades en preparación</span>
                            <span class="text-on-surface-variant">Próximamente: cronogramas y alertas SUNAT.</span>
                        </li>
                        @endforelse
                    </ul>
                </div>
                <div class="pt-4 mt-6 border-t border-outline-variant/60">
                    <a href="{{ route('blog') }}" class="text-xs font-title font-bold text-navy hover:text-teal-deep inline-flex items-center gap-1.5 transition-colors">
                        Ver publicaciones de actualidad
                        <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                    </a>
                </div>
            </div>

            {{-- 2. UTILITARIOS --}}
            <div class="bg-white border border-outline-variant rounded-2xl p-6 shadow-sm flex flex-col justify-between reveal-on-scroll">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <span class="w-9 h-9 rounded-lg bg-teal-accent text-navy-dark flex items-center justify-center">
                            <span class="material-symbols-outlined text-[19px]">table_chart</span>
                        </span>
                        <h3 class="font-title font-bold text-base text-navy">2. UTILITARIOS</h3>
                    </div>
                    <p class="text-[13px] text-on-surface-variant mb-4">
                        Excel, formatos, calculadoras, checklists, controles y herramientas BYT SOLUTION.
                    </p>
                    <ul class="space-y-2.5 text-[12px]">
                        <li class="p-2.5 bg-surface-variant rounded-lg border border-outline-variant/60 flex items-center justify-between gap-2">
                            <div>
                                <span class="font-bold block text-xs text-navy">Calculadora Laboral (CTS / Grati)</span>
                                <span class="text-on-surface-variant">Hoja de formulación automática.</span>
                            </div>
                            <span class="material-symbols-outlined text-[18px] text-teal-deep">download</span>
                        </li>
                        <li class="p-2.5 bg-surface-variant rounded-lg border border-outline-variant/60 flex items-center justify-between gap-2">
                            <div>
                                <span class="font-bold block text-xs text-navy">Checklist de Cierre Mensual</span>
                                <span class="text-on-surface-variant">Control de conciliación y facturación.</span>
                            </div>
                            <span class="material-symbols-outlined text-[18px] text-teal-deep">download</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 mt-6 border-t border-outline-variant/60">
                    <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20deseo%20recibir%20las%20plantillas%20y%20utilitarios%20de%20BYT%20SOLUTION." target="_blank" rel="noopener noreferrer" class="text-xs font-title font-bold text-navy hover:text-teal-deep inline-flex items-center gap-1.5 transition-colors">
                        Solicitar plantillas y macros
                        <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                    </a>
                </div>
            </div>

            {{-- 3. ACADEMIA --}}
            <div class="bg-white border border-outline-variant rounded-2xl p-6 shadow-sm flex flex-col justify-between reveal-on-scroll">
                <div>
                    <div class="flex items-center gap-2.5 mb-4">
                        <span class="w-9 h-9 rounded-lg bg-navy-light text-white flex items-center justify-center">
                            <span class="material-symbols-outlined text-[19px]">play_circle</span>
                        </span>
                        <h3 class="font-title font-bold text-base text-navy">3. ACADEMIA</h3>
                    </div>
                    <p class="text-[13px] text-on-surface-variant mb-4">
                        Videos cortos de dudas frecuentes explicados de manera clara y directa por especialistas.
                    </p>
                    <ul class="space-y-2.5 text-[12px]">
                        <li class="p-2.5 bg-surface-variant rounded-lg border border-outline-variant/60">
                            <span class="font-bold block text-xs text-navy">¿Qué es el SIRE y cómo opera?</span>
                            <span class="text-on-surface-variant">Resumen práctico en 3 minutos.</span>
                        </li>
                        <li class="p-2.5 bg-surface-variant rounded-lg border border-outline-variant/60">
                            <span class="font-bold block text-xs text-navy">Diferencia entre RER y Régimen MYPE</span>
                            <span class="text-on-surface-variant">¿Cuál le conviene a su facturación?</span>
                        </li>
                        <li class="p-2.5 bg-surface-variant rounded-lg border border-outline-variant/60">
                            <span class="font-bold block text-xs text-navy">¿Qué hago si recibo una esquela?</span>
                            <span class="text-on-surface-variant">Primeros pasos y plazos improrrogables.</span>
                        </li>
                    </ul>
                </div>
                <div class="pt-4 mt-6 border-t border-outline-variant/60">
                    <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20deseo%20acceder%20a%20la%20Academia%20de%20videos%20de%20BYT%20SOLUTION." target="_blank" rel="noopener noreferrer" class="text-xs font-title font-bold text-navy hover:text-teal-deep inline-flex items-center gap-1.5 transition-colors">
                        Ir a la videoteca formativa
                        <span class="material-symbols-outlined text-[15px]">arrow_forward</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section>
