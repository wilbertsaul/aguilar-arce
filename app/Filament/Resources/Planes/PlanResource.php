<?php

namespace App\Filament\Resources\Planes;

use App\Filament\Resources\Planes\Pages\CreatePlan;
use App\Filament\Resources\Planes\Pages\EditPlan;
use App\Filament\Resources\Planes\Pages\ListPlanes;
use App\Filament\Resources\Planes\Schemas\PlanForm;
use App\Filament\Resources\Planes\Tables\PlanesTable;
use App\Models\Plan;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use UnitEnum;

class PlanResource extends Resource
{
    protected static ?string $model = Plan::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCurrencyDollar;

    protected static string|UnitEnum|null $navigationGroup = 'Descargas SUNAT';

    protected static ?string $navigationLabel = 'Planes';

    protected static ?int $navigationSort = 1;

    protected static ?string $modelLabel = 'Plan';

    protected static ?string $pluralModelLabel = 'Planes';

    public static function form(Schema $schema): Schema
    {
        return PlanForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return PlanesTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListPlanes::route('/'),
            'create' => CreatePlan::route('/create'),
            'edit' => EditPlan::route('/{record}/edit'),
        ];
    }
}