@extends('layouts.app')

@section('title', 'Descarga de comprobantes SUNAT · BYT SOLUTION')
@section('meta_description', 'Descarga real de XML, CDR y PDF de un comprobante SUNAT usando tus credenciales SOL. Y consulta masiva simulada con cotización por WhatsApp.')

@section('content')
@php
    $whatsapp = $whatsapp ?? \App\Models\Setting::get('contacto_whatsapp', '51957129087');
    $waBloque = "https://wa.me/{$whatsapp}?text=" . rawurlencode('Hola, quiero cotizar la descarga masiva de comprobantes por período para mi empresa.');
@endphp

{{-- Hero --}}
<section class="relative overflow-hidden byt-gradient">
    <div class="absolute inset-0 pattern-dots opacity-30"></div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter py-12 md:py-16">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white transition-colors text-sm mb-6 font-byt">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Volver al inicio
        </a>

        <div class="max-w-2xl byt-surface">
            <div class="flex flex-wrap items-center gap-2 mb-4">
                <span class="byt-badge-demo !bg-white/10 !text-white !border-white/25">XML · CDR · PDF reales</span>
                <span class="byt-badge-demo !bg-white/10 !text-white !border-white/25">Consulta individual</span>
            </div>

            <h1 class="font-byt font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white leading-[1.1] tracking-tight">
                Descarga de comprobantes SUNAT
            </h1>
            <p class="text-base sm:text-lg text-white/75 mt-4 leading-relaxed font-byt">
                Descarga el XML, el CDR y el PDF oficiales de un comprobante usando tus credenciales SOL.
                Y simula la descarga masiva por período para cotizar el servicio completo.
            </p>

            <div class="flex flex-wrap items-center gap-x-5 gap-y-2.5 pt-5 text-white/65 text-xs font-byt">
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">verified</span> Documentos reales de SUNAT</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">lock</span> Credenciales no se almacenan</span>
                <span class="flex items-center gap-1.5"><span class="material-symbols-outlined text-[16px]">download</span> ZIP con XML + CDR + PDF</span>
            </div>
        </div>
    </div>
</section>

