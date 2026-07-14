<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::set('hero_titulo', 'Transformamos números en');
        Setting::set('hero_subtitulo', 'decisiones estratégicas.');
        Setting::set('hero_descripcion', 'Acompañamos a las empresas líderes en su evolución financiera y tecnológica mediante una visión audaz y datos precisos.');
        Setting::set('cta_titulo', 'Impulsemos juntos el crecimiento.');
        Setting::set('cta_descripcion', 'Estamos listos para transformar su visión en resultados tangibles.');
        Setting::set('cta_boton', 'Agendar Consultoría');
        Setting::set('clientes_count', '1000');
        Setting::set('proyectos_count', '1200');
        Setting::set('anos_count', '8');
        Setting::set('satisfaccion', '99');
    }
}
