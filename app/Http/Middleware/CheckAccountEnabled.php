<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class CheckAccountEnabled
{
    /**
     * Handle an incoming request.
     */
    public function handle($request, Closure $next)
    {
        $user = Auth::user();

        if (!$user || !$user->enabled) {
            // Redirigez l'utilisateur vers la page de connexion avec un message
            return redirect('/login')->withErrors(['username' => 'Votre compte n\'est pas activé.']);
        }

        return $next($request);
    }
}
