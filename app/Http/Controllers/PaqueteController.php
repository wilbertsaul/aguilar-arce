<?php

namespace App\Http\Controllers;

use App\Models\Plan;

class PaqueteController extends Controller
{
    public function index()
    {
        $planes = Plan::where('activo', true)->orderBy('orden')->get();

        return view('pages.paquetes', [
            'planes' => $planes,
            'whatsapp' => \App\Models\Setting::get('contacto_whatsapp', '51957129087'),
        ]);
    }
}