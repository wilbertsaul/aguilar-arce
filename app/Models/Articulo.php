<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Articulo extends Model
{
    protected $fillable = [
        'titulo', 'slug', 'resumen', 'contenido', 'imagen',
        'autor_nombre', 'autor_rol', 'autor_imagen',
        'categoria', 'destacado', 'activo',
    ];

    protected $casts = [
        'destacado' => 'boolean',
        'activo' => 'boolean',
    ];

    protected static function booted()
    {
        static::creating(function (self $articulo) {
            if (empty($articulo->slug)) {
                $articulo->slug = Str::slug($articulo->titulo);
            }
        });
    }
}
