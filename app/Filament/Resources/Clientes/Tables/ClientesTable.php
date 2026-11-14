<?php

namespace App\Filament\Resources\Clientes\Tables;

use App\Models\Suscripcion;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')->label('Cliente')->searchable()->sortable(),
                TextColumn::make('email')->label('Usuario')->searchable(),
                TextColumn::make('ruc')->label('RUC'),
                TextColumn::make('telefono')->label('Teléfono'),
                TextColumn::make('suscripcion.plan.nombre')->label('Plan')->badge(),
                TextColumn::make('suscripcion.consultas_incluidas')->label('Incluidas')->numeric(),
                TextColumn::make('suscripcion.consultas_usadas')->label('Usadas')->numeric(),
                TextColumn::make('suscripcion.saldo')->label('Saldo')
                    ->getStateUsing(fn ($record) => $record->suscripcionActiva()?->saldo() ?? 0)
                    ->badge()
                    ->color(fn ($state) => $state > 0 ? 'success' : 'danger'),
                TextColumn::make('suscripcion.expira_at')->label('Vence')->date('d/m/Y'),
                ToggleColumn::make('activo')->label('Activo'),
            ])
            ->defaultSort('created_at', 'desc')
            ->recordActions([
                EditAction::make(),
                Action::make('regenerarClave')
                    ->label('Regenerar clave')
                    ->icon('heroicon-o-key')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $plain = Str::random(12);
                        $record->update(['password' => Hash::make($plain), 'debe_cambiar_password' => true]);
                        \Filament\Notifications\Notification::make()
                            ->title('Nueva contraseña generada')
                            ->body("Usuario: {$record->email}\nContraseña: {$plain}\nEnvía estas credenciales al cliente.")
                            ->success()
                            ->persistent()
                            ->send();
                    }),
                Action::make('renovar')
                    ->label('Renovar 30/365 días')
                    ->icon('heroicon-o-arrow-path')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function ($record) {
                        $sub = $record->suscripcionActiva();
                        if ($sub && $sub->plan) {
                            $dias = $sub->plan->periodicidad === 'anual' ? 365 : 30;
                            $sub->update([
                                'consultas_usadas' => 0,
                                'inicia_at' => now(),
                                'expira_at' => now()->addDays($dias),
                                'estado' => 'activa',
                            ]);
                            \Filament\Notifications\Notification::make()
                                ->title('Suscripción renovada')
                                ->body("Vence el {$sub->expira_at->format('d/m/Y')}. Consultas reiniciadas.")
                                ->success()
                                ->send();
                        }
                    }),
                Action::make('suspender')
                    ->label(fn ($record) => $record->activo ? 'Suspender' : 'Reactivar')
                    ->icon('heroicon-o-no-symbol')
                    ->color('danger')
                    ->action(fn ($record) => $record->update(['activo' => ! $record->activo])),
            ])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}