<?php

namespace App\Http\Controllers\Api\Chatbot;

use App\Http\Controllers\Controller;
use App\Http\Responses\ChatbotResponse;
use App\Models\Utilisateur;
use App\Services\SecurityAccessService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Throwable;

/**
 * Services PGDE consommés par le chatbot Rasa.
 * Le chatbot n'accède jamais directement à la base : tout passe par ici.
 */
class PgdeAccountController extends Controller
{
    private const CNI_RULES = ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9]+$/'];

    public function __construct(private SecurityAccessService $security)
    {
    }

    /** Vérifie l'existence et l'état d'un compte à partir de la CNI. */
    public function verify(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), ['cni' => self::CNI_RULES]);
        if ($validator->fails()) {
            return $this->invalidInput($request);
        }

        $utilisateur = $this->findByCni($validator->validated()['cni']);
        if (!$utilisateur) {
            return $this->notFound($request, 'Aucun compte ne correspond à cette CNI.');
        }

        $accountPayload = $this->accountPayload($utilisateur);

        if (!$this->isUsable($utilisateur)) {
            return ChatbotResponse::make(
                $request,
                false,
                ChatbotResponse::INACTIVE_ACCOUNT,
                'Compte trouvé mais inactif.',
                $accountPayload,
                403
            );
        }

        return ChatbotResponse::make($request, true, ChatbotResponse::FOUND, 'Compte trouvé.', $accountPayload);
    }

    /** Déclenche l'email officiel de réinitialisation (aucun lien ne transite par le chatbot). */
    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'cni' => self::CNI_RULES,
            'email' => ['required', 'string', 'email', 'max:255'],
        ]);
        if ($validator->fails()) {
            return $this->invalidInput($request);
        }

        $validated = $validator->validated();
        $utilisateur = $this->findByCni($validated['cni']);
        $email = mb_strtolower(trim($validated['email']), 'UTF-8');

        // CNI et email doivent désigner le même compte.
        $accountEmail = mb_strtolower(trim((string) ($utilisateur?->email_canonical ?: $utilisateur?->email)), 'UTF-8');
        if (!$utilisateur || $accountEmail !== $email) {
            return $this->notFound($request, 'Les informations fournies ne correspondent à aucun compte.');
        }

        if (!$this->isUsable($utilisateur)) {
            return ChatbotResponse::make(
                $request,
                false,
                ChatbotResponse::INACTIVE_ACCOUNT,
                'Compte inactif : réinitialisation impossible.',
                null,
                403
            );
        }

        try {
            $status = Password::broker('utilisateur')->sendResetLink(['email' => $utilisateur->email]);
        } catch (Throwable $exception) {
            Log::error('chatbot.pgde.reset_failed', [
                'correlation_id' => ChatbotResponse::correlationId($request),
                'utilisateur_id' => $utilisateur->id,
                'exception' => $exception->getMessage(),
            ]);

            return $this->temporaryError($request);
        }

        Log::info('chatbot.pgde.reset_requested', [
            'correlation_id' => ChatbotResponse::correlationId($request),
            'utilisateur_id' => $utilisateur->id,
            'status' => $status,
        ]);

        return match ($status) {
            Password::RESET_LINK_SENT => ChatbotResponse::make(
                $request,
                true,
                ChatbotResponse::RESET_ACCEPTED,
                'La demande de réinitialisation a été prise en compte.'
            ),
            Password::RESET_THROTTLED => ChatbotResponse::make(
                $request,
                false,
                ChatbotResponse::TOO_MANY_REQUESTS,
                'Une demande récente est déjà en cours. Réessayez dans quelques minutes.',
                null,
                429
            ),
            default => $this->temporaryError($request),
        };
    }

    private function findByCni(string $cni): ?Utilisateur
    {
        return Utilisateur::where('numberid', trim($cni))->first();
    }

    /** Un compte est utilisable s'il est activé et non suspendu par l'administration. */
    private function isUsable(Utilisateur $utilisateur): bool
    {
        return $utilisateur->enabled && !$this->security->isAccountBlocked($utilisateur->id);
    }

    /** @return array<string, mixed> */
    private function accountPayload(Utilisateur $utilisateur): array
    {
        return [
            'user_id' => (string) $utilisateur->id,
            'numero_dossier' => (string) $utilisateur->id,
            'nom' => $utilisateur->lastname,
            'prenom' => $utilisateur->firstname,
            'nom_complet' => trim("{$utilisateur->firstname} {$utilisateur->lastname}"),
            'username' => $utilisateur->username,
            'email' => $utilisateur->email,
            'cni' => $utilisateur->numberid,
            'actif' => $this->isUsable($utilisateur),
        ];
    }

    private function invalidInput(Request $request): JsonResponse
    {
        return ChatbotResponse::make(
            $request,
            false,
            ChatbotResponse::INVALID_INPUT,
            'Données absentes ou au format incorrect.',
            null,
            422
        );
    }

    private function notFound(Request $request, string $message): JsonResponse
    {
        return ChatbotResponse::make($request, false, ChatbotResponse::NOT_FOUND, $message, null, 404);
    }

    private function temporaryError(Request $request): JsonResponse
    {
        return ChatbotResponse::make(
            $request,
            false,
            ChatbotResponse::TEMPORARY_ERROR,
            'Erreur technique temporaire.',
            null,
            503
        );
    }
}
