<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Log;
class VerificationController extends Controller
{
    // Page "Merci de vérifier votre email"
    public function notice()
    {
        return view('auth.verify-email');
    }

    // Vérifie le lien de vérification d'email

public function verify(Request $request)
{
    // Récupérer l'utilisateur par ID
    $user = Utilisateur::findOrFail($request->route('id'));

    Log::info('Vérification email pour utilisateur', [
        'id' => $user->id,
        'enabled' => $user->enabled,
        'email_canonical' => $user->email_canonical
    ]);

    // Vérifiez si le hash correspond à l'email canonicalisé
    if (!hash_equals(sha1($user->email_canonical), (string) $request->route('hash'))) {
        Log::error('Hash invalide pour utilisateur', ['id' => $user->id]);
        abort(403, 'Lien de vérification invalide.');
    }

    // Vérifiez si l'utilisateur a déjà activé son compte
    if ($user->enabled) {
        Log::info('Utilisateur déjà activé', ['id' => $user->id]);
        return redirect('/login')->with('success', 'Votre email a déjà été vérifié et votre compte est déjà activé.');
    }

    // Active le compte en mettant "enabled" à 1
    $user->enabled = 1;
    $user->save();

    if ($user->wasChanged('enabled')) {
        Log::info('Compte activé avec succès', ['id' => $user->id]);
        return redirect('/login')->with('success', 'Votre email a été vérifié, et votre compte est activé.');
    } else {
        Log::error('Échec de la mise à jour de enabled', ['id' => $user->id]);
        return redirect('/login')->with('error', 'Échec de l\'activation de votre compte. Veuillez contacter le support.');
    }
}
}
