<?php

namespace App\Http\Controllers;

use App\Mail\ConsultoriaRecibida;
use App\Models\Consultoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ConsultoriaController extends Controller
{
    public function show()
    {
        $encryptedTimestamp = Crypt::encryptString(now()->timestamp);

        return view('pages.consultoria', [
            'formTimestamp' => $encryptedTimestamp,
        ]);
    }

    public function store(Request $request)
    {
        // Layer 1: Honeypot validation (Spatie package handles this automatically via middleware, but we add a manual backup)
        if (! empty($request->get('website_url'))) {
            Log::warning('Honeypot triggered', [
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);

            return redirect()
                ->route('consultoria.show')
                ->with('success', '¡Solicitud enviada correctamente! Nos comunicaremos contigo pronto.');
        }

        // Layer 2: JavaScript checksum - must be 2 (set by JS on page load)
        if ($request->get('js_checksum') !== '2') {
            Log::warning('JS checksum failed', [
                'ip' => $request->ip(),
                'value' => $request->get('js_checksum'),
            ]);

            return redirect()
                ->route('consultoria.show')
                ->with('success', '¡Solicitud enviada correctamente! Nos comunicaremos contigo pronto.');
        }

        // Layer 3: Time trap - reject if submitted in less than 5 seconds
        try {
            $formTimestamp = Crypt::decryptString($request->get('form_timestamp', ''));
            $timeTaken = now()->timestamp - (int) $formTimestamp;
            if ($timeTaken < 5) {
                Log::warning('Form submitted too quickly', [
                    'ip' => $request->ip(),
                    'time_taken' => $timeTaken,
                ]);

                return redirect()
                    ->route('consultoria.show')
                    ->with('success', '¡Solicitud enviada correctamente! Nos comunicaremos contigo pronto.');
            }
        } catch (\Exception $e) {
            Log::warning('Invalid form timestamp', ['ip' => $request->ip()]);

            return redirect()
                ->route('consultoria.show')
                ->with('success', '¡Solicitud enviada correctamente! Nos comunicaremos contigo pronto.');
        }

        // Layer 4: Rate limiting - max 5 submissions per IP per hour
        $ipKey = 'consultoria_submissions_'.md5($request->ip());
        $submissions = Cache::get($ipKey, 0);

        if ($submissions >= 5) {
            Log::warning('Rate limit exceeded', ['ip' => $request->ip()]);

            return back()->withErrors([
                'rate_limit' => 'Ha excedido el límite de envíos. Por favor, intente más tarde.',
            ]);
        }

        // Layer 5: Content spam analysis
        if ($this->isSpamContent($request)) {
            Log::warning('Spam content detected', [
                'ip' => $request->ip(),
                'message' => substr($request->get('mensaje', ''), 0, 200),
            ]);

            return redirect()
                ->route('consultoria.show')
                ->with('success', '¡Solicitud enviada correctamente! Nos comunicaremos contigo pronto.');
        }

        // Standard Laravel validation
        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'mensaje' => 'required|string|max:2000',
        ]);

        // Record successful submission for rate limiting
        Cache::put($ipKey, $submissions + 1, now()->addHour());

        $consultoria = Consultoria::create($validated);

        Mail::to('aguilaryarceconsultores@gmail.com')
            ->send(new ConsultoriaRecibida($consultoria));

        return redirect()
            ->route('consultoria.show')
            ->with('success', '¡Solicitud enviada correctamente! Nos comunicaremos contigo pronto.');
    }

    private function isSpamContent(Request $request): bool
    {
        $message = strtolower($request->get('mensaje', ''));
        $nombre = strtolower($request->get('nombre', ''));

        // Check for excessive URLs (more than 2)
        $linkCount = preg_match_all('/https?:\/\/|www\.|\.com|\.pe|\.org|\.net/i', $request->get('mensaje', ''));
        if ($linkCount > 2) {
            return true;
        }

        // Check for common spam patterns in Spanish and English
        $spamPatterns = [
            'mejorar tu página',
            'mejorar su página',
            'mejorar tu web',
            'mejorar su sitio',
            'diseño web',
            'posicionamiento seo',
            'agencia de marketing',
            'somos una agencia',
            'queremos ayudarte',
            'podemos ayudarte',
            'ofrecemos servicios',
            'click here',
            'make money',
            'viagra',
            'casino',
            'poker',
            'cryptocurrency',
            'investment opportunity',
            'buy now',
            'free money',
            'work from home',
            'earn extra',
            'side hustle',
            'whatsapp',
            'telegram',
        ];

        foreach ($spamPatterns as $pattern) {
            if (str_contains($message, $pattern) || str_contains($nombre, $pattern)) {
                return true;
            }
        }

        // Check for repeated characters (spam pattern)
        if (preg_match('/(.)\1{5,}/', $request->get('mensaje', ''))) {
            return true;
        }

        // Check for all caps in message (more than 70% uppercase for messages > 20 chars)
        $mensaje = $request->get('mensaje', '');
        if (strlen($mensaje) > 20) {
            $uppercaseRatio = strlen(preg_replace('/[^A-ZÁÉÍÓÚÑÜ]/', '', $mensaje)) / strlen($mensaje);
            if ($uppercaseRatio > 0.7) {
                return true;
            }
        }

        return false;
    }
}
