<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
            'enabled' => \App\Http\Middleware\CheckAccountEnabled::class,
            'account.verified' => \App\Http\Middleware\EnsureAccountVerified::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        $exceptions->render(function (Throwable $exception, Request $request) {
            // Garder le format standard Laravel pour les erreurs de validation.
            if ($exception instanceof ValidationException) {
                return null;
            }

            $isApi = $request->is('api/*') || $request->expectsJson();

            // Une session web expirée doit continuer à rediriger vers la connexion.
            if ($exception instanceof AuthenticationException && !$isApi) {
                return null;
            }

            if ($exception instanceof ModelNotFoundException) {
                $status = 404;
            } elseif ($exception instanceof AuthorizationException) {
                $status = 403;
            } elseif ($exception instanceof AuthenticationException) {
                $status = 401;
            } elseif ($exception instanceof HttpExceptionInterface) {
                $status = $exception->getStatusCode();
            } else {
                $status = 500;
            }

            $messages = [
                400 => 'La demande ne peut pas être traitée. Vérifiez les informations puis réessayez.',
                401 => 'Une authentification est nécessaire pour accéder à cette ressource.',
                403 => 'Vous n’êtes pas autorisé à accéder à cette page.',
                404 => 'La page demandée est introuvable. Elle a peut-être été déplacée ou supprimée.',
                405 => 'Cette action n’est pas autorisée pour cette page.',
                419 => 'Votre session a expiré. Rechargez la page puis réessayez.',
                429 => 'Trop de tentatives ont été effectuées. Veuillez patienter avant de réessayer.',
                500 => 'Un problème technique est survenu. Veuillez réessayer plus tard.',
                503 => 'Le service est temporairement indisponible. Veuillez réessayer dans quelques instants.',
            ];
            $message = $messages[$status] ?? 'Une erreur a empêché le traitement de votre demande.';

            if ($isApi) {
                $codes = [
                    400 => 'bad_request',
                    401 => 'unauthenticated',
                    403 => 'forbidden',
                    404 => 'not_found',
                    405 => 'method_not_allowed',
                    419 => 'session_expired',
                    429 => 'too_many_requests',
                    500 => 'server_error',
                    503 => 'service_unavailable',
                ];

                return response()->json([
                    'success' => false,
                    'code' => $codes[$status] ?? 'request_error',
                    'message' => $message,
                ], $status);
            }

            return response()->view('errors.error', [
                'status' => $status,
                'message' => $message,
            ], $status);
        });
    })->create();
