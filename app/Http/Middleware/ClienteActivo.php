<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ClienteActivo
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user instanceof User || ! $user->esCliente()) {
            return redirect()->route('cliente.login');
        }

        if (! $user->activo) {
            return redirect()->route('cliente.login')->with('error', 'Tu cuenta está suspendida. Contacta a soporte.');
        }

        $sub = $user->suscripcionActiva();

        if (! $sub) {
            return redirect()->route('cliente.login')->with('error', 'No tienes una suscripción activa. Contacta para renovar.');
        }

        if ($sub->saldo() <= 0) {
            return redirect()->route('cliente.panel')->with('error', 'Agotaste tus consultas. Contacta para renovar.');
        }

        return $next($request);
    }
}