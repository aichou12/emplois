<?php

namespace Tests\Feature\Chatbot;

use App\Models\Utilisateur;
use App\Notifications\CustomResetPasswordNotification;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Testing\TestResponse;
use Tests\TestCase;

/**
 * Les tests tournent sur la base MySQL locale : DatabaseTransactions annule
 * chaque insertion, ne jamais utiliser RefreshDatabase ici.
 */
class PgdeAccountApiTest extends TestCase
{
    use DatabaseTransactions;

    private const TOKEN = 'test-chatbot-token';
    private const VERIFY_URL = '/api/v1/chatbot/pgde/accounts/verify';
    private const RESET_URL = '/api/v1/chatbot/pgde/password/reset';
    private const CNI = 'ZZCHATBOTTEST001';

    protected function setUp(): void
    {
        parent::setUp();

        config(['services.chatbot.token' => self::TOKEN, 'services.chatbot.allowed_ips' => '']);
        Notification::fake();
    }

    private function createUtilisateur(bool $enabled = true): Utilisateur
    {
        return Utilisateur::create([
            'firstname' => 'Moussa',
            'lastname' => 'NDIAYE',
            'username' => 'zz_chatbot_test',
            'numberid' => self::CNI,
            'email' => 'Moussa.Chatbot.Test@exemple.sn',
            'password' => Hash::make('secret-password'),
            'enabled' => $enabled,
            'date_inscription' => now(),
            'roles' => 'a:0:{}',
        ]);
    }

    private function callApi(string $url, array $payload, ?string $token = self::TOKEN): TestResponse
    {
        $headers = $token === null ? [] : ['Authorization' => "Bearer {$token}"];

        return $this->postJson($url, $payload, $headers);
    }

    private function assertEnvelope(TestResponse $response, int $status, bool $success, string $code): void
    {
        $response->assertStatus($status)
            ->assertJsonStructure(['success', 'code', 'message', 'data', 'correlation_id'])
            ->assertJson(['success' => $success, 'code' => $code]);
    }

    public function test_call_without_token_is_unauthorized(): void
    {
        $response = $this->callApi(self::VERIFY_URL, ['cni' => self::CNI], null);

        $this->assertEnvelope($response, 401, false, 'UNAUTHORIZED');
    }

    public function test_call_with_wrong_token_is_unauthorized(): void
    {
        $response = $this->callApi(self::VERIFY_URL, ['cni' => self::CNI], 'mauvais-jeton');

        $this->assertEnvelope($response, 401, false, 'UNAUTHORIZED');
    }

    public function test_all_calls_are_refused_when_token_is_not_configured(): void
    {
        config(['services.chatbot.token' => null]);

        $response = $this->callApi(self::VERIFY_URL, ['cni' => self::CNI], '');

        $this->assertEnvelope($response, 401, false, 'UNAUTHORIZED');
    }

    public function test_ip_outside_allow_list_is_unauthorized(): void
    {
        config(['services.chatbot.allowed_ips' => '10.0.0.1, 10.0.0.2']);

        $response = $this->callApi(self::VERIFY_URL, ['cni' => self::CNI]);

        $this->assertEnvelope($response, 401, false, 'UNAUTHORIZED');
    }

    public function test_verify_returns_active_account(): void
    {
        $utilisateur = $this->createUtilisateur();

        $response = $this->callApi(self::VERIFY_URL, ['cni' => self::CNI]);

        $this->assertEnvelope($response, 200, true, 'FOUND');
        $response->assertJson(['data' => [
            'user_id' => (string) $utilisateur->id,
            'numero_dossier' => (string) $utilisateur->id,
            'nom' => 'NDIAYE',
            'prenom' => 'Moussa',
            'nom_complet' => 'Moussa NDIAYE',
            'username' => 'zz_chatbot_test',
            'email' => 'Moussa.Chatbot.Test@exemple.sn',
            'cni' => self::CNI,
            'actif' => true,
        ]]);
        $this->assertArrayNotHasKey('password', $response->json('data'));
        $this->assertArrayNotHasKey('salt', $response->json('data'));
    }

