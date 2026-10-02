<?php

namespace Tests\Feature\Chatbot;

use App\Models\Utilisateur;
use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\Request as ClientRequest;
use Illuminate\Support\Facades\Http;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class ChatbotMessageApiTest extends TestCase
{
    private const URL = '/api/v1/chatbot/messages';
    private const RASA_WEBHOOK = 'http://rasa.test:5005/webhooks/rest/webhook';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.rasa.url' => 'http://rasa.test:5005/', 'services.rasa.timeout' => 5]);
    }

    private function fakeRasaReply(array $rasaMessages, int $status = 200): void
    {
        Http::fake([self::RASA_WEBHOOK => Http::response($rasaMessages, $status)]);
    }

    public function test_guest_first_message_creates_session_and_normalizes_reply(): void
    {
        $this->fakeRasaReply([
            [
                'recipient_id' => 'x',
                'text' => '**Bienvenue** 👋',
                'buttons' => [
                    ['title' => '🎯 PGDE', 'payload' => '/choose_platform{"platform": "PGDE"}'],
                    ['title' => 'sans payload'],
                ],
            ],
            ['recipient_id' => 'x', 'image' => 'https://exemple.sn/logo.png'],
        ]);

        $response = $this->postJson(self::URL, ['message' => '  Bonjour  ']);

        $response->assertOk()
            ->assertJsonPath('success', true)
            ->assertJsonPath('data.messages', [
                [
                    'text' => '**Bienvenue** 👋',
                    'buttons' => [['title' => '🎯 PGDE', 'payload' => '/choose_platform{"platform": "PGDE"}']],
                    'image' => null,
                    'custom' => null,
                ],
                ['text' => null, 'buttons' => [], 'image' => 'https://exemple.sn/logo.png', 'custom' => null],
            ]);

        $sessionId = $response->json('data.session_id');
        $this->assertTrue(\Illuminate\Support\Str::isUuid($sessionId));
        Http::assertSent(fn (ClientRequest $request) => $request->url() === self::RASA_WEBHOOK
            && $request['sender'] === "guest-{$sessionId}"
            && $request['message'] === 'Bonjour');
    }

    public function test_guest_session_is_reused(): void
    {
        $this->fakeRasaReply([]);
        $sessionId = '3f2b8c1e-7d4a-4c2b-9a1e-5b6c7d8e9f00';

        $response = $this->postJson(self::URL, ['message' => '/affirm', 'session_id' => $sessionId]);

        $response->assertOk()
            ->assertJsonPath('data.session_id', $sessionId)
            ->assertJsonPath('data.messages', []);
        Http::assertSent(fn (ClientRequest $request) => $request['sender'] === "guest-{$sessionId}");
    }

    public function test_authenticated_user_conversation_is_bound_to_account(): void
    {
        $this->fakeRasaReply([['text' => 'Bonjour']]);
        $utilisateur = (new Utilisateur())->forceFill(['id' => 987654321]);
        Sanctum::actingAs($utilisateur);

        // Un session_id fourni ne permet pas de sortir de la conversation du compte.
        $this->postJson(self::URL, ['message' => 'Bonjour', 'session_id' => '3f2b8c1e-7d4a-4c2b-9a1e-5b6c7d8e9f00'])
            ->assertOk();

        Http::assertSent(fn (ClientRequest $request) => $request['sender'] === 'user-987654321');
    }

    public function test_invalid_input_is_rejected_without_calling_rasa(): void
    {
        Http::fake();

        $this->postJson(self::URL, [])->assertStatus(422)->assertJsonValidationErrors('message');
        $this->postJson(self::URL, ['message' => str_repeat('a', 1001)])->assertStatus(422);
        $this->postJson(self::URL, ['message' => 'Bonjour', 'session_id' => 'guest-1'])
            ->assertStatus(422)
            ->assertJsonValidationErrors('session_id');

        Http::assertNothingSent();
    }

    public function test_rasa_unreachable_returns_503(): void
    {
        Http::fake(fn () => throw new ConnectionException('Connection refused'));

        $this->postJson(self::URL, ['message' => 'Bonjour'])
            ->assertStatus(503)
            ->assertJson(['success' => false, 'code' => 'chatbot_unavailable']);
    }

    public function test_rasa_server_error_returns_503(): void
    {
        $this->fakeRasaReply(['error' => 'boom'], 500);

        $this->postJson(self::URL, ['message' => 'Bonjour'])
            ->assertStatus(503)
            ->assertJsonPath('code', 'chatbot_unavailable');
    }

    public function test_messages_are_throttled_per_conversation(): void
    {
        $this->fakeRasaReply([['text' => 'ok']]);
        $payload = ['message' => 'Bonjour', 'session_id' => '3f2b8c1e-7d4a-4c2b-9a1e-5b6c7d8e9f01'];

        for ($attempt = 1; $attempt <= 30; $attempt++) {
            $this->postJson(self::URL, $payload)->assertOk();
        }

        $this->postJson(self::URL, $payload)->assertStatus(429);
    }
}
