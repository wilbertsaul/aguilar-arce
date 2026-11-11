@extends('layouts.app')

@section('title', 'Simulador de Facturación Electrónica | Aguilar & Arce')

@section('content')
@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
    $comboTexto = \App\Models\Setting::get('facturador_combo_texto', 'Pregunta por el combo Factura + Contabilidad mensual sin costo adicional de software.');
    $comboBadge = \App\Models\Setting::get('facturador_combo_badge', 'Ahorro 25%');
@endphp

<script type="application/json" id="facturador-data">{!! json_encode($facturadorConfig, JSON_UNESCAPED_UNICODE) !!}</script>

{{-- Hero del simulador --}}
<section class="relative overflow-hidden hero-gradient">
    <div class="absolute inset-0 pattern-dots opacity-40"></div>
    <div class="absolute -top-24 -left-24 w-96 h-96 bg-teal-accent/10 rounded-full blur-3xl"></div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter py-14 md:py-20">
        <a href="{{ route('home') }}#facturador" class="inline-flex items-center gap-2 text-white/60 hover:text-white transition-colors text-sm mb-6">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Volver al inicio
        </a>
        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
            <div class="max-w-2xl">
                <div class="inline-flex items-center gap-2 mb-5">
                    <span class="badge-sunat">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        SUNAT Conectado
                    </span>
                </div>
                <h1 class="font-title font-bold text-3xl sm:text-4xl lg:text-5xl text-white leading-[1.15] tracking-tight">
                    Simulador de <span class="text-teal-bright">Facturación Electrónica</span>
                </h1>
                <p class="text-base sm:text-lg text-white/75 mt-4 leading-relaxed">
                    Recorra el mismo flujo de nuestro facturador: elija el comprobante, registre el cliente, agregue servicios y vea cómo se calcula el IGV automáticamente.
                </p>
                <div class="flex flex-wrap items-center gap-x-6 gap-y-2.5 pt-5 text-white/60 text-xs">
                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-teal-accent">bolt</span> Emisión en segundos</span>
                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-teal-accent">calculate</span> IGV 18% automático</span>
                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px] text-teal-accent">devices</span> Multiempresa</span>
                </div>
            </div>
            <div class="bg-white/10 border border-amber-accent/40 rounded-2xl px-5 py-4 backdrop-blur-sm max-w-sm">
                <p class="text-[11px] font-title font-bold uppercase tracking-wider text-amber-accent flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">warning</span>
                    Simulación — Sin valor tributario
                </p>
                <p class="text-xs text-white/70 mt-1.5 leading-relaxed">
                    Esta herramienta es una demostración del flujo. No emite comprobantes reales ni se conecta a SUNAT.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Aplicación del simulador --}}
