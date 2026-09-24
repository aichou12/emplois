<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class VerificationController extends Controller
{
    public function notice(): View|RedirectResponse
    {
        $user = auth()->user();

        if ($user && $user->hasVerifiedEmail()) {
            return redirect()->route('home');
        }

        return view('auth.verify-email', compact('user'));
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

        $user->sendEmailVerificationNotification();

        return back()->with('status', 'verification-link-sent');
    }
}
