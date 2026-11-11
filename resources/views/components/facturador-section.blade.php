@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
    $facturadorTitulo = \App\Models\Setting::get('facturador_titulo', 'Facturación que se integra con su gestión contable.');
    $facturadorDesc = \App\Models\Setting::get('facturador_descripcion', 'Emita comprobantes electrónicos y centralice la información de su empresa para facilitar sus procesos administrativos y contables.');
    $comboTitulo = \App\Models\Setting::get('facturador_combo_titulo', 'Plan Integrado Especial');
    $comboTexto = \App\Models\Setting::get('facturador_combo_texto', 'Pregunta por el combo Factura + Contabilidad mensual sin costo adicional de software.');
    $comboBadge = \App\Models\Setting::get('facturador_combo_badge', 'Ahorro 25%');
@endphp
<section class="py-section-padding bg-surface" id="facturador">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            {{-- Contenido --}}
            <div class="lg:col-span-7 space-y-6">
                <span class="text-caps-micro font-title font-bold uppercase tracking-[0.2em] text-teal-deep block reveal-on-scroll">TECNOLOGÍA PROPIA · FACTURADOR ONLINE</span>
                <h2 class="text-headline-lg font-title font-bold text-navy tracking-tight reveal-on-scroll">{{ $facturadorTitulo }}</h2>
                <p class="text-body-md text-on-surface-variant leading-relaxed reveal-on-scroll">{{ $facturadorDesc }}</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 reveal-on-scroll">
                    <div class="p-4 bg-surface-variant border border-outline-variant/60 rounded-xl hover:border-teal-accent/60 transition-colors">
                        <span class="material-symbols-outlined text-[22px] text-navy mb-1.5">domain</span>
                        <h4 class="font-title font-bold text-[13px] text-navy">Multiempresa</h4>
                        <p class="text-[12px] text-on-surface-variant mt-0.5">Gestione distintas razones sociales en una cuenta.</p>
                    </div>
                    <div class="p-4 bg-surface-variant border border-outline-variant/60 rounded-xl hover:border-teal-accent/60 transition-colors">
                        <span class="material-symbols-outlined text-[22px] text-navy mb-1.5">receipt</span>
                        <h4 class="font-title font-bold text-[13px] text-navy">Comprobantes electrónicos</h4>
                        <p class="text-[12px] text-on-surface-variant mt-0.5">Facturas, boletas, notas y guías validadas.</p>
                    </div>
                    <div class="p-4 bg-surface-variant border border-outline-variant/60 rounded-xl hover:border-teal-accent/60 transition-colors">
                        <span class="material-symbols-outlined text-[22px] text-navy mb-1.5">sync</span>
                        <h4 class="font-title font-bold text-[13px] text-navy">Gestión centralizada</h4>
                        <p class="text-[12px] text-on-surface-variant mt-0.5">Conexión limpia y directa con sus libros contables.</p>
                    </div>
                </div>

                <div class="pt-3 space-y-5 reveal-on-scroll">
                    {{-- Combo promocional --}}
                    <div class="p-4 bg-teal-container border border-teal-accent/40 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-navy flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[24px] text-teal-bright">savings</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-title font-bold text-xs uppercase tracking-wide text-navy">{{ $comboTitulo }}</span>
                                    <span class="bg-amber-accent text-white font-bold text-[10px] px-2 py-0.5 rounded">{{ $comboBadge }}</span>
                                </div>
                                <p class="text-xs text-on-surface-variant font-medium mt-1">{!! $comboTexto !!}</p>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20deseo%20informaci%C3%B3n%20sobre%20el%20combo%20Factura%20%2B%20Contabilidad" target="_blank" rel="noopener noreferrer" class="btn-navy !px-4 !py-2 !text-[12px] shrink-0">
                            <span class="material-symbols-outlined text-[15px] text-teal-bright">chat</span>
                            Consultar Combo
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('facturador') }}" class="btn-teal">
                            <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                            Probar el Simulador GRATIS
                        </a>
                        <a href="#diagnostico-orientacion" class="btn-outline">
                            <span class="material-symbols-outlined text-[18px] text-teal-deep">calculate</span>
                            Solicitar Cotización
                        </a>
                    </div>
                </div>
            </div>

            {{-- Visual: navegador + móvil (CSS puro) --}}
            <div class="lg:col-span-5 reveal-on-scroll">
                <div class="relative py-8 lg:py-10">
                    <div class="relative w-full max-w-[540px] mx-auto">
                        {{-- Navegador --}}
                        <div class="bg-navy rounded-2xl p-2.5 shadow-2xl border border-navy-light relative z-10">
                            <div class="flex items-center justify-between px-2 pb-2 mb-1 border-b border-white/10">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-error/80"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-amber-accent/80"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-whatsapp/80"></span>
                                </div>
                                <div class="bg-white/10 px-3 py-0.5 rounded text-[10px] text-grey-metallic font-mono flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[12px] text-teal-bright">lock</span>
                                    facturador.aguilaryarce.com
                                </div>
                                <div class="flex items-center gap-1 text-grey-metallic">
                                    <span class="material-symbols-outlined text-[14px]">wifi</span>
                                    <span class="material-symbols-outlined text-[14px]">more_vert</span>
                                </div>
                            </div>
                            <div class="rounded-xl overflow-hidden bg-white border border-outline-variant/20 aspect-[16/10] relative shadow-inner">
                                <img src="{{ asset('images/facturador/desktop.jpg') }}" alt="Facturador electrónico Aguilar & Arce — vista escritorio" class="w-full h-full object-cover object-top">
                            </div>
                        </div>

                        {{-- Móvil (composición CSS) --}}
                        <div class="device-phone w-[32%] absolute -bottom-6 right-2 sm:right-4 z-30">
                            <div class="notch"></div>
                            <div class="rounded-[1.15rem] bg-white h-44 flex flex-col p-2 gap-1.5 overflow-hidden">
                                <div class="h-6 rounded-lg bg-navy flex items-center justify-center shrink-0">
                                    <span class="text-[7px] font-title font-bold text-teal-bright tracking-widest">AA FACTURADOR</span>
                                </div>
                                <div class="flex-1 rounded-lg bg-surface-variant p-1.5 flex flex-col gap-1.5">
                                    <div class="h-2 rounded-full bg-teal-accent/60"></div>
                                    <div class="h-2 w-3/4 rounded-full bg-outline-variant"></div>
                                    <div class="h-2 rounded-full bg-teal-accent/40"></div>
                                    <div class="h-2 w-2/3 rounded-full bg-outline-variant"></div>
                                    <div class="mt-auto h-6 rounded-lg bg-gradient-to-r from-teal-accent to-teal-bright"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Badge SUNAT --}}
                        <div class="absolute -top-2 -right-2 z-30">
                            <span class="badge-sunat">
                                <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                                SUNAT Conectado
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
