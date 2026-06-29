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
        Setting::set('vision_titulo', 'El Nuevo Paradigma de la Consultoría');
        Setting::set('vision_texto', 'En Aguilar & Arce no solo gestionamos procesos; redefinimos el potencial de su organización. A través de la integración de inteligencia analítica y experiencia técnica, hemos facilitado el crecimiento de más de 500+ corporaciones a nivel global. Nuestra metodología ha gestionado activos por un valor superior a los 1.2k millones de dólares, asegurando que cada cifra sea un peldaño hacia la expansión sostenible.');
        Setting::set('cta_titulo', 'Impulsemos juntos el crecimiento.');
        Setting::set('cta_descripcion', 'Estamos listos para transformar su visión en resultados tangibles. Agende una sesión de diagnóstico hoy mismo.');
        Setting::set('cta_boton', 'Agendar Consultoría');
    }
}
