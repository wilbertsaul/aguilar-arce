<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        $planes = [
            ['nombre' => 'Básico', 'slug' => 'basico-mensual', 'periodicidad' => 'mensual', 'consultas' => 100, 'precio' => 50.00, 'beneficios' => ['Descarga individual (XML/CDR/PDF)', 'Soporte por email', '1 usuario'], 'orden' => 1],
            ['nombre' => 'Profesional', 'slug' => 'profesional-mensual', 'periodicidad' => 'mensual', 'consultas' => 500, 'precio' => 150.00, 'beneficios' => ['Descarga individual', 'Descarga por lote', 'Soporte por WhatsApp', '3 usuarios'], 'destacado' => true, 'orden' => 2],
            ['nombre' => 'Corporativo', 'slug' => 'corporativo-mensual', 'periodicidad' => 'mensual', 'consultas' => 2000, 'precio' => 450.00, 'beneficios' => ['Descarga individual', 'Descarga por lote', 'Soporte prioritario', '10 usuarios', 'API'], 'orden' => 3],
            ['nombre' => 'Básico', 'slug' => 'basico-anual', 'periodicidad' => 'anual', 'consultas' => 1200, 'precio' => 500.00, 'beneficios' => ['Bolsa anual de 1,200 consultas', 'Descarga individual', 'Soporte por email', '1 usuario'], 'orden' => 4],
            ['nombre' => 'Profesional', 'slug' => 'profesional-anual', 'periodicidad' => 'anual', 'consultas' => 6000, 'precio' => 1500.00, 'beneficios' => ['Bolsa anual de 6,000 consultas', 'Descarga individual y por lote', 'Soporte por WhatsApp', '3 usuarios'], 'destacado' => true, 'orden' => 5],
            ['nombre' => 'Corporativo', 'slug' => 'corporativo-anual', 'periodicidad' => 'anual', 'consultas' => 24000, 'precio' => 4500.00, 'beneficios' => ['Bolsa anual de 24,000 consultas', 'Descarga individual y por lote', 'Soporte prioritario', '10 usuarios', 'API'], 'orden' => 6],
        ];

        foreach ($planes as $p) {
            Plan::updateOrCreate(['slug' => $p['slug']], $p);
        }
    }
}