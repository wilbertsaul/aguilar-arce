<section class="py-section-padding bg-surface" id="servicios">
    <div class="max-w-container-max mx-auto px-gutter">
        <div class="max-w-2xl mb-12">
            <span class="text-caps-micro font-title font-bold uppercase tracking-[0.2em] text-teal-deep block mb-3 reveal-on-scroll">SERVICIOS</span>
            <h2 class="text-headline-lg font-title font-bold text-navy tracking-tight reveal-on-scroll">Práctica Integral Especializada</h2>
            <p class="text-body-md text-on-surface-variant mt-3 reveal-on-scroll">
                Flujos metodológicos diseñados para garantizar precisión contable y tranquilidad jurídica.
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($servicios as $index => $servicio)
            @php
                $flujoParts = $servicio->flujo ? array_map('trim', explode('→', $servicio->flujo)) : [];
            @endphp
            <div class="bg-surface-variant/70 border border-outline-variant hover:border-teal-accent rounded-2xl p-6 flex flex-col justify-between transition-all duration-300 group shadow-sm hover:shadow-xl hover:shadow-navy/10 reveal-on-scroll">
                <div>
                    <div class="flex items-center justify-between mb-5">
                        <span class="font-title font-bold text-[26px] text-navy-light/50">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        @if($servicio->icono)
                        <div class="w-11 h-11 rounded-xl bg-white border border-outline-variant/60 flex items-center justify-center shadow-sm group-hover:bg-navy transition-all duration-300">
                            <span class="material-symbols-outlined text-[22px] text-navy group-hover:text-teal-bright transition-all duration-300">{{ $servicio->icono }}</span>
                        </div>
                        @endif
                    </div>

                    <h3 class="font-title font-bold text-[16px] text-navy mb-3 leading-snug uppercase tracking-wide">{{ $servicio->titulo }}</h3>

                    @if(count($flujoParts) > 1)
                    <div class="flow-badge mb-4">
                        @foreach($flujoParts as $i => $part)
                            @if($i > 0) → @endif
                            @if($i === 0 || $i === count($flujoParts) - 1)<strong>{{ $part }}</strong>@else{{ $part }}@endif
                        @endforeach
                    </div>
                    @endif

                    @if($servicio->sub_servicios && count($servicio->sub_servicios) > 0)
                    <ul class="space-y-2.5 text-[13px] text-on-surface-variant">
                        @foreach($servicio->sub_servicios as $sub)
                        @php $subTitle = is_array($sub) ? ($sub['titulo'] ?? ($sub['title'] ?? '')) : $sub; @endphp
                        <li class="flex items-start gap-2.5">
                            <span class="w-1.5 h-1.5 rounded-full bg-teal-accent mt-1.5 shrink-0"></span>
                            <span>{{ $subTitle }}</span>
                        </li>
                        @endforeach
                    </ul>
                    @endif
                </div>

                <div class="pt-5 mt-6 border-t border-outline-variant/60">
                    <a href="{{ route('consultoria.show') }}" class="text-xs font-title font-bold text-navy hover:text-teal-deep inline-flex items-center gap-1.5 transition-colors">
                        Solicitar información
                        <span class="material-symbols-outlined text-[16px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>
            @empty
            <div class="py-12 text-center md:col-span-2 lg:col-span-3">
                <p class="text-on-surface-variant">No hay servicios disponibles.</p>
            </div>
            @endforelse
        </div>
    </div>
</section>
