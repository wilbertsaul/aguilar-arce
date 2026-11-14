@php
    $msg = "Hola, quiero solicitar el paquete {$p->nombre} ({$p->periodicidad}) de {$p->consultas} consultas por S/ " . number_format((float)$p->precio, 2) . ".";
    $wa = "https://wa.me/{$whatsapp}?text=" . rawurlencode($msg);
    $beneficios = is_array($p->beneficios) ? $p->beneficios : [];
@endphp

<div class="bg-white rounded-2xl border {{ $p->destacado ? 'border-byt-blue shadow-xl ring-2 ring-byt-blue/30' : 'border-byt-line shadow-sm' }} p-6 flex flex-col">
    @if ($p->destacado)
        <span class="inline-block self-start bg-byt-blue text-white text-[10px] font-byt font-extrabold px-2.5 py-1 rounded mb-3">Recomendado</span>
    @endif

    <h3 class="font-byt font-extrabold text-xl text-byt-navy">{{ $p->nombre }}</h3>
    <p class="text-xs text-byt-grey mt-1 capitalize">{{ $p->periodicidad }}</p>

    <div class="mt-4">
        <span class="font-mono font-bold text-3xl text-byt-blue">S/ {{ number_format((float)$p->precio, 2) }}</span>
    </div>
    <p class="text-xs text-byt-grey mt-1">{{ number_format($p->consultas) }} consultas incluidas</p>

    <ul class="mt-5 space-y-2 flex-1">
        @foreach ($beneficios as $b)
            <li class="flex items-start gap-2 text-sm text-byt-grey">
                <span class="material-symbols-outlined text-[16px] text-byt-blue mt-0.5">check_circle</span>
                {{ $b }}
            </li>
        @endforeach
    </ul>

    <a href="{{ $wa }}" target="_blank" rel="noopener noreferrer" class="btn-byt w-full mt-6">
        <span class="material-symbols-outlined text-[17px]">chat</span>
        Solicitar por WhatsApp
    </a>
</div>