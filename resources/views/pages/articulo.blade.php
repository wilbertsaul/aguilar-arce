@extends('layouts.app')

@section('title', $articulo->titulo . ' | Aguilar & Arce')

@section('content')
<style>
    .article-section {
        max-width: 1280px;
        margin: 0 auto;
        padding-left: 32px !important;
        padding-right: 32px !important;
    }
    @media (max-width: 767px) {
        .article-section { padding-left: 24px !important; padding-right: 24px !important; }
    }
    .article-header {
        padding: 3rem 0 4rem;
    }
    .article-header-grid {
        display: grid;
        grid-template-columns: 1fr;
    }
    @media (min-width: 1024px) {
        .article-header-grid {
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
            align-items: start;
        }
    }
    .article-breadcrumb {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 1.5rem;
        font-size: 0.75rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: var(--color-on-surface-variant, #43474d);
    }
    .article-breadcrumb a {
        color: inherit;
        text-decoration: none;
        transition: color 0.2s;
    }
    .article-breadcrumb a:hover {
        color: var(--color-navy, #0b1c30);
    }
    .article-badge {
        display: inline-flex;
        align-items: center;
        background: rgba(11, 28, 48, 0.1);
        color: var(--color-navy, #0b1c30);
        padding: 0.25rem 0.75rem;
        border-radius: 9999px;
        font-size: 10px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
    }
    .article-date {
        color: var(--color-on-surface-variant, #43474d);
        font-size: 0.875rem;
        font-weight: 500;
    }
    .article-title {
        font-size: clamp(2rem, 5vw, 3rem);
        font-weight: 700;
        color: var(--color-navy, #0b1c30);
        margin-bottom: 1.5rem;
        line-height: 1.1;
        letter-spacing: -0.02em;
    }
    .article-subtitle {
        color: var(--color-on-surface-variant, #43474d);
        max-width: 42rem;
        font-size: 1.25rem;
        line-height: 1.6;
    }
    .article-featured-img {
        margin-top: 2rem;
        margin-bottom: 4rem;
    }
    .article-featured-img-inner {
        position: relative;
        width: 100%;
        height: 500px;
        border-radius: 1.5rem;
        overflow: hidden;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
    }
    .article-featured-img-inner img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .article-featured-img-inner::after {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(to top, rgba(0,0,0,0.4), transparent);
    }
    @media (max-width: 767px) {
        .article-featured-img-inner {
            height: 250px;
            border-radius: 1rem;
        }
    }
    .article-content-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 4rem;
    }
    @media (max-width: 1023px) {
        .article-content-grid {
            grid-template-columns: 1fr;
            gap: 2rem;
        }
    }
    .article-prose h2 {
        font-size: 1.5rem;
        font-weight: 700;
        color: var(--color-navy, #0b1c30);
        margin-top: 2.5rem;
        margin-bottom: 0.75rem;
        line-height: 1.3;
    }
    .article-prose h3 {
        font-size: 1.25rem;
        font-weight: 600;
        color: var(--color-navy, #0b1c30);
        margin-top: 2rem;
        margin-bottom: 0.5rem;
    }
    .article-prose p {
        margin-bottom: 1.5rem;
        line-height: 1.8;
        font-size: 1.125rem;
        color: var(--color-on-surface-variant, #43474d);
    }
    .article-prose strong {
        font-weight: 700;
        color: var(--color-navy, #0b1c30);
    }
    .article-prose a {
        color: var(--color-navy, #0b1c30);
        text-decoration: underline;
        text-underline-offset: 3px;
    }
    .article-prose a:hover {
        color: var(--color-navy-light, #1a3a5c);
    }
    .article-prose img {
        border-radius: 1rem;
        margin: 2rem 0;
        width: 100%;
        height: auto;
    }
    .article-prose ul {
        list-style: none;
        padding: 0;
        margin: 1.5rem 0;
    }
    .article-prose ul li {
        padding: 0.5rem 0 0.5rem 1.5rem;
        position: relative;
        line-height: 1.7;
        font-size: 1.125rem;
        color: var(--color-on-surface-variant, #43474d);
    }
    .article-prose ul li::before {
        content: "\2022";
        position: absolute;
        left: 0;
        color: var(--color-navy, #0b1c30);
        font-weight: bold;
    }
    .article-prose blockquote {
        border-left: 4px solid var(--color-navy, #0b1c30);
        padding: 0.5rem 0 0.5rem 2rem;
        margin: 2.5rem 0;
        font-style: italic;
        color: var(--color-navy, #0b1c30);
        background: var(--color-surface-container-low, #f5f3f6);
        border-radius: 0 0.75rem 0.75rem 0;
    }
    .article-prose blockquote p {
        font-size: 1.25rem;
        font-weight: 600;
        margin-bottom: 0;
    }
    .article-prose blockquote cite {
        display: block;
        font-size: 0.875rem;
        font-style: normal;
        color: var(--color-grey-metallic, #74777e);
        margin-top: 0.5rem;
    }
    .prose-first-letter > p:first-of-type::first-letter {
        font-size: 2.5rem;
        font-weight: 700;
        color: var(--color-navy, #0b1c30);
        float: left;
        margin-right: 0.5rem;
        margin-top: 0.1rem;
        line-height: 1;
    }
    .author-box {
        margin-top: 4rem;
        padding-top: 2rem;
        border-top: 1px solid var(--color-outline-variant, #e2e8f0);
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }
    @media (min-width: 640px) {
        .author-box {
            flex-direction: row;
        }
    }
    .author-img {
        width: 80px;
        height: 80px;
        border-radius: 9999px;
        background: var(--color-surface-container-high, #e9e8ea);
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        flex-shrink: 0;
    }
    .author-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .author-name {
        font-size: 1.125rem;
        font-weight: 700;
        color: var(--color-navy, #0b1c30);
    }
    .author-role {
        font-size: 0.875rem;
        color: var(--color-on-surface-variant, #43474d);
    }
    .sidebar-box {
        background: var(--color-surface, #ffffff);
        border-radius: 1rem;
        padding: 1.5rem;
        border: 1px solid var(--color-outline-variant, #e2e8f0);
    }
    .sidebar-title {
        font-weight: 600;
        color: var(--color-navy, #0b1c30);
        margin-bottom: 1rem;
        font-size: 1.125rem;
    }
    .sidebar-search {
        width: 100%;
        background: var(--color-surface-variant, #f1f5f9);
        padding: 0.75rem 1rem 0.75rem 3rem;
        border-radius: 0.75rem;
        border: none;
        font-size: 0.875rem;
        color: var(--color-on-surface, #1b1c1e);
        outline: none;
    }
    .sidebar-search-icon {
        position: absolute;
        left: 1rem;
        top: 0.75rem;
        color: var(--color-on-surface-variant, #43474d);
        font-size: 1.25rem;
    }
    .sidebar-posts-title {
        font-weight: 600;
        color: var(--color-navy, #0b1c30);
        margin-bottom: 1.5rem;
        font-size: 1.125rem;
    }
    .sidebar-posts-list {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .sidebar-card {
        display: flex;
        gap: 1rem;
        padding: 1rem;
        border: 1px solid var(--color-outline-variant, #e2e8f0);
        border-radius: 1rem;
        overflow: hidden;
        text-decoration: none;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
    }
    .sidebar-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    .sidebar-card-img {
        width: 96px;
        height: 96px;
        min-width: 96px;
        border-radius: 0.75rem;
        overflow: hidden;
        background: var(--color-surface-container-high, #e9e8ea);
    }
    .sidebar-card-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    .sidebar-card:hover .sidebar-card-img img {
        transform: scale(1.1);
    }
    .sidebar-card-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .sidebar-card-cat {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        color: rgba(11, 28, 48, 0.5);
        margin-bottom: 0.25rem;
    }
    .sidebar-card-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-navy, #0b1c30);
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .sidebar-card:hover .sidebar-card-title {
        color: var(--color-navy-light, #1a3a5c);
    }
    .sidebar-cta {
        background: var(--color-navy, #0b1c30);
        color: white;
        padding: 2rem;
        border-radius: 1.5rem;
        position: relative;
        overflow: hidden;
    }
    .sidebar-cta h3 {
        font-size: 1.5rem;
        font-weight: 700;
        color: white;
        margin-bottom: 1rem;
    }
    .sidebar-cta p {
        color: rgba(255,255,255,0.7);
        font-size: 0.875rem;
        margin-bottom: 1.5rem;
    }
    .sidebar-cta-btn {
        display: block;
        background: white;
        color: var(--color-navy, #0b1c30);
        padding: 0.75rem 1.5rem;
        border-radius: 0.75rem;
        font-weight: 700;
        text-align: center;
        text-decoration: none;
        transition: opacity 0.2s;
        width: 100%;
    }
    .sidebar-cta-btn:hover {
        opacity: 0.9;
    }
    .sidebar-cta-icon {
        position: absolute;
        right: -2rem;
        bottom: -2rem;
        opacity: 0.1;
    }
    .sidebar-space > * + * {
        margin-top: 2rem;
    }
</style>

<div style="padding-top: 8rem; padding-bottom: 96px;">
    {{-- Article Header --}}
    <section class="article-section article-header">
        <nav class="article-breadcrumb">
            <a href="{{ route('home') }}">Inicio</a>
            <span class="material-symbols-outlined" style="font-size: 1rem;">chevron_right</span>
            <a href="{{ route('blog') }}">Blog</a>
            <span class="material-symbols-outlined" style="font-size: 1rem;">chevron_right</span>
            <span style="color: var(--color-navy, #0b1c30); font-weight: 700;">{{ $articulo->titulo }}</span>
        </nav>

        <div class="article-header-grid">
            <div>
                <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                    <span class="article-badge">{{ $articulo->categoria }}</span>
                    <span class="article-date">{{ $articulo->created_at->translatedFormat('d \\d\\e F, Y') }}</span>
                </div>
                <h1 class="article-title">{{ $articulo->titulo }}</h1>
                <p class="article-subtitle">{{ $articulo->resumen }}</p>
            </div>
        </div>
    </section>

    {{-- Featured Image --}}
    @if($articulo->imagen)
    <section class="article-section article-featured-img">
        <div class="article-featured-img-inner">
            <img alt="{{ $articulo->titulo }}" src="{{ $articulo->imagen }}">
        </div>
    </section>
    @endif

    {{-- Article Content Layout --}}
    <section class="article-section article-content-grid">
        {{-- Main Content --}}
        <article>
            <div class="article-prose prose-first-letter">
                {!! $articulo->contenido !!}
            </div>

            {{-- Author Box --}}
            @if($articulo->autor_nombre)
            <div class="author-box">
                <div class="author-img">
                    @if($articulo->autor_imagen)
                    <img src="{{ $articulo->autor_imagen }}" alt="{{ $articulo->autor_nombre }}">
                    @else
                    <span class="material-symbols-outlined" style="font-size: 2rem; color: var(--color-on-surface-variant, #43474d);">person</span>
                    @endif
                </div>
                <div>
                    <h4 class="author-name">{{ $articulo->autor_nombre }}</h4>
                    @if($articulo->autor_rol)
                    <p class="author-role">{{ $articulo->autor_rol }}</p>
                    @endif
                </div>
            </div>
            @endif
        </article>

        {{-- Sidebar --}}
        <aside class="sidebar-space">
            {{-- Search --}}
            <div class="sidebar-box">
                <h3 class="sidebar-title">Buscar en el Blog</h3>
                <div style="position: relative;">
                    <input class="sidebar-search" placeholder="IA, Auditoría, Compliance..." type="text">
                    <span class="material-symbols-outlined sidebar-search-icon">search</span>
                </div>
            </div>

            {{-- Related Posts --}}
            @if($relacionados->isNotEmpty())
            <div>
                <h3 class="sidebar-posts-title">Artículos Relacionados</h3>
                <div class="sidebar-posts-list">
                    @foreach($relacionados as $relacionado)
                    <a class="sidebar-card" href="{{ route('articulo.show', $relacionado->slug) }}">
                        <div class="sidebar-card-img">
                            <img src="{{ $relacionado->imagen ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCBuuj0NGt4VNyE5sDWrp8_EHS90-1rZoaz_nA52qI99mSkLdSoTS8F9HClGCmDtB8j1DPbmmEhnD7MGIJDH-b2ggUfuSDjIRkDT6tEXRiE7T9DrTTEMR2I5rOnGb4jDRxfno5dm6LuZdZsAk8Cz77MKMKHX7UNjbChIqRdphvNZ7h_0YVCigsHcGaM0aFGaqUwREkWqX-tKdhp3j1F6L9qbW0InCJ8UaaKSrbGdFdJU2N7xmwidMhCePdnqy77J97zZ3zsWj2CROmQ' }}" alt="{{ $relacionado->titulo }}">
                        </div>
                        <div class="sidebar-card-text">
                            <span class="sidebar-card-cat">{{ $relacionado->categoria }}</span>
                            <h4 class="sidebar-card-title">{{ $relacionado->titulo }}</h4>
                        </div>
                    </a>
                    @endforeach
                </div>
            </div>
            @endif

            {{-- CTA Sidebar --}}
            <div class="sidebar-cta">
                <div style="position: relative; z-index: 10;">
                    <h3>¿Preparado para el futuro?</h3>
                    <p>Optimice sus procesos con nuestra tecnología de vanguardia.</p>
                    <a href="{{ route('consultoria.show') }}" class="sidebar-cta-btn">Agendar Consulta</a>
                </div>
                <div class="sidebar-cta-icon">
                    <span class="material-symbols-outlined" style="font-size: 120px;">auto_awesome</span>
                </div>
            </div>
        </aside>
    </section>
</div>
@endsection
