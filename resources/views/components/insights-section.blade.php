<style>
    .insights-section {
        padding: 80px 0;
        background: var(--color-surface-low, #f9fafb);
    }
    .insights-container {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 24px;
    }
    .insights-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 3rem;
    }
    @media (min-width: 1024px) {
        .insights-grid { grid-template-columns: 2fr 1fr; }
    }
    .insights-main-glass {
        border-radius: 1rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(226, 232, 240, 0.5);
    }
    .insights-main-glass:first-child {
        margin-bottom: 1.5rem;
    }
    .insights-post-grid {
        display: grid;
        grid-template-columns: 1fr;
        gap: 1.25rem;
    }
    @media (min-width: 640px) {
        .insights-post-grid { grid-template-columns: 1fr 1fr; }
    }
    @media (min-width: 1024px) {
        .insights-post-grid { grid-template-columns: 1fr 1fr; }
    }
    .insights-post-card {
        display: flex;
        gap: 1rem;
        text-decoration: none;
        transition: transform 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
        border-radius: 1rem;
        padding: 0.5rem;
    }
    .insights-post-card:hover {
        transform: translateY(-4px);
    }
    .insights-post-img {
        width: 80px;
        height: 80px;
        min-width: 80px;
        border-radius: 1rem;
        overflow: hidden;
        background: var(--color-surface-container-high, #e9e8ea);
    }
    .insights-post-img img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }
    .insights-post-text {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .insights-post-cat {
        font-size: 10px;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        color: rgba(11, 28, 48, 0.5);
        margin-bottom: 0.25rem;
    }
    .insights-post-title {
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--color-navy, #0b1c30);
        line-height: 1.4;
    }
    .insights-post-card:hover .insights-post-title {
        color: var(--color-navy-light, #0a2a4a);
    }
    .insights-sidebar-glass {
        border-radius: 1rem;
        padding: 1.5rem;
        background: rgba(255, 255, 255, 0.85);
        backdrop-filter: blur(20px);
        -webkit-backdrop-filter: blur(20px);
        border: 1px solid rgba(226, 232, 240, 0.5);
    }
    .insights-sidebar-title {
        font-size: 0.75rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        font-weight: 600;
        color: var(--color-navy, #0b1c30);
        margin-bottom: 1.5rem;
        padding-bottom: 0.75rem;
        border-bottom: 1px solid rgba(11, 28, 48, 0.05);
    }
    .insights-sidebar-links {
        display: flex;
        flex-direction: column;
        gap: 1rem;
    }
    .insights-sidebar-link {
        text-decoration: none;
        color: var(--color-on-surface-variant, #43474d);
        font-size: 0.875rem;
        font-weight: 500;
        transition: color 0.2s;
        display: block;
    }
    .insights-sidebar-link:hover {
        color: var(--color-navy, #0b1c30);
    }
    .insights-view-all {
        display: inline-flex;
        align-items: center;
        margin-top: 3rem;
        padding: 0.75rem 1.5rem;
        background: transparent;
        color: var(--color-navy, #0b1c30);
        border: 1px solid rgba(11, 28, 48, 0.2);
        border-radius: 9999px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.4s ease;
    }
    .insights-view-all:hover {
        background: var(--color-navy, #0b1c30);
        color: white;
        border-color: var(--color-navy, #0b1c30);
        box-shadow: 0 20px 40px rgba(0, 28, 55, 0.1);
    }
    .insights-view-all-arrow {
        transition: transform 0.3s;
    }
    .insights-view-all:hover .insights-view-all-arrow {
        transform: translateX(4px);
    }
    .insights-center {
        text-align: center;
    }
    .insights-justify {
        display: flex;
        justify-content: center;
    }
</style>

<section class="insights-section" id="blog">
    <div class="insights-container">
        <div class="insights-grid">
            {{-- Main Column --}}
            <div>
                @foreach($featured as $index => $articulo)
                <a href="{{ route('articulo.show', $articulo->slug) }}" class="insights-main-glass @if($index === 0)@endif">
                    <div class="insights-post-grid">
                        <div class="insights-post-img">
                            <img src="{{ $articulo->imagen ?? 'https://lh3.googleusercontent.com/aida-public/AB6AXuCBuuj0NGt4VNyE5sDWrp8_EHS90-1rZoaz_nA52qI99mSkLdSoTS8F9HClGCmDtB8j1DPbmmEhnD7MGIJDH-b2ggUfuSDjIRkDT6tEXRiE7T9DrTTEMR2I5rOnGb4jDRxfno5dm6LuZdZsAk8Cz77MKMKHX7UNjbChIqRdphvNZ7h_0YVCigsHcGaM0aFGaqUwREkWqX-tKdhp3j1F6L9qbW0InCJ8UaaKSrbGdFdJU2N7xmwidMhCePdnqy77J97zZ3zsWj2CROmQ' }}" alt="{{ $articulo->titulo }}">
                        </div>
                        <div class="insights-post-text">
                            <span class="insights-post-cat">{{ $articulo->categoria }}</span>
                            <h4 class="insights-post-title">{{ $articulo->titulo }}</h4>
                        </div>
                    </div>
                </a>
                @endforeach

                <div class="insights-center">
                    <a href="{{ route('blog') }}" class="insights-view-all">
                        Ver todos
                        <span class="material-symbols-outlined insights-view-all-arrow" style="font-size: 1.25rem; margin-left: 0.5rem;">arrow_forward</span>
                    </a>
                </div>
            </div>

            {{-- Sidebar --}}
            <div>
                <div class="insights-sidebar-glass">
                    <h3 class="insights-sidebar-title">Explorar</h3>
                    <div class="insights-sidebar-links">
                        @foreach($all as $articulo)
                        <a href="{{ route('articulo.show', $articulo->slug) }}" class="insights-sidebar-link">
                            {{ $articulo->titulo }}
                        </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
