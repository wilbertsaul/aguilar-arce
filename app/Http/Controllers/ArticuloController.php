<?php

namespace App\Http\Controllers;

use App\Models\Articulo;

class ArticuloController extends Controller
{
    public function show(string $slug)
    {
        $articulo = Articulo::where('slug', $slug)->where('activo', true)->firstOrFail();

        $relacionados = Articulo::where('activo', true)
            ->where('id', '!=', $articulo->id)
            ->take(3)
            ->latest()
            ->get();

        return view('pages.articulo', compact('articulo', 'relacionados'));
    }

    public function blog()
    {
        $articulos = Articulo::where('activo', true)->latest()->paginate(9);

        $categorias = Articulo::where('activo', true)
            ->distinct()
            ->pluck('categoria')
            ->filter();

        return view('pages.blog', compact('articulos', 'categorias'));
    }
}
