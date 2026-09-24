<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureAccountVerified
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()?->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'code' => 'email_not_verified',
                'message' => 'Vérifiez votre adresse e-mail pour activer votre compte.',
            ], 403);
        }

        return $next($request);
    }
}
