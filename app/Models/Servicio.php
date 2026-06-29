<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Servicio extends Model
{
    protected $fillable = [
        'titulo', 'slug', 'descripcion_corta', 'descripcion_larga',
        'icono', 'orden', 'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
        'orden' => 'integer',
    ];

    protected static function booted()
    {
        static::creating(function (self $servicio) {
            if (empty($servicio->slug)) {
                $servicio->slug = Str::slug($servicio->titulo);
            }
        });
    }
}
