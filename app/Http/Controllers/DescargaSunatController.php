<?php

namespace App\Http\Controllers;

use App\Services\JsonPe\JsonPeClientService;
use App\Services\Sunat\XmlComprobanteParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;
use ZipArchive;

class DescargaSunatController extends Controller
{
    private const TIPOS = [
        '01' => 'Factura',
        '03' => 'Boleta de venta',
        '07' => 'Nota de crédito',
        '08' => 'Nota de débito',
        '09' => 'Guía de remisión',
        '20' => 'Comprobante de retención',
        '40' => 'Comprobante de percepción',
    ];

    public function index()
    {
        $jsonpe = app(JsonPeClientService::class);

        $config = [
            'jsonpeConfigurado' => $jsonpe->isConfigured(),
            'tipos' => self::TIPOS,
            'limitePorIp' => (int) config('consultas.sunat_por_ip_dia', 1),
            'globalDia' => (int) config('consultas.sunat_global_dia', 10),
        ];

        return view('pages.descarga-sunat', [
            'descargaConfig' => $config,
            'whatsapp' => \App\Models\Setting::get('contacto_whatsapp', '51957129087'),
        ]);
    }

    /**
     * Descarga real de XML / CDR / PDF de un comprobante de SUNAT.
     */
    public function consultar(Request $request, JsonPeClientService $jsonpe, XmlComprobanteParser $parser)
    {
        $validated = $request->validate([
            'ruc' => ['required', 'digits:11'],
            'sol_user' => ['required', 'string', 'max:50'],
            'sol_password' => ['required', 'string', 'max:100'],
            'ruc_emisor' => ['required', 'digits:11'],
            'tipo_comprobante' => ['required', 'in:'.implode(',', array_keys(self::TIPOS))],
            'serie' => ['required', 'regex:/^[A-Z0-9]{4}$/'],
            'correlativo' => ['required', 'digits_between:1,8'],
            'consentimiento' => ['accepted'],
        ], [
            'ruc.required' => 'Indique el RUC de su empresa.',
            'ruc.digits' => 'El RUC de la empresa debe tener 11 dígitos.',
            'sol_user.required' => 'Indique el usuario SOL principal.',
            'sol_password.required' => 'Indique la clave SOL.',
            'ruc_emisor.required' => 'Indique el RUC del emisor.',
            'ruc_emisor.digits' => 'El RUC del emisor debe tener 11 dígitos.',
            'tipo_comprobante.required' => 'Seleccione el tipo de comprobante.',
            'serie.required' => 'Indique la serie.',
            'serie.regex' => 'La serie debe tener 4 caracteres alfanuméricos.',
            'correlativo.required' => 'Indique el correlativo.',
            'correlativo.digits_between' => 'El correlativo debe tener entre 1 y 8 dígitos.',
            'consentimiento.accepted' => 'Debe aceptar el uso de sus credenciales SOL.',
        ]);

        $ip = $request->ip();
        $ruc = $validated['ruc'];
        $solUser = $validated['sol_user'];
        $solPassword = $validated['sol_password'];
        $rucEmisor = $validated['ruc_emisor'];
        $tipo = $validated['tipo_comprobante'];
        $serie = strtoupper($validated['serie']);
        // SUNAT/json.pe esperan el correlativo sin ceros a la izquierda (numérico).
        $correlativo = ltrim($validated['correlativo'], '0');
        if ($correlativo === '') {
            $correlativo = '0';
        }

        if (! $jsonpe->isConfigured()) {
            return response()->json([
                'ok' => false,
                'mensaje' => 'El servicio de descarga no está configurado.',
            ], 503);
        }

        // 1) Lock de concurrencia: una sola consulta a la vez por IP.
        $lockKey = 'descarga:sunat:lock:'.$ip;
        $lock = Cache::lock($lockKey, 300);
        if (! $lock->get()) {
            return response()->json([
                'ok' => false,
                'mensaje' => 'Ya tiene una descarga en proceso. Espere a que termine.',
            ], 429);
        }

        try {
            // 2) Cupo diario por IP.
            $porIpDia = (int) config('consultas.sunat_por_ip_dia', 1);
            $usadasIp = (int) Cache::get('descarga:sunat:ip:'.$ip.':'.now()->toDateString(), 0);
            if ($usadasIp >= $porIpDia) {
                return response()->json([
                    'ok' => false,
                    'mensaje' => "Ya usó su consulta del día. Vuelva mañana.",
                ], 429);
            }

            // 3) Tope global diario.
            $globalDia = (int) config('consultas.sunat_global_dia', 10);
            $usadasGlobal = (int) Cache::get('descarga:sunat:global:'.now()->toDateString(), 0);
            if ($usadasGlobal >= $globalDia) {
                return response()->json([
                    'ok' => false,
                    'mensaje' => 'Se alcanzó el límite diario de descargas. Intente mañana.',
                ], 429);
            }

            // 4) Descarga real.
            $xml = $jsonpe->descargarXml($ruc, $solUser, $solPassword, $rucEmisor, $tipo, $serie, $correlativo);

            $meta = [];
            try {
                $meta = $parser->parse($xml['xml'], $tipo);
            } catch (Throwable $e) {
                $meta = [];
            }

            $pdf = null;
            $pdfError = null;
            try {
                $pdf = $jsonpe->descargarPdf($ruc, $solUser, $solPassword, $rucEmisor, $tipo, $serie, $correlativo);
            } catch (Throwable $e) {
                $pdfError = $e->getMessage();
            }

            // 5) Empaquetar en ZIP.
            $nombreBase = "{$rucEmisor}-{$tipo}-{$serie}-{$correlativo}";
            $tmpZip = tempnam(sys_get_temp_dir(), 'descarga_').'.zip';
            $zip = new ZipArchive;
            if ($zip->open($tmpZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new RuntimeException('No se pudo crear el archivo ZIP.');
            }

            $zip->addFromString($xml['xml_nombre'] ?: "{$serie}-{$correlativo}.xml", $xml['xml']);
            if (! empty($xml['cdr'])) {
                $zip->addFromString($xml['cdr_nombre'] ?: "R-{$serie}-{$correlativo}.xml", $xml['cdr']);
            }
            if ($pdf !== null) {
                $zip->addFromString("{$serie}-{$correlativo}.pdf", $pdf);
            }
            $zip->close();

            // 6) Consumir cupo.
            $ttl = max(60, now()->diffInSeconds(now()->endOfDay()) + 1);
            $ipKey = 'descarga:sunat:ip:'.$ip.':'.now()->toDateString();
            Cache::add($ipKey, 0, $ttl);
            Cache::increment($ipKey);
            $globalKey = 'descarga:sunat:global:'.now()->toDateString();
            Cache::add($globalKey, 0, $ttl);
            Cache::increment($globalKey);

            // 7) Entregar ZIP.
            $restantes = max(0, $porIpDia - ((int) Cache::get($ipKey, 0)));
            $zipNombre = "{$nombreBase}.zip";

            return response()->streamDownload(function () use ($tmpZip) {
                readfile($tmpZip);
                @unlink($tmpZip);
            }, $zipNombre, [
                'Content-Type' => 'application/zip',
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'ok' => false,
                'mensaje' => $this->mensajeError($e->getMessage()),
            ], 422);
        } finally {
            $lock->release();
        }
    }

    private function mensajeError(string $msg): string
    {
        $lower = strtolower($msg);
        if (str_contains($lower, 'credencia') || str_contains($lower, 'usuario') || str_contains($lower, 'password') || str_contains($lower, 'autentic')) {
            return 'Credenciales SOL incorrectas. Verifique usuario y clave.';
        }
        if (str_contains($lower, 'no se pudo obtener') || str_contains($lower, 'no devolvió')) {
            return 'No se pudo obtener el comprobante. Verifique los datos (RUC, tipo, serie, correlativo).';
        }
        return 'No se pudo completar la descarga. Intente nuevamente.';
    }
}