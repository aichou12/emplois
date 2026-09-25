<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function notice(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $cooldownSeconds = $user && !$user->hasVerifiedEmail()
            ? RateLimiter::availableIn($this->resendLimiterKey($user->getAuthIdentifier()))
            : 0;

        return view('auth.verify-email', compact('user', 'cooldownSeconds'));
    }

    public function verify(Request $request): RedirectResponse
    {
        $user = Utilisateur::findOrFail($request->route('id'));
        $expectedHash = sha1($user->getEmailForVerification());

        if (!hash_equals($expectedHash, (string) $request->route('hash'))) {
            abort(403, 'Lien de vérification invalide ou expiré.');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')
                ->with('success', 'Votre adresse e-mail est déjà vérifiée.');
        }

        $user->markEmailAsVerified();

        if (!$user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->withErrors(['email' => 'L’activation du compte a échoué. Veuillez réessayer.']);
        }

        return redirect()->route('login')
            ->with('success', 'Votre adresse e-mail est vérifiée et votre compte est activé. Vous pouvez vous connecter.');
    }

    public function send(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        $key = $this->resendLimiterKey($user->getAuthIdentifier());
        $waitSeconds = RateLimiter::availableIn($key);

        if ($waitSeconds > 0) {
            return back()
                ->with('resend_cooldown', $waitSeconds)
                ->withErrors(['email' => 'Veuillez patienter 5 minutes entre deux demandes de renvoi du mail d’activation.']);
        }

        // Reserve the five-minute window before sending to prevent concurrent requests.
        RateLimiter::hit($key, 300);

        try {
            $user->sendEmailVerificationNotification();
        } catch (\Throwable $exception) {
            RateLimiter::clear($key);
            throw $exception;
        }

        return back()
            ->with('status', 'verification-link-sent')
            ->with('resend_cooldown', 300);
    }

    private function resendLimiterKey(int|string $userId): string
    {
        return 'verification-email-resend:' . $userId;
    }
}
