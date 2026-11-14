<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Suscripcion extends Model
{
    protected $table = 'suscripciones';

    protected $fillable = [
        'user_id', 'plan_id', 'periodo', 'consultas_incluidas', 'consultas_usadas',
        'inicia_at', 'expira_at', 'estado', 'notas',
    ];

    protected $casts = [
        'inicia_at' => 'datetime',
        'expira_at' => 'datetime',
        'consultas_incluidas' => 'integer',
        'consultas_usadas' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(Plan::class);
    }

    public function saldo(): int
    {
        return max(0, $this->consultas_incluidas - $this->consultas_usadas);
    }

    public function estaVigente(): bool
    {
        if ($this->estado !== 'activa') return false;
        if ($this->expira_at && $this->expira_at->isPast()) return false;
        return true;
    }

    public function consumir(int $cantidad = 1): bool
    {
        if (! $this->estaVigente()) return false;
        if ($this->saldo() < $cantidad) return false;

        $this->increment('consultas_usadas', $cantidad);
        return true;
    }
}