@extends('layouts.app')

@section('title', 'Acceso clientes · BYT SOLUTION')

@section('content')
<section class="py-16 bg-byt-mist min-h-[70vh]">
    <div class="max-w-md mx-auto px-gutter">
        <div class="bg-white rounded-2xl border border-byt-line shadow-xl p-8">
            <div class="text-center mb-6">
                <h1 class="font-byt font-extrabold text-2xl text-byt-navy">Acceso clientes</h1>
                <p class="text-sm text-byt-grey mt-1">Descargas SUNAT con tu paquete</p>
            </div>

            @if (session('error'))
                <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="mb-4 bg-red-50 border border-red-200 rounded-xl p-3 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('cliente.login.post') }}" class="space-y-4">
                @csrf
                <div>
                    <label class="byt-label" for="email">Usuario (email)</label>
                    <input id="email" name="email" type="email" class="byt-input" value="{{ old('email') }}" required autofocus>
                </div>
                <div>
                    <label class="byt-label" for="password">Contraseña</label>
                    <input id="password" name="password" type="password" class="byt-input" required>
                </div>
                <label class="flex items-center gap-2 text-xs text-byt-grey">
                    <input type="checkbox" name="remember" value="1">
                    Recordarme
                </label>
                <button type="submit" class="btn-byt w-full">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Ingresar
                </button>
            </form>

            <p class="text-xs text-byt-grey mt-6 text-center">
                ¿No tienes acceso? <a href="https://wa.me/{{ $whatsapp }}" target="_blank" class="text-byt-blue font-bold">Solicita tu paquete</a>
            </p>
        </div>
    </div>
</section>
@endsection