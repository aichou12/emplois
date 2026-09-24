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
            $email = (string) $request->input('email');
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(3)->by($email . '|' . $request->ip());
        });

        \Illuminate\Support\Facades\RateLimiter::for('verification-email', function (\Illuminate\Http\Request $request) {
            $email = strtolower(trim((string) $request->input('email')));
            return \Illuminate\Cache\RateLimiting\Limit::perMinute(3)
                ->by(hash('sha256', $email . '|' . $request->ip()));
        });
    }
}
