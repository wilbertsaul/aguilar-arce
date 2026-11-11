@extends('layouts.app')

@section('title', 'Aguilar & Arce Consultores | Contabilidad · Tributación · Auditoría')

@section('content')
    @include('components.hero')
    @include('components.trust-bar')
    @include('components.stats-banner')
    @include('components.services-section')
    @include('components.methodology-section')
    @include('components.facturador-section')
    @include('components.resources-section')
    @include('components.needs-section')
    @include('components.contact-section')
@endsection
