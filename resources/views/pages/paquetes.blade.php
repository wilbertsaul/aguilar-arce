@extends('layouts.app')

@section('title', 'Paquetes de descargas SUNAT · BYT SOLUTION')
@section('meta_description', 'Paquetes de consultas para descargar comprobantes SUNAT (XML, CDR, PDF). Mensual y anual.')

@section('content')
@php
    $mensuales = $planes->where('periodicidad', 'mensual')->values();
    $anuales = $planes->where('periodicidad', 'anual')->values();
@endphp

<section class="relative overflow-hidden byt-gradient">
    <div class="absolute inset-0 pattern-dots opacity-30"></div>
    <div class="relative z-10 max-w-container-max mx-auto px-gutter py-12 md:py-16">
        <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-white/60 hover:text-white transition-colors text-sm mb-6 font-byt">
            <span class="material-symbols-outlined text-[18px]">arrow_back</span>
            Volver al inicio
        </a>
        <div class="max-w-2xl byt-surface">
            <h1 class="font-byt font-extrabold text-3xl sm:text-4xl lg:text-5xl text-white leading-[1.1] tracking-tight">
                Paquetes de descargas SUNAT
            </h1>
            <p class="text-base sm:text-lg text-white/75 mt-4 leading-relaxed font-byt">
                Descarga XML, CDR y PDF de tus comprobantes. Elige el paquete que se ajuste a tu volumen.
            </p>
        </div>
    </div>
</section>

<section class="py-10 md:py-14 bg-byt-mist">
    <div class="max-w-5xl mx-auto px-gutter">

        {{-- Switch --}}
        <div class="flex justify-center mb-8">
            <div class="inline-flex bg-white border border-byt-line rounded-xl p-1">
                <button type="button" id="sw-mensual" class="toggle-pill active">Mensual</button>
                <button type="button" id="sw-anual" class="toggle-pill">Anual (ahorra 17%)</button>
            </div>
        </div>

        {{-- Mensuales --}}
        <div id="bloque-mensual" class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($mensuales as $p)
                @include('components.paquete-card', ['p' => $p, 'whatsapp' => $whatsapp])
            @endforeach
        </div>

        {{-- Anuales --}}
        <div id="bloque-anual" class="hidden grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($anuales as $p)
                @include('components.paquete-card', ['p' => $p, 'whatsapp' => $whatsapp])
            @endforeach
        </div>

        <p class="text-xs text-byt-grey text-center mt-8">
            El pago se realiza por transferencia o Yape. Al solicitar, te contactamos para activar tu acceso.
            Precios no incluyen IGV.
        </p>
    </div>
</section>

@push('scripts')
<script>
(() => {
    const m = document.getElementById('sw-mensual');
    const a = document.getElementById('sw-anual');
    const bm = document.getElementById('bloque-mensual');
    const ba = document.getElementById('bloque-anual');
    m.addEventListener('click', () => { m.classList.add('active'); a.classList.remove('active'); bm.classList.remove('hidden'); ba.classList.add('hidden'); });
    a.addEventListener('click', () => { a.classList.add('active'); m.classList.remove('active'); ba.classList.remove('hidden'); bm.classList.add('hidden'); });
})();
</script>
@endpush
@endsection