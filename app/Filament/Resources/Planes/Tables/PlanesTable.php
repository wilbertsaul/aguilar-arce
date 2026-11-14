<?php

namespace App\Filament\Resources\Planes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class PlanesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('orden')->label('#')->sortable(),
                TextColumn::make('nombre')->label('Nombre')->searchable()->sortable(),
                TextColumn::make('periodicidad')->label('Periodicidad')->badge(),
                TextColumn::make('consultas')->label('Consultas')->numeric()->sortable(),
                TextColumn::make('precio')->label('Precio')->money('PEN')->sortable(),
                ToggleColumn::make('activo')->label('Activo'),
                ToggleColumn::make('destacado')->label('Destacado'),
            ])
            ->defaultSort('orden')
            ->recordActions([EditAction::make()])
            ->toolbarActions([
                BulkActionGroup::make([DeleteBulkAction::make()]),
            ]);
    }
}