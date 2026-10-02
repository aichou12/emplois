<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PasswordService;

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
        \Illuminate\Support\Facades\RateLimiter::for('login', function (\Illuminate\Http\Request $request) {
            $username = (string) $request->input('username');
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(5)->by($username . '|' . $request->ip());
        });

        \Illuminate\Support\Facades\RateLimiter::for('password-reset', function (\Illuminate\Http\Request $request) {
            $email = mb_strtolower(trim((string) $request->input('email')));
            $tooManyRequests = function ($request, array $headers) {
                $retryAfter = max(1, (int) ($headers['Retry-After'] ?? 300));
                $waitMinutes = max(1, (int) ceil($retryAfter / 60));
                $message = "Trop de demandes de réinitialisation. Réessayez dans environ {$waitMinutes} minute(s).";

                if ($request->expectsJson() || $request->is('api/*')) {
                    return response()->json([
                        'success' => false,
                        'message' => $message,
                        'errors' => ['email' => [$message]],
                        'retry_after' => $retryAfter,
                    ], 429, $headers);
                }

                return back()
                    ->withErrors(['email' => $message])
                    ->withInput($request->only('email'))
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

        // Chatbot : tous les appels viennent de l'IP du serveur Rasa, on limite donc par CNI
        // et non par IP (sinon un seul utilisateur abusif bloquerait tout le monde).
        \Illuminate\Support\Facades\RateLimiter::for('chatbot', function (\Illuminate\Http\Request $request) {
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(120)->by('chatbot:' . $request->ip());
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
