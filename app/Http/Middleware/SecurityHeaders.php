<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Response;

/**
 * Cabeceras de seguridad para el sitio público.
 *
 * La CSP se omite en /admin y /livewire porque el panel de Filament (Alpine +
 * Livewire) necesita eval e inline; ahí la sesión ya está autenticada y el
 * panel no es indexable.
 */
class SecurityHeaders
{
    public function handle(Request $request, Closure $next): Response
    {
        /** @var Response $response */
        $response = $next($request);

        $response->headers->set('X-Content-Type-Options', 'nosniff');
        $response->headers->set('X-Frame-Options', 'DENY');
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=(), magnetometer=(), gyroscope=(), accelerometer=()');
        $response->headers->set('Cross-Origin-Opener-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Resource-Policy', 'same-origin');
        $response->headers->set('Cross-Origin-Embedder-Policy', 'credentialless');

        if ($request->isSecure()) {
            $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains');
        }

        if (! $this->isAdmin($request)) {
            $response->headers->set('Content-Security-Policy', $this->policy($request));
        }

        $this->hardenXsrfCookie($response);

        return $response;
    }

    protected function isAdmin(Request $request): bool
    {
        return $request->is('admin', 'admin/*', 'livewire', 'livewire/*');
    }

    protected function policy(Request $request): string
    {
        // En local, Vite sirve desde localhost:5173 y usa websockets para el HMR.
        $local = app()->environment('local');
        $ws = $local ? ' http://localhost:5173 ws://localhost:5173' : '';

        $directives = [
            "default-src 'self'",
            "script-src 'self' 'unsafe-inline'{$ws}",
            "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com",
            "font-src 'self' data: https://fonts.gstatic.com",
            "img-src 'self' data: https:",
            "connect-src 'self'{$ws}",
            "frame-src 'self'",
            "object-src 'none'",
            "base-uri 'self'",
            "form-action 'self'",
            "frame-ancestors 'none'",
        ];

        if ($request->isSecure()) {
            $directives[] = 'upgrade-insecure-requests';
        }

        return implode('; ', $directives);
    }

    /**
     * Laravel publica XSRF-TOKEN sin HttpOnly porque las SPA lo leen por JS.
     * Este sitio envía el token por meta tag, así que la cookie puede ser
     * HttpOnly sin romper nada.
     */
    protected function hardenXsrfCookie(Response $response): void
    {
        foreach ($response->headers->getCookies() as $cookie) {
            if ($cookie->getName() !== 'XSRF-TOKEN' || $cookie->isHttpOnly()) {
                continue;
            }

            $response->headers->removeCookie($cookie->getName(), $cookie->getPath(), $cookie->getDomain());

            $response->headers->setCookie(new Cookie(
                $cookie->getName(),
                $cookie->getValue(),
                $cookie->getExpiresTime(),
                $cookie->getPath(),
                $cookie->getDomain(),
                $cookie->isSecure(),
                true,
                $cookie->isRaw(),
                $cookie->getSameSite(),
            ));
        }
    }
}
