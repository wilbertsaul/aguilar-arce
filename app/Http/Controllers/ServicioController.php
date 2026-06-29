<?php

namespace App\Http\Controllers;

use App\Models\Servicio;

class ServicioController extends Controller
{
    public function show(string $slug)
    {
        $servicio = Servicio::where('slug', $slug)->where('activo', true)->firstOrFail();

        return view('servicios.show', compact('servicio'));
    }
}
