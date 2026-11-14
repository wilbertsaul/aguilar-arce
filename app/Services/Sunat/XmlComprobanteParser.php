<?php

namespace App\Services\Sunat;

use Carbon\Carbon;
use RuntimeException;
use SimpleXMLElement;

class XmlComprobanteParser
{
    private const NS_CBC = 'urn:oasis:names:specification:ubl:schema:xsd:CommonBasicComponents-2';
    private const NS_CAC = 'urn:oasis:names:specification:ubl:schema:xsd:CommonAggregateComponents-2';

    public function parse(string $contenido, ?string $tipoEsperado = null): array
    {
        $xml = $this->cargar($contenido);

        $fecha = $this->primerXpath($xml, '//cbc:IssueDate');

        if ($fecha === null) {
            throw new RuntimeException('El XML no contiene la fecha de emisión (cbc:IssueDate).');
        }

        $moneda = strtoupper((string) $this->primerXpath($xml, '//cbc:DocumentCurrencyCode')) ?: 'PEN';

        return [
            'fecha_emision' => $this->normalizarFecha($fecha),
            'moneda' => substr($moneda, 0, 3),
            'importe_total' => $this->importeTotal($xml),
            'razon_social_emisor' => $this->primerXpath($xml, '//cac:AccountingSupplierParty//cac:PartyLegalEntity/cbc:RegistrationName'),
            'numero' => $this->primerXpath($xml, '//cbc:ID'),
            'tipo_comprobante' => $this->tipoComprobante($xml) ?? $tipoEsperado,
        ];
    }

    private function cargar(string $contenido): SimpleXMLElement
    {
        $contenido = trim($contenido);

        if ($contenido === '') {
            throw new RuntimeException('El XML llegó vacío.');
        }

        $anterior = libxml_use_internal_errors(true);
        $xml = simplexml_load_string($contenido, SimpleXMLElement::class, LIBXML_NONET);
        $errores = libxml_get_errors();
        libxml_clear_errors();
        libxml_use_internal_errors($anterior);

        if ($xml === false) {
            $detalle = isset($errores[0]) ? trim($errores[0]->message) : 'XML inválido';
            throw new RuntimeException("No se pudo interpretar el XML: {$detalle}");
        }

        $xml->registerXPathNamespace('cbc', self::NS_CBC);
        $xml->registerXPathNamespace('cac', self::NS_CAC);

        return $xml;
    }

    private function primerXpath(SimpleXMLElement $xml, string $expresion): ?string
    {
        $nodos = $xml->xpath($expresion);

        if ($nodos === false || $nodos === []) {
            return null;
        }

        $valor = trim((string) $nodos[0]);

        return $valor === '' ? null : $valor;
    }

    private function tipoComprobante(SimpleXMLElement $xml): ?string
    {
        foreach (['//cbc:InvoiceTypeCode', '//cbc:CreditNoteTypeCode', '//cbc:DebitNoteTypeCode'] as $expresion) {
            $tipo = $this->primerXpath($xml, $expresion);

            if ($tipo !== null) {
                return $tipo;
            }
        }

        return null;
    }

    private function importeTotal(SimpleXMLElement $xml): float
    {
        $candidatos = [
            '//cac:LegalMonetaryTotal/cbc:PayableAmount',
            '//cac:LegalMonetaryTotal/cbc:TaxInclusiveAmount',
            '//cac:LegalMonetaryTotal/cbc:LineExtensionAmount',
        ];

        foreach ($candidatos as $expresion) {
            $valor = $this->primerXpath($xml, $expresion);

            if ($valor !== null) {
                return (float) str_replace(',', '', $valor);
            }
        }

        return 0.0;
    }

    private function normalizarFecha(string $fecha): string
    {
        $fecha = trim($fecha);

        if (preg_match('/^(\d{4})-(\d{2})-(\d{2})$/', $fecha, $partes) === 1) {
            if (checkdate((int) $partes[2], (int) $partes[3], (int) $partes[1])) {
                return $fecha;
            }
        }

        if (preg_match('#^(\d{2})/(\d{2})/(\d{4})$#', $fecha, $partes) === 1) {
            if (checkdate((int) $partes[2], (int) $partes[1], (int) $partes[3])) {
                return "{$partes[3]}-{$partes[2]}-{$partes[1]}";
            }
        }

        try {
            return Carbon::parse($fecha)->format('Y-m-d');
        } catch (\Throwable) {
            throw new RuntimeException("La fecha de emisión del XML no es válida: {$fecha}");
        }
    }
}