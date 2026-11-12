@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
    $telefono1 = \App\Models\Setting::get('contacto_telefono_1', '+51 957 129 087');
    $telefono2 = \App\Models\Setting::get('contacto_telefono_2', '+51 993 750 502');
    $email = \App\Models\Setting::get('contacto_email', 'aguilaryarce.tributos@gmail.com');
    $horario = \App\Models\Setting::get('contacto_horario', 'Lun–Vie · 8:30 a. m. – 6:30 p. m.');
    $sedePm = \App\Models\Setting::get('sede_puerto_maldonado', 'Av. Alameda Mz. F Lote 5');
    $sedeCusco = \App\Models\Setting::get('sede_cusco', 'Jr. La Cultura');
    $telDigits1 = preg_replace('/\D+/', '', $telefono1);
    $telDigits2 = preg_replace('/\D+/', '', $telefono2);
@endphp
<section class="py-section-padding bg-surface-variant" id="contacto">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="max-w-2xl mb-12">
            <span class="text-caps-micro font-title font-bold uppercase tracking-[0.2em] text-teal-deep block mb-3 reveal-on-scroll">CANALES DE ATENCIÓN</span>
            <h2 class="text-headline-lg font-title font-bold text-navy tracking-tight reveal-on-scroll">Hablemos sobre su empresa</h2>
            <p class="text-body-md text-on-surface-variant mt-3 reveal-on-scroll">
                Atención personalizada con presencia física en el sur del país y canales directos.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mb-12">
            {{-- Presencia física --}}
            <div class="bg-white p-7 rounded-2xl border border-outline-variant/70 shadow-sm space-y-5 reveal-on-scroll">
                <div class="flex items-center gap-2.5 text-navy">
                    <span class="material-symbols-outlined text-[24px] text-teal-deep">location_on</span>
                    <h3 class="font-title font-bold text-base">Presencia Física</h3>
                </div>
                <div class="space-y-4 pt-1 text-[13px]">
                    <div class="border-b border-outline-variant/60 pb-3">
                        <span class="font-bold text-navy block">Puerto Maldonado (Madre de Dios)</span>
                        <p class="text-on-surface-variant mt-0.5">{{ $sedePm }}</p>
                    </div>
                    <div>
                        <span class="font-bold text-navy block">Cusco</span>
                        <p class="text-on-surface-variant mt-0.5">{{ $sedeCusco }}</p>
                    </div>
                </div>
                <div class="pt-3 border-t border-outline-variant/60 text-xs text-on-surface-variant">
                    <span class="font-semibold text-navy block">Horario de atención:</span>
                    {{ $horario }}
                </div>
            </div>

            {{-- Central y teléfonos --}}
            <div class="bg-white p-7 rounded-2xl border border-outline-variant/70 shadow-sm space-y-5 reveal-on-scroll">
                <div class="flex items-center gap-2.5 text-navy">
                    <span class="material-symbols-outlined text-[24px] text-teal-deep">call</span>
                    <h3 class="font-title font-bold text-base">Central &amp; Teléfonos</h3>
                </div>
                <div class="space-y-4 pt-1 text-[13px]">
                    <div>
                        <span class="text-xs text-on-surface-variant block">Línea directa 01</span>
                        <a class="font-title font-bold text-base text-navy hover:text-teal-deep transition-colors mt-0.5 block" href="tel:{{ $telDigits1 }}">{{ $telefono1 }}</a>
                    </div>
                    <div>
                        <span class="text-xs text-on-surface-variant block">Línea directa 02</span>
                        <a class="font-title font-bold text-base text-navy hover:text-teal-deep transition-colors mt-0.5 block" href="tel:{{ $telDigits2 }}">{{ $telefono2 }}</a>
                    </div>
                </div>
                <div class="pt-3 border-t border-outline-variant/60">
                    <span class="text-xs text-on-surface-variant block">Correo institucional:</span>
                    <a class="font-semibold text-xs text-navy hover:text-teal-deep hover:underline break-all transition-colors" href="mailto:{{ $email }}">{{ $email }}</a>
                </div>
            </div>

            {{-- WhatsApp --}}
            <div class="bg-white p-7 rounded-2xl border border-outline-variant/70 shadow-sm flex flex-col justify-between reveal-on-scroll">
                <div class="space-y-4">
                    <div class="flex items-center gap-2.5 text-navy">
                        <span class="material-symbols-outlined text-[26px] text-whatsapp">forum</span>
                        <h3 class="font-title font-bold text-base">Atención Inmediata</h3>
                    </div>
                    <p class="text-[13px] text-on-surface-variant leading-relaxed">
                        Coordine consultas preliminares o envíe documentos de manera directa con nuestro equipo de guardia.
                    </p>
                    <div class="bg-teal-container border border-teal-accent/30 p-3.5 rounded-xl text-xs text-on-surface-variant">
                        <span class="font-bold text-navy block mb-1">Mesa de Partes Virtual</span>
                        Recepción formal de requerimientos y fiscalizaciones.
                    </div>
                </div>
                <div class="pt-6">
                    <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20deseo%20una%20atenci%C3%B3n%20inmediata%20con%20BYT%20SOLUTION." target="_blank" rel="noopener noreferrer" class="btn-whatsapp w-full">
                        <span class="material-symbols-outlined text-[18px]">forum</span>
                        Iniciar WhatsApp Directo
                    </a>
                </div>
            </div>
        </div>

        {{-- Cobertura regional estilizada (CSS, sin mapa externo) --}}
        <div class="bg-white rounded-2xl border border-outline-variant/70 shadow-sm overflow-hidden reveal-on-scroll">
            <div class="flex items-center justify-between px-6 py-4 border-b border-outline-variant/60 flex-wrap gap-2">
                <div class="flex items-center gap-2">
                    <span class="material-symbols-outlined text-teal-deep">map</span>
                    <span class="font-title font-bold text-sm text-navy">Cobertura Regional: Cusco &amp; Madre de Dios</span>
                </div>
                <span class="text-xs text-on-surface-variant font-semibold">Sedes Operativas en el Sur del Perú</span>
            </div>
            <div class="relative h-72 md:h-80 bg-navy overflow-hidden">
                <div class="absolute inset-0 pattern-dots opacity-60"></div>
                <div class="absolute top-1/4 left-1/4 w-72 h-72 bg-teal-accent/10 rounded-full blur-3xl"></div>
                <div class="absolute bottom-0 right-1/4 w-72 h-72 bg-teal-accent/10 rounded-full blur-3xl"></div>

                {{-- Rutas decorativas --}}
                <svg class="absolute inset-0 w-full h-full" viewBox="0 0 1000 320" preserveAspectRatio="none" aria-hidden="true">
                    <path d="M 150 260 Q 350 220 480 120" fill="none" stroke="rgba(0,196,167,0.35)" stroke-width="2" stroke-dasharray="6 8"/>
                    <path d="M 480 120 Q 620 90 820 200" fill="none" stroke="rgba(0,196,167,0.35)" stroke-width="2" stroke-dasharray="6 8"/>
                    <path d="M 300 300 Q 500 280 700 300" fill="none" stroke="rgba(255,255,255,0.08)" stroke-width="2" stroke-dasharray="2 10"/>
                </svg>

                {{-- Pin: Puerto Maldonado --}}
                <div class="absolute left-[10%] top-[68%] flex flex-col items-center group">
                    <span class="absolute top-0 w-5 h-5 rounded-full bg-teal-bright opacity-30 animate-ping"></span>
                    <span class="material-symbols-outlined text-[34px] text-teal-bright drop-shadow-lg">location_on</span>
                    <div class="mt-1 bg-white/95 backdrop-blur rounded-lg px-3 py-1.5 shadow-lg border border-white/30">
                        <p class="text-[10px] font-title font-bold text-navy">PUERTO MALDONADO</p>
                        <p class="text-[9px] text-on-surface-variant">{{ $sedePm }}</p>
                    </div>
                </div>

                {{-- Pin: Cusco --}}
                <div class="absolute left-[46%] top-[28%] flex flex-col items-center group">
                    <span class="absolute top-0 w-5 h-5 rounded-full bg-teal-bright opacity-30 animate-ping"></span>
                    <span class="material-symbols-outlined text-[34px] text-teal-bright drop-shadow-lg">location_on</span>
                    <div class="mt-1 bg-white/95 backdrop-blur rounded-lg px-3 py-1.5 shadow-lg border border-white/30">
                        <p class="text-[10px] font-title font-bold text-navy">CUSCO</p>
                        <p class="text-[9px] text-on-surface-variant">{{ $sedeCusco }}</p>
                    </div>
                </div>

                {{-- Leyenda --}}
                <div class="absolute bottom-4 right-4 bg-white/10 backdrop-blur border border-white/20 rounded-lg px-3.5 py-2">
                    <p class="text-[10px] text-white/80 flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px] text-teal-bright">public</span>
                        Atención presencial y remota en todo el Perú
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>
