<?php

namespace App\Filament\Resources\Articulos\Schemas;

use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class ArticuloForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Información del Artículo')
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
                        TextInput::make('resumen')
                            ->label('Resumen')
                            ->required()
                            ->maxLength(255),
                        RichEditor::make('contenido')
                            ->label('Contenido')
                            ->columnSpanFull(),
                        TextInput::make('imagen')
                            ->label('URL de la imagen')
                            ->maxLength(255),
                        TextInput::make('categoria')
                            ->label('Categoría')
                            ->required()
                            ->maxLength(255),
                        Toggle::make('destacado')
                            ->label('Destacado'),
                        Toggle::make('activo')
                            ->label('Activo')
                            ->default(true),
                    ]),
            ]);
    }
}
