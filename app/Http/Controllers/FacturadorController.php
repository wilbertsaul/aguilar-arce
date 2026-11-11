<?php

namespace App\Http\Controllers;

use App\Models\Setting;

class FacturadorController extends Controller
{
    /**
     * Simulador de facturación electrónica (demostración del facturador propio).
     * No emite comprobantes reales ni se conecta a SUNAT: todo ocurre en el navegador.
     */
    public function index()
    {
        $config = [
            'razonSocial' => 'AGUILAR & ARCE CONSULTORES S.A.C.',
            'ruc' => Setting::get('empresa_ruc', '20608492011'),
            'direccion' => Setting::get('sede_puerto_maldonado', 'Av. Alameda Mz. F Lote 5').' - Puerto Maldonado',
            'logo' => asset('images/AA Consultores.png'),
            'whatsapp' => Setting::get('contacto_whatsapp', '51957129087'),
            'servicios' => [
                ['descripcion' => 'Honorarios Contables Mensuales', 'precio' => 350.00],
                ['descripcion' => 'Declaración Mensual IGV (SIRE / PLE)', 'precio' => 180.00],
                ['descripcion' => 'Planilla Electrónica PLAME (hasta 10 trabajadores)', 'precio' => 150.00],
                ['descripcion' => 'Conciliación Bancaria Mensual', 'precio' => 120.00],
                ['descripcion' => 'Asesoría Tributaria por hora', 'precio' => 90.00],
                ['descripcion' => 'Regularización de Libros Electrónicos', 'precio' => 480.00],
                ['descripcion' => 'Boleta de Pago Electrónica (por trabajador)', 'precio' => 12.00],
            ],
            'clientes' => [
                ['doc' => '20512345678', 'tipo' => 'RUC', 'nombre' => 'COMERCIAL LA SELVA S.A.C.', 'direccion' => 'Av. Perú 245, Puerto Maldonado'],
                ['doc' => '20487654321', 'tipo' => 'RUC', 'nombre' => 'TRANSPORTES MANU E.I.R.L.', 'direccion' => 'Jr. Las Palmeras 108, Puerto Maldonado'],
                ['doc' => '20608492011', 'tipo' => 'RUC', 'nombre' => 'AGUILAR & ARCE CONSULTORES S.A.C.', 'direccion' => 'Av. Alameda Mz. F Lote 5, Puerto Maldonado'],
                ['doc' => '10234567', 'tipo' => 'DNI', 'nombre' => 'MARIA QUISPE FLORES', 'direccion' => 'Urb. Ttio A-12, Cusco'],
                ['doc' => '08765432', 'tipo' => 'DNI', 'nombre' => 'JUAN PEREZ ROJAS', 'direccion' => 'Av. La Cultura 320, Cusco'],
            ],
        ];

        return view('pages.facturador', ['facturadorConfig' => $config]);
    }
}
