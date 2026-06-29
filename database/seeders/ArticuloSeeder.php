<?php

namespace Database\Seeders;

use App\Models\Articulo;
use Illuminate\Database\Seeder;

class ArticuloSeeder extends Seeder
{
    public function run(): void
    {
        Articulo::create([
            'titulo' => 'La desmaterialización de la banca corporativa',
            'slug' => 'desmaterializacion-banca-corporativa',
            'resumen' => 'Exploramos cómo las infraestructuras de nube están eliminando las barreras tradicionales del flujo de caja corporativo y qué significa esto para la liquidez a largo plazo...',
            'categoria' => 'Tendencias 2024',
            'destacado' => true,
            'activo' => true,
        ]);

        Articulo::create([
            'titulo' => 'IA en la Auditoría: Más allá del algoritmo',
            'slug' => 'ia-en-auditoria',
            'resumen' => 'Cómo la inteligencia artificial generativa está redefiniendo los estándares de cumplimiento y detección de fraude.',
            'categoria' => 'Análisis Técnico',
            'destacado' => false,
            'activo' => true,
        ]);

        Articulo::create([
            'titulo' => 'Resiliencia en Mercados Emergentes',
            'slug' => 'resiliencia-mercados-emergentes',
            'resumen' => 'Estrategias de cobertura para empresas con operaciones en LATAM frente a la volatilidad monetaria.',
            'categoria' => 'Global Markets',
            'destacado' => false,
            'activo' => true,
        ]);

        Articulo::create([
            'titulo' => 'El nuevo CFO: Estratega tecnológico',
            'slug' => 'nuevo-cfo-estratega-tecnologico',
            'resumen' => 'El cambio de perfil necesario para liderar la transformación digital desde el departamento financiero.',
            'categoria' => 'Talento & Cultura',
            'destacado' => false,
            'activo' => true,
        ]);
    }
}
