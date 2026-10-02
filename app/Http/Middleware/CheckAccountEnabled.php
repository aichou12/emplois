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

        if (!$user) {
            return redirect()->route('login');
        }

        if ($user->hasRole('admin') && !$user->enabled) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()->route('admin.login')
                ->withErrors(['login' => 'Ce compte administrateur n’est pas activé.']);
        }

        if (!$user->hasVerifiedEmail() && !$user->hasRole('admin')) {
            return redirect()->route('verification.notice')
                ->withErrors(['email' => 'Veuillez vérifier votre adresse e-mail avant de continuer.']);
        }

        return $next($request);
    }
}
