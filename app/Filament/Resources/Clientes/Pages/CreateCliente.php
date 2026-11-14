<?php

namespace App\Filament\Resources\Clientes\Pages;

use App\Filament\Resources\Clientes\ClienteResource;
use App\Models\Plan;
use App\Models\Suscripcion;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateCliente extends CreateRecord
{
    protected static string $resource = ClienteResource::class;

    protected ?string $plainPassword = null;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if (empty($data['password'])) {
            $data['password'] = Str::random(12);
        }
        $this->plainPassword = $data['password'];

        // rol cliente por defecto
        $data['rol'] = $data['rol'] ?? 'cliente';

        return $data;
    }

    protected function afterCreate(): void
    {
        $record = $this->record;
        $plan = Plan::find($this->data['plan_id'] ?? null);

        if ($plan) {
            Suscripcion::create([
                'user_id' => $record->id,
                'plan_id' => $plan->id,
                'periodo' => $plan->periodicidad,
                'consultas_incluidas' => (int) ($this->data['consultas_incluidas'] ?? $plan->consultas),
                'consultas_usadas' => (int) ($this->data['consultas_usadas'] ?? 0),
                'inicia_at' => $this->data['inicia_at'] ?? now(),
                'expira_at' => $this->data['expira_at'] ?? now()->addDays($plan->periodicidad === 'anual' ? 365 : 30),
                'estado' => 'activa',
                'notas' => $this->data['notas'] ?? null,
            ]);
        }
    }

    protected function getCreatedNotification(): ?\Filament\Notifications\Notification
    {
        $email = $this->record->email;
        $pass = $this->plainPassword ?? '(no disponible)';

        return \Filament\Notifications\Notification::make()
            ->title('Cliente creado — envía estas credenciales')
            ->body("Usuario: {$email}\nContraseña: {$pass}\n\nCopia y envía por WhatsApp o email.")
            ->success()
            ->persistent()
            ->send();
    }
}