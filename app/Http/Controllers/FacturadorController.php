<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Services\DocumentoLookupService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;

class FacturadorController extends Controller
{
    /**
     * Simulador BYTFACT: réplica del flujo de facturación electrónica.
     *
     * Emisión 100% simulada. Lo único real es la consulta de DNI/RUC
     * (json.pe) para que el autocompletado muestre datos verdaderos.
     */
    public function index()
    {
        $lookup = app(DocumentoLookupService::class);

        $config = [
            'emisor' => [
                'razonSocial' => 'BYTFACT DEMO S.A.C.',
                'ruc' => '20601234567',
                'direccion' => 'Av. Javier Prado Este 1234, San Isidro, Lima',
                'telefono' => '(01) 555-0100',
                'email' => 'demo@bytfact.pe',
            ],
            'sistema' => [
                'nombre' => 'bytfact.',
                'lema' => 'FACTURACIÓN ELECTRÓNICA',
                'logo' => asset('images/bytfact/bytfact-logo.png'),
                'logoBlanco' => asset('images/bytfact/bytfact-logo-blanco.png'),
            ],
            'whatsapp' => Setting::get('contacto_whatsapp', '51957129087'),
            'servicios' => [
                ['descripcion' => 'Servicio de consultoría mensual', 'precio' => 350.00],
                ['descripcion' => 'Desarrollo de software (hito)', 'precio' => 1200.00],
                ['descripcion' => 'Soporte técnico remoto', 'precio' => 180.00],
                ['descripcion' => 'Licencia anual BYTFACT', 'precio' => 720.00],
                ['descripcion' => 'Capacitación por sesión', 'precio' => 250.00],
                ['descripcion' => 'Implementación y migración de datos', 'precio' => 900.00],
            ],
            'clientes' => [
                ['doc' => '20512345678', 'tipo' => 'RUC', 'nombre' => 'COMERCIAL LA SELVA S.A.C.', 'direccion' => 'Av. Perú 245, Puerto Maldonado'],
                ['doc' => '20487654321', 'tipo' => 'RUC', 'nombre' => 'TRANSPORTES MANU E.I.R.L.', 'direccion' => 'Jr. Las Palmeras 108, Puerto Maldonado'],
                ['doc' => '10234567', 'tipo' => 'DNI', 'nombre' => 'MARIA QUISPE FLORES', 'direccion' => 'Urb. Ttio A-12, Cusco'],
                ['doc' => '08765432', 'tipo' => 'DNI', 'nombre' => 'JUAN PEREZ ROJAS', 'direccion' => 'Av. La Cultura 320, Cusco'],
            ],
            'consulta' => [
                'habilitada' => $lookup->isConfigured(),
                'endpoint' => route('facturador.consultar'),
                'limitePorIp' => (int) config('consultas.por_ip_dia'),
                'globalDia' => (int) config('consultas.global_dia'),
            ],
        ];

        return view('pages.facturador', ['facturadorConfig' => $config]);
    }

