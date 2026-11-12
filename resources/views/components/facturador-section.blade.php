@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
    $facturadorTitulo = \App\Models\Setting::get('facturador_titulo', 'Factura fácil. Crece con respaldo.');
    $facturadorDesc = \App\Models\Setting::get('facturador_descripcion', 'Sistema de facturación electrónica con un equipo contable profesional a tu lado.');
    $comboTitulo = \App\Models\Setting::get('facturador_combo_titulo', 'Plan Integrado');
    $comboTexto = \App\Models\Setting::get('facturador_combo_texto', 'Pregunta por el combo Factura + Contabilidad mensual sin costo adicional de software.');
    $comboBadge = \App\Models\Setting::get('facturador_combo_badge', 'Ahorro 25%');
@endphp
<section class="py-section-padding bg-white byt-surface" id="facturador">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">

            {{-- Contenido --}}
            <div class="lg:col-span-7 space-y-6">
                <div class="reveal-on-scroll">
                    <img src="{{ asset('images/bytfact/bytfact-logo.png') }}" alt="BYTFACT — facturación electrónica" class="h-9 w-auto mb-4">
                    <span class="byt-eyebrow block">Hecho por BYT SOLUTION</span>
                </div>

                <h2 class="text-headline-lg font-byt font-extrabold text-byt-navy tracking-tight reveal-on-scroll">{{ $facturadorTitulo }}</h2>
                <p class="text-body-md text-byt-grey leading-relaxed reveal-on-scroll">{{ $facturadorDesc }}</p>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 pt-2 reveal-on-scroll">
                    <div class="p-4 bg-byt-mist border border-byt-line rounded-xl hover:border-byt-blue/60 transition-colors">
                        <span class="material-symbols-outlined text-[22px] text-byt-blue mb-1.5">bolt</span>
                        <h4 class="font-byt font-extrabold text-[13px] text-byt-navy">Factura en segundos</h4>
                        <p class="text-[12px] text-byt-grey mt-0.5">Boletas y facturas con IGV calculado automáticamente.</p>
                    </div>
                    <div class="p-4 bg-byt-mist border border-byt-line rounded-xl hover:border-byt-blue/60 transition-colors">
                        <span class="material-symbols-outlined text-[22px] text-byt-blue mb-1.5">badge</span>
                        <h4 class="font-byt font-extrabold text-[13px] text-byt-navy">Valida DNI y RUC</h4>
                        <p class="text-[12px] text-byt-grey mt-0.5">Autocompleta los datos del cliente desde RENIEC y SUNAT.</p>
                    </div>
                    <div class="p-4 bg-byt-mist border border-byt-line rounded-xl hover:border-byt-blue/60 transition-colors">
                        <span class="material-symbols-outlined text-[22px] text-byt-blue mb-1.5">account_balance</span>
                        <h4 class="font-byt font-extrabold text-[13px] text-byt-navy">Listo para tu contador</h4>
                        <p class="text-[12px] text-byt-grey mt-0.5">La información llega ordenada a tu gestión contable.</p>
                    </div>
                </div>

                <div class="pt-3 space-y-5 reveal-on-scroll">
                    {{-- Combo promocional --}}
                    <div class="p-4 bg-byt-blue-soft border border-byt-blue/30 rounded-xl flex flex-col sm:flex-row sm:items-center justify-between gap-4 shadow-sm">
                        <div class="flex items-center gap-3.5">
                            <div class="w-11 h-11 rounded-xl bg-byt-navy flex items-center justify-center shrink-0">
                                <span class="material-symbols-outlined text-[24px] text-white">savings</span>
                            </div>
                            <div>
                                <div class="flex items-center gap-2 flex-wrap">
                                    <span class="font-byt font-extrabold text-xs uppercase tracking-wide text-byt-navy">{{ $comboTitulo }}</span>
                                    <span class="bg-byt-blue text-white font-byt font-extrabold text-[10px] px-2 py-0.5 rounded">{{ $comboBadge }}</span>
                                </div>
                                <p class="text-xs text-byt-grey font-medium mt-1">{!! $comboTexto !!}</p>
                            </div>
                        </div>
                        <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20deseo%20informaci%C3%B3n%20sobre%20el%20combo%20Factura%20%2B%20Contabilidad" target="_blank" rel="noopener noreferrer" class="btn-byt !px-4 !py-2 !text-[12px] shrink-0">
                            <span class="material-symbols-outlined text-[15px]">chat</span>
                            Consultar combo
                        </a>
                    </div>

                    <div class="flex flex-wrap items-center gap-4">
                        <a href="{{ route('facturador') }}" class="btn-byt">
                            <span class="material-symbols-outlined text-[18px]">receipt_long</span>
                            Probar el simulador
                        </a>
                        <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20quiero%20informaci%C3%B3n%20sobre%20BYTFACT" target="_blank" rel="noopener noreferrer" class="btn-byt-outline">
                            <span class="material-symbols-outlined text-[18px] text-byt-blue">forum</span>
                            Hablar con un asesor
                        </a>
                    </div>
                </div>
            </div>

            {{-- Visual: navegador + móvil (CSS puro) --}}
            <div class="lg:col-span-5 reveal-on-scroll">
                <div class="relative py-8 lg:py-10">
                    <div class="relative w-full max-w-[540px] mx-auto">
                        {{-- Navegador --}}
                        <div class="bg-byt-navy rounded-2xl p-2.5 shadow-2xl border border-byt-navy relative z-10">
                            <div class="flex items-center justify-between px-2 pb-2 mb-1 border-b border-white/10">
                                <div class="flex items-center gap-1.5">
                                    <span class="w-2.5 h-2.5 rounded-full bg-white/25"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-white/25"></span>
                                    <span class="w-2.5 h-2.5 rounded-full bg-white/25"></span>
                                </div>
                                <div class="bg-white/10 px-3 py-0.5 rounded text-[10px] text-white/60 font-mono flex items-center gap-1.5">
                                    <span class="material-symbols-outlined text-[12px] text-white/70">lock</span>
                                    app.bytfact.pe
                                </div>
                                <div class="flex items-center gap-1 text-white/40">
                                    <span class="material-symbols-outlined text-[14px]">wifi</span>
                                    <span class="material-symbols-outlined text-[14px]">more_vert</span>
                                </div>
                            </div>

                            {{-- Comprobante (composición CSS) --}}
                            <div class="rounded-xl overflow-hidden bg-white aspect-[16/10] relative">
                                <div class="absolute inset-0 p-3 flex flex-col gap-1.5">
                                    <div class="flex items-start justify-between gap-2">
                                        <img src="{{ asset('images/bytfact/bytfact-logo.png') }}" alt="BYTFACT" class="h-3.5 w-auto mt-0.5">
                                        <div class="text-right leading-tight">
                                            <span class="inline-block border border-byt-navy text-byt-navy text-[6px] font-byt font-extrabold px-1.5 py-0.5 rounded-sm">FACTURA ELECTRÓNICA</span>
                                            <div class="text-[7px] font-mono font-bold text-byt-navy mt-0.5">F001-00001234</div>
                                        </div>
                                    </div>

                                    <div class="h-px bg-byt-line"></div>

                                    <div class="grid grid-cols-3 gap-2 text-[6px] leading-tight text-byt-grey">
                                        <div class="col-span-2">
                                            <span class="block font-byt font-extrabold text-byt-navy uppercase text-[5px] tracking-wider">Cliente</span>
                                            COMERCIAL LA SELVA S.A.C.
                                        </div>
                                        <div>
                                            <span class="block font-byt font-extrabold text-byt-navy uppercase text-[5px] tracking-wider">RUC</span>
                                            20512345678
                                        </div>
                                    </div>

                                    <div class="rounded border border-byt-line overflow-hidden">
                                        <div class="grid grid-cols-[10%_1fr_22%] bg-byt-mist text-[5px] font-byt font-extrabold uppercase tracking-wider text-byt-navy px-1.5 py-1">
                                            <span>Cant.</span><span>Descripción</span><span class="text-right">Total</span>
                                        </div>
                                        <div class="grid grid-cols-[10%_1fr_22%] text-[6px] text-byt-grey px-1.5 py-1 border-t border-byt-line/70">
                                            <span>1</span><span>Consultoría mensual</span><span class="text-right font-mono">350.00</span>
                                        </div>
                                        <div class="grid grid-cols-[10%_1fr_22%] text-[6px] text-byt-grey px-1.5 py-1 border-t border-byt-line/70">
                                            <span>1</span><span>Licencia anual BYTFACT</span><span class="text-right font-mono">720.00</span>
                                        </div>
                                        <div class="grid grid-cols-[10%_1fr_22%] text-[6px] text-byt-grey px-1.5 py-1 border-t border-byt-line/70">
                                            <span>1</span><span>Soporte técnico remoto</span><span class="text-right font-mono">180.00</span>
                                        </div>
                                    </div>

                                    <div class="mt-auto flex items-end justify-between gap-2">
                                        <span class="inline-flex items-center gap-1 bg-byt-blue-soft border border-byt-blue text-byt-navy rounded px-1.5 py-0.5 text-[5.5px] font-byt font-extrabold">
                                            <span class="w-1.5 h-1.5 rounded-full bg-byt-blue"></span>
                                            CDR 0 · ACEPTADO
                                        </span>
                                        <div class="text-right leading-none">
                                            <span class="block text-[5px] font-byt font-extrabold uppercase tracking-wider text-byt-grey">Total</span>
                                            <span class="font-mono font-extrabold text-byt-blue text-[13px]">S/ 1,250.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Móvil (composición CSS) --}}
                        <div class="device-phone w-[32%] absolute -bottom-6 right-2 sm:right-4 z-30">
                            <div class="notch"></div>
                            <div class="rounded-[1.15rem] bg-white h-44 flex flex-col p-2 gap-1.5 overflow-hidden">
                                <div class="h-6 rounded-lg bg-byt-navy flex items-center justify-center shrink-0">
                                    <span class="text-[7px] font-byt font-extrabold text-white tracking-widest">BYTFACT</span>
                                </div>
                                <div class="flex-1 rounded-lg bg-byt-mist p-1.5 flex flex-col gap-1.5">
                                    <div class="h-2 rounded-full bg-byt-blue/60"></div>
                                    <div class="h-2 w-3/4 rounded-full bg-byt-line"></div>
                                    <div class="h-2 rounded-full bg-byt-blue/40"></div>
                                    <div class="h-2 w-2/3 rounded-full bg-byt-line"></div>
                                    <div class="mt-auto h-6 rounded-lg bg-gradient-to-r from-byt-blue to-byt-navy"></div>
                                </div>
                            </div>
                        </div>

                        {{-- Badge SUNAT --}}
                        <div class="absolute -top-3 -right-3 z-30">
                            <span class="inline-flex items-center gap-2 bg-white border border-byt-line shadow-lg rounded-full px-3.5 py-2 text-[11px] font-byt font-extrabold text-byt-navy">
                                <span class="w-2 h-2 rounded-full bg-byt-blue animate-ping"></span>
                                SUNAT conectado
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
