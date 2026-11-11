<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        // Re-seed completo: la estructura anidada cambia, así que truncamos y recreamos.
        Servicio::truncate();

        Servicio::create([
            'titulo' => 'Outsourcing Contable Integral',
            'slug' => 'outsourcing-contable-integral',
            'categoria' => 'Contabilidad',
            'descripcion_corta' => 'Diseñado para: PYMES, empresas en crecimiento y profesionales que desean delegar el 100% de la carga operativa y tributaria en manos de un equipo experto.',
            'descripcion_larga' => null,
            'flujo' => 'Documentos → Registro → Conciliación → Estados Financieros',
            'sub_servicios' => [
                [
                    'titulo' => 'Gestión Contable y Financiera',
                    'items' => [
                        ['nombre' => 'Procesamiento de Información: Registro y categorización mensual de compras, ventas, caja y bancos.'],
                        ['nombre' => 'Libros Contables Electrónicos: Elaboración y presentación puntual de Libros Electrónicos (PLE / SIRE).'],
                        ['nombre' => 'Conciliación Bancaria: Control estricto de cuentas bancarias y cuentas de detracciones para evitar inconsistencias con la administración tributaria.'],
                        ['nombre' => 'Informes de Gestión: Entrega mensual de un reporte ejecutivo básico (Estado de Ganancias y Pérdidas) en lenguaje sencillo para evaluar la salud real del negocio.'],
                    ],
                ],
                [
                    'titulo' => 'Declaración y Cumplimiento Tributario',
                    'items' => [
                        ['nombre' => 'Liquidación de Impuestos: Cálculo y presentación mensual de Impuesto General a la Ventas (IGV) e Impuesto a la Renta.'],
                        ['nombre' => 'Declaración Jurada Anual: Elaboración, balance de cierre y presentación del Impuesto a la Renta Anual.'],
                        ['nombre' => 'Atención de Notificaciones: Gestión y respuesta rápida ante esquemas de citación, esquelas de inducción o cartas inductivas de la SUNAT.'],
                    ],
                ],
                [
                    'titulo' => 'Planilla y Gestión Laboral (Opcional / Add-on)',
                    'items' => [
                        ['nombre' => 'PLAME y T-Registro: Alta y baja de trabajadores, emisión de boletas de pago y cálculo de aportes (AFP/ONP, EsSalud).'],
                        ['nombre' => 'Cálculo de Beneficios Sociales: Determinación de gratificaciones, CTS, vacaciones y liquidaciones.'],
                    ],
                ],
            ],
            'icono' => 'account_balance',
            'orden' => 1,
            'activo' => true,
        ]);

        Servicio::create([
            'titulo' => 'Auditoría',
            'slug' => 'auditoria',
            'categoria' => 'Auditoría',
            'descripcion_corta' => 'Evaluación crítica y constructiva para garantizar la integridad de sus operaciones. Mitigamos riesgos mediante auditorías de alto impacto estratégico.',
            'descripcion_larga' => null,
            'flujo' => 'Planeamiento → Trabajo de Campo → Sustento → Informe',
            'sub_servicios' => [
                [
                    'titulo' => 'Evaluación de Riesgos',
                    'items' => [
                        ['nombre' => 'Identificación y análisis de riesgos financieros y operativos.'],
                        ['nombre' => 'Diseño de controles internos efectivos.'],
                    ],
                ],
                [
                    'titulo' => 'Cumplimiento Normativo',
                    'items' => [
                        ['nombre' => 'Revisión de cumplimiento de normativas legales y tributarias.'],
                        ['nombre' => 'Emisión de informes de cumplimiento.'],
                    ],
                ],
            ],
            'icono' => 'security',
            'orden' => 2,
            'activo' => true,
        ]);

        Servicio::create([
            'titulo' => 'Transformación Digital',
            'slug' => 'transformacion-digital',
            'categoria' => 'Tecnología',
            'descripcion_corta' => 'Implementación de arquitecturas digitales que automatizan el valor. Desde ERPs inteligentes hasta análisis de datos en tiempo real.',
            'descripcion_larga' => null,
            'flujo' => 'Diagnóstico → Implementación → Integración → Control',
            'sub_servicios' => [
                [
                    'titulo' => 'Infraestructura Digital',
                    'items' => [
                        ['nombre' => 'Implementación de sistemas ERP y software de gestión.'],
                        ['nombre' => 'Migración a la nube y modernización tecnológica.'],
                    ],
                ],
                [
                    'titulo' => 'Analítica de Datos',
                    'items' => [
                        ['nombre' => 'Dashboards y reportes automatizados en tiempo real.'],
                        ['nombre' => 'Inteligencia de negocio para la toma de decisiones.'],
                    ],
                ],
            ],
            'icono' => 'devices',
            'orden' => 3,
            'activo' => true,
        ]);
    }
}
