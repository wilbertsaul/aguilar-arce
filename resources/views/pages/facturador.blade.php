@extends('layouts.app')

@section('title', 'BYTFACT · Simulador de facturación electrónica')
@section('meta_description', 'Simulador gratuito de facturación electrónica: DNI y RUC reales, IGV, vista previa del comprobante y CDR. Sin valor tributario.')

@section('content')
@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
    $comboTexto = \App\Models\Setting::get('facturador_combo_texto', 'Pregunta por el combo Factura + Contabilidad mensual sin costo adicional de software.');
    $comboBadge = \App\Models\Setting::get('facturador_combo_badge', 'Ahorro 25%');
@endphp

<script type="application/json" id="facturador-data">{!! json_encode($facturadorConfig, JSON_UNESCAPED_UNICODE) !!}</script>

{{-- Hero --}}
<section class="relative overflow-hidden byt-gradient">
    <div class="absolute inset-0 pattern-dots opacity-30"></div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter py-12 md:py-16">
        <a href="{{ route('home') }}#facturador" class="inline-flex items-center gap-2 text-white/60 hover:text-white transition-colors text-sm mb-6 font-byt">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Volver al inicio
        </a>

        <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-8">
            <div class="max-w-2xl byt-surface">
                <img src="{{ asset('images/bytfact/bytfact-logo-blanco.png') }}" alt="BYTFACT" class="h-9 md:h-11 w-auto mb-6">

                <div class="flex flex-wrap items-center gap-2 mb-4">
                    <span class="byt-badge-demo">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        Modo demostración
                    </span>
                    <span class="byt-badge-demo !bg-white/10 !text-white !border-white/25">Consulta DNI/RUC real</span>
                </div>

                <h1 class="font-byt font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white leading-[1.1] tracking-tight">
                    Factura fácil.<br>Crece con respaldo.
                </h1>
                <p class="text-base sm:text-lg text-white/75 mt-4 leading-relaxed font-byt">
                    Recorre el mismo flujo del sistema: revisa los requisitos, configura el ambiente, consulta el DNI o RUC
                    del cliente y emite un comprobante de prueba.
                </p>

                <div class="flex flex-wrap items-center gap-x-5 gap-y-2.5 pt-5 text-white/65 text-xs font-byt">
                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">badge</span> RENIEC y SUNAT en línea</span>
                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">calculate</span> IGV 18% automático</span>
                    <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">verified_user</span> XML + CDR simulados</span>
                </div>
            </div>

            <div class="bg-white/10 border border-white/25 rounded-2xl px-5 py-4 backdrop-blur-sm max-w-sm">
                <p class="text-[11px] font-byt font-extrabold uppercase tracking-wider text-white flex items-center gap-1.5">
                    <span class="material-symbols-outlined text-[16px]">warning</span>
                    Simulación — sin valor tributario
                </p>
                <p class="text-xs text-white/70 mt-1.5 leading-relaxed font-byt">
                    La emisión es una demostración: no se envía nada a SUNAT. Solo la consulta de DNI/RUC usa datos reales,
                    con cupo limitado por visitante.
                </p>
            </div>
        </div>
    </div>
</section>

