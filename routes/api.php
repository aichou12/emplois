<?php

use App\Http\Controllers\Api\AuthApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Plateforme PGDE Mobile
|--------------------------------------------------------------------------
|
| Toutes les routes ci-dessous sont préfixées automatiquement par '/api'.
| Version actuelle de l'API : v1.
|
*/

Route::prefix('v1')->group(function () {

    // =========================================================================
    // 1. AUTHENTIFICATION & SÉCURITÉ
    // =========================================================================
    Route::prefix('auth')->group(function () {
        // Routes publiques
        Route::post('/register', [AuthApiController::class, 'register'])->name('api.v1.auth.register');
        Route::post('/login', [AuthApiController::class, 'login'])->name('api.v1.auth.login');
        Route::post('/forgot-password', [AuthApiController::class, 'forgotPassword'])->name('api.v1.auth.forgot_password');
        Route::post('/resend-verification', [AuthApiController::class, 'resendVerification'])
            ->middleware('throttle:verification-email')
            ->name('api.v1.auth.resend_verification');

        // Routes protégées par Bearer Token Sanctum
        Route::middleware('auth:sanctum')->group(function () {
            Route::get('/me', [AuthApiController::class, 'me'])
                ->middleware('account.verified')
                ->name('api.v1.auth.me');
            Route::post('/logout', [AuthApiController::class, 'logout'])->name('api.v1.auth.logout');
        });
    });

    // =========================================================================
    // 2. DONNÉES DE RÉFÉRENCE (Publiques pour alimenter les listes déroulantes)
    // =========================================================================
    Route::prefix('reference')->group(function () {
        Route::get('/all', [\App\Http\Controllers\Api\ReferenceApiController::class, 'getAllReferences'])->name('api.v1.reference.all');
        Route::get('/regions', [\App\Http\Controllers\Api\ReferenceApiController::class, 'getRegions'])->name('api.v1.reference.regions');
        Route::get('/regions/{id}/departements', [\App\Http\Controllers\Api\ReferenceApiController::class, 'getDepartementsByRegion'])->name('api.v1.reference.departements');
        Route::get('/niveaux-formation', [\App\Http\Controllers\Api\ReferenceApiController::class, 'getNiveauxFormation'])->name('api.v1.reference.formations');
        Route::get('/secteurs', [\App\Http\Controllers\Api\ReferenceApiController::class, 'getSecteurs'])->name('api.v1.reference.secteurs');
        Route::get('/secteurs/{id}/emplois', [\App\Http\Controllers\Api\ReferenceApiController::class, 'getEmploisBySecteur'])->name('api.v1.reference.secteur_emplois');
        Route::get('/emplois', [\App\Http\Controllers\Api\ReferenceApiController::class, 'getAllEmplois'])->name('api.v1.reference.emplois');
        Route::get('/handicaps', [\App\Http\Controllers\Api\ReferenceApiController::class, 'getHandicaps'])->name('api.v1.reference.handicaps');
    });

    // =========================================================================
    // 3. CANDIDAT & PARCOURS DOSSIER (Protégé par Bearer Token Sanctum)
    // =========================================================================
    Route::middleware(['auth:sanctum', 'account.verified'])->prefix('candidat')->group(function () {
        Route::get('/profile', [\App\Http\Controllers\Api\CandidatApiController::class, 'getProfile'])->name('api.v1.candidat.profile');
        Route::put('/identity', [\App\Http\Controllers\Api\CandidatApiController::class, 'updateIdentity'])->name('api.v1.candidat.identity');
        Route::put('/formations', [\App\Http\Controllers\Api\CandidatApiController::class, 'updateFormations'])->name('api.v1.candidat.formations');
        Route::put('/experiences', [\App\Http\Controllers\Api\CandidatApiController::class, 'updateExperiences'])->name('api.v1.candidat.experiences');
        Route::put('/target-jobs', [\App\Http\Controllers\Api\CandidatApiController::class, 'updateTargetJobs'])->name('api.v1.candidat.target_jobs');

        // =========================================================================
        // 4. GESTION DES DOCUMENTS & MÉDIAS
        // =========================================================================
        Route::prefix('files')->group(function () {
            Route::post('/photo', [\App\Http\Controllers\Api\DocumentApiController::class, 'uploadPhoto'])->name('api.v1.candidat.upload_photo');
            Route::post('/cv', [\App\Http\Controllers\Api\DocumentApiController::class, 'uploadCv'])->name('api.v1.candidat.upload_cv');
            Route::delete('/cv', [\App\Http\Controllers\Api\DocumentApiController::class, 'deleteCv'])->name('api.v1.candidat.delete_cv');
            Route::post('/diplome', [\App\Http\Controllers\Api\DocumentApiController::class, 'uploadDiplome'])->name('api.v1.candidat.upload_diplome');
        });
    });
});
