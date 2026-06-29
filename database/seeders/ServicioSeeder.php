<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        Servicio::create([
            'titulo' => 'Contabilidad',
            'slug' => 'contabilidad',
            'descripcion_corta' => 'Precisión quirúrgica en el cumplimiento fiscal y financiero. Transformamos el registro tradicional en un motor de visibilidad empresarial continua.',
            'descripcion_larga' => 'Nuestro equipo de expertos garantiza que cada transacción sea registrada con exactitud, proporcionando una base sólida para la toma de decisiones estratégicas.',
            'icono' => 'account_balance',
            'orden' => 1,
            'activo' => true,
        ]);

        Servicio::create([
            'titulo' => 'Auditoría',
            'slug' => 'auditoria',
            'descripcion_corta' => 'Evaluación crítica y constructiva para garantizar la integridad de sus operaciones. Mitigamos riesgos mediante auditorías de alto impacto estratégico.',
            'descripcion_larga' => 'Aseguramos que cada proceso cumpla con los más altos estándares de calidad y transparencia, proporcionando confianza a sus stakeholders.',
            'icono' => 'receipt',
            'orden' => 2,
            'activo' => true,
        ]);

        Servicio::create([
            'titulo' => 'Transformación Digital',
            'slug' => 'transformacion-digital',
            'descripcion_corta' => 'Implementación de arquitecturas digitales que automatizan el valor. Desde ERPs inteligentes hasta análisis de datos en tiempo real.',
            'descripcion_larga' => 'Redefinimos la infrastructura tecnológica de su empresa para impulsar la eficiencia operativa y la innovación continua.',
            'icono' => 'devices',
            'orden' => 3,
            'activo' => true,
        ]);
    }
}