{{-- Aplicación --}}
<section class="py-10 md:py-14 bg-byt-mist min-h-[60vh]">
    <div class="max-w-4xl mx-auto px-gutter">

        <div id="facturador-app" class="byt-surface bg-white rounded-2xl border border-byt-line shadow-xl overflow-hidden">

            {{-- Stepper --}}
            <div class="px-5 sm:px-8 pt-7 pb-5 border-b border-byt-line/70">
                <div class="flex items-center justify-between gap-2 sm:gap-3 overflow-x-auto pb-1" id="stepper">
                    <div class="stepper-step active" data-step="1">
                        <span class="stepper-dot">1</span>
                        <span class="hidden md:inline text-[11px] font-byt font-bold whitespace-nowrap">Requisitos</span>
                    </div>
                    <div class="stepper-step" data-step="2">
                        <span class="stepper-dot">2</span>
                        <span class="hidden md:inline text-[11px] font-byt font-bold whitespace-nowrap">Configuración</span>
                    </div>
                    <div class="stepper-step" data-step="3">
                        <span class="stepper-dot">3</span>
                        <span class="hidden md:inline text-[11px] font-byt font-bold whitespace-nowrap">Comprobante</span>
                    </div>
                    <div class="stepper-step" data-step="4">
                        <span class="stepper-dot">4</span>
                        <span class="hidden md:inline text-[11px] font-byt font-bold whitespace-nowrap">Cliente</span>
                    </div>
                    <div class="stepper-step" data-step="5">
                        <span class="stepper-dot">5</span>
                        <span class="hidden md:inline text-[11px] font-byt font-bold whitespace-nowrap">Servicios</span>
                    </div>
                    <div class="stepper-step" data-step="6">
                        <span class="stepper-dot">6</span>
                        <span class="hidden md:inline text-[11px] font-byt font-bold whitespace-nowrap">Condiciones</span>
                    </div>
                    <div class="stepper-step" data-step="7">
                        <span class="stepper-dot">7</span>
                        <span class="hidden md:inline text-[11px] font-byt font-bold whitespace-nowrap">Vista previa</span>
                    </div>
                </div>
            </div>

            {{-- PASO 1: Requisitos --}}
            <div class="panel p-6 sm:p-9" data-panel="1">
                <h2 class="font-byt font-extrabold text-xl text-byt-navy">Lo que tu empresa necesita para facturar electrónicamente</h2>
                <p class="text-sm text-byt-grey mt-1 mb-7">
                    Antes de emitir el primer comprobante, SUNAT exige estos cuatro elementos. En el sistema real,
                    BYTFACT los configura contigo; aquí los revisamos y luego simulamos la conexión.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="byt-requisito">
                        <span class="byt-requisito-icono"><span class="material-symbols-outlined text-[22px]">domain_verification</span></span>
                        <div>
                            <h3 class="font-byt font-extrabold text-sm text-byt-navy">RUC habilitado y activo</h3>
                            <p class="text-[12.5px] text-byt-grey mt-1 leading-relaxed">El RUC debe estar <strong class="text-byt-navy">ACTIVO</strong> y <strong class="text-byt-navy">HABIDO</strong> en SUNAT, con régimen tributario y actividad económica definidos.</p>
                        </div>
                    </div>
                    <div class="byt-requisito">
                        <span class="byt-requisito-icono"><span class="material-symbols-outlined text-[22px]">key</span></span>
                        <div>
                            <h3 class="font-byt font-extrabold text-sm text-byt-navy">Usuario SOL secundario</h3>
                            <p class="text-[12.5px] text-byt-grey mt-1 leading-relaxed">Un usuario con perfil de facturación electrónica. No se usa la Clave SOL del titular: SUNAT exige un usuario aparte para el sistema.</p>
                        </div>
                    </div>
                    <div class="byt-requisito">
                        <span class="byt-requisito-icono"><span class="material-symbols-outlined text-[22px]">workspace_premium</span></span>
                        <div>
                            <h3 class="font-byt font-extrabold text-sm text-byt-navy">Certificado digital</h3>
                            <p class="text-[12.5px] text-byt-grey mt-1 leading-relaxed">Archivo <span class="font-mono text-[11px]">.pfx</span> vigente de una entidad acreditada, con su contraseña. Es lo que firma cada comprobante.</p>
                        </div>
                    </div>
                    <div class="byt-requisito">
                        <span class="byt-requisito-icono"><span class="material-symbols-outlined text-[22px]">fact_check</span></span>
                        <div>
                            <h3 class="font-byt font-extrabold text-sm text-byt-navy">Homologación y series</h3>
                            <p class="text-[12.5px] text-byt-grey mt-1 leading-relaxed">Pruebas aprobadas en beta y series autorizadas en producción (<span class="font-mono text-[11px]">F001</span>, <span class="font-mono text-[11px]">B001</span>), además de ubigeo y catálogos SUNAT.</p>
                        </div>
                    </div>
                </div>

                <div class="mt-6 bg-byt-blue-soft border border-byt-blue/25 rounded-xl p-4 flex items-start gap-3">
                    <span class="material-symbols-outlined text-[20px] text-byt-blue mt-0.5">info</span>
                    <p class="text-xs text-byt-grey leading-relaxed">
                        <strong class="text-byt-navy">Tiempo real de implementación:</strong> entre 3 y 10 días hábiles si el RUC y el certificado están listos.
                        Si aún no tienes certificado, se tramita con una entidad acreditada (Llama.pe, DigiFlow, Camerfirma, entre otras).
                    </p>
                </div>
            </div>

            {{-- PASO 2: Configuración simulada --}}
            <div class="panel hidden p-6 sm:p-9" data-panel="2">
                <h2 class="font-byt font-extrabold text-xl text-byt-navy">Configuración del ambiente</h2>
                <p class="text-sm text-byt-grey mt-1 mb-7">Simulación de la puesta en marcha. Puedes probar la conexión con datos de ejemplo.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="byt-label" for="cfg-ruc">RUC de la empresa</label>
                        <input id="cfg-ruc" class="byt-input font-mono" value="{{ $facturadorConfig['emisor']['ruc'] }}" maxlength="11" inputmode="numeric">
                    </div>
                    <div>
                        <label class="byt-label" for="cfg-razon">Razón social</label>
                        <input id="cfg-razon" class="byt-input" value="{{ $facturadorConfig['emisor']['razonSocial'] }}">
                    </div>
                    <div>
                        <label class="byt-label">Ambiente SUNAT</label>
                        <div class="flex gap-2.5">
                            <button type="button" class="ambiente-toggle toggle-pill active" data-ambiente="beta">Beta · homologación</button>
                            <button type="button" class="ambiente-toggle toggle-pill" data-ambiente="produccion">Producción</button>
                        </div>
                    </div>
                    <div>
                        <label class="byt-label">Series autorizadas</label>
                        <div class="flex gap-2.5">
                            <input class="byt-input font-mono text-center" value="F001" maxlength="4" aria-label="Serie de factura">
                            <input class="byt-input font-mono text-center" value="B001" maxlength="4" aria-label="Serie de boleta">
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="byt-label" for="cfg-cert">Certificado digital (.pfx)</label>
                        <div class="flex flex-col sm:flex-row gap-2.5">
                            <input id="cfg-cert" type="file" accept=".pfx,.p12" class="byt-input !py-2 text-xs file:mr-3 file:rounded-md file:border-0 file:bg-byt-blue-soft file:px-3 file:py-1.5 file:text-[11px] file:font-bold file:text-byt-navy">
                            <input id="cfg-cert-pass" type="password" class="byt-input sm:max-w-[220px]" placeholder="Contraseña del certificado">
                        </div>
                        <p class="text-[11px] text-byt-grey mt-1.5">En la demo no se sube ningún archivo: se valida en el navegador.</p>
                    </div>
                    <div>
                        <label class="byt-label" for="cfg-sol-user">Usuario SOL secundario</label>
                        <input id="cfg-sol-user" class="byt-input" value="BYTFACTDEMO" autocomplete="off">
                    </div>
                    <div>
                        <label class="byt-label" for="cfg-sol-pass">Clave SOL</label>
                        <input id="cfg-sol-pass" type="password" class="byt-input" value="demo1234" autocomplete="new-password">
                    </div>
                </div>

                <div class="mt-5 flex flex-col sm:flex-row sm:items-center gap-3">
                    <button type="button" id="btn-probar" class="btn-byt">
                        <span class="material-symbols-outlined text-[18px]">bolt</span>
                        Probar conexión con SUNAT
                    </button>
                    <span id="conexion-estado" class="text-xs text-byt-grey"></span>
                </div>

                <div id="conexion-log" class="byt-log mt-4 hidden"></div>

                <div id="config-warning" class="hidden mt-4 bg-byt-mist border border-byt-line rounded-xl p-4 text-xs text-byt-grey">
                    Todavía no probaste la conexión.
                    <button type="button" id="btn-continuar-demo" class="font-byt font-extrabold text-byt-blue underline underline-offset-2">Continuar en modo demo</button>
                    o pulsa “Probar conexión” para ver el handshake simulado.
                </div>
            </div>

            {{-- PASO 3: Tipo de comprobante --}}
            <div class="panel hidden p-6 sm:p-9" data-panel="3">
                <h2 class="font-byt font-extrabold text-xl text-byt-navy">¿Qué comprobante vas a emitir?</h2>
                <p class="text-sm text-byt-grey mt-1 mb-7">El tipo de documento determina los datos del cliente y la serie.</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <button type="button" class="tipo-card text-left p-6 rounded-2xl border-2 border-byt-line bg-byt-mist/60 hover:border-byt-blue transition-all" data-tipo="B">
                        <div class="flex items-start justify-between mb-3">
                            <span class="material-symbols-outlined text-[32px] text-byt-navy">receipt</span>
                            <span class="font-mono text-xs font-bold bg-byt-navy text-white px-2.5 py-1 rounded">B001</span>
                        </div>
                        <h3 class="font-byt font-extrabold text-byt-navy text-lg">Boleta de venta</h3>
                        <p class="text-[13px] text-byt-grey mt-2 leading-relaxed">Para consumidores finales. El DNI es opcional en ventas menores a S/ 700.</p>
                        <span class="tipo-card-check mt-4 hidden items-center gap-1.5 text-byt-blue text-xs font-byt font-extrabold">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span> Seleccionado
                        </span>
                    </button>

                    <button type="button" class="tipo-card text-left p-6 rounded-2xl border-2 border-byt-line bg-byt-mist/60 hover:border-byt-blue transition-all" data-tipo="F">
                        <div class="flex items-start justify-between mb-3">
                            <span class="material-symbols-outlined text-[32px] text-byt-navy">description</span>
                            <span class="font-mono text-xs font-bold bg-byt-navy text-white px-2.5 py-1 rounded">F001</span>
                        </div>
                        <h3 class="font-byt font-extrabold text-byt-navy text-lg">Factura</h3>
                        <p class="text-[13px] text-byt-grey mt-2 leading-relaxed">Requiere RUC del cliente (11 dígitos). Sustenta el crédito fiscal del IGV.</p>
                        <span class="tipo-card-check mt-4 hidden items-center gap-1.5 text-byt-blue text-xs font-byt font-extrabold">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span> Seleccionado
                        </span>
                    </button>
                </div>
            </div>

            {{-- PASO 4: Cliente --}}
            <div class="panel hidden p-6 sm:p-9" data-panel="4">
                <h2 class="font-byt font-extrabold text-xl text-byt-navy">Datos del cliente</h2>
                <p class="text-sm text-byt-grey mt-1 mb-7">
                    Escribe el <strong class="text-byt-navy">DNI</strong> (8 dígitos) o <strong class="text-byt-navy">RUC</strong> (11 dígitos) y consulta el padrón.
                    Es la misma consulta que hace el sistema real.
                </p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="byt-label" for="cliente-doc">Documento <span id="cliente-tipo-label" class="text-byt-blue">(DNI o RUC)</span></label>
                        <div class="flex flex-col sm:flex-row gap-2.5">
                            <input type="text" id="cliente-doc" inputmode="numeric" maxlength="11" autocomplete="off"
                                   class="byt-input font-mono tracking-wider" placeholder="Ej: 20512345678">
                            <button type="button" id="btn-consultar" class="btn-byt shrink-0">
                                <span class="material-symbols-outlined text-[18px]">search</span>
                                Consultar
                            </button>
                        </div>
                        <div class="flex flex-wrap items-center gap-2 mt-2.5">
                            <span id="consulta-pill" class="hidden"></span>
                            <span id="consulta-cupo" class="text-[11px] text-byt-grey"></span>
                        </div>
                        <p class="text-error text-xs mt-1.5 hidden" id="cliente-doc-error"></p>
                    </div>

                    <div>
                        <label class="byt-label" for="cliente-nombre">Nombre / Razón social</label>
                        <input type="text" id="cliente-nombre" class="byt-input uppercase" placeholder="Se completa con la consulta">
                        <p class="text-error text-xs mt-1.5 hidden" id="cliente-nombre-error"></p>
                    </div>
                    <div>
                        <label class="byt-label" for="cliente-direccion">Dirección <span class="text-byt-grey/70 normal-case font-semibold">(opcional)</span></label>
                        <input type="text" id="cliente-direccion" class="byt-input" placeholder="Se completa con la consulta">
                    </div>
                </div>

                <div class="mt-4 flex flex-wrap items-center gap-2.5">
                    <button type="button" id="btn-consumidor-final" class="btn-byt-outline !py-2 !px-4 !text-[12px]">
                        <span class="material-symbols-outlined text-[17px] text-byt-blue">person</span>
                        Usar consumidor final
                    </button>
                    <button type="button" id="btn-cliente-demo" class="btn-byt-outline !py-2 !px-4 !text-[12px]">
                        <span class="material-symbols-outlined text-[17px] text-byt-blue">science</span>
                        Cargar datos de ejemplo
                    </button>
                </div>

                <div class="mt-6 bg-byt-mist border border-byt-line rounded-xl p-4 flex items-start gap-3">
                    <span class="material-symbols-outlined text-[20px] text-byt-blue mt-0.5">lightbulb</span>
                    <p class="text-xs text-byt-grey leading-relaxed">
                        La consulta va a RENIEC (DNI) o SUNAT (RUC) a través de JSON.PE. Tienes
                        <strong class="text-byt-navy">{{ $facturadorConfig['consulta']['limitePorIp'] }} consultas reales por día</strong>;
                        si el documento ya fue consultado antes, se sirve desde la caché sin gastar cupo.
                        No guardamos el número consultado.
                    </p>
                </div>
            </div>

            {{-- PASO 5: Servicios --}}
            <div class="panel hidden p-6 sm:p-9" data-panel="5">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-2 mb-7">
                    <div>
                        <h2 class="font-byt font-extrabold text-xl text-byt-navy">Servicios a facturar</h2>
                        <p class="text-sm text-byt-grey mt-1">Cada línea incluye IGV. El subtotal se calcula hacia atrás (total / 1.18).</p>
                    </div>
                    <button type="button" id="btn-add-item" class="btn-byt !px-4 !py-2 !text-[12px]">
                        <span class="material-symbols-outlined text-[17px]">add</span>
                        Agregar servicio
                    </button>
                </div>

                <div class="overflow-x-auto -mx-2 px-2">
                    <table class="w-full text-sm min-w-[560px]">
                        <thead>
                            <tr class="text-left text-[11px] font-byt font-extrabold uppercase tracking-wider text-byt-grey border-b-2 border-byt-line">
                                <th class="py-3 pr-2 w-20">Cant.</th>
                                <th class="py-3 pr-2">Descripción</th>
                                <th class="py-3 pr-2 w-32 text-right">P. unitario</th>
                                <th class="py-3 pr-2 w-32 text-right">Total</th>
                                <th class="py-3 w-10"></th>
                            </tr>
                        </thead>
                        <tbody id="items-body"></tbody>
                    </table>
                    <p class="text-error text-xs mt-3 hidden" id="items-error"></p>
                </div>

                <div class="mt-7 ml-auto max-w-xs bg-byt-mist border border-byt-line rounded-xl p-5 space-y-2.5">
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-byt-grey">Op. gravadas</span>
                        <span class="font-mono font-bold text-byt-navy" id="tot-op-gravadas">S/ 0.00</span>
                    </div>
                    <div class="flex items-center justify-between text-sm">
                        <span class="text-byt-grey">IGV (18%)</span>
                        <span class="font-mono font-bold text-byt-navy" id="tot-igv">S/ 0.00</span>
                    </div>
                    <div class="flex items-center justify-between text-base pt-2.5 border-t border-dashed border-byt-line">
                        <span class="font-byt font-extrabold text-byt-navy">TOTAL</span>
                        <span class="font-mono font-bold text-byt-blue text-lg" id="tot-total">S/ 0.00</span>
                    </div>
                </div>
            </div>

            {{-- PASO 6: Condiciones --}}
            <div class="panel hidden p-6 sm:p-9" data-panel="6">
                <h2 class="font-byt font-extrabold text-xl text-byt-navy">Condiciones del comprobante</h2>
                <p class="text-sm text-byt-grey mt-1 mb-7">Moneda, forma de pago y observaciones.</p>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="byt-label">Moneda</label>
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
                        <label class="byt-label">Condición de pago</label>
                        <div class="flex gap-3">
                            <button type="button" class="toggle-pill forma-pago-toggle active" data-forma="contado">Contado</button>
                            <button type="button" class="toggle-pill forma-pago-toggle" data-forma="credito">Crédito</button>
                        </div>
                    </div>
                    <div class="md:col-span-2">
                        <label class="byt-label" for="observaciones">Observaciones <span class="text-byt-grey/70 normal-case font-semibold">(opcional)</span></label>
                        <textarea id="observaciones" rows="3"
                                  class="byt-input resize-none"
                                  placeholder="Ej: Según contrato de servicios N° 004-2026"></textarea>
                    </div>
                </div>
            </div>

            {{-- PASO 7: Vista previa --}}
            <div class="panel hidden p-6 sm:p-9" data-panel="7">
                <h2 class="font-byt font-extrabold text-xl text-byt-navy">Vista previa del comprobante</h2>
                <p class="text-sm text-byt-grey mt-1 mb-7">Así se verá antes de enviarlo a SUNAT. Todo es simulado.</p>

                <div class="max-w-2xl mx-auto" id="invoice-preview-container">
                    <div class="invoice-preview" id="invoice-preview"></div>
                </div>

                <div class="mt-7 flex flex-col items-center gap-3">
                    <button type="button" id="btn-emitir" class="btn-byt !px-10 !py-4 !text-base">
                        <span class="material-symbols-outlined text-[20px]">send</span>
                        <span id="btn-emitir-text">Emitir comprobante (simulado)</span>
                    </button>
                    <p class="text-[11px] text-byt-grey flex items-center gap-1.5">
                        <span class="material-symbols-outlined text-[14px]">info</span>
                        No se envía nada a SUNAT ni se guardan datos del comprobante.
                    </p>
                </div>

                <div id="emision-result" class="hidden mt-9 max-w-xl mx-auto bg-byt-blue-soft border border-byt-blue/30 rounded-2xl p-8 text-center">
                    <div class="w-16 h-16 mx-auto mb-4 rounded-full bg-byt-blue/10 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[36px] text-byt-blue">check_circle</span>
                    </div>
                    <span class="inline-flex items-center gap-2 bg-byt-blue text-white text-[11px] font-byt font-extrabold px-3 py-1.5 rounded-full">
                        <span class="w-2 h-2 rounded-full bg-white animate-ping"></span>
                        ACEPTADO POR SUNAT (SIMULADO)
                    </span>
                    <h3 class="font-byt font-extrabold text-lg text-byt-navy mt-4">Comprobante emitido correctamente</h3>
                    <p class="text-sm text-byt-grey mt-1.5">Simulación completada: así de simple es emitir con BYTFACT.</p>

                    <div class="bg-white border border-byt-line rounded-xl p-4 mt-6 text-left font-mono text-xs text-byt-navy space-y-1.5">
                        <p class="flex justify-between gap-3"><span class="text-byt-grey">NÚMERO:</span> <span class="font-bold" id="res-numero"></span></p>
                        <p class="flex justify-between gap-3"><span class="text-byt-grey">FECHA:</span> <span id="res-fecha"></span></p>
                        <p class="flex justify-between gap-3"><span class="text-byt-grey">CDR:</span> <span id="res-cdr">0 · El comprobante ha sido aceptado</span></p>
                        <p class="flex justify-between gap-3"><span class="text-byt-grey">HASH:</span> <span class="truncate" id="res-hash"></span></p>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-3 mt-6">
                        <a href="https://wa.me/{{ $whatsapp }}?text=Hola,%20prob%C3%A9%20el%20simulador%20de%20BYTFACT%20y%20quiero%20implementarlo%20en%20mi%20empresa" target="_blank" rel="noopener noreferrer" class="btn-byt w-full sm:w-auto">
                            <span class="material-symbols-outlined text-[17px]">chat</span>
                            Solicitar el facturador real
                        </a>
                        <button type="button" id="btn-reiniciar" class="btn-byt-outline w-full sm:w-auto">
                            <span class="material-symbols-outlined text-[17px] text-byt-blue">restart_alt</span>
                            Nueva simulación
                        </button>
                    </div>
                </div>
            </div>

            {{-- Navegación --}}
            <div class="px-5 sm:px-8 py-5 border-t border-byt-line/70 bg-byt-mist/70 flex items-center justify-between">
                <button type="button" id="btn-prev" class="btn-byt-outline !py-2.5 invisible">
                    <span class="material-symbols-outlined text-[17px] text-byt-blue">arrow_back</span>
                    Atrás
                </button>
                <span class="text-[11px] text-byt-grey font-bold font-byt uppercase tracking-wider" id="step-indicator">Paso 1 de 7</span>
                <button type="button" id="btn-next" class="btn-byt !py-2.5">
                    Continuar
                    <span class="material-symbols-outlined text-[17px]">arrow_forward</span>
                </button>
            </div>
        </div>

        {{-- CTA combo A&A --}}
        <div class="mt-9 p-5 bg-white border border-byt-line rounded-2xl shadow-sm flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-3.5">
                <div class="w-11 h-11 rounded-xl bg-byt-navy flex items-center justify-center shrink-0">
                    <span class="material-symbols-outlined text-[24px] text-white">savings</span>
                </div>
                <div>
                    <div class="flex items-center gap-2 flex-wrap">
                        <span class="font-byt font-extrabold text-sm uppercase tracking-wide text-byt-navy">Plan integrado</span>
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
    </div>
</section>

@push('scripts')
    @vite('resources/js/facturador.js')
@endpush
@endsection
