<?php

namespace App\Filament\Resources\Testimonios\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Table;

class TestimoniosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('nombre')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('cargo')
                    ->label('Cargo'),
                TextColumn::make('empresa')
                    ->label('Empresa'),
                TextColumn::make('texto')
                    ->label('Testimonio')
                    ->limit(80),
                ToggleColumn::make('activo')
                    ->label('Activo'),
            ])
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
