<?php

namespace App\Filament\Resources\Planes\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PlanForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('Paquete')
                ->columns(2)
                ->schema([
                    TextInput::make('nombre')
                        ->label('Nombre')
                        ->required()
                        ->maxLength(60),
                    TextInput::make('slug')
                        ->label('Slug')
                        ->required()
                        ->maxLength(60)
                        ->unique(ignoreRecord: true),
                    Select::make('periodicidad')
                        ->label('Periodicidad')
                        ->options(['mensual' => 'Mensual', 'anual' => 'Anual'])
                        ->required()
                        ->default('mensual'),
                    TextInput::make('consultas')
                        ->label('Consultas incluidas')
                        ->numeric()
                        ->required()
                        ->minValue(1),
                    TextInput::make('precio')
                        ->label('Precio (S/)')
                        ->numeric()
                        ->required()
                        ->prefix('S/'),
                    TextInput::make('orden')
                        ->label('Orden')
                        ->numeric()
                        ->default(0),
                    Toggle::make('destacado')
                        ->label('Destacado')
                        ->default(false),
                    Toggle::make('activo')
                        ->label('Activo')
                        ->default(true),
                    Textarea::make('beneficios')
                        ->label('Beneficios (uno por línea)')
                        ->rows(6)
                        ->columnSpanFull()
                        ->helperText('Se guardan como lista. Ej: Descarga individual, Soporte WhatsApp.')
                        ->formatStateUsing(fn ($state) => is_array($state) ? implode("\\n", $state) : $state)
                        ->dehydrateStateUsing(fn ($state) => $state ? array_values(array_filter(array_map('trim', explode("\\n", $state)))) : []),
                ]),
        ]);
    }
}