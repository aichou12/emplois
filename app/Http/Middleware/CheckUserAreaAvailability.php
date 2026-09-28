<?php

namespace App\Http\Middleware;

use App\Services\PlatformSettings;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserAreaAvailability
{
    public function __construct(private PlatformSettings $settings)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        // L'administration doit rester accessible pour réactiver le service.
        if ($request->is('admin', 'admin/*')) {
            return $next($request);
        }

        $values = $this->settings->all();
        if (($values['user_area_blocked'] ?? '0') === '1') {
            return $this->unavailableResponse($request, $values['user_area_message']);
        }

        if (($values['registration_blocked'] ?? '0') === '1'
            && ($request->is('register') || $request->is('api/v1/auth/register'))) {
            return $this->unavailableResponse(
                $request,
                'La création de compte est momentanément indisponible. Merci de réessayer plus tard.'
            );
        }

        return $next($request);
    }

    private function unavailableResponse(Request $request, string $message): Response
    {
        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'code' => 'service_unavailable',
                'message' => $message,
            ], 503);
        }

        return response()->view('errors.maintenance', ['message' => $message], 503);
    }
}
