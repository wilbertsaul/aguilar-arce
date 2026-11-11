@php
    $etapas = [
        'empezando' => ['num' => '01', 'titulo' => 'ESTOY EMPEZANDO', 'desc' => 'Constitución · RUC · Régimen tributario idóneo · Comprobantes iniciales · Libros legales.', 'cta' => 'Necesito orientación'],
        'operando' => ['num' => '02', 'titulo' => 'YA ESTOY OPERANDO', 'desc' => 'Contabilidad mensual · Impuestos sin multas · Planillas activas · SIRE · Conciliaciones.', 'cta' => 'Quiero ordenar mi empresa'],
        'crecer' => ['num' => '03', 'titulo' => 'QUIERO CRECER Y CONTROLAR', 'desc' => 'Información financiera estratégica · Automatización · Auditoría tributaria · Planeamiento fiscal.', 'cta' => 'Quiero mejorar mi gestión'],
    ];
    $chips = ['Contabilidad', 'Tributación', 'Gestión laboral', 'Fiscalización', 'Facturación', 'Automatización'];
@endphp
<section class="py-section-padding bg-surface" id="diagnostico-orientacion">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="max-w-2xl mb-12">
            <span class="text-caps-micro font-title font-bold uppercase tracking-[0.2em] text-teal-deep block mb-3 reveal-on-scroll">ORIENTACIÓN PERSONALIZADA</span>
            <h2 class="text-headline-lg font-title font-bold text-navy tracking-tight reveal-on-scroll">¿Qué necesita su empresa?</h2>
            <p class="text-body-md text-on-surface-variant mt-3 reveal-on-scroll">
                Cuéntenos en qué etapa se encuentra y le orientaremos sobre los servicios que pueden ayudarle.
            </p>
        </div>

        {{-- Tarjetas de etapa --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            @foreach($etapas as $key => $etapa)
            <div class="stage-card {{ $loop->first ? 'active' : '' }} reveal-on-scroll" onclick="selectStageCard(this, '{{ $key }}')" role="button" tabindex="0" aria-pressed="{{ $loop->first ? 'true' : 'false' }}" onkeydown="if(event.key==='Enter') selectStageCard(this, '{{ $key }}')">
                <span class="font-title font-bold text-[18px] text-teal-deep block mb-1">{{ $etapa['num'] }}</span>
                <h3 class="font-title font-bold text-base text-navy mb-2">{{ $etapa['titulo'] }}</h3>
                <p class="text-[13px] text-on-surface-variant leading-relaxed mb-4">{{ $etapa['desc'] }}</p>
                <span class="text-xs font-title font-bold text-navy flex items-center gap-1.5">
                    {{ $etapa['cta'] }}
                    <span class="material-symbols-outlined text-[16px]">arrow_forward</span>
                </span>
            </div>
            @endforeach
        </div>

        {{-- Formulario de evaluación preliminar --}}
        <div class="bg-surface-variant border border-outline-variant/70 rounded-2xl p-6 sm:p-8 lg:p-10 reveal-on-scroll">
            <div class="max-w-3xl mb-8">
                <h3 class="font-title font-bold text-lg text-navy">Complete su evaluación preliminar</h3>
                <p class="text-[13px] text-on-surface-variant mt-1">Seleccione las áreas requeridas e ingrese los datos de su empresa para emitirle una propuesta ajustada.</p>
            </div>

            @if(session('success'))
            <div class="mb-6 bg-success-green/10 border border-success-green/25 text-success-green rounded-xl p-4 flex items-center gap-3">
                <span class="material-symbols-outlined">check_circle</span>
                <p class="text-sm font-semibold">{{ session('success') }}</p>
            </div>
            @endif

            <form action="{{ route('consultoria.store') }}" method="POST" class="space-y-6" id="evaluacion-form">
                @csrf

                {{-- Capa anti-spam 1: honeypot --}}
                <div style="position: absolute; left: -9999px; opacity: 0; height: 0; width: 0; overflow: hidden;" aria-hidden="true">
                    <input type="text" name="website_url" tabindex="-1" autocomplete="off" value="">
                </div>
                {{-- Capa anti-spam 2: timestamp encriptado (time-trap) --}}
                <input type="hidden" name="form_timestamp" value="{{ $formTimestamp }}">
                {{-- Capa anti-spam 3: checksum JS --}}
                <input type="hidden" name="js_checksum" class="js-checksum-input" value="1">

                {{-- Origen del envío (para redirigir de vuelta al formulario correcto) --}}
                <input type="hidden" name="source" value="home">
                {{-- Etapa y requerimientos seleccionados (JS) --}}
                <input type="hidden" name="etapa" id="etapa-value" value="empezando">
                <input type="hidden" name="requerimientos" id="requerimientos-value" value="Contabilidad">

                <div>
                    <label class="block text-xs font-title font-bold uppercase tracking-wider text-navy mb-3">
                        Seleccione sus requerimientos principales
                    </label>
                    <div class="flex flex-wrap gap-2.5">
                        @foreach($chips as $i => $chip)
                        <button type="button" class="chip {{ $i === 0 ? 'active' : '' }}" onclick="toggleNeedChip(this)">{{ $chip }}</button>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                    <div>
                        <label for="eval-nombre" class="block text-xs font-semibold text-navy mb-1.5">Nombre</label>
                        <input type="text" id="eval-nombre" name="nombre" value="{{ old('nombre') }}" required
                               class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 text-sm text-navy focus:border-teal-accent focus:ring-1 focus:ring-teal-accent outline-none transition-colors"
                               placeholder="Nombres y Apellidos">
                        @error('nombre')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="eval-empresa" class="block text-xs font-semibold text-navy mb-1.5">Empresa / RUC</label>
                        <input type="text" id="eval-empresa" name="empresa_ruc" value="{{ old('empresa_ruc') }}"
                               class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 text-sm text-navy focus:border-teal-accent focus:ring-1 focus:ring-teal-accent outline-none transition-colors"
                               placeholder="Razón Social o RUC">
                        @error('empresa_ruc')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="eval-whatsapp" class="block text-xs font-semibold text-navy mb-1.5">WhatsApp</label>
                        <input type="tel" id="eval-whatsapp" name="whatsapp" value="{{ old('whatsapp') }}" required
                               class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 text-sm text-navy focus:border-teal-accent focus:ring-1 focus:ring-teal-accent outline-none transition-colors"
                               placeholder="+51 900 000 000">
                        @error('whatsapp')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                    <div>
                        <label for="eval-email" class="block text-xs font-semibold text-navy mb-1.5">Correo</label>
                        <input type="email" id="eval-email" name="email" value="{{ old('email') }}" required
                               class="w-full bg-white border border-outline-variant rounded-xl px-4 py-3 text-sm text-navy focus:border-teal-accent focus:ring-1 focus:ring-teal-accent outline-none transition-colors"
                               placeholder="correo@empresa.com">
                        @error('email')<p class="text-error text-xs mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                @error('rate_limit')
                <div class="bg-error/10 border border-error/20 text-error rounded-xl p-4">
                    <p class="text-sm font-medium">{{ $message }}</p>
                </div>
                @enderror

                <div>
                    <button type="submit" class="btn-teal">
                        Solicitar orientación
                        <span class="material-symbols-outlined text-[18px]">arrow_forward</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</section>
