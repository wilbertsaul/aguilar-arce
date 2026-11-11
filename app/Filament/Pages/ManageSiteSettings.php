<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected string $view = 'filament.pages.manage-site-settings';

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string|UnitEnum|null $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 4;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'hero_titulo' => Setting::get('hero_titulo', 'Seguridad contable.'),
            'hero_subtitulo' => Setting::get('hero_subtitulo', 'Control tributario. Decisiones con información.'),
            'hero_descripcion' => Setting::get('hero_descripcion', 'Integramos servicios contables, tributarios, laborales y herramientas digitales para mantener la información de su empresa bajo control.'),
            'clientes_count' => Setting::get('clientes_count', '500'),
            'proyectos_count' => Setting::get('proyectos_count', '1200'),
            'anos_count' => Setting::get('anos_count', '8'),
            'satisfaccion' => Setting::get('satisfaccion', '99'),
            'contacto_horario' => Setting::get('contacto_horario', 'Lun–Vie · 8:30 a. m. – 6:30 p. m.'),
            'contacto_telefono_1' => Setting::get('contacto_telefono_1', '+51 957 129 087'),
            'contacto_telefono_2' => Setting::get('contacto_telefono_2', '+51 993 750 502'),
            'contacto_whatsapp' => Setting::get('contacto_whatsapp', '51957129087'),
            'contacto_email' => Setting::get('contacto_email', 'aguilaryarce.tributos@gmail.com'),
            'sede_puerto_maldonado' => Setting::get('sede_puerto_maldonado', 'Av. Alameda Mz. F Lote 5'),
            'sede_cusco' => Setting::get('sede_cusco', 'Jr. La Cultura'),
            'empresa_ruc' => Setting::get('empresa_ruc', '20608492011'),
            'facturador_titulo' => Setting::get('facturador_titulo', 'Facturación que se integra con su gestión contable.'),
            'facturador_descripcion' => Setting::get('facturador_descripcion', 'Emita comprobantes electrónicos y centralice la información de su empresa para facilitar sus procesos administrativos y contables.'),
            'facturador_combo_badge' => Setting::get('facturador_combo_badge', 'Ahorro 25%'),
            'facturador_combo_texto' => Setting::get('facturador_combo_texto', 'Pregunta por el combo <strong>Factura + Contabilidad</strong> mensual sin costo adicional de software.'),
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Hero')
                    ->description('Texto de la sección principal de la portada')
                    ->columns(2)
                    ->schema([
                        TextInput::make('hero_titulo')
                            ->label('Título (línea 1)')
                            ->required(),
                        TextInput::make('hero_subtitulo')
                            ->label('Subtítulo (línea destacada)')
                            ->required(),
                        Textarea::make('hero_descripcion')
                            ->label('Descripción')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
                Section::make('Estadísticas')
                    ->description('Banner de estadísticas (contadores animados)')
                    ->columns(4)
                    ->schema([
                        TextInput::make('clientes_count')
                            ->label('Clientes')
                            ->numeric()
                            ->required(),
                        TextInput::make('proyectos_count')
                            ->label('Proyectos')
                            ->numeric()
                            ->required(),
                        TextInput::make('anos_count')
                            ->label('Años de experiencia')
                            ->numeric()
                            ->required(),
                        TextInput::make('satisfaccion')
                            ->label('% Satisfacción')
                            ->numeric()
                            ->required(),
                    ]),
                Section::make('Contacto y Sedes')
                    ->description('Datos visibles en la barra superior, sección de contacto y pie de página')
                    ->columns(2)
                    ->schema([
                        TextInput::make('contacto_horario')
                            ->label('Horario de atención')
                            ->required()
                            ->columnSpanFull(),
                        TextInput::make('contacto_telefono_1')
                            ->label('Línea directa 01')
                            ->required(),
                        TextInput::make('contacto_telefono_2')
                            ->label('Línea directa 02')
                            ->required(),
                        TextInput::make('contacto_whatsapp')
                            ->label('WhatsApp corporativo (solo dígitos, con código de país)')
                            ->helperText('Ej: 51957129087 — se usa en los enlaces wa.me')
                            ->required(),
                        TextInput::make('contacto_email')
                            ->label('Correo institucional')
                            ->email()
                            ->required(),
                        TextInput::make('sede_puerto_maldonado')
                            ->label('Sede Puerto Maldonado')
                            ->required(),
                        TextInput::make('sede_cusco')
                            ->label('Sede Cusco')
                            ->required(),
                        TextInput::make('empresa_ruc')
                            ->label('RUC de la empresa')
                            ->required(),
                    ]),
                Section::make('Facturador (Simulador)')
                    ->description('Textos de la sección promocional del facturador y del combo')
                    ->columns(2)
                    ->schema([
                        TextInput::make('facturador_titulo')
                            ->label('Título de la sección')
                            ->required()
                            ->columnSpanFull(),
                        Textarea::make('facturador_descripcion')
                            ->label('Descripción')
                            ->rows(3)
                            ->columnSpanFull(),
                        TextInput::make('facturador_combo_badge')
                            ->label('Badge del combo (ej: Ahorro 25%)'),
                        TextInput::make('facturador_combo_texto')
                            ->label('Texto del combo')
                            ->helperText('Puede incluir HTML básico como <strong>.')
                            ->columnSpanFull(),
                    ]),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $data = $this->form->getState();

        foreach ($data as $key => $value) {
            Setting::set($key, $value);
        }

        Notification::make()
            ->title('Configuración guardada exitosamente')
            ->success()
            ->send();
    }
}
