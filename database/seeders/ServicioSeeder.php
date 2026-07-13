<?php

namespace Database\Seeders;

use App\Models\Servicio;
use Illuminate\Database\Seeder;

class ServicioSeeder extends Seeder
{
    public function run(): void
    {
        Servicio::create([
            'titulo' => 'Servicios Contables',
            'slug' => 'servicios-contables',
            'categoria' => 'Servicios Contables',
            'descripcion_corta' => 'Gestión contable integral con precisión y transparencia. Transformamos datos financieros en información estratégica para la toma de decisiones.',
            'descripcion_larga' => 'Nuestro equipo de expertos garantiza el registro contable preciso y oportuno, proporcionando una base sólida para la gestión financiera de su empresa.',
            'sub_servicios' => [
                'Registro contable mensual.',
                'Elaboración de estados financieros.',
                'Conciliaciones bancarias.',
                'Cierre contable mensual y anual.',
                'Análisis financiero.',
            ],
            'icono' => 'account_balance',
            'orden' => 1,
            'activo' => true,
        ]);

        Servicio::create([
            'titulo' => 'Servicios Tributarios',
            'slug' => 'servicios-tributarios',
            'categoria' => 'Servicios Tributarios',
            'descripcion_corta' => 'Cumplimiento tributario efectivo y estratégico. Minimizamos riesgos y optimizamos la carga fiscal de su empresa.',
            'descripcion_larga' => 'Le asesoramos en todas sus obligaciones tributarias, garantizando el cumplimiento normativo y la optimización de su posición fiscal.',
            'sub_servicios' => [
                'Declaración mensual de impuestos (IGV, Renta).',
                'Declaración anual del Impuesto a la Renta.',
                'Libros electrónicos (PLE).',
                'Atención de fiscalizaciones de SUNAT.',
                'Fraccionamientos y aplazamientos.',
                'Levantamiento de restricciones y actualización de RUC.',
            ],
            'icono' => 'receipt',
            'orden' => 2,
            'activo' => true,
        ]);

        Servicio::create([
            'titulo' => 'Servicios Laborales',
            'slug' => 'servicios-laborales',
            'categoria' => 'Servicios Laborales',
            'descripcion_corta' => 'Administración laboral completa y cumplimiento normativo. Protegemos su empresa y aseguramos el bienestar de su equipo.',
            'descripcion_larga' => 'Gestionamos todos los aspectos laborales de su empresa, desde planillas hasta beneficios sociales, garantizando el cumplimiento legal.',
            'sub_servicios' => [
                'Elaboración de planillas.',
                'T-Registro.',
                'PLAME.',
                'AFP Net.',
                'Cálculo de beneficios sociales (CTS, gratificaciones, vacaciones).',
                'Liquidaciones de beneficios sociales.',
                'Contratos de trabajo.',
            ],
            'icono' => 'groups',
            'orden' => 3,
            'activo' => true,
        ]);

        Servicio::create([
            'titulo' => 'Constitución y Asesoría Empresarial',
            'slug' => 'constitucion-asesoria-empresarial',
            'categoria' => 'Constitución y Asesoría Empresarial',
            'descripcion_corta' => 'Acompañamiento integral desde la constitución hasta el crecimiento de su negocio. Su socio estratégico confiable.',
            'descripcion_larga' => 'Le guiamos en cada paso del proceso de constitución y desarrollo empresarial, brindando asesoría experta para el éxito de su emprendimiento.',
            'sub_servicios' => [
                'Constitución de empresas.',
                'Elección del régimen tributario.',
                'Trámite de RUC.',
                'Licencias y asesoría para el inicio de actividades.',
                'Asesoría permanente para emprendedores.',
            ],
            'icono' => 'handshake',
            'orden' => 4,
            'activo' => true,
        ]);

        Servicio::create([
            'titulo' => 'Otros Servicios',
            'slug' => 'otros-servicios',
            'categoria' => 'Otros Servicios',
            'descripcion_corta' => 'Soluciones contables y administrativas especializadas. Completamos su operación con servicios complementarios de alto valor.',
            'descripcion_larga' => 'Ofrecemos una gama de servicios adicionales diseñados para cubrir todas las necesidades administrativas y financieras de su empresa.',
            'sub_servicios' => [
                'Emisión de facturas electrónicas.',
                'Elaboración de reportes financieros.',
                'Presupuestos y flujo de caja.',
                'Costeo de proyectos.',
                'Asesoría para cooperativas y asociaciones.',
                'Elaboración de reglamentos y políticas administrativas.',
                'Auditoría interna y revisión de procesos.',
            ],
            'icono' => 'lightbulb',
            'orden' => 5,
            'activo' => true,
        ]);
    }
}
