<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\LoginController;
// Route par défaut redirige vers la page de connexion
Route::get('/', function () {
    return redirect()->route('login');  // Redirige vers la page de connexion
});

// Routes de connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');  // Afficher le formulaire de connexion
Route::post('/login', [AuthController::class, 'login'])->name('login.store');     // Soumettre le formulaire de connexion

// Routes d'inscription
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');  // Afficher le formulaire d'inscription
Route::post('/register', [AuthController::class, 'register'])->name('register.store');      // Soumettre le formulaire d'inscription

// Routes pour la création d'informations
Route::get('/info/create', [InfoController::class, 'create'])->name('info.create');  // Formulaire pour créer des informations
Route::post('/info', [InfoController::class, 'store'])->name('info.store');          // Soumettre les informations
Route::get('/info', [InfoController::class, 'index'])->name('info.index');


//Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
