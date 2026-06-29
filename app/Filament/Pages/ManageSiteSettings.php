<?php

namespace App\Filament\Pages;

use App\Models\Setting;
use BackedEnum;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use UnitEnum;

class ManageSiteSettings extends Page implements HasForms
{
    use InteractsWithForms;
    protected string $view = 'filament.pages.manage-site-settings';

    protected static string | BackedEnum | null $navigationIcon = Heroicon::OutlinedCog6Tooth;

    protected static string | UnitEnum | null $navigationGroup = 'Contenido';

    protected static ?int $navigationSort = 4;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'hero_titulo' => Setting::get('hero_titulo', 'Transformamos números en'),
            'hero_subtitulo' => Setting::get('hero_subtitulo', 'decisiones estratégicas.'),
            'hero_descripcion' => Setting::get('hero_descripcion', 'Acompañamos a las empresas líderes en su evolución financiera y tecnológica mediante una visión audaz y datos precisos.'),
            'vision_titulo' => Setting::get('vision_titulo', 'El Nuevo Paradigma de la Consultoría'),
            'vision_texto' => Setting::get('vision_texto', 'En Aguilar & Arce no solo gestionamos procesos; redefinimos el potencial de su organización.'),
            'cta_titulo' => Setting::get('cta_titulo', 'Impulsemos juntos el crecimiento.'),
            'cta_descripcion' => Setting::get('cta_descripcion', 'Estamos listos para transformar su visión en resultados tangibles.'),
            'cta_boton' => Setting::get('cta_boton', 'Agendar Consultoría'),
        ]);
    }

    public function form(Schema $form): Schema
    {
        return $form
            ->schema([
                Section::make('Hero')
                    ->description('Texto de la sección principal')
                    ->columns(2)
                    ->schema([
                        TextInput::make('hero_titulo')
                            ->label('Título')
                            ->required(),
                        TextInput::make('hero_subtitulo')
                            ->label('Subtítulo (cursiva)')
                            ->required(),
                        Textarea::make('hero_descripcion')
                            ->label('Descripción')
                            ->columnSpanFull()
                            ->rows(3),
                    ]),
                Section::make('Visión')
                    ->description('Sección "El Nuevo Paradigma"')
                    ->schema([
                        TextInput::make('vision_titulo')
                            ->label('Título')
                            ->required(),
                        Textarea::make('vision_texto')
                            ->label('Texto')
                            ->rows(4),
                    ]),
                Section::make('CTA Final')
                    ->description('Sección de llamada a la acción')
                    ->columns(2)
                    ->schema([
                        TextInput::make('cta_titulo')
                            ->label('Título')
                            ->columnSpanFull()
                            ->required(),
                        Textarea::make('cta_descripcion')
                            ->label('Descripción')
                            ->columnSpanFull()
                            ->rows(2),
                        TextInput::make('cta_boton')
                            ->label('Texto del botón')
                            ->required(),
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

        $this->sendSuccessNotification();
    }
}
