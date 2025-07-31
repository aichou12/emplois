<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use App\Models\Utilisateur;

class ResetPasswordController extends Controller
{
    public function handleReset(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'cni' => 'required'
        ]);

        $user = User::where('email', $request->email)
                    ->where('cni', $request->cni)
                    ->first();

        if (!$user) {
            return response()->json(['message' => 'Aucun utilisateur trouvé avec ces informations.'], 404);
        }

        // Envoi du lien de réinitialisation
        $status = Password::sendResetLink(['email' => $request->email]);

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => 'Lien de réinitialisation envoyé avec succès.'], 200)
            : response()->json(['message' => 'Erreur lors de l’envoi du mail.'], 500);
    }
}
