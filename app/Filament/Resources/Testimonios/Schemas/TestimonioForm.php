<?php

namespace App\Filament\Resources\Testimonios\Schemas;

use Filament\Schemas\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class TestimonioForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Testimonio')
                    ->columns(2)
                    ->schema([
                        TextInput::make('nombre')
                            ->label('Nombre')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('cargo')
                            ->label('Cargo')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('empresa')
                            ->label('Empresa')
                            ->required()
                            ->maxLength(255),
                        Textarea::make('texto')
                            ->label('Testimonio')
                            ->required()
                            ->rows(4),
                        TextInput::make('avatar')
                            ->label('URL del Avatar')
                            ->maxLength(255),
                        Toggle::make('activo')
                            ->label('Activo')
                            ->default(true),
                    ]),
            ]);
    }
}
