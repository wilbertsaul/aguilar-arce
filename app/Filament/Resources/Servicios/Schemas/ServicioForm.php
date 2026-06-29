<?php

namespace App\Filament\Resources\Servicios\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ServicioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Servicio')
                    ->columns(2)
                    ->schema([
                        TextInput::make('titulo')
                            ->label('Título')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->helperText('Déjalo vacío para que se genere automáticamente.'),
                        Textarea::make('descripcion_corta')
                            ->label('Descripción Corta')
                            ->required()
                            ->rows(3),
                        Textarea::make('descripcion_larga')
                            ->label('Descripción Larga')
                            ->rows(6),
                        TextInput::make('icono')
                            ->label('Icono (Material Symbol)')
                            ->maxLength(255)
                            ->helperText('Ej: account_balance, receipt, devices'),
                        TextInput::make('orden')
                            ->label('Orden')
                            ->numeric()
                            ->default(0),
                        Toggle::make('activo')
                            ->label('Activo')
                            ->default(true),
                    ]),
            ]);
    }
}
