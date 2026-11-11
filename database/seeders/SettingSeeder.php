<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        // Hero
        Setting::set('hero_titulo', 'Seguridad contable.');
        Setting::set('hero_subtitulo', 'Control tributario. Decisiones con información.');
        Setting::set('hero_descripcion', 'Integramos servicios contables, tributarios, laborales y herramientas digitales para mantener la información de su empresa bajo control.');

        // Estadísticas
        Setting::set('clientes_count', '500');
        Setting::set('proyectos_count', '1200');
        Setting::set('anos_count', '8');
        Setting::set('satisfaccion', '99');

        // Contacto y sedes
        Setting::set('contacto_horario', 'Lun–Vie · 8:30 a. m. – 6:30 p. m.');
        Setting::set('contacto_telefono_1', '+51 957 129 087');
        Setting::set('contacto_telefono_2', '+51 993 750 502');
        Setting::set('contacto_whatsapp', '51957129087');
        Setting::set('contacto_email', 'aguilaryarce.tributos@gmail.com');
        Setting::set('sede_puerto_maldonado', 'Av. Alameda Mz. F Lote 5');
        Setting::set('sede_cusco', 'Jr. La Cultura');
        Setting::set('empresa_ruc', '20608492011');

        // Facturador (simulador)
        Setting::set('facturador_titulo', 'Facturación que se integra con su gestión contable.');
        Setting::set('facturador_descripcion', 'Emita comprobantes electrónicos y centralice la información de su empresa para facilitar sus procesos administrativos y contables.');
        Setting::set('facturador_combo_badge', 'Ahorro 25%');
        Setting::set('facturador_combo_texto', 'Pregunta por el combo <strong>Factura + Contabilidad</strong> mensual sin costo adicional de software.');
    }
}
