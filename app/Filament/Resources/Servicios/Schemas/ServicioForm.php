<?php

namespace App\Filament\Resources\Servicios\Schemas;

use Filament\Schemas\Components\Section;
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
                        Select::make('icono')
                            ->label('Icono')
                            ->allowHtml()
                            ->options([
                                'account_balance' => '<span class="material-symbols-outlined align-middle mr-2">account_balance</span> Banco / Contabilidad',
                                'receipt' => '<span class="material-symbols-outlined align-middle mr-2">receipt</span> Factura / Recibo',
                                'calculate' => '<span class="material-symbols-outlined align-middle mr-2">calculate</span> Calculadora',
                                'analytics' => '<span class="material-symbols-outlined align-middle mr-2">analytics</span> Analítica / Datos',
                                'trending_up' => '<span class="material-symbols-outlined align-middle mr-2">trending_up</span> Crecimiento',
                                'security' => '<span class="material-symbols-outlined align-middle mr-2">security</span> Seguridad / Auditoría',
                                'devices' => '<span class="material-symbols-outlined align-middle mr-2">devices</span> Tecnología / Dispositivos',
                                'insights' => '<span class="material-symbols-outlined align-middle mr-2">insights</span> Insights / Perspectivas',
                                'groups' => '<span class="material-symbols-outlined align-middle mr-2">groups</span> Equipo / Personas',
                                'handshake' => '<span class="material-symbols-outlined align-middle mr-2">handshake</span> Alianza / Partnership',
                                'lightbulb' => '<span class="material-symbols-outlined align-middle mr-2">lightbulb</span> Innovación',
                                'bar_chart' => '<span class="material-symbols-outlined align-middle mr-2">bar_chart</span> Gráfico / Estadísticas',
                            ]),
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