<section class="py-12 md:py-16 bg-surface-variant min-h-[60vh]">
    <div class="max-w-4xl mx-auto px-gutter">

        {{-- Stepper --}}
        <div id="facturador-app" class="bg-white rounded-2xl border border-outline-variant shadow-lg overflow-hidden">
            <div class="px-6 sm:px-10 pt-8 pb-6 border-b border-outline-variant/60">
                <div class="flex items-center justify-between gap-1 sm:gap-2 overflow-x-auto pb-2 -mb-2" id="stepper">
                    <div class="stepper-step active" data-step="1">
                        <span class="stepper-dot">1</span>
                        <span class="hidden sm:inline text-xs font-title font-semibold whitespace-nowrap">Comprobante</span>
                    </div>
                    <div class="stepper-step" data-step="2">
                        <span class="stepper-dot">2</span>
                        <span class="hidden sm:inline text-xs font-title font-semibold whitespace-nowrap">Cliente</span>
                    </div>
                    <div class="stepper-step" data-step="3">
                        <span class="stepper-dot">3</span>
                        <span class="hidden sm:inline text-xs font-title font-semibold whitespace-nowrap">Servicios</span>
                    </div>
                    <div class="stepper-step" data-step="4">
                        <span class="stepper-dot">4</span>
                        <span class="hidden sm:inline text-xs font-title font-semibold whitespace-nowrap">Condiciones</span>
                    </div>
                    <div class="stepper-step" data-step="5">
                        <span class="stepper-dot">5</span>
                        <span class="hidden sm:inline text-xs font-title font-semibold whitespace-nowrap">Vista previa</span>
                    </div>
                </div>
            </div>

            {{-- PASO 1: Tipo de comprobante --}}
            <div class="panel p-6 sm:p-10" data-panel="1">
                <h2 class="font-title font-bold text-xl text-navy">¿Qué comprobante va a emitir?</h2>
                <p class="text-sm text-on-surface-variant mt-1 mb-8">Elija el tipo de documento electrónico que necesita generar.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <button type="button" class="tipo-card text-left p-6 rounded-2xl border-2 border-outline-variant bg-surface-variant/50 hover:border-teal-accent transition-all" data-tipo="B">
                        <div class="flex items-start justify-between mb-3">
                            <span class="material-symbols-outlined text-[32px] text-navy">receipt</span>
                            <span class="font-mono text-xs font-bold bg-navy text-teal-bright px-2.5 py-1 rounded">B001</span>
                        </div>
                        <h3 class="font-title font-bold text-navy text-lg">Boleta de Venta</h3>
                        <p class="text-[13px] text-on-surface-variant mt-2 leading-relaxed">Para consumidores finales. El DNI es opcional en ventas menores a S/ 700.</p>
                        <span class="tipo-card-check mt-4 hidden items-center gap-1.5 text-teal-deep text-xs font-title font-bold">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span> Seleccionado
                        </span>
                    </button>

                    <button type="button" class="tipo-card text-left p-6 rounded-2xl border-2 border-outline-variant bg-surface-variant/50 hover:border-teal-accent transition-all" data-tipo="F">
                        <div class="flex items-start justify-between mb-3">
                            <span class="material-symbols-outlined text-[32px] text-navy">description</span>
                            <span class="font-mono text-xs font-bold bg-navy text-teal-bright px-2.5 py-1 rounded">F001</span>
                        </div>
                        <h3 class="font-title font-bold text-navy text-lg">Factura</h3>
                        <p class="text-[13px] text-on-surface-variant mt-2 leading-relaxed">Requiere el RUC del cliente (11 dígitos). Sustenta el crédito fiscal del IGV.</p>
                        <span class="tipo-card-check mt-4 hidden items-center gap-1.5 text-teal-deep text-xs font-title font-bold">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span> Seleccionado
                        </span>
                    </button>
                </div>
            </div>

            {{-- PASO 2: Cliente --}}
            <div class="panel hidden p-6 sm:p-10" data-panel="2">
                <h2 class="font-title font-bold text-xl text-navy">Datos del cliente</h2>
                <p class="text-sm text-on-surface-variant mt-1 mb-8">
                    Ingrese el documento: <strong>RUC</strong> (11 dígitos) o <strong>DNI</strong> (8 dígitos). Pruebe los RUC de demostración: <span class="font-mono text-xs">20512345678</span> · <span class="font-mono text-xs">20487654321</span>.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="cliente-doc" class="block text-xs font-semibold text-navy mb-1.5">
                            Documento <span id="cliente-tipo-label" class="text-teal-deep font-bold">(DNI o RUC)</span>
                        </label>
                        <input type="text" id="cliente-doc" inputmode="numeric" maxlength="11"
                               class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 text-sm font-mono text-navy focus:border-teal-accent focus:ring-1 focus:ring-teal-accent outline-none transition-colors"
                               placeholder="Ej: 20512345678">
                        <p class="text-error text-xs mt-1.5 hidden" id="cliente-doc-error"></p>
                    </div>
                    <div class="flex items-end">
                        <button type="button" id="btn-consumidor-final" class="btn-outline !py-2.5 w-full sm:w-auto">
                            <span class="material-symbols-outlined text-[17px] text-teal-deep">person</span>
                            Usar CONSUMIDOR FINAL
                        </button>
                    </div>
                    <div>
                        <label for="cliente-nombre" class="block text-xs font-semibold text-navy mb-1.5">Nombre / Razón Social</label>
                        <input type="text" id="cliente-nombre"
                               class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 text-sm text-navy focus:border-teal-accent focus:ring-1 focus:ring-teal-accent outline-none transition-colors uppercase"
                               placeholder="Se autocompleta con el documento">
                        <p class="text-error text-xs mt-1.5 hidden" id="cliente-nombre-error"></p>
                    </div>
                    <div>
                        <label for="cliente-direccion" class="block text-xs font-semibold text-navy mb-1.5">Dirección <span class="text-grey-metallic font-normal">(opcional)</span></label>
                        <input type="text" id="cliente-direccion"
                               class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 text-sm text-navy focus:border-teal-accent focus:ring-1 focus:ring-teal-accent outline-none transition-colors"
                               placeholder="Se autocompleta con el documento">
                    </div>
                </div>

                <div class="mt-6 bg-teal-container border border-teal-accent/30 rounded-xl p-4 flex items-start gap-3">
                    <span class="material-symbols-outlined text-[20px] text-teal-deep mt-0.5">lightbulb</span>
                    <p class="text-xs text-on-surface-variant leading-relaxed">
                        Al emitir una <strong class="text-navy">factura</strong>, nuestro facturador consulta la razón social en los
                        padrones de SUNAT y la completa automáticamente, igual que en esta simulación.
                    </p>
                </div>
            </div>

            {{-- PASO 3: Servicios / items --}}
            <div class="panel hidden p-6 sm:p-10" data-panel="3">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-8">
                    <div>
                        <h2 class="font-title font-bold text-xl text-navy">Servicios a facturar</h2>
                        <p class="text-sm text-on-surface-variant mt-1">Agregue líneas de servicio. El IGV (18%) se calcula automáticamente.</p>
                    </div>
                    <button type="button" id="btn-add-item" class="btn-teal !px-4 !py-2 !text-[12px]">
                        <span class="material-symbols-outlined text-[17px]">add</span>
                        Agregar servicio
                    </button>
                </div>

                <div class="overflow-x-auto -mx-2 px-2">
                    <table class="w-full text-sm min-w-[560px]">
                        <thead>
                            <tr class="text-left text-[11px] font-title font-bold uppercase tracking-wider text-on-surface-variant border-b-2 border-outline-variant">
                                <th class="py-3 pr-2 w-20">Cant.</th>
                                <th class="py-3 pr-2">Descripción</th>
                                <th class="py-3 pr-2 w-32 text-right">P. Unitario</th>
                                <th class="py-3 pr-2 w-32 text-right">Total</th>
                                <th class="py-3 w-10"></th>
                            </tr>
                        </thead>
                        <tbody id="items-body"></tbody>
                    </table>
                    <p class="text-error text-xs mt-3 hidden" id="items-error"></p>
                </div>

                <div class="mt-8 ml-auto max-w-xs bg-surface-variant border border-outline-variant rounded-xl p-5 space-y-2.5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface-variant">Op. Gravadas</span>
                        <span class="font-mono font-bold text-navy" id="tot-op-gravadas">S/ 0.00</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-on-surface-variant">IGV (18%)</span>
                        <span class="font-mono font-bold text-navy" id="tot-igv">S/ 0.00</span>
                    </div>
                    <div class="flex items-center justify-between text-base pt-2.5 border-t border-dashed border-outline-variant">
                        <span class="font-title font-bold text-navy">TOTAL</span>
                        <span class="font-mono font-bold text-teal-deep text-lg" id="tot-total">S/ 0.00</span>
                    </div>
                </div>
            </div>

            {{-- PASO 4: Condiciones --}}
            <div class="panel hidden p-6 sm:p-10" data-panel="4">
                <h2 class="font-title font-bold text-xl text-navy">Condiciones del comprobante</h2>
                <p class="text-sm text-on-surface-variant mt-1 mb-8">Defina moneda, forma de pago y observaciones.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-semibold text-navy mb-2.5">Moneda</label>
                        <div class="flex gap-3">
                            <button type="button" class="toggle-pill moneda-toggle active" data-moneda="PEN">
                                <span class="font-mono font-bold">S/</span> Soles
                            </button>
                            <button type="button" class="toggle-pill moneda-toggle" data-moneda="USD">
                                <span class="font-mono font-bold">$</span> Dólares
                            </button>
                        </div>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-navy mb-2.5">Condición de pago</label>
                        <div class="flex gap-3">
                            <button type="button" class="toggle-pill forma-pago-toggle active" data-forma="contado">Contado</button>
                            <button type="button" class="toggle-pill forma-pago-toggle" data-forma="credito">Crédito</button>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label for="observaciones" class="block text-xs font-semibold text-navy mb-2.5">Observaciones <span class="text-grey-metallic font-normal">(opcional)</span></label>
                        <textarea id="observaciones" rows="3"
                                  class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 text-sm text-navy focus:border-teal-accent focus:ring-1 focus:ring-teal-accent outline-none transition-colors resize-none"
                                  placeholder="Ej: Según contrato de servicios N° 004-2026"></textarea>
                    </div>
                </div>
            </div>

            {{-- PASO 5: Vista previa --}}
            <div class="panel hidden p-6 sm:p-10" data-panel="5">
                <h2 class="font-title font-bold text-xl text-navy">Vista previa del comprobante</h2>
                <p class="text-sm text-on-surface-variant mt-1 mb-8">Así se verá su comprobante electrónico antes de enviarlo a SUNAT.</p>

                <div class="max-w-2xl mx-auto" id="invoice-preview-container">
                    <div class="invoice-preview" id="invoice-preview"></div>
                </div>

                <div class="mt-8 flex flex-col items-center gap-4">
                    <button type="button" id="btn-emitir" class="btn-teal !px-10 !py-4 !text-base">
                        <span class="material-symbols-outlined text-[20px]">send</span>
                        <span id="btn-emitir-text">Emitir comprobante (simulado)</span>
                    </button>
                    <p class="text-[11px] text-grey-metallic flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">info</span>
                        Simulación local: no se envía nada a SUNAT ni se guardan datos.
                    </p>
                </div>

                {{-- Resultado de la emisión --}}
                <div id="emision-result" class="hidden mt-10 max-w-xl mx-auto bg-teal-container border border-teal-accent/40 rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-success-green/15 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[36px] text-success-green">check_circle</span>
                    </div>
                    <span class="badge-sunat mb-4 mx-auto w-fit">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        ACEPTADO POR SUNAT
                    </span>
                    <h3 class="font-title font-bold text-lg text-navy">Comprobante emitido correctamente</h3>
                    <p class="text-sm text-on-surface-variant mt-1.5">Simulación completada. Así de simple es emitir con nuestro facturador.</p>

                    <div class="bg-white border border-outline-variant rounded-xl p-4 mt-6 text-left font-mono text-xs text-navy space-y-1.5">
                        <p class="flex justify-between"><span class="text-grey-metallic">NÚMERO:</span> <span class="font-bold" id="res-numero"></span></p>
                        <p class="flex justify-between"><span class="text-grey-metallic">FECHA:</span> <span id="res-fecha"></span></p>
                        <p class="flex justify-between gap-4"><span class="text-grey-metallic">HASH:</span> <span class="truncate" id="res-hash"></span></p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-6">
                        <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20prob%C3%A9%20el%20simulador%20del%20facturador%20y%20quiero%20informaci%C3%B3n%20del%20combo%20Factura%20%2B%20Contabilidad" target="_blank" rel="noopener noreferrer" class="btn-whatsapp w-full sm:w-auto">
                            <span class="material-symbols-outlined text-[17px]">chat</span>
                            Solicitar el facturador real
                        </a>
                        <button type="button" id="btn-reiniciar" class="btn-outline w-full sm:w-auto">
                            <span class="material-symbols-outlined text-[17px] text-teal-deep">restart_alt</span>
                            Nueva simulación
                        </button>
                    </div>
                </div>
            </div>

            {{-- Barra de navegación del stepper --}}
            <div class="px-6 sm:px-10 py-6 border-t border-outline-variant/60 bg-surface-variant/50 flex items-center justify-between">
                <button type="button" id="btn-prev" class="btn-outline !py-2.5 invisible">
                    <span class="material-symbols-outlined text-[17px]">arrow_back</span>
                    Atrás
                </button>
                <span class="text-[11px] text-grey-metallic font-semibold font-title uppercase tracking-wider" id="step-indicator">Paso 1 de 5</span>
                <button type="button" id="btn-next" class="btn-teal !py-2.5">
                    Continuar
                    <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                </button>
            </div>
        </div>

        {{-- CTA final: combo --}}
        <div class="mt-10 p-5 bg-white border border-teal-accent/40 rounded-2xl shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-navy flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[24px] text-teal-bright">savings</span>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-title font-bold text-sm uppercase tracking-wide text-navy">Plan Integrado Especial</span>
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
    </div>
</section>

@push('scripts')
    @vite('resources/js/facturador.js')
@endpush
@endsection
