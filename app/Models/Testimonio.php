<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonio extends Model
{
    protected $fillable = [
        'nombre', 'cargo', 'empresa', 'texto', 'avatar', 'activo',
    ];

    protected $casts = [
        'activo' => 'boolean',
    ];
}
