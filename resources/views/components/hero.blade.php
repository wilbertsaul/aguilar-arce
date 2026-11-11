@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
@endphp
<section class="relative overflow-hidden hero-gradient">
    <div class="absolute inset-0 pattern-dots opacity-40"></div>
    <div class="absolute -top-32 -right-32 w-[28rem] h-[28rem] bg-teal-accent/10 rounded-full blur-3xl"></div>

    <div class="relative z-10 max-w-container-max mx-auto px-gutter py-16 md:py-24 lg:py-28">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-14 items-center">

            {{-- Contenido --}}
            <div class="lg:col-span-7 text-white space-y-7">
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-white/10 border border-teal-accent/30 rounded-full backdrop-blur-sm reveal-on-scroll">
                    <span class="relative flex w-2 h-2">
                        <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-bright opacity-75"></span>
                        <span class="relative inline-flex rounded-full h-2 w-2 bg-teal-accent"></span>
                    </span>
                    <span class="text-[11px] font-title font-semibold tracking-[0.15em] uppercase text-white/90">Contabilidad · Tributación · Auditoría</span>
                </div>

                <h1 class="font-title font-bold text-3xl sm:text-4xl lg:text-[46px] leading-[1.15] tracking-tight reveal-on-scroll">
                    {{ $hero['titulo'] ?? 'Seguridad contable.' }}<br>
                    <span class="text-teal-bright">{{ $hero['subtitulo'] ?? 'Control tributario. Decisiones con información.' }}</span>
                </h1>

                <p class="text-base sm:text-lg text-white/75 max-w-xl leading-relaxed reveal-on-scroll">
                    {{ $hero['descripcion'] ?? 'Integramos servicios contables, tributarios, laborales y herramientas digitales para mantener la información de su empresa bajo control.' }}
                </p>

                <div class="flex flex-wrap items-center gap-4 pt-2 reveal-on-scroll">
                    <a href="#diagnostico-orientacion" class="btn-teal">
                        Solicitar Diagnóstico Gratuito
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </a>
                    <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20deseo%20chatear%20con%20un%20especialista%20de%20Aguilar%20%26%20Arce." target="_blank" rel="noopener noreferrer" class="btn-whatsapp">
                        <span class="material-symbols-outlined text-[18px]">forum</span>
                        Chatear con un Especialista
                    </a>
                </div>

                <div class="flex flex-wrap items-center gap-x-6 gap-y-2.5 pt-5 text-white/60 text-xs reveal-on-scroll">
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-teal-accent">verified</span>
                        Profesionales colegiados
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-teal-accent">schedule</span>
                        Respuesta en menos de 24 h
                    </span>
                    <span class="flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[16px] text-teal-accent">location_on</span>
                        Puerto Maldonado · Cusco
                    </span>
                </div>
            </div>

            {{-- Visual: tarjeta de comprobante electrónico (CSS puro) --}}
            <div class="hidden lg:block lg:col-span-5 reveal-on-scroll">
                <div class="relative animate-float max-w-sm ml-auto">
                    <div class="bg-white rounded-2xl shadow-2xl border border-outline-variant/40 overflow-hidden">
                        {{-- Encabezado del comprobante --}}
                        <div class="bg-gradient-to-r from-navy to-navy-light px-5 py-4 flex items-center justify-between">
                            <div class="flex items-center gap-2.5">
                                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center shrink-0">
                                    <img src="{{ asset('images/AA Consultores.png') }}" alt="A&A" class="w-full h-full object-contain p-0.5">
                                </div>
                                <div class="leading-tight">
                                    <p class="text-[9px] font-title font-bold text-white">AGUILAR &amp; ARCE CONSULTORES</p>
                                    <p class="text-[8px] text-grey-metallic font-mono">RUC 20608492011</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <span class="inline-block bg-teal-accent text-navy-dark text-[8px] font-title font-bold px-2 py-0.5 rounded">BOLETA ELECTRÓNICA</span>
                                <p class="text-[10px] font-mono font-bold text-white mt-1">B001-00001258</p>
                            </div>
                        </div>

                        {{-- Items --}}
                        <div class="px-5 py-4 space-y-2.5">
                            <div class="flex items-center justify-between text-[10px] text-on-surface-variant border-b border-dashed border-outline-variant/60 pb-2">
                                <span class="font-medium">01 Honorarios Contables</span>
                                <span class="font-mono font-bold text-navy">S/ 350.00</span>
                            </div>
                            <div class="flex items-center justify-between text-[10px] text-on-surface-variant border-b border-dashed border-outline-variant/60 pb-2">
                                <span class="font-medium">01 Declaración IGV (SIRE)</span>
                                <span class="font-mono font-bold text-navy">S/ 180.00</span>
                            </div>
                            <div class="flex items-center justify-between pt-1">
                                <span class="text-[10px] font-semibold text-on-surface-variant">OP. GRAVADAS + IGV (18%)</span>
                                <span class="text-sm font-mono font-bold text-navy">S/ 625.68</span>
                            </div>
                        </div>

                        {{-- Pie del comprobante --}}
                        <div class="bg-surface-variant border-t border-outline-variant/60 px-5 py-3.5 flex items-center justify-between">
                            <div class="flex items-center gap-2">
                                <span class="badge-sunat !text-[9px] !px-2 !py-0.5">
                                    <span class="w-1.5 h-1.5 rounded-full bg-white"></span>
                                    Aceptado por SUNAT
                                </span>
                                <div class="qr-box !w-9 !h-9"></div>
                            </div>
                            <span class="text-[8px] text-grey-metallic font-mono">2026-11-10 08:45</span>
                        </div>
                    </div>

                    {{-- Chip flotante --}}
                    <div class="absolute -left-6 top-10 bg-white rounded-xl shadow-xl px-3.5 py-2.5 border border-outline-variant/40 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[20px] text-teal-accent">bolt</span>
                        <div class="leading-tight">
                            <p class="text-[10px] font-title font-bold text-navy">Emisión en segundos</p>
                            <p class="text-[9px] text-on-surface-variant">Validación automática</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