    public function test_verify_unknown_cni_is_not_found(): void
    {
        $response = $this->callApi(self::VERIFY_URL, ['cni' => 'ZZINCONNU999']);

        $this->assertEnvelope($response, 404, false, 'NOT_FOUND');
        $response->assertJsonPath('data', null);
    }

    public function test_verify_invalid_cni_is_invalid_input(): void
    {
        $this->assertEnvelope($this->callApi(self::VERIFY_URL, []), 422, false, 'INVALID_INPUT');
        $this->assertEnvelope($this->callApi(self::VERIFY_URL, ['cni' => "12 34'--"]), 422, false, 'INVALID_INPUT');
    }

    public function test_verify_disabled_account_is_inactive(): void
    {
        $this->createUtilisateur(enabled: false);

        $response = $this->callApi(self::VERIFY_URL, ['cni' => self::CNI]);

        $this->assertEnvelope($response, 403, false, 'INACTIVE_ACCOUNT');
        $response->assertJsonPath('data.actif', false);
    }

    public function test_verify_blocked_account_is_inactive(): void
    {
        $utilisateur = $this->createUtilisateur();
        DB::table('security_blocked_accounts')->insert([
            'utilisateur_id' => $utilisateur->id,
            'blocked_at' => now(),
        ]);

        $response = $this->callApi(self::VERIFY_URL, ['cni' => self::CNI]);

        $this->assertEnvelope($response, 403, false, 'INACTIVE_ACCOUNT');
    }

    public function test_verify_is_throttled_per_cni(): void
    {
        $this->createUtilisateur();

        for ($attempt = 1; $attempt <= 10; $attempt++) {
            $this->callApi(self::VERIFY_URL, ['cni' => self::CNI])->assertOk();
        }

        $this->assertEnvelope($this->callApi(self::VERIFY_URL, ['cni' => self::CNI]), 429, false, 'TOO_MANY_REQUESTS');
    }

    public function test_reset_sends_official_reset_link(): void
    {
        $utilisateur = $this->createUtilisateur();

        // L'email est comparé sans tenir compte de la casse.
        $response = $this->callApi(self::RESET_URL, ['cni' => self::CNI, 'email' => 'moussa.chatbot.test@EXEMPLE.sn']);

        $this->assertEnvelope($response, 200, true, 'RESET_ACCEPTED');
        $response->assertJsonPath('data', null);
        Notification::assertSentTo($utilisateur, CustomResetPasswordNotification::class);
    }

    public function test_reset_with_mismatched_email_is_not_found(): void
    {
        $this->createUtilisateur();

        $response = $this->callApi(self::RESET_URL, ['cni' => self::CNI, 'email' => 'autre@exemple.sn']);

        $this->assertEnvelope($response, 404, false, 'NOT_FOUND');
        Notification::assertNothingSent();
    }

    public function test_reset_on_inactive_account_is_refused(): void
    {
        $this->createUtilisateur(enabled: false);

        $response = $this->callApi(self::RESET_URL, ['cni' => self::CNI, 'email' => 'moussa.chatbot.test@exemple.sn']);

        $this->assertEnvelope($response, 403, false, 'INACTIVE_ACCOUNT');
        Notification::assertNothingSent();
    }

    public function test_reset_requires_cni_and_valid_email(): void
    {
        $response = $this->callApi(self::RESET_URL, ['cni' => self::CNI, 'email' => 'pas-un-email']);

        $this->assertEnvelope($response, 422, false, 'INVALID_INPUT');
    }

    public function test_second_reset_in_a_row_is_throttled(): void
    {
        $this->createUtilisateur();
        $payload = ['cni' => self::CNI, 'email' => 'moussa.chatbot.test@exemple.sn'];

        $this->assertEnvelope($this->callApi(self::RESET_URL, $payload), 200, true, 'RESET_ACCEPTED');
        $this->assertEnvelope($this->callApi(self::RESET_URL, $payload), 429, false, 'TOO_MANY_REQUESTS');
    }
}
