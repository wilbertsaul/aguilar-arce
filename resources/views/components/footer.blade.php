@php
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
    $telefono1 = \App\Models\Setting::get('contacto_telefono_1', '+51 957 129 087');
    $telefono2 = \App\Models\Setting::get('contacto_telefono_2', '+51 993 750 502');
    $email = \App\Models\Setting::get('contacto_email', 'aguilaryarce.tributos@gmail.com');
    $ruc = \App\Models\Setting::get('empresa_ruc', '20608492011');
    $sedePm = \App\Models\Setting::get('sede_puerto_maldonado', 'Av. Alameda Mz. F Lote 5');
    $sedeCusco = \App\Models\Setting::get('sede_cusco', 'Jr. La Cultura');
@endphp
<footer class="bg-navy text-white relative overflow-hidden">
    <div class="h-1 bg-gradient-to-r from-teal-deep via-teal-accent to-teal-bright"></div>
    <div class="absolute inset-0 pattern-dots opacity-20"></div>

    <div class="relative max-w-container-max mx-auto px-gutter pt-16 pb-12">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-white/10">
            {{-- Bloque institucional --}}
            <div class="md:col-span-4 space-y-4">
                <div class="flex items-center gap-3.5">
                    <div class="w-14 h-14 rounded-xl bg-white flex items-center justify-center overflow-hidden border border-white/20 shadow-sm shrink-0">
                        <img src="{{ asset('images/AA Consultores.png') }}" alt="Aguilar & Arce Consultores" class="w-full h-full object-contain p-1">
                    </div>
                    <div>
                        <span class="font-title font-bold text-[15px] tracking-tight text-white block">AGUILAR &amp; ARCE CONSULTORES</span>
                        <span class="text-[10px] tracking-[0.18em] text-grey-metallic font-semibold uppercase block mt-0.5">Contabilidad · Tributación · Auditoría</span>
                    </div>
                </div>
                <p class="text-xs text-white/60 leading-relaxed">
                    Soluciones profesionales y herramientas digitales para mantener el control de su empresa.
                </p>
                <div class="text-xs text-white/60">
                    <span class="text-grey-metallic font-bold block">RUC:</span> {{ $ruc }}
                </div>
            </div>

            {{-- Navegación --}}
            <div class="md:col-span-3 space-y-3">
                <h4 class="font-title font-bold text-xs uppercase tracking-wider text-teal-accent">Navegación</h4>
                <ul class="space-y-2.5 text-xs text-white/60">
                    <li><a class="hover:text-white transition-colors" href="{{ route('home') }}">Inicio</a></li>
                    <li><a class="hover:text-white transition-colors" href="{{ route('home') }}#servicios">Servicios</a></li>
                    <li><a class="hover:text-white transition-colors" href="{{ route('facturador') }}">Facturador Online</a></li>
                    <li><a class="hover:text-white transition-colors" href="{{ route('home') }}#recursos">Utilitarios</a></li>
                    <li><a class="hover:text-white transition-colors" href="{{ route('home') }}#recursos">Academia</a></li>
                    <li><a class="hover:text-white transition-colors" href="{{ route('blog') }}">Blog</a></li>
                    <li><a class="hover:text-white transition-colors" href="{{ route('home') }}#contacto">Contacto</a></li>
                </ul>
            </div>

            {{-- Sedes y contacto --}}
            <div class="md:col-span-3 space-y-3">
                <h4 class="font-title font-bold text-xs uppercase tracking-wider text-teal-accent">Sedes &amp; Contacto</h4>
                <div class="space-y-2.5 text-xs text-white/60">
                    <p><strong class="text-white">Puerto Maldonado:</strong> {{ $sedePm }}</p>
                    <p><strong class="text-white">Cusco:</strong> {{ $sedeCusco }}</p>
                    <p class="pt-1"><strong class="text-white">Teléfonos:</strong><br>{{ $telefono1 }} · {{ $telefono2 }}</p>
                    <p class="pt-1"><strong class="text-white">Correo:</strong><br>{{ $email }}</p>
                    <p class="pt-1"><a href="https://wa.me/{{ $whatsapp }}" target="_blank" rel="noopener noreferrer" class="text-whatsapp hover:brightness-125 font-semibold transition-all inline-flex items-center gap-1"><span class="material-symbols-outlined text-[14px]">forum</span> WhatsApp Corporativo</a></p>
                </div>
            </div>

            {{-- Legal --}}
            <div class="md:col-span-2 space-y-3">
                <h4 class="font-title font-bold text-xs uppercase tracking-wider text-teal-accent">Legal</h4>
                <ul class="space-y-2.5 text-xs text-white/40">
                    <li class="flex items-center gap-2">Libro de Reclamaciones <span class="text-[9px] bg-white/10 px-1.5 py-0.5 rounded uppercase tracking-wide">próximamente</span></li>
                    <li class="flex items-center gap-2">Política de Privacidad <span class="text-[9px] bg-white/10 px-1.5 py-0.5 rounded uppercase tracking-wide">próximamente</span></li>
                    <li class="flex items-center gap-2">Términos y Condiciones <span class="text-[9px] bg-white/10 px-1.5 py-0.5 rounded uppercase tracking-wide">próximamente</span></li>
                </ul>
            </div>
        </div>

        {{-- Copyright --}}
        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between text-xs text-white/50 gap-3">
            <p>© {{ date('Y') }} Aguilar &amp; Arce Consultores. Todos los derechos reservados.</p>
            <p class="text-[11px] text-grey-metallic">Rigor normativo y acompañamiento estratégico.</p>
        </div>
    </div>
</footer>
