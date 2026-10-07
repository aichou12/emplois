<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PasswordService;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */


    public function register()
    {
        $this->app->singleton(PasswordService::class, function ($app) {
            return new PasswordService();
        });
    }

    public function boot(): void
    {
        if (
            $this->app->environment('production') ||
            request()->isSecure() ||
            request()->header('X-Forwarded-Proto') === 'https' ||
            str_starts_with((string) config('app.url'), 'https://')
        ) {
            URL::forceScheme('https');
        }
        \Illuminate\Support\Facades\RateLimiter::for('login', function (\Illuminate\Http\Request $request) {
            $username = mb_strtolower(trim((string) $request->input('username')));
            $response = function ($request, array $headers) use ($username) {
                    $channel = $request->is('admin/login') ? 'admin' : 'web';
                    app(\App\Services\SecurityAccessService::class)
                        ->recordLoginFailure($request, $channel, 'rate_limited', null, $username);

                    $message = 'Trop de tentatives de connexion. Veuillez patienter avant de réessayer.';
                    if ($request->expectsJson()) {
                        return response()->json(['message' => $message], 429, $headers);
                    }

                    return response()->view('errors.error', [
                        'status' => 429,
                        'message' => $message,
                    ], 429, $headers);
                };

            return [
                \Illuminate\Cache\RateLimiting\Limit::perMinute(5)
                    ->by('login:' . hash('sha256', $username . '|' . $request->ip()))
                    ->response($response),
                \Illuminate\Cache\RateLimiting\Limit::perMinute(20)
                    ->by('login-ip:' . $request->ip())
                    ->response($response),
                \Illuminate\Cache\RateLimiting\Limit::perHour(20)
                    ->by('login-account:' . hash('sha256', $username))
                    ->response($response),
            ];
        });

        \Illuminate\Support\Facades\RateLimiter::for('api-login', function (\Illuminate\Http\Request $request) {
            $identifier = mb_strtolower(trim((string) $request->input('login')));
            $response = function ($request, array $headers) use ($identifier) {
                app(\App\Services\SecurityAccessService::class)
                    ->recordLoginFailure($request, 'mobile', 'rate_limited', null, $identifier);

                return response()->json([
                    'success' => false,
                    'message' => 'Trop de tentatives de connexion. Veuillez patienter avant de réessayer.',
                ], 429, $headers);
            };

            return [
                \Illuminate\Cache\RateLimiting\Limit::perMinute(5)
                    ->by('api-login:' . hash('sha256', $identifier . '|' . $request->ip()))
                    ->response($response),
                \Illuminate\Cache\RateLimiting\Limit::perMinute(20)
                    ->by('api-login-ip:' . $request->ip())
                    ->response($response),
                \Illuminate\Cache\RateLimiting\Limit::perHour(20)
                    ->by('api-login-account:' . hash('sha256', $identifier))
                    ->response($response),
            ];
        });

        \Illuminate\Support\Facades\RateLimiter::for('password-reset', function (\Illuminate\Http\Request $request) {
            $email = mb_strtolower(trim((string) $request->input('email')));
            $tooManyRequests = function ($request, array $headers) use ($email) {
                $retryAfter = max(1, (int) ($headers['Retry-After'] ?? 300));
                $waitMinutes = max(1, (int) ceil($retryAfter / 60));
                $message = "Trop de demandes de réinitialisation. Réessayez dans environ {$waitMinutes} minute(s).";
                \Illuminate\Support\Facades\Log::warning('Password reset email request rate limited.', [
                    'email_hash' => hash('sha256', $email),
                    'ip_hash' => hash('sha256', (string) $request->ip()),
                ]);

                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'errors' => ['email' => [$message]],
                        'retry_after' => $retryAfter,
                    ], 429, $headers);
                }

                return redirect()->route('password.request')
                    ->with('rateLimited', true)
                    ->with('rateLimitMessage', $message)
                    ->withHeaders($headers);
            };

            return [
                \Illuminate\Cache\RateLimiting\Limit::perMinutes(5, 1)
                    ->by('email:' . hash('sha256', $email))
                    ->response($tooManyRequests),
                \Illuminate\Cache\RateLimiting\Limit::perHour(10)
                    ->by('ip:' . $request->ip())
                    ->response($tooManyRequests),
            ];
        });

        \Illuminate\Support\Facades\RateLimiter::for('password-reset-submit', function (\Illuminate\Http\Request $request) {
            $tooManyAttempts = function ($request, array $headers) {
                $retryAfter = max(1, (int) ($headers['Retry-After'] ?? 60));
                $waitMinutes = max(1, (int) ceil($retryAfter / 60));
                $message = "Trop de tentatives de réinitialisation. Demandez un nouveau lien ou réessayez dans environ {$waitMinutes} minute(s).";

                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'retry_after' => $retryAfter,
                    ], 429, $headers);
                }

                return response()->view('auth.reset-password', [
                    'token' => '',
                    'email' => '',
                    'rateLimited' => true,
                    'rateLimitMessage' => $message,
                ], 429, $headers);
            };

            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)
                ->by('password-reset-submit-ip:' . $request->ip())
                ->response($tooManyAttempts);
        });

        // Chatbot : tous les appels viennent de l'IP du serveur Rasa, on limite donc par CNI
        // et non par IP (sinon un seul utilisateur abusif bloquerait tout le monde).
        \Illuminate\Support\Facades\RateLimiter::for('chatbot', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(120)->by('chatbot:' . $request->ip());
        });

        // Chatbot mobile : par conversation (compte ou session invité) et par IP
        // (limite IP large car beaucoup d'utilisateurs mobiles partagent une IP opérateur).
        \Illuminate\Support\Facades\RateLimiter::for('chatbot-messages', function (\Illuminate\Http\Request $request) {
            $utilisateur = \Illuminate\Support\Facades\Auth::guard('sanctum')->user();
            $conversationKey = $utilisateur
                ? 'user:' . $utilisateur->id
                : 'guest:' . ((string) $request->input('session_id') ?: $request->ip());

            return [
                \Illuminate\Cache\RateLimiting\Limit::perMinute(30)->by('chatbot-messages:' . $conversationKey),
                \Illuminate\Cache\RateLimiting\Limit::perMinute(300)->by('chatbot-messages-ip:' . $request->ip()),
            ];
        });

        \Illuminate\Support\Facades\RateLimiter::for('chatbot-pgde-verify', function (\Illuminate\Http\Request $request) {
            $cni = mb_strtolower(trim((string) $request->input('cni')));
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(10)->by('chatbot-verify:' . hash('sha256', $cni));
        });

        \Illuminate\Support\Facades\RateLimiter::for('chatbot-pgde-reset', function (\Illuminate\Http\Request $request) {
            $cni = mb_strtolower(trim((string) $request->input('cni')));
            return \Illuminate\Cache\RateLimiting\Limit::perMinutes(15, 3)->by('chatbot-reset:' . hash('sha256', $cni));
        });

        \Illuminate\Support\Facades\RateLimiter::for('verification-email', function (\Illuminate\Http\Request $request) {
            $email = strtolower(trim((string) $request->input('email')));
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(3)
                ->by(hash('sha256', $email . '|' . $request->ip()));
        });
    }
}
