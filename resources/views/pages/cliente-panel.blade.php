@extends('layouts.app')

@section('title', 'Panel del cliente · BYT SOLUTION')

@section('content')
@php
    $sub = $suscripcion;
    $waLote = "https://wa.me/{$whatsapp}?text=" . rawurlencode('Hola, quiero cotizar la descarga masiva por período para mi empresa.');
@endphp

<section class="py-10 bg-byt-mist min-h-[70vh]">
    <div class="max-w-5xl mx-auto px-gutter space-y-6">

        {{-- Saldo --}}
        <div class="bg-white rounded-2xl border border-byt-line shadow-sm p-6 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <p class="text-xs text-byt-grey font-byt font-bold uppercase tracking-wider">Bienvenido, {{ $user->name }}</p>
                <h1 class="font-byt font-extrabold text-2xl text-byt-navy mt-1">Tu panel de descargas</h1>
                @if ($sub)
                    <p class="text-sm text-byt-grey mt-1">
                        Plan: <strong class="text-byt-navy">{{ $sub->plan->nombre ?? '—' }}</strong>
                        ({{ $sub->plan->periodicidad ?? '' }}) ·
                        Vence el {{ optional($sub->expira_at)->format('d/m/Y') }}
                    </p>
                @endif
            </div>
            <div class="text-right">
                <p class="text-[11px] text-byt-grey font-byt font-bold uppercase tracking-wider">Consultas disponibles</p>
                <p class="font-mono font-bold text-3xl text-byt-blue">{{ $sub ? $sub->saldo() : 0 }}</p>
                @if ($sub)
                    <p class="text-xs text-byt-grey">{{ $sub->consultas_usadas }} / {{ $sub->consultas_incluidas }} usadas</p>
                @endif
            </div>
        </div>

        @if (session('error'))
            <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-sm text-red-700">{{ session('error') }}</div>
        @endif
        @if (session('status'))
            <div class="bg-green-50 border border-green-200 rounded-xl p-4 text-sm text-green-700">{{ session('status') }}</div>
        @endif

        {{-- Descarga individual --}}
        <div class="bg-white rounded-2xl border border-byt-line shadow-sm p-6">
            <h2 class="font-byt font-extrabold text-lg text-byt-navy mb-1">Descarga individual (real)</h2>
            <p class="text-sm text-byt-grey mb-5">Descarga XML + CDR + PDF de un comprobante. Cada descarga consume 1 consulta.</p>

            <form id="form-descarga" class="space-y-4">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="byt-label" for="p-ruc">RUC de tu empresa (receptor)</label>
                        <input id="p-ruc" name="ruc" class="byt-input font-mono" maxlength="11" required>
                    </div>
                    <div>
                        <label class="byt-label" for="p-sol-user">Usuario SOL principal</label>
                        <input id="p-sol-user" name="sol_user" class="byt-input" maxlength="50" required>
                    </div>
                    <div>
                        <label class="byt-label" for="p-sol-pass">Clave SOL</label>
                        <input id="p-sol-pass" name="sol_password" type="password" class="byt-input" maxlength="100" required>
                    </div>
                    <div>
                        <label class="byt-label" for="p-ruc-emisor">RUC del emisor</label>
                        <input id="p-ruc-emisor" name="ruc_emisor" class="byt-input font-mono" maxlength="11" required>
                    </div>
                    <div>
                        <label class="byt-label" for="p-tipo">Tipo de comprobante</label>
                        <select id="p-tipo" name="tipo_comprobante" class="byt-input" required>
                            @foreach ($tipos as $cod => $nombre)
                                <option value="{{ $cod }}">{{ $cod }} — {{ $nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="byt-label" for="p-serie">Serie</label>
                            <input id="p-serie" name="serie" class="byt-input font-mono text-center" maxlength="4" required>
                        </div>
                        <div>
                            <label class="byt-label" for="p-corr">Correlativo</label>
                            <input id="p-corr" name="correlativo" class="byt-input font-mono text-center" maxlength="8" required>
                        </div>
                    </div>
                </div>

                <div class="flex flex-col sm:flex-row sm:items-center gap-3 pt-2">
                    <button type="submit" id="btn-descargar" class="btn-byt">
                        <span class="material-symbols-outlined text-[18px]">download</span>
                        Descargar comprobante (ZIP)
                    </button>
                    <span id="p-estado" class="text-xs text-byt-grey"></span>
                </div>
            </form>
        </div>

        {{-- Lote --}}
        <div class="bg-white rounded-2xl border border-byt-line shadow-sm p-6">
            <h2 class="font-byt font-extrabold text-lg text-byt-navy mb-1">Descarga por lote (por período)</h2>
            <p class="text-sm text-byt-grey mb-4">Descarga masiva de todos los comprobantes de un período (RCE). Cada comprobante del período consume 1 consulta.</p>
            <p class="text-xs text-byt-grey mb-4">
                Esta función requiere portar el flujo SIRE. Mientras tanto, solicita la activación por WhatsApp.
            </p>
            <a href="{{ $waLote }}" target="_blank" rel="noopener noreferrer" class="btn-byt">
                <span class="material-symbols-outlined text-[17px]">chat</span>
                Solicitar descarga masiva
            </a>
        </div>

        {{-- Historial --}}
        <div class="bg-white rounded-2xl border border-byt-line shadow-sm p-6">
            <h2 class="font-byt font-extrabold text-lg text-byt-navy mb-4">Historial de descargas</h2>
            @if ($consumos->isEmpty())
                <p class="text-sm text-byt-grey">Aún no has descargado comprobantes.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="text-left text-[11px] font-byt font-extrabold uppercase tracking-wider text-byt-grey border-b-2 border-byt-line">
                                <th class="py-2 pr-2">Fecha</th>
                                <th class="py-2 pr-2">Emisor</th>
                                <th class="py-2 pr-2">Tipo</th>
                                <th class="py-2 pr-2">Serie-Nro</th>
                                <th class="py-2 pr-2">Docs</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($consumos as $c)
                                <tr class="border-b border-byt-line/60">
                                    <td class="py-2 pr-2 text-xs">{{ $c->created_at->format('d/m/Y H:i') }}</td>
                                    <td class="py-2 pr-2 font-mono text-xs">{{ $c->ruc_emisor }}</td>
                                    <td class="py-2 pr-2 text-xs">{{ $c->tipo_comprobante }}</td>
                                    <td class="py-2 pr-2 font-mono text-xs">{{ $c->serie }}-{{ $c->correlativo }}</td>
                                    <td class="py-2 pr-2 text-xs">
                                        @if (is_array($c->documentos))
                                            {{ implode(', ', array_keys(array_filter($c->documentos))) }}
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>

        {{-- Logout --}}
        <div class="text-right">
            <form method="POST" action="{{ route('cliente.logout') }}" class="inline">
                @csrf
                <button type="submit" class="text-xs text-byt-grey hover:text-byt-navy">Cerrar sesión</button>
            </form>
        </div>
    </div>
</section>

@push('scripts')
<script>
(() => {
    const form = document.getElementById('form-descarga');
    const btn = document.getElementById('btn-descargar');
    const estado = document.getElementById('p-estado');

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        estado.textContent = 'Descargando…';
        btn.disabled = true;

        const fd = new FormData(form);
        try {
            const resp = await fetch('{{ route('cliente.descargar') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'Accept': 'application/zip, application/json',
                },
                body: fd,
            });

            if (!resp.ok) {
                let msg = 'No se pudo completar la descarga.';
                try { const j = await resp.json(); if (j && j.mensaje) msg = j.mensaje; } catch (_) {}
                estado.textContent = msg;
                return;
            }

            const blob = await resp.blob();
            const cd = resp.headers.get('Content-Disposition') || '';
            const m = cd.match(/filename="?([^"]+)"?/);
            const filename = m ? m[1] : 'comprobante.zip';

            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url; a.download = filename;
            document.body.appendChild(a); a.click(); a.remove();
            URL.revokeObjectURL(url);

            estado.textContent = 'Descarga completada: ' + filename;
            setTimeout(() => window.location.reload(), 1500);
        } catch (err) {
            estado.textContent = 'Error de red. Intente nuevamente.';
        } finally {
            btn.disabled = false;
        }
    });
})();
</script>
@endpush
@endsection