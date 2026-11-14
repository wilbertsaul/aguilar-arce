<?php

namespace App\Http\Controllers;

use App\Models\Consumo;
use App\Services\JsonPe\JsonPeClientService;
use App\Services\Sunat\XmlComprobanteParser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Throwable;
use ZipArchive;

class ClientePanelController extends Controller
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

    public function panel(Request $request)
    {
        $user = $request->user();
        $sub = $user->suscripcionActiva();

        return view('pages.cliente-panel', [
            'user' => $user,
            'suscripcion' => $sub,
            'tipos' => self::TIPOS,
            'consumos' => $user->consumos()->latest()->limit(20)->get(),
            'whatsapp' => \App\Models\Setting::get('contacto_whatsapp', '51957129087'),
        ]);
    }

    public function descargar(Request $request, JsonPeClientService $jsonpe, XmlComprobanteParser $parser)
    {
        $user = $request->user();
        $sub = $user->suscripcionActiva();

        if (! $sub || $sub->saldo() < 1) {
            return response()->json(['ok' => false, 'mensaje' => 'Sin consultas disponibles. Contacta para renovar.'], 402);
        }

        $validated = $request->validate([
            'ruc' => ['required', 'digits:11'],
            'sol_user' => ['required', 'string', 'max:50'],
            'sol_password' => ['required', 'string', 'max:100'],
            'ruc_emisor' => ['required', 'digits:11'],
            'tipo_comprobante' => ['required', 'in:'.implode(',', array_keys(self::TIPOS))],
            'serie' => ['required', 'regex:/^[A-Z0-9]{4}$/'],
            'correlativo' => ['required', 'digits_between:1,8'],
        ]);

        $ruc = $validated['ruc'];
        $solUser = $validated['sol_user'];
        $solPassword = $validated['sol_password'];
        $rucEmisor = $validated['ruc_emisor'];
        $tipo = $validated['tipo_comprobante'];
        $serie = strtoupper($validated['serie']);
        $correlativo = ltrim($validated['correlativo'], '0') ?: '0';

        if (! $jsonpe->isConfigured()) {
            return response()->json(['ok' => false, 'mensaje' => 'Servicio no configurado.'], 503);
        }

        DB::beginTransaction();
        try {
            // Bloqueo pesimista del saldo.
            $sub->refresh();
            if ($sub->saldo() < 1) {
                DB::rollBack();
                return response()->json(['ok' => false, 'mensaje' => 'Sin consultas disponibles.'], 402);
            }

            $xml = $jsonpe->descargarXml($ruc, $solUser, $solPassword, $rucEmisor, $tipo, $serie, $correlativo);

            $pdf = null;
            try {
                $pdf = $jsonpe->descargarPdf($ruc, $solUser, $solPassword, $rucEmisor, $tipo, $serie, $correlativo);
            } catch (Throwable $e) {
                // PDF opcional
            }

            $tmpZip = tempnam(sys_get_temp_dir(), 'descarga_').'.zip';
            $zip = new ZipArchive;
            if ($zip->open($tmpZip, ZipArchive::CREATE | ZipArchive::OVERWRITE) !== true) {
                throw new \RuntimeException('No se pudo crear el ZIP.');
            }
            $zip->addFromString($xml['xml_nombre'] ?: "{$serie}-{$correlativo}.xml", $xml['xml']);
            if (! empty($xml['cdr'])) {
                $zip->addFromString($xml['cdr_nombre'] ?: "R-{$serie}-{$correlativo}.xml", $xml['cdr']);
            }
            if ($pdf !== null) {
                $zip->addFromString("{$serie}-{$correlativo}.pdf", $pdf);
            }
            $zip->close();

            // Descontar 1 consulta.
            $sub->increment('consultas_usadas');
            Consumo::create([
                'user_id' => $user->id,
                'suscripcion_id' => $sub->id,
                'tipo' => 'individual',
                'ruc_emisor' => $rucEmisor,
                'tipo_comprobante' => $tipo,
                'serie' => $serie,
                'correlativo' => $correlativo,
                'documentos' => [
                    'xml' => true,
                    'cdr' => ! empty($xml['cdr']),
                    'pdf' => $pdf !== null,
                ],
            ]);

            DB::commit();

            $zipNombre = "{$rucEmisor}-{$tipo}-{$serie}-{$correlativo}.zip";
            return response()->streamDownload(function () use ($tmpZip) {
                readfile($tmpZip);
                @unlink($tmpZip);
            }, $zipNombre, ['Content-Type' => 'application/zip']);
        } catch (Throwable $e) {
            DB::rollBack();
            return response()->json(['ok' => false, 'mensaje' => 'No se pudo completar la descarga: '.$e->getMessage()], 422);
        }
    }
}