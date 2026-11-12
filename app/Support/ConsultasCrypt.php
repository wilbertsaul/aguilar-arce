<?php

namespace App\Support;

use Illuminate\Encryption\Encrypter;

/**
 * Cifrado del caché de consultas con una clave propia (CONSULTAS_KEY).
 *
 * No usa APP_KEY a propósito: cuando la tabla pase a la base compartida
 * `consultas_pe`, IziPay y BYTFACT solo necesitan la misma CONSULTAS_KEY
 * para leer y escribir los mismos registros.
 */
class ConsultasCrypt
{
    private static ?Encrypter $encrypter = null;

    public static function encrypter(): Encrypter
    {
        if (self::$encrypter === null) {
            $key = (string) config('consultas.cache_key');

            if (str_starts_with($key, 'base64:')) {
                $key = base64_decode(substr($key, 7));
            }

            if (strlen($key) < 32) {
                $key = hash('sha256', $key !== '' ? $key : (string) config('app.key'), true);
            }

            self::$encrypter = new Encrypter($key, config('app.cipher', 'AES-256-CBC'));
        }

        return self::$encrypter;
    }

    public static function encryptString(?string $value): ?string
    {
        return $value === null ? null : self::encrypter()->encryptString($value);
    }

    public static function decryptString(?string $payload): ?string
    {
        if ($payload === null || $payload === '') {
            return null;
        }

        return self::encrypter()->decryptString($payload);
    }

    public static function encryptArray(?array $value): ?string
    {
        if ($value === null) {
            return null;
        }

        return self::encrypter()->encryptString(
            json_encode($value, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES)
        );
    }

    public static function decryptArray(?string $payload): ?array
    {
        if ($payload === null || $payload === '') {
            return null;
        }

        $decoded = json_decode(self::encrypter()->decryptString($payload), true);

        return is_array($decoded) ? $decoded : null;
    }
}
