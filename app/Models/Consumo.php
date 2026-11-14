<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Consumo extends Model
{
    protected $table = 'consumos';

    protected $fillable = [
        'user_id', 'suscripcion_id', 'tipo', 'ruc_emisor', 'tipo_comprobante',
        'serie', 'correlativo', 'documentos',
    ];

    protected $casts = [
        'documentos' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function suscripcion(): BelongsTo
    {
        return $this->belongsTo(Suscripcion::class);
    }
}