<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteAuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.cliente-login', [
            'whatsapp' => \App\Models\Setting::get('contacto_whatsapp', '51957129087'),
        ]);
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();
            if (! $user->esCliente()) {
                Auth::logout();
                return back()->withErrors(['email' => 'Esta cuenta no es de cliente.'])->withInput();
            }
            if (! $user->activo) {
                Auth::logout();
                return back()->withErrors(['email' => 'Tu cuenta está suspendida.'])->withInput();
            }

            return redirect()->intended(route('cliente.panel'));
        }

        return back()->withErrors(['email' => 'Credenciales incorrectas.'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('cliente.login');
    }
}