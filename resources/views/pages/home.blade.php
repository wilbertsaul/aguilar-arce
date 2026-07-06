@extends('layouts.app')

@section('title', 'Aguilar & Arce | Consultoría Estratégica')

@section('content')
    @include('components.hero')
    @include('components.stats-banner')
    @include('components.services-section')
    @include('components.digital-section')
    @include('components.paradigm-section')
    @include('components.testimonials-section')
    @include('components.insights-section')
    @include('components.cta-section')
@endsection
