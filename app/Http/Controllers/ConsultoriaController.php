<?php

namespace App\Http\Controllers;

use App\Models\Consultoria;
use App\Mail\ConsultoriaRecibida;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ConsultoriaController extends Controller
{
    public function show()
    {
        return view('pages.consultoria');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|max:2000',
        ]);

        $consultoria = Consultoria::create($validated);

        Mail::to('aguilaryarceconsultores@gmail.com')
            ->send(new ConsultoriaRecibida($consultoria));

        return redirect()
            ->route('consultoria.show')
            ->with('success', '¡Solicitud enviada correctamente! Nos comunicaremos contigo pronto.');
    }
}