    /**
     * Consulta real de DNI/RUC con caché compartida y cupos por IP.
     */
    public function consultarDocumento(Request $request, DocumentoLookupService $lookup): JsonResponse
    {
        $validated = $request->validate([
            'documento' => ['required', 'string', 'regex:/^\d{8}$|^\d{11}$/'],
        ], [
            'documento.regex' => 'Ingrese un DNI de 8 dígitos o un RUC de 11 dígitos.',
        ]);

        $documento = $validated['documento'];
        $tipo = DocumentoLookupService::tipo($documento);

        if (! $lookup->isConfigured()) {
            return $this->demo('No hay proveedor configurado en este entorno. Complete los datos a mano.');
        }

        // 1) Caché compartida: no consume cupo ni créditos.
        if ($registro = $lookup->cacheado($tipo, $documento)) {
            return response()->json([
                'ok' => true,
                'tipo' => $tipo,
                'nombre' => $registro->nombre,
                'datos' => $registro->datos ?? [],
                'fuente' => 'cache',
                'restantes' => $this->restantes($request->ip()),
                'demo' => false,
            ]);
        }

        // 2) Ráfaga (anti-bot): 10 por minuto.
        $burstKey = 'consulta:rafaga:'.$request->ip();
        if (RateLimiter::tooManyAttempts($burstKey, (int) config('consultas.rafaga_por_minuto', 10))) {
            return $this->demo('Demasiadas solicitudes seguidas. Espere un minuto o continúe en modo demo.', 429);
        }
        RateLimiter::hit($burstKey, 60);

        // 3) Cupo diario por IP.
        $restantes = $this->restantes($request->ip());
        if ($restantes <= 0) {
            return $this->demo('Ya usó sus '.config('consultas.por_ip_dia').' consultas reales de hoy. Puede continuar en modo demo.');
        }

        // 4) Tope global diario (protege los créditos del proveedor).
        if ($this->globalUsadas() >= (int) config('consultas.global_dia', 50)) {
            return $this->demo('Se alcanzó el límite de consultas reales por hoy. Continúe en modo demo.');
        }

        $resultado = $lookup->consultarApi($tipo, $documento);

        // Una consulta no encontrada igual consumió un crédito del proveedor.
        if (! $resultado['ok'] && $resultado['motivo'] !== 'no_encontrado') {
            return $this->respuestaError($resultado['motivo'] ?? 'error_red');
        }

        $this->consumir($request->ip());

        if (! $resultado['ok']) {
            return response()->json([
                'ok' => false,
                'motivo' => 'no_encontrado',
                'mensaje' => 'El '.$tipo.' no aparece en los padrones consultados. Verifique el número o complete los datos a mano.',
                'restantes' => $this->restantes($request->ip()),
                'demo' => true,
            ], 404);
        }

        $registro = $lookup->guardar($tipo, $documento, $resultado['nombre'], $resultado['datos'] ?? []);

        return response()->json([
            'ok' => true,
            'tipo' => $tipo,
            'nombre' => $registro->nombre,
            'datos' => $registro->datos ?? [],
            'fuente' => 'jsonpe',
            'restantes' => $this->restantes($request->ip()),
            'demo' => false,
        ]);
    }

    private function consumir(string $ip): void
    {
        $ttl = max(60, now()->diffInSeconds(now()->endOfDay()) + 1);

        $ipKey = 'consulta:ip:'.$ip.':'.now()->toDateString();
        Cache::add($ipKey, 0, $ttl);
        Cache::increment($ipKey);

        $globalKey = 'consulta:global:'.now()->toDateString();
        Cache::add($globalKey, 0, $ttl);
        Cache::increment($globalKey);
    }

    private function restantes(string $ip): int
    {
        $usadas = (int) Cache::get('consulta:ip:'.$ip.':'.now()->toDateString(), 0);

        return max(0, (int) config('consultas.por_ip_dia', 2) - $usadas);
    }

    private function globalUsadas(): int
    {
        return (int) Cache::get('consulta:global:'.now()->toDateString(), 0);
    }

    private function respuestaError(string $motivo): JsonResponse
    {
        $mensaje = match ($motivo) {
            'credenciales' => 'El servicio de consulta rechazó las credenciales. Continúe en modo demo.',
            'limite_proveedor' => 'El proveedor agotó su cuota de consultas. Continúe en modo demo.',
            'no_configurado' => 'No hay proveedor configurado en este entorno. Complete los datos a mano.',
            default => 'No se pudo conectar con el padrón. Continúe en modo demo.',
        };

        return response()->json([
            'ok' => false,
            'motivo' => $motivo,
            'mensaje' => $mensaje,
            'demo' => true,
        ], 503);
    }

    private function demo(string $mensaje, int $status = 200): JsonResponse
    {
        return response()->json([
            'ok' => false,
            'motivo' => 'limite',
            'mensaje' => $mensaje,
            'demo' => true,
        ], $status);
    }
}
