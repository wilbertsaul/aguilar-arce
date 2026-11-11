<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultoria extends Model
{
    protected $fillable = [
        'nombre',
        'empresa_ruc',
        'email',
        'whatsapp',
        'etapa',
        'requerimientos',
        'mensaje',
    ];
}
