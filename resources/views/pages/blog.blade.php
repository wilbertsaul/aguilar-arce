@extends('layouts.app')

@section('title', 'Blog | Aguilar & Arce')

@section('content')
<style>
    .blog-section {
        padding: 4rem 0;
        background: var(--color-surface, #ffffff);
    }
    @media (min-width: 768px) {
        .blog-section { padding: 6rem 0; }
    }
    .blog-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .blog-header {
        margin-bottom: 3rem;
        text-align: center;
    }
    .blog-header-tag {
        font-size: 11px;
        font-weight: 600;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        color: var(--color-grey-metallic, #8c8c8c);
        display: block;
        margin-bottom: 1rem;
    }
    .blog-header-title {
        font-size: clamp(2rem, 4vw, 2.5rem);
        font-weight: 700;
        color: var(--color-navy, #0b1c30);
        letter-spacing: -0.02em;
    }
    .blog-cats {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        gap: 0.75rem;
        margin-bottom: 3rem;
    }
    .blog-cat {
        padding: 0.5rem 1rem;
        background: rgba(11, 28, 48, 0.05);
        color: var(--color-navy, #0b1c30);
        font-size: 0.875rem;
        border-radius: 9999px;
        font-weight: 500;
    }
    .blog-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    @media (min-width: 768px) {
        .blog-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (min-width: 1024px) {
        .blog-grid { grid-template-columns: 1fr 1fr 1fr; }
    }
    .blog-card {
        border-radius: 1rem;
        overflow: hidden;
        text-decoration: none;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(226, 232, 240, 0.5);
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
    }
    .blog-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 40px rgba(0, 28, 55, 0.1);
    }
    .blog-card-img {
        position: relative;
        aspect-ratio: 16 / 9;
        overflow: hidden;
    }
    .blog-card-img-bg {
        position: absolute;
        inset: 0;
        background-size: cover;
        background-position: center;
        transition: transform 0.7s ease;
    }
    .blog-card:hover .blog-card-img-bg {
        transform: scale(1.05);
    }
    .blog-card-body {
        padding: 1.5rem;
    }
    .blog-card-cat {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--color-grey-metallic, #8c8c8c);
    }
    .blog-card-title {
        font-size: 1.125rem;
        font-weight: 600;
        color: var(--color-navy, #0b1c30);
        margin-top: 0.5rem;
        margin-bottom: 0.5rem;
        line-height: 1.4;
    }
    .blog-card:hover .blog-card-title {
        color: var(--color-navy-light, #0a2a4a);
    }
    .blog-card-resume {
        font-size: 0.875rem;
        color: var(--color-on-surface-variant, #43474d);
        line-height: 1.6;
    }
    .blog-card-date {
        font-size: 0.75rem;
        color: var(--color-grey-metallic, #8c8c8c);
        margin-top: 1rem;
        display: block;
    }
    .blog-empty {
        grid-column: 1 / -1;
        text-align: center;
        padding: 4rem 0;
    }
    .blog-empty p {
        font-size: 1.125rem;
        color: var(--color-on-surface-variant, #43474d);
    }
    .blog-pagination {
        margin-top: 3rem;
    }
</style>

<section class="blog-section">
    <div class="blog-container">
        <div class="blog-header">
            <span class="blog-header-tag">Perspectivas Estratégicas</span>
            <h1 class="blog-header-title">El Pulso del Mercado</h1>
        </div>

        @if($categorias->isNotEmpty())
        <div class="blog-cats">
            @foreach($categorias as $categoria)
            <span class="blog-cat">{{ $categoria }}</span>
            @endforeach
        </div>
        @endif

        <div class="blog-grid">
            @forelse($articulos as $articulo)
            <a href="{{ route('articulo.show', $articulo->slug) }}" class="blog-card">
                <div class="blog-card-img">
                    <div class="blog-card-img-bg" style="background-image: url('{{ $articulo->imagen ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCBuuj0NGt4VNyE5sDWrp8_EHS90-1rZoaz_nA52qI99mSkLdSoTS8F9HClGCmDtB8j1DPbmmEhnD7MGIJDH-b2ggUfuSDjIRkDT6tEXRiE7T9DrTTEMR2I5rOnGb4jDRxfno5dm6LuZdZsAk8Cz77MKMKHX7UNjbChIqRdphvNZ7h_0YVCigsHcGaM0aFGaqUwREkWqX-tKdhp3j1F6L9qbW0InCJ8UaaKSrbGdFdJU2N7xmwidMhCePdnqy77J97zZ3zsWj2CROmQ' }}')"></div>
                </div>
                <div class="blog-card-body">
                    <span class="blog-card-cat">{{ $articulo->categoria }}</span>
                    <h3 class="blog-card-title">{{ $articulo->titulo }}</h3>
                    <p class="blog-card-resume">{{ $articulo->resumen }}</p>
                    <time class="blog-card-date">{{ $articulo->created_at->translatedFormat('d \\d\\e F, Y') }}</time>
                </div>
            </a>
            @empty
            <div class="blog-empty">
                <p>No hay artículos disponibles.</p>
            </div>
            @endforelse
        </div>

        <div class="blog-pagination">
            {{ $articulos->links() }}
        </div>
    </div>
</section>
@endsection
