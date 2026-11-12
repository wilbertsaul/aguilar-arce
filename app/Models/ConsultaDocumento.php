<?php

namespace App\Models;

use App\Support\ConsultasCrypt;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;

class ConsultaDocumento extends Model
{
    protected $table = 'consultas_documento';

    protected $fillable = [
        'lookup_hash',
        'tipo',
        'nombre',
        'datos',
        'fuente',
        'hits',
        'consultado_at',
        'expira_at',
    ];

    protected $casts = [
        'hits' => 'integer',
        'consultado_at' => 'datetime',
        'expira_at' => 'datetime',
    ];

    protected function nombre(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => ConsultasCrypt::decryptString($value),
            set: fn (?string $value) => ConsultasCrypt::encryptString($value),
        );
    }

    protected function datos(): Attribute
    {
        return Attribute::make(
            get: fn (?string $value) => ConsultasCrypt::decryptArray($value),
            set: fn (?array $value) => ConsultasCrypt::encryptArray($value),
        );
    }
}
