<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Plan extends Model
{
    protected $table = 'planes';

    protected $fillable = [
        'nombre', 'slug', 'periodicidad', 'consultas', 'precio',
        'beneficios', 'destacado', 'orden', 'activo',
    ];

    protected $casts = [
        'beneficios' => 'array',
        'destacado' => 'boolean',
        'activo' => 'boolean',
        'precio' => 'decimal:2',
    ];

    public function suscripciones(): HasMany
    {
        return $this->hasMany(Suscripcion::class);
    }

    public function precioFormateado(): string
    {
        return 'S/ '.number_format((float) $this->precio, 2);
    }
}