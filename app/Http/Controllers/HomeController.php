<?php

namespace App\Http\Controllers;

use App\Models\Articulo;
use App\Models\Servicio;
use App\Models\Setting;
use App\Models\Testimonio;

class HomeController extends Controller
{
    public function index()
    {
        $servicios = Servicio::where('activo', true)->orderBy('orden')->get();
        $testimonios = Testimonio::where('activo', true)->get();
        $featured = Articulo::where('activo', true)->where('destacado', true)->get();
        $all = Articulo::where('activo', true)->where('destacado', false)->take(3)->get();

        $settings = Setting::pluck('value', 'key');

        $hero = [
            'titulo' => $settings['hero_titulo'] ?? null,
            'subtitulo' => $settings['hero_subtitulo'] ?? null,
            'descripcion' => $settings['hero_descripcion'] ?? null,
        ];

        $cta = [
            'titulo' => $settings['cta_titulo'] ?? null,
            'descripcion' => $settings['cta_descripcion'] ?? null,
            'boton' => $settings['cta_boton'] ?? null,
        ];

        $stats = [
            'clientes' => $settings['clientes_count'] ?? '1000',
            'proyectos' => $settings['proyectos_count'] ?? '1200',
            'anos' => $settings['anos_count'] ?? '8',
            'satisfaccion' => $settings['satisfaccion'] ?? '99',
        ];

        return view('pages.home', compact(
            'servicios', 'testimonios', 'featured', 'all',
            'hero', 'cta', 'stats'
        ));
    }
}
