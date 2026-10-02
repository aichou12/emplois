<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Throwable;

/**
 * Mise à jour de l'identité du compte (prénom, nom, CNI) depuis le pop-up du dossier candidat.
 */
class AccountIdentityController extends Controller
{
    public function update(Request $request): JsonResponse
    {
        /** @var Utilisateur|null $account */
        $account = $request->user();
        if (!$account) {
            return response()->json(['message' => 'Session expirée. Reconnectez-vous.'], 401);
        }

        $validated = $request->validate([
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'numberid' => [
                'required',
                'string',
                'max:255',
                'regex:/^[A-Za-z0-9]+$/',
                Rule::unique('utilisateur', 'numberid')->ignore($account->id),
            ],
        ], [
            'firstname.required' => 'Le prénom est obligatoire.',
            'lastname.required' => 'Le nom est obligatoire.',
            'numberid.required' => 'Le numéro de CNI ou de passeport est obligatoire.',
            'numberid.regex' => 'Le numéro de CNI ou de passeport ne doit contenir que des lettres et des chiffres.',
            'numberid.unique' => 'Ce numéro de CNI ou de passeport est déjà utilisé par un autre compte.',
        ]);

        try {
            $account->update([
                'firstname' => trim($validated['firstname']),
                'lastname' => trim($validated['lastname']),
                'numberid' => strtoupper($validated['numberid']),
            ]);
        } catch (Throwable $exception) {
            report($exception);

            return response()->json(['message' => 'L’enregistrement a échoué. Réessayez dans un instant.'], 500);
        }

        return response()->json([
            'message' => 'Vos informations ont été mises à jour.',
            'firstname' => $account->firstname,
            'lastname' => $account->lastname,
            'numberid' => $account->numberid,
        ]);
    }
}
