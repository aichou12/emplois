<?php

namespace App\Services;

use App\Exceptions\ChatbotUnavailableException;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;

/**
 * Relais serveur-à-serveur vers le canal REST de Rasa (serveur Rasa séparé).
 * Le client mobile ne parle jamais directement à Rasa.
 */
class RasaChatService
{
    /**
     * Envoie un message à Rasa et retourne les réponses normalisées.
     *
     * @return list<array{text: ?string, buttons: list<array{title: string, payload: string}>, image: ?string, custom: ?array}>
     *
     * @throws ChatbotUnavailableException
     */
    public function send(string $senderId, string $message): array
    {
        $baseUrl = rtrim((string) config('services.rasa.url'), '/');
        if ($baseUrl === '') {
            throw new ChatbotUnavailableException('RASA_URL n\'est pas configurée.');
        }

        try {
            $response = Http::acceptJson()
                ->timeout((int) config('services.rasa.timeout', 30))
                ->post("{$baseUrl}/webhooks/rest/webhook", [
                    'sender' => $senderId,
                    'message' => $message,
                ])
                ->throw();
        } catch (ConnectionException|RequestException $exception) {
            throw new ChatbotUnavailableException('Rasa injoignable : ' . $exception->getMessage(), previous: $exception);
        }

        $rasaMessages = $response->json();
        if (!is_array($rasaMessages)) {
            throw new ChatbotUnavailableException('Réponse Rasa invalide.');
        }

        return array_values(array_filter(array_map(
            fn (mixed $rasaMessage): ?array => is_array($rasaMessage) ? $this->normalize($rasaMessage) : null,
            $rasaMessages
        )));
    }

    /**
     * Format stable pour le mobile, indépendant du format interne de Rasa.
     *
     * @param array<string, mixed> $rasaMessage
     * @return array{text: ?string, buttons: list<array{title: string, payload: string}>, image: ?string, custom: ?array}
     */
    private function normalize(array $rasaMessage): array
    {
        $buttons = [];
        foreach ($rasaMessage['buttons'] ?? [] as $button) {
            if (!is_array($button) || !isset($button['title'], $button['payload'])) {
                continue;
            }
            $buttons[] = ['title' => (string) $button['title'], 'payload' => (string) $button['payload']];
        }

        return [
            'text' => isset($rasaMessage['text']) ? (string) $rasaMessage['text'] : null,
            'buttons' => $buttons,
            'image' => isset($rasaMessage['image']) ? (string) $rasaMessage['image'] : null,
            'custom' => isset($rasaMessage['custom']) && is_array($rasaMessage['custom']) ? $rasaMessage['custom'] : null,
        ];
    }
}
