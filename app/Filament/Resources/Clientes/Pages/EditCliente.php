<?php

namespace App\Filament\Resources\Clientes\Pages;

use App\Filament\Resources\Clientes\ClienteResource;
use App\Models\Plan;
use App\Models\Suscripcion;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCliente extends EditRecord
{
    protected static string $resource = ClienteResource::class;

    protected function getHeaderActions(): array
    {
        return [DeleteAction::make()];
    }

    protected function afterSave(): void
    {
        $record = $this->record;
        $sub = $record->suscripcionActiva();

        if ($sub && isset($this->data['plan_id']) && $sub->plan_id != $this->data['plan_id']) {
            $plan = Plan::find($this->data['plan_id']);
            if ($plan) {
                $sub->update([
                    'plan_id' => $plan->id,
                    'periodo' => $plan->periodicidad,
                    'consultas_incluidas' => (int) ($this->data['consultas_incluidas'] ?? $plan->consultas),
                    'expira_at' => $this->data['expira_at'] ?? $sub->expira_at,
                ]);
            }
        } elseif ($sub) {
            $sub->update([
                'consultas_incluidas' => (int) ($this->data['consultas_incluidas'] ?? $sub->consultas_incluidas),
                'consultas_usadas' => (int) ($this->data['consultas_usadas'] ?? $sub->consultas_usadas),
                'expira_at' => $this->data['expira_at'] ?? $sub->expira_at,
                'estado' => $record->activo ? $sub->estado : 'suspendida',
            ]);
        }
    }
}