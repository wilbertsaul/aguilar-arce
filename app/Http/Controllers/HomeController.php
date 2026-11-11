<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Servicio;
use App\Models\Setting;
use Illuminate\Support\Facades\Crypt;

class HomeController extends Controller
{
    public function index()
    {
        $servicios = Servicio::where('activo', true)->orderBy('orden')->get();

        $all = Articulo::where('activo', true)
            ->orderBy('created_at', 'desc')
            ->take(3)
            ->get();

        $settings = Setting::pluck('value', 'key');

        $hero = [
            'titulo' => $settings['hero_titulo'] ?? null,
            'subtitulo' => $settings['hero_subtitulo'] ?? null,
            'descripcion' => $settings['hero_descripcion'] ?? null,
        ];

        $stats = [
            'clientes' => $settings['clientes_count'] ?? '500',
            'proyectos' => $settings['proyectos_count'] ?? '1200',
            'anos' => $settings['anos_count'] ?? '15',
            'satisfaccion' => $settings['satisfaccion'] ?? '99',
        ];

        // Timestamp encriptado para el time-trap del formulario de evaluación preliminar
        $formTimestamp = Crypt::encryptString(now()->timestamp);

        return view('pages.home', compact(
            'servicios', 'all', 'hero', 'stats', 'formTimestamp'
        ));
    }
}