{{-- Aplicación --}}
<section class="py-10 md:py-14 bg-byt-mist min-h-[60vh]">
    <div class="max-w-4xl mx-auto px-gutter">

        {{-- Pestañas --}}
        <div class="flex gap-2 mb-6">
            <button type="button" id="tab-individual" class="toggle-pill active">Consulta individual (real)</button>
            <button type="button" id="tab-bloque" class="toggle-pill">Consultas en bloque (simulado)</button>
        </div>

        {{-- Panel individual --}}
        <div id="panel-individual" class="byt-surface bg-white rounded-2xl border border-byt-line shadow-xl overflow-hidden p-6 sm:p-9">
            <h2 class="font-byt font-extrabold text-xl text-byt-navy">Descarga de un comprobante</h2>
            <p class="text-sm text-byt-grey mt-1 mb-6">
                Ingresa tus credenciales SOL (usuario principal) y los datos del comprobante. Se descargará un ZIP con el XML, el CDR (si SUNAT lo incluye) y el PDF oficial.
            </p>

            @if (! $descargaConfig['jsonpeConfigurado'])
                <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">
                    El servicio de descarga no está configurado en este entorno.
                </div>
            @endif

            <form id="form-individual" class="space-y-5">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="byt-label" for="ds-ruc">RUC de tu empresa (receptor)</label>
                        <input id="ds-ruc" name="ruc" class="byt-input font-mono" maxlength="11" inputmode="numeric" placeholder="20XXXXXXXXX" required>
                    </div>
                    <div>
                        <label class="byt-label" for="ds-sol-user">Usuario SOL principal</label>
                        <input id="ds-sol-user" name="sol_user" class="byt-input" maxlength="50" placeholder="USUARIO" required>
                    </div>
                    <div>
                        <label class="byt-label" for="ds-sol-pass">Clave SOL</label>
                        <input id="ds-sol-pass" name="sol_password" type="password" class="byt-input" maxlength="100" required>
                    </div>
                    <div>
                        <label class="byt-label" for="ds-ruc-emisor">RUC del emisor</label>
                        <input id="ds-ruc-emisor" name="ruc_emisor" class="byt-input font-mono" maxlength="11" inputmode="numeric" placeholder="20XXXXXXXXX" required>
                    </div>
                    <div>
                        <label class="byt-label" for="ds-tipo">Tipo de comprobante</label>
                        <select id="ds-tipo" name="tipo_comprobante" class="byt-input" required>
                            @foreach ($descargaConfig['tipos'] as $cod => $nombre)
                                <option value="{{ $cod }}">{{ $cod }} — {{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="byt-label" for="ds-serie">Serie</label>
                            <input id="ds-serie" name="serie" class="byt-input font-mono text-center" maxlength="4" placeholder="F001" required>
                        </div>
                        <div>
                            <label class="byt-label" for="ds-corr">Correlativo</label>
                            <input id="ds-corr" name="correlativo" class="byt-input font-mono text-center" maxlength="8" placeholder="1" required>
                        </div>
                    </div>
                </div>

                <label class="flex items-start gap-2.5 text-xs text-byt-grey cursor-pointer">
                    <input type="checkbox" name="consentimiento" value="1" class="mt-0.5" required>
                    <span>Autorizo el uso de mis credenciales SOL únicamente para esta consulta. <strong class="text-byt-navy">No se almacenan ni se registran.</strong></span>
                </label>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3 pt-2">
                    <button type="submit" id="btn-descargar" class="btn-byt">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Descargar comprobante (ZIP)
                    </button>
                    <span id="ds-estado" class="text-xs text-byt-grey"></span>
                </div>

                <p class="text-[11px] text-byt-grey">
                    Cupo: {{ $descargaConfig['limitePorIp'] }} consulta por día por IP · {{ $descargaConfig['globalDia'] }} consultas globales por día.
                    No se guarda el número de comprobante ni las credenciales.
                </p>
            </form>

            <div id="ds-resultado" class="hidden mt-6 bg-byt-blue-soft border border-byt-blue/30 rounded-xl p-5">
                <p class="font-byt font-extrabold text-byt-navy text-sm mb-2">Descarga iniciada</p>
                <p id="ds-resumen" class="text-xs text-byt-grey"></p>
            </div>
        </div>

        {{-- Panel bloque (simulado) --}}
        <div id="panel-bloque" class="hidden byt-surface bg-white rounded-2xl border border-byt-line shadow-xl overflow-hidden p-6 sm:p-9">
            <h2 class="font-byt font-extrabold text-xl text-byt-navy">Descarga masiva por período (simulación)</h2>
            <p class="text-sm text-byt-grey mt-1 mb-6">
                Simula la descarga de todos los comprobantes de un período (RCE). Los datos son de ejemplo.
                Para el servicio real, solicita una cotización.
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                <div>
                    <label class="byt-label" for="blk-periodo">Período (AAAA-MM)</label>
                    <input id="blk-periodo" type="month" class="byt-input" value="{{ now()->format('Y-m') }}">
                </div>
                <div>
                    <label class="byt-label" for="blk-ruc">RUC de la empresa</label>
                    <input id="blk-ruc" class="byt-input font-mono" maxlength="11" placeholder="20XXXXXXXXX">
                </div>
            </div>

            <div class="mt-5 flex flex-col sm:flex-row sm:items-center gap-3">
                <button type="button" id="btn-simular-bloque" class="btn-byt">
                    <span class="material-symbols-outlined text-[18px]">play_arrow</span>
                    Simular descarga
                </button>
                <span id="blk-estado" class="text-xs text-byt-grey"></span>
            </div>

            <div id="blk-log" class="byt-log mt-4 hidden"></div>

            <div id="blk-resultado" class="hidden mt-6 bg-byt-blue-soft border border-byt-blue/30 rounded-xl p-5" data-whatsapp="{{ $whatsapp }}">
                <p class="font-byt font-extrabold text-byt-navy text-sm mb-2">Simulación completada</p>
                <p class="text-xs text-byt-grey mb-4">Se generó un ZIP de ejemplo con 24 comprobantes (XML + CDR + PDF).</p>
                <a href="{{ $waBloque }}" target="_blank" rel="noopener noreferrer" class="btn-byt">
                    <span class="material-symbols-outlined text-[17px]">chat</span>
                    Solicitar cotización por WhatsApp
                </a>
            </div>
        </div>

        {{-- Aviso --}}
        <div class="mt-6 bg-byt-blue-soft border border-byt-blue/25 rounded-xl p-4 flex items-start gap-3">
            <span class="material-symbols-outlined text-[20px] text-byt-blue mt-0.5">info</span>
            <p class="text-xs text-byt-grey leading-relaxed">
                <strong class="text-byt-navy">Simulador de descarga.</strong> La consulta individual descarga documentos reales de SUNAT usando tus credenciales SOL y el servicio json.pe.
                La descarga masiva es una simulación: para el servicio real (con SIRE + empaquetado) solicita una cotización.
                No se almacenan credenciales ni documentos en el servidor.
            </p>
        </div>
    </div>
</section>

@push('scripts')
    @vite('resources/js/descarga-sunat.js')
@endpush
@endsection