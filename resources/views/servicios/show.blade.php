@extends('layouts.app')

@section('title', $servicio->titulo . ' | Aguilar & Arce')

@section('content')
<section class="pt-40 pb-24 md:pt-48 md:pb-40 bg-surface">
    <div class="max-w-container-max mx-auto px-gutter">
        <span class="font-caps-micro text-secondary uppercase tracking-[0.3em] mb-4 block">Servicios</span>
        <h1 class="font-display-lg text-display-lg-mobile md:text-display-lg text-primary mb-8">{{ $servicio->titulo }}</h1>
        <div class="max-w-3xl">
            <p class="font-body-lg text-on-surface-variant leading-relaxed">
                {{ $servicio->descripcion_larga ?? $servicio->descripcion_corta }}
            </p>
            <a href="{{ route('home') }}#servicios" class="inline-flex items-center gap-2 mt-8 text-primary font-label-sm border-b border-primary/20 pb-1 hover:border-primary transition-all">
                ← Todos los servicios
            </a>
        </div>
    </div>
</section>
@endsection
