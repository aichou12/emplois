<?php

namespace App\Http\Middleware;

use App\Http\Responses\ChatbotResponse;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Authentification machine-à-machine du serveur d'actions Rasa.
 * Le jeton partagé est défini par CHATBOT_API_TOKEN ; sans jeton configuré,
 * tous les appels sont refusés.
 */
class AuthenticateChatbot
{
    public function handle(Request $request, Closure $next): Response
    {
        $expectedToken = (string) config('services.chatbot.token');
        $providedToken = (string) $request->bearerToken();

        if ($expectedToken === '' || $providedToken === '' || !hash_equals($expectedToken, $providedToken)) {
            return $this->unauthorized($request);
        }

        $allowedIps = $this->allowedIps();
        if ($allowedIps !== [] && !in_array($request->ip(), $allowedIps, true)) {
            return $this->unauthorized($request);
        }

        return $next($request);
    }

    /** @return list<string> */
    private function allowedIps(): array
    {
        $rawIps = (string) config('services.chatbot.allowed_ips');

        return array_values(array_filter(array_map('trim', explode(',', $rawIps))));
    }

    private function unauthorized(Request $request): Response
    {
        return ChatbotResponse::make(
            $request,
            false,
            ChatbotResponse::UNAUTHORIZED,
            'Appel non autorisé.',
            null,
            401
        );
    }
}
