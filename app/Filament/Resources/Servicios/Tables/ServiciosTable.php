<?php

namespace App\Filament\Resources\Servicios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class ServiciosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orden')
                    ->label('#')
                    ->sortable(),
                TextColumn::make('titulo')
                    ->label('Título')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('descripcion_corta')
                    ->label('Descripción')
                    ->limit(60),
                ToggleColumn::make('activo')
                    ->label('Activo'),
            ])
            ->defaultSort('orden')
            ->filters([])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
