<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultoria extends Model
{
    protected $fillable = [
        'nombre',
        'email',
        'mensaje',
    ];
}
