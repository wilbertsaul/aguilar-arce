<?php

namespace App\Filament\Resources\Servicios\Schemas;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
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
                            ->maxLength(255)
                            ->columnSpanFull(),
                        TextInput::make('slug')
                            ->label('Slug')
                            ->maxLength(255)
                            ->helperText('Déjalo vacío para que se genere automáticamente.'),
                        TextInput::make('categoria')
                            ->label('Categoría')
                            ->maxLength(255)
                            ->helperText('Ej: Outsourcing, Auditoría, Consultoría.'),
                        Textarea::make('descripcion_corta')
                            ->label('Descripción Corta')
                            ->required()
                            ->rows(3)
                            ->columnSpanFull(),
                        Textarea::make('descripcion_larga')
                            ->label('Descripción Larga')
                            ->helperText('Texto que se muestra al expandir el servicio.')
                            ->rows(4)
                            ->columnSpanFull(),
                        TextInput::make('flujo')
                            ->label('Flujo metodológico')
                            ->maxLength(255)
                            ->helperText('Proceso del servicio separado por flechas. Se muestra en la tarjeta. Ej: Documentos → Registro → Conciliación → Estados Financieros')
                            ->columnSpanFull(),
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
                                'work' => '<span class="material-symbols-outlined align-middle mr-2">work</span> Trabajo / Laboral',
                                'gavel' => '<span class="material-symbols-outlined align-middle mr-2">gavel</span> Legal / Fiscal',
                                'description' => '<span class="material-symbols-outlined align-middle mr-2">description</span> Documentos',
                            ]),
                        Grid::make(2)->schema([
                            TextInput::make('orden')
                                ->label('Orden')
                                ->numeric()
                                ->default(0),
                            Toggle::make('activo')
                                ->label('Activo')
                                ->default(true),
                        ]),
                    ]),

                Section::make('Sub-servicios (Categorías)')
                    ->helperText('Define las categorías que se muestran al expandir el servicio. Ej: "Gestión Contable y Financiera" con sus items.')
                    ->schema([
                        Repeater::make('sub_servicios')
                            ->label('Categorías')
                            ->schema([
                                TextInput::make('titulo')
                                    ->label('Nombre de la categoría')
                                    ->required()
                                    ->maxLength(255)
                                    ->placeholder('Ej: Gestión Contable y Financiera'),
                                Repeater::make('items')
                                    ->label('Items')
                                    ->schema([
                                        TextInput::make('nombre')
                                            ->label('Item')
                                            ->required()
                                            ->maxLength(500),
                                    ])
                                    ->defaultItems(1)
                                    ->itemLabel(fn (array $state): ?string => $state['nombre'] ?? null)
                                    ->addActionLabel('Agregar item')
                                    ->reorderable()
                                    ->collapsible(),
                            ])
                            ->defaultItems(1)
                            ->itemLabel(fn (array $state): ?string => $state['titulo'] ?? null)
                            ->addActionLabel('Agregar categoría')
                            ->reorderable()
                            ->collapsible(),
                    ]),
            ]);
    }
}
