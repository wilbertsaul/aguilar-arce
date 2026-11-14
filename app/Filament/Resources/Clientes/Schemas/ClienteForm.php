<?php

namespace App\Filament\Resources\Clientes\Schemas;

use App\Models\Plan;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ClienteForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Datos del cliente')
                ->columns(2)
                ->schema([
                    TextInput::make('name')
                        ->label('Razón social / Nombre')
                        ->required()
                        ->maxLength(255),
                    TextInput::make('email')
                        ->label('Email (será el usuario)')
                        ->email()
                        ->required()
                        ->unique(ignoreRecord: true)
                        ->maxLength(255),
                    TextInput::make('ruc')
                        ->label('RUC')
                        ->maxLength(11)
                        ->regex('/^\d{11}$/')
                        ->helperText('11 dígitos'),
                    TextInput::make('telefono')
                        ->label('Teléfono / WhatsApp')
                        ->maxLength(20),
                    Toggle::make('activo')
                        ->label('Activo')
                        ->default(true),
                    Toggle::make('debe_cambiar_password')
                        ->label('Cambiar contraseña al ingresar')
                        ->default(true),
                ]),

            Section::make('Acceso y paquete')
                ->columns(2)
                ->schema([
                    TextInput::make('password')
                        ->label('Contraseña (se genera sola)')
                        ->password()
                        ->revealable()
                        ->default(fn () => \Illuminate\Support\Str::random(12))
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn ($state) => filled($state))
                        ->helperText('Copia esta contraseña antes de guardar. Luego no se podrá ver.'),
                    Select::make('plan_id')
                        ->label('Plan')
                        ->options(fn () => Plan::where('activo', true)
                            ->orderBy('orden')
                            ->get()
                            ->mapWithKeys(fn ($p) => [$p->id => "{$p->nombre} ({$p->periodicidad}) — {$p->consultas} consultas — S/ ".number_format((float)$p->precio, 2)]))
                        ->required()
                        ->live()
                        ->afterStateUpdated(function ($state, $set) {
                            $plan = Plan::find($state);
                            if ($plan) {
                                $set('consultas_incluidas', $plan->consultas);
                                $set('expira_at', now()->addDays($plan->periodicidad === 'anual' ? 365 : 30)->format('Y-m-d\TH:i'));
                            }
                        }),
                    TextInput::make('consultas_incluidas')
                        ->label('Consultas incluidas')
                        ->numeric()
                        ->required()
                        ->default(100),
                    TextInput::make('consultas_usadas')
                        ->label('Consultas usadas')
                        ->numeric()
                        ->default(0)
                        ->disabled()
                        ->hiddenOn('create'),
                ]),

            Section::make('Vigencia')
                ->columns(2)
                ->schema([
                    \Filament\Forms\Components\DateTimePicker::make('inicia_at')
                        ->label('Inicio')
                        ->default(now())
                        ->required(),
                    \Filament\Forms\Components\DateTimePicker::make('expira_at')
                        ->label('Vencimiento')
                        ->required(),
                ]),

            Section::make('Notas')
                ->schema([
                    Textarea::make('notas')
                        ->label('Notas internas')
                        ->rows(3),
                ]),
        ]);
    }
}