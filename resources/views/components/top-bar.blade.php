@php
    $horario = \App\Models\Setting::get('contacto_horario', 'Lun–Vie · 8:30 a. m. – 6:30 p. m.');
    $telefono1 = \App\Models\Setting::get('contacto_telefono_1', '+51 957 129 087');
    $telefono2 = \App\Models\Setting::get('contacto_telefono_2', '+51 993 750 502');
    $whatsapp = \App\Models\Setting::get('contacto_whatsapp', '51957129087');
    $telDigits1 = preg_replace('/\D+/', '', $telefono1);
    $telDigits2 = preg_replace('/\D+/', '', $telefono2);
@endphp
<div class="bg-navy-dark text-white border-b border-navy-light/60 text-xs">
    <div class="max-w-container-max mx-auto px-gutter h-10 flex items-center justify-between gap-4">
        <div class="flex items-center gap-4 text-grey-metallic min-w-0">
            <span class="flex items-center gap-1.5 shrink-0">
                <span class="material-symbols-outlined text-[15px]">schedule</span>
                <span class="hidden md:inline">{{ $horario }}</span>
                <span class="md:hidden">{{ \Illuminate\Support\Str::before($horario, '·') }}</span>
            </span>
            <span class="text-white/10 hidden lg:inline">|</span>
            <span class="hidden lg:flex items-center gap-1.5">
                <span class="material-symbols-outlined text-[15px]">call</span>
                <a class="hover:text-teal-accent transition-colors" href="tel:{{ $telDigits1 }}">{{ $telefono1 }}</a>
                <span>·</span>
                <a class="hover:text-teal-accent transition-colors" href="tel:{{ $telDigits2 }}">{{ $telefono2 }}</a>
            </span>
        </div>
        <a class="text-whatsapp hover:brightness-110 font-semibold flex items-center gap-1.5 transition-all shrink-0"
           href="https://wa.me/{{ $whatsapp }}" rel="noopener noreferrer" target="_blank">
            <span class="material-symbols-outlined text-[16px]">forum</span>
            WhatsApp Corporativo
        </a>
    </div>
</div>
