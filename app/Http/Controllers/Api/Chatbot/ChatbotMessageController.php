<?php

namespace App\Http\Controllers\Api\Chatbot;

use App\Exceptions\ChatbotUnavailableException;
use App\Http\Controllers\Controller;
use App\Services\RasaChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * Point d'entrée unique du chatbot pour l'application mobile (public).
 * Un token Sanctum facultatif rattache la conversation au compte connecté.
 */
class ChatbotMessageController extends Controller
{
    public function __construct(private RasaChatService $rasa)
    {
    }

    public function send(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'message' => ['required', 'string', 'max:1000'],
            'session_id' => ['nullable', 'uuid'],
        ], [
            'message.required' => 'Le message est obligatoire.',
            'message.max' => 'Le message ne doit pas dépasser 1000 caractères.',
            'session_id.uuid' => 'Identifiant de session invalide.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation des données.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();
        $sessionId = $validated['session_id'] ?? (string) Str::uuid();
        $utilisateur = Auth::guard('sanctum')->user();

        // Le sender_id est calculé ici : un invité ne peut jamais rejoindre la conversation d'un compte.
        $senderId = $utilisateur ? "user-{$utilisateur->id}" : "guest-{$sessionId}";

        try {
            $botMessages = $this->rasa->send($senderId, trim($validated['message']));
        } catch (ChatbotUnavailableException $exception) {
            Log::warning('chatbot.mobile.rasa_unavailable', [
                'sender_id' => $senderId,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'code' => 'chatbot_unavailable',
                'message' => 'L’assistant est momentanément indisponible. Veuillez réessayer dans quelques instants.',
            ], 503);
        }

        return response()->json([
            'success' => true,
            'message' => 'Réponse du chatbot.',
            'data' => [
                'session_id' => $sessionId,
                'messages' => $botMessages,
            ],
        ]);
    }
}
