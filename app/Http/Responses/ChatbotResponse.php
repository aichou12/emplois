<?php

namespace App\Http\Responses;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * Enveloppe JSON du contrat chatbot (CONTRAT_INTERFACE_BACKEND.md côté Rasa).
 */
class ChatbotResponse
{
    public const FOUND = 'FOUND';
    public const NOT_FOUND = 'NOT_FOUND';
    public const INVALID_INPUT = 'INVALID_INPUT';
    public const INACTIVE_ACCOUNT = 'INACTIVE_ACCOUNT';
    public const RESET_ACCEPTED = 'RESET_ACCEPTED';
    public const UNAUTHORIZED = 'UNAUTHORIZED';
    public const TOO_MANY_REQUESTS = 'TOO_MANY_REQUESTS';
    public const TEMPORARY_ERROR = 'TEMPORARY_ERROR';

    private const CORRELATION_ATTRIBUTE = 'chatbot_correlation_id';

    public static function make(
        Request $request,
        bool $success,
        string $code,
        string $message,
        ?array $payload = null,
        int $status = 200,
        array $headers = []
    ): JsonResponse {
        return response()->json([
            'success' => $success,
            'code' => $code,
            'message' => $message,
            'data' => $payload,
            'correlation_id' => self::correlationId($request),
        ], $status, $headers);
    }

    /** Identifiant unique par requête, réutilisé dans les journaux. */
    public static function correlationId(Request $request): string
    {
        $correlationId = $request->attributes->get(self::CORRELATION_ATTRIBUTE);
        if ($correlationId !== null) {
            return $correlationId;
        }

        $correlationId = Str::lower(Str::random(12));
        $request->attributes->set(self::CORRELATION_ATTRIBUTE, $correlationId);

        return $correlationId;
    }

    /** Traduit un statut HTTP d'erreur en code métier du contrat. */
    public static function codeForStatus(int $status): string
    {
        return match ($status) {
            401, 403 => self::UNAUTHORIZED,
            404 => self::NOT_FOUND,
            422 => self::INVALID_INPUT,
            429 => self::TOO_MANY_REQUESTS,
            default => self::TEMPORARY_ERROR,
        };
    }
}
