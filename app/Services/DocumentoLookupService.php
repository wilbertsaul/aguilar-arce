<?php

namespace App\Services;

use App\Models\ConsultaDocumento;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

/**
 * Consulta de DNI (RENIEC) y RUC (SUNAT) vía json.pe, con caché previa.
 *
 * Mismo flujo que el facturador de IziPay: primero se busca el documento
 * en la tabla de consultas y solo si no existe se gasta un crédito.
 */
class DocumentoLookupService
{
    public function isConfigured(): bool
    {
        return filled(config('services.jsonpe.key'));
    }

    /**
     * Devuelve 'DNI' o 'RUC' según la longitud del documento.
     */
    public static function tipo(string $documento): ?string
    {
        $documento = preg_replace('/\D/', '', $documento);

        return match (strlen($documento)) {
            8 => 'DNI',
            11 => 'RUC',
            default => null,
        };
    }

    public static function hash(string $tipo, string $documento): string
    {
        return hash_hmac('sha256', $tipo.'|'.$documento, (string) config('consultas.cache_key'));
    }

    /**
     * Registro vigente en la caché (sin gastar crédito).
     */
    public function cacheado(string $tipo, string $documento): ?ConsultaDocumento
    {
        $registro = ConsultaDocumento::query()
            ->where('lookup_hash', self::hash($tipo, $documento))
            ->where('expira_at', '>', now())
            ->first();

        if ($registro) {
            $registro->increment('hits');
        }

        return $registro;
    }

    /**
     * Consulta real al proveedor.
     *
     * @return array{ok: bool, nombre?: ?string, datos?: array, motivo?: string}
     */
    public function consultarApi(string $tipo, string $documento): array
    {
        if (! $this->isConfigured()) {
            return ['ok' => false, 'motivo' => 'no_configurado'];
        }

        $ruta = strtolower($tipo);
        $base = rtrim((string) config('services.jsonpe.base_url'), '/');

        try {
            $response = Http::acceptJson()
                ->withToken((string) config('services.jsonpe.key'))
                ->timeout((int) config('services.jsonpe.timeout', 15))
                ->post($base.'/'.$ruta, [$ruta => $documento]);
        } catch (\Throwable $e) {
            // Nunca registramos el número de documento.
            Log::warning('Consulta '.$tipo.' falló por red: '.$e->getMessage());

            return ['ok' => false, 'motivo' => 'error_red'];
        }

        if ($response->status() === 404) {
            return ['ok' => false, 'motivo' => 'no_encontrado'];
        }

        if (in_array($response->status(), [401, 403], true)) {
            Log::warning('Consulta '.$tipo.': credenciales de json.pe rechazadas ('.$response->status().').');

            return ['ok' => false, 'motivo' => 'credenciales'];
        }

        if (in_array($response->status(), [402, 429], true)) {
            Log::warning('Consulta '.$tipo.': sin créditos o límite del proveedor ('.$response->status().').');

            return ['ok' => false, 'motivo' => 'limite_proveedor'];
        }

        if ($response->failed()) {
            Log::warning('Consulta '.$tipo.' falló: HTTP '.$response->status().'.');

            return ['ok' => false, 'motivo' => 'error_red'];
        }

        $body = $response->json();

        if (! is_array($body) || empty($body['success']) || empty($body['data']) || ! is_array($body['data'])) {
            return ['ok' => false, 'motivo' => 'no_encontrado'];
        }

        return $tipo === 'DNI'
            ? $this->normalizarDni($body['data'])
            : $this->normalizarRuc($body['data']);
    }

    private function normalizarDni(array $data): array
    {
        $porPartes = trim(implode(' ', array_filter([
            $data['apellido_paterno'] ?? null,
            $data['apellido_materno'] ?? null,
            $data['nombres'] ?? null,
        ])));

        $nombre = $porPartes !== ''
            ? $porPartes
            : trim(str_replace(',', ' ', (string) ($data['nombre_completo'] ?? '')));

        return [
            'ok' => $nombre !== '',
            'motivo' => $nombre !== '' ? null : 'no_encontrado',
            'nombre' => $nombre !== '' ? mb_strtoupper($nombre) : null,
            'datos' => [
                'direccion' => trim((string) ($data['direccion_completa'] ?? $data['direccion'] ?? '')),
                'ubigeo' => $data['ubigeo_sunat'] ?? $data['ubigeo_reniec'] ?? null,
                'estado' => null,
                'condicion' => null,
            ],
        ];
    }

    private function normalizarRuc(array $data): array
    {
        $nombre = trim((string) ($data['nombre_o_razon_social'] ?? ''));

        return [
            'ok' => $nombre !== '',
            'motivo' => $nombre !== '' ? null : 'no_encontrado',
            'nombre' => $nombre !== '' ? mb_strtoupper($nombre) : null,
            'datos' => [
                'direccion' => trim((string) ($data['direccion_completa'] ?? $data['direccion'] ?? '')),
                'ubigeo' => $data['ubigeo_sunat'] ?? null,
                'estado' => $data['estado'] ?? null,
                'condicion' => $data['condicion'] ?? null,
                'distrito' => $data['distrito'] ?? null,
                'provincia' => $data['provincia'] ?? null,
                'departamento' => $data['departamento'] ?? null,
            ],
        ];
    }

    /**
     * Guarda el resultado vigente en la caché compartida.
     */
    public function guardar(string $tipo, string $documento, string $nombre, array $datos, string $fuente = 'jsonpe'): ConsultaDocumento
    {
        return ConsultaDocumento::updateOrCreate(
            ['lookup_hash' => self::hash($tipo, $documento)],
            [
                'tipo' => $tipo,
                'nombre' => $nombre,
                'datos' => $datos,
                'fuente' => $fuente,
                'consultado_at' => now(),
                'expira_at' => now()->addDays(max(1, (int) config('consultas.ttl_dias', 30))),
            ],
        );
    }
}
