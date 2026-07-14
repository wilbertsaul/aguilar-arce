@extends('layouts.app')

@section('title', 'Agendar Consultoría | Aguilar & Arce')

@section('content')
<section class="relative min-h-screen flex items-center overflow-hidden">
    <div class="absolute top-0 right-0 w-1/3 h-full bg-surface-container-low hidden lg:block z-0"></div>
    <div class="max-w-container-max mx-auto px-gutter w-full relative z-10 py-16">
        <div class="grid lg:grid-cols-12 gap-12 items-center">

            {{-- Left: Title & Contact Info --}}
            <div class="lg:col-span-5 space-y-12">
                <div class="space-y-6">
                    <span class="text-grey-metallic font-label-sm uppercase tracking-[0.2em] mb-4 block">CONSULTORÍA GLOBAL DE ÉLITE</span>
                    <h1 class="text-headline-lg md:text-display-lg text-navy">Agendar Consultoría</h1>
                    <p class="text-body-lg text-on-surface-variant max-w-md">Cuéntanos sobre tu empresa y tus necesidades. Nos comunicaremos contigo pronto para coordinar una consulta personalizada con nuestro equipo de expertos.</p>
                </div>

                <div class="space-y-8 pt-8 border-t border-outline-variant/30">
                    <div class="flex gap-6 items-start">
                        <div class="w-12 h-12 rounded-full bg-navy/5 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-navy uppercase tracking-wider mb-2 text-[10px] font-semibold tracking-[0.1em]">Ubicación Estratégica</h4>
                            <p class="text-body-md text-on-surface-variant">Sede Central Corporativa<br>Distrito Financiero</p>
                        </div>
                    </div>

                    <div class="flex gap-6 items-start">
                        <div class="w-12 h-12 rounded-full bg-navy/5 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                        <div>
                            <h4 class="text-navy uppercase tracking-wider mb-2 text-[10px] font-semibold tracking-[0.1em]">Horario de Atención</h4>
                            <p class="text-body-md text-on-surface-variant">Lunes a Viernes: 08:30 — 18:30<br>Sábados: Previa cita</p>
                        </div>
                    </div>

                    <div class="flex gap-6 items-start">
                        <div class="w-12 h-12 rounded-full bg-navy/5 flex items-center justify-center shrink-0">
                            <svg class="w-5 h-5 text-navy" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 01-2.25 2.25h-15a2.25 2.25 0 01-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0019.5 4.5h-15a2.25 2.25 0 00-2.25 2.25m19.5 0v.243a2.25 2.25 0 01-1.07 1.916l-7.5 4.615a2.25 2.25 0 01-2.36 0L3.32 8.91a2.25 2.25 0 01-1.07-1.916V6.75"/></svg>
                        </div>
                        <div>
                            <h4 class="text-navy uppercase tracking-wider mb-2 text-[10px] font-semibold tracking-[0.1em]">Contacto Directo</h4>
                            <p class="text-body-md text-on-surface-variant font-medium">aguilaryarceconsultores@gmail.com</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Right: Form & Image --}}
            <div class="lg:col-span-7">
                <div class="relative">
                    <div class="absolute -top-12 -right-12 w-64 h-64 bg-navy/5 rounded-full blur-3xl -z-10"></div>

                    <div class="bg-surface-container-low p-6 md:p-8 lg:p-12 rounded-2xl lg:rounded-[32px] shadow-2xl shadow-navy/5 border border-white/50 backdrop-blur-sm">

                        {{-- Logo separator --}}
                        <div class="flex items-center gap-4 mb-10">
                            <img alt="Aguilar & Arce Icon" class="h-8 w-auto grayscale opacity-40" src="{{ asset('images/AA Consultores.png') }}">
                            <span class="h-[1px] flex-1 bg-outline-variant/30"></span>
                        </div>

                        @if(session('success'))
                        <div class="bg-success-green/10 border border-success-green/20 text-success-green rounded-xl p-6 mb-8 text-center">
                            <svg class="w-10 h-10 mx-auto mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            <p class="font-semibold">{{ session('success') }}</p>
                        </div>
                        @endif

                        <form action="{{ route('consultoria.store') }}" method="POST" class="space-y-6" id="consultoria-form">
                            @csrf

                            {{-- Layer 1: Honeypot - hidden field that bots fill but humans don't --}}
                            <div style="position: absolute; left: -9999px; opacity: 0; height: 0; width: 0; overflow: hidden;" aria-hidden="true">
                                <input type="text" name="website_url" tabindex="-1" autocomplete="off" value="">
                            </div>

                            {{-- Layer 2: Encrypted timestamp for time trap --}}
                            <input type="hidden" name="form_timestamp" value="{{ $formTimestamp }}">

                            {{-- Layer 3: JavaScript checksum - will be set to "2" by JS --}}
                            <input type="hidden" name="js_checksum" id="js_checksum" value="1">

                            <div class="space-y-2">
                                <label for="nombre" class="block text-navy uppercase tracking-widest text-[10px] font-semibold tracking-[0.1em]">NOMBRE COMPLETO</label>
                                <input
                                    type="text"
                                    id="nombre"
                                    name="nombre"
                                    value="{{ old('nombre') }}"
                                    required
                                    class="w-full bg-white/60 px-6 py-4 rounded-xl border border-outline-variant/50 focus:border-navy focus:ring-1 focus:ring-navy outline-none transition-all text-body-md text-on-surface"
                                    placeholder="Tu nombre"
                                >
                                @error('nombre')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="email" class="block text-navy uppercase tracking-widest text-[10px] font-semibold tracking-[0.1em]">CORREO ELECTRÓNICO</label>
                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    required
                                    class="w-full bg-white/60 px-6 py-4 rounded-xl border border-outline-variant/50 focus:border-navy focus:ring-1 focus:ring-navy outline-none transition-all text-body-md text-on-surface"
                                    placeholder="tu@empresa.com"
                                >
                                @error('email')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="space-y-2">
                                <label for="mensaje" class="block text-navy uppercase tracking-widest text-[10px] font-semibold tracking-[0.1em]">MENSAJE</label>
                                <textarea
                                    id="mensaje"
                                    name="mensaje"
                                    required
                                    rows="4"
                                    class="w-full bg-white/60 px-6 py-4 rounded-xl border border-outline-variant/50 focus:border-navy focus:ring-1 focus:ring-navy outline-none transition-all text-body-md text-on-surface resize-none"
                                    placeholder="Cuéntanos brevemente qué necesitas..."
                                >{{ old('mensaje') }}</textarea>
                                @error('mensaje')
                                <p class="text-error text-sm mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @error('rate_limit')
                            <div class="bg-error/10 border border-error/20 text-error rounded-xl p-4 mb-4">
                                <p class="text-sm font-medium">{{ $message }}</p>
                            </div>
                            @enderror

                            <div class="pt-4">
                                <button type="submit" class="w-full bg-navy text-white py-5 rounded-2xl font-semibold hover:opacity-90 transition-all shadow-lg shadow-navy/20 flex items-center justify-center gap-3">
                                    Enviar Solicitud
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/></svg>
                                </button>
                            </div>
                        </form>
                    </div>

                    {{-- Office image --}}
                    <div class="hidden lg:block mt-8 rounded-2xl border border-outline-variant/20 shadow-lg overflow-hidden lg:absolute lg:-bottom-24 lg:-left-24 lg:w-72 lg:mt-0">
                        <div class="aspect-[4/3] relative">
                            <img alt="Sede Central Corporativa" class="object-cover w-full h-full brightness-[0.85] opacity-75" src="https://lh3.googleusercontent.com/aida-public/AB6AXuCJcwBqhkFwWRWtDC3Im-Z0DQ-Lhng4CQ2X2xnrM_-5qifK6qmjeYBr__g9N0XflBfVkgqcql2kf1pORp8E8wKhXKoxOYOLahiMjDh2wF1tFfO18exVX9mZLp0USV2X3jplejRQhwHJJedapvRipRo9cKbuTo0c0OI1dG2wCEfB8nbVc7HsrpP2M1fhZQlxLMksvY0bFmzHLW23EvEXUg4gZGZTe8x1KYWJquheycIOpnq6fXd_77ooqg">
                            <div class="absolute inset-0 bg-gradient-to-t from-navy/60 to-transparent"></div>
                            <div class="absolute bottom-4 left-4 text-white">
                                <p class="text-[8px] uppercase tracking-widest mb-1 font-semibold">GLOBAL HQ</p>
                                <p class="text-xs font-semibold">Excelencia Corporativa</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('js_checksum').value = '2';
    });
</script>
@endpush
