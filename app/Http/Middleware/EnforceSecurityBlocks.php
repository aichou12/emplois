<?php

namespace App\Http\Middleware;

use App\Services\SecurityAccessService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforceSecurityBlocks
{
    public function __construct(private SecurityAccessService $security)
    {
    }

    public function handle(Request $request, Closure $next): Response
    {
        $isAdminPath = $request->is('admin', 'admin/*');

        // Les IP bloquées perdent l'accès à l'espace usager, l'administration reste joignable.
        if (!$isAdminPath && $this->security->isIpBlocked($request->ip())) {
            return $this->blockedResponse($request, 'Cette adresse réseau ne peut pas accéder à la plateforme.');
        }

        $user = $request->user();
        if (!$user && $request->is('api/*')) {
            $user = Auth::guard('sanctum')->user();
        }

        if ($user && $this->security->isAccountBlocked($user->id)) {
            if ($request->is('api/*')) {
                $token = $user->currentAccessToken();
                if ($token && method_exists($token, 'delete')) {
                    $token->delete();
                }
            } elseif (Auth::check()) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
            }

            return $this->blockedResponse($request, 'Ce compte est temporairement suspendu. Veuillez contacter l’administration.');
        }

        return $next($request);
    }

    private function blockedResponse(Request $request, string $message): Response
    {
        if ($request->is('api/*') || $request->expectsJson()) {
            return response()->json([
                'success' => false,
                'code' => 'access_blocked',
                'message' => $message,
            ], 403);
        }

        return response()->view('errors.access-blocked', compact('message'), 403);
    }
}
