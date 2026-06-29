@extends('layouts.app')

@section('title', 'Aguilar & Arce | Consultoría Estratégica')

@section('content')
    @include('components.hero')
    @include('components.paradigm-section')
    @include('components.services-section')
    @include('components.insights-section')
    @include('components.testimonials-section')
    @include('components.cta-section')
@endsection

@push('scripts')
<script>
    const observerOptions = { threshold: 0.1 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('active');
            }
        });
    }, observerOptions);
    document.querySelectorAll('.reveal-on-scroll').forEach((el) => observer.observe(el));

    window.addEventListener('scroll', () => {
        const nav = document.getElementById('navbar');
        if (window.scrollY > 50) {
            nav.classList.add('h-16');
            nav.classList.remove('h-20');
        } else {
            nav.classList.add('h-20');
            nav.classList.remove('h-16');
        }
    });
</script>
@endpush
