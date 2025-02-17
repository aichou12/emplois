<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, $role)
    {
        if (Auth::check() && Auth::user()->hasRole($role)) {
            return $next($request);
        }

        // Si l'utilisateur n'a pas le bon rôle, on redirige
        return redirect()->route('home')->withErrors('Accès refusé');
    }
}
