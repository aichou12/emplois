<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserdataController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\DemandeurController;
use App\Http\Controllers\DemandeurFemininController;
use App\Http\Controllers\DemandeurMasculinController;
use App\Http\Controllers\AvecDiplomeController;
use App\Http\Controllers\SansDiplomeController;
use App\Http\Controllers\NombreInscritController;
use App\Http\Controllers\DemandeurIncompletController;
use App\Http\Controllers\ActifController;
use App\Http\Controllers\PasActifController;

use App\Models\Departement;
use App\Models\Emploi;
use App\Models\User;

// Redirection par défaut vers la page de connexion
Route::get('/', function () {
    return redirect()->route('login');
});

// =========================================================================
// 1. ROUTES PUBLIQUES (API Locales / Utilitaires)
// =========================================================================
Route::get('/departements-par-region/{regionId}', function ($regionId) {
    return response()->json(Departement::where('region_id', $regionId)->get());
});
Route::get('/get-departements/{region_id}', [RegionController::class, 'getDepartements']);
Route::get('/getDepartements/{regionId}', function ($regionId) {
    return response()->json(Departement::where('region_id', $regionId)->get());
});
Route::get('/departements/{region_id}', [UserdataController::class, 'getDepartements']);

Route::get('/emplois-par-secteur/{secteur_id}', function($secteur_id) {
    return response()->json(Emploi::where('secteur_id', $secteur_id)->get());
})->name('emplois.by.secteur');

Route::get('/check-email', function (Request $request) {
    $email = $request->query('email');
    $emailExists = User::where('email', $email)->exists();
    return response()->json(['exists' => $emailExists]);
});


// =========================================================================
// 2. AUTHENTIFICATION CANDIDAT & VISITEUR
// =========================================================================
Route::middleware('guest')->group(function () {
    // Connexion
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');

    // Inscription
    Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');

    // Réinitialisation de mot de passe
    Route::get('/forgot-password', function () {
        return view('auth.forgot-password');
    })->name('password.request');

    Route::post('/forgot-password', function (Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:utilisateur,email',
        ], [
            'email.exists' => 'Votre email n\'est associé à aucun compte.',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $status = Password::sendResetLink($request->only('email'));
        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Un email vous a été envoyé pour la réinitialisation de votre mot de passe.');
        } else {
            return back()->withErrors(['email' => __($status)]);
        }
    })->name('password.email');

    Route::get('/reset-password/{token}', function ($token) {
        return view('auth.reset-password', ['token' => $token]);
    })->name('password.reset');

    Route::post('/reset-password', function (Request $request) {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();

                Auth::login($user);
                $request->session()->regenerate();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return back()->with('success', 'Votre mot de passe a été mis à jour avec succès. Veuillez vous connecter.');
        }

        return back()->withErrors(['email' => [__($status)]]);
    })->name('password.update');

    // Connexion Admin
    Route::get('/admin/login', [AuthController::class, 'showAdminLoginForm'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'adminLogin'])->name('admin.login.submit');
});

// Déconnexion
Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect()->route('login');
})->name('logout');


// =========================================================================
// 3. VÉRIFICATION PAR EMAIL
// =========================================================================
Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware('signed')
    ->name('verification.verify');
Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware('auth')
    ->name('verification.send');


// =========================================================================
// 4. ESPACE CANDIDAT AUTHENTIFIÉ (Middleware: auth)
// =========================================================================
Route::middleware('auth')->group(function () {

    // Changement de mot de passe
    Route::get('/change-password', [PasswordController::class, 'edit'])->name('password.edit');
    Route::post('/change-password', [PasswordController::class, 'update'])->name('password.update');
    Route::post('/auth/change-password', [AuthController::class, 'changePassword'])->name('change.password');

    // Gestion du dossier candidat / Userdata
    Route::get('/userdata/create', [UserdataController::class, 'create'])->name('userdata.create');
    Route::post('/userdata', [UserdataController::class, 'store'])->name('userdata.store');
    Route::get('/userdata/{id}/edit', [UserdataController::class, 'edit'])->name('userdata.edit');
    Route::put('/userdata/{id}', [UserdataController::class, 'update'])->name('userdata.update');
    Route::get('/userdata/summary/{id}', [UserdataController::class, 'summary'])->name('userdata.summary');
    Route::get('/userdata/{id}/resume', [UserdataController::class, 'resume'])->name('resume');

    // Fichiers et photos
    Route::post('/delete-file', [UserdataController::class, 'deleteFile'])->name('file.delete');
    Route::post('/deleteCvFile', [UserdataController::class, 'deleteCvFile'])->name('files.delete');
    Route::post('/update-photo', [UserdataController::class, 'updatePhotoProfil'])->name('updatePhotoProfil');
    Route::post('/updatephoto-profil', [UserdataController::class, 'updatePhotoProfil'])->name('update.photo');

    // Route d'accueil / Dashboard connecté
    Route::get('/home', function () {
        $user = auth()->user();
        if ($user && $user->hasRole('admin')) {
            return redirect()->route('admin.users');
        }
        $userdata = \App\Models\Userdata::where('utilisateur_id', $user->id)->first();
        if ($userdata) {
            return redirect()->route('userdata.summary', $userdata->id);
        }
        return redirect()->route('userdata.create');
    })->name('home');

    // Routes info protégées par "enabled" (Compte actif)
    Route::middleware('enabled')->group(function () {
        Route::get('/info/create', [InfoController::class, 'create'])->name('info.create');
    });
});


// =========================================================================
// 5. ESPACE ADMINISTRATION SÉCURISÉ (Middleware: auth + role:admin)
// =========================================================================
Route::middleware(['auth', 'role:admin'])->prefix('admin')->group(function () {

    // Dashboard et Gestion des Utilisateurs
    Route::get('/users', [AdminController::class, 'index'])->name('admin.users');
    Route::get('/users/{user}/edit', [AdminController::class, 'edit'])->name('admin.edit');
    Route::delete('/users/{user}', [AdminController::class, 'destroy'])->name('admin.delete');
    Route::post('/users/{user}/recruter', [AdminController::class, 'recruter'])->name('admin.recruter');
    Route::get('/search-users', [AdminController::class, 'searchUsers'])->name('searchUsers');

    // Vues et éditions spécialisées
    Route::get('/users/{user}/editnombreinscrit', [AdminController::class, 'editnombreinscrit'])->name('admin.editnombreinscrit');
    Route::get('/users/{user}/editsansdiplome', [AdminController::class, 'editsansdiplome'])->name('admin.editsansdiplome');
    Route::get('/users/{user}/editincomplet', [AdminController::class, 'editincomplet'])->name('admin.editincomplet');
    Route::get('/users/{user}/editactif', [AdminController::class, 'editactif'])->name('admin.editactif');
    Route::get('/users/{user}/editpasactif', [AdminController::class, 'editpasactif'])->name('admin.editpasactif');
    Route::get('/users/{user}/editavecdiplome', [AdminController::class, 'editavecdiplome'])->name('admin.editavecdiplome');
    Route::get('/users/{user}/editmasculin', [AdminController::class, 'editmasculin'])->name('admin.editmasculin');
    Route::get('/users/{user}/editfeminin', [AdminController::class, 'editfeminin'])->name('admin.editfeminin');

    // Mises à jour administrateur
    Route::put('/update/{id}', [AdminController::class, 'update'])->name('admin.update');
    Route::put('/updatemasculin/{id}', [AdminController::class, 'updatemasculin'])->name('admin.updatemasculin');
    Route::put('/updatenombreinscrit/{id}', [AdminController::class, 'updatenombreinscrit'])->name('admin.updatenombreinscrit');
    Route::put('/updatesansdiplome/{id}', [AdminController::class, 'updatesansdiplome'])->name('admin.updatesansdiplome');
    Route::put('/updateavecdiplome/{id}', [AdminController::class, 'updateavecdiplome'])->name('admin.updateavecdiplome');
    Route::put('/updatefeminin/{id}', [AdminController::class, 'updatefeminin'])->name('admin.updatefeminin');
    Route::put('/updateincomplet/{id}', [AdminController::class, 'updateincomplet'])->name('admin.updateincomplet');
    Route::put('/updateactif/{id}', [AdminController::class, 'updateactif'])->name('admin.updateactif');
    Route::put('/updatepasactif/{id}', [AdminController::class, 'updatepasactif'])->name('admin.updatepasactif');

    // Listes & Statistiques
    Route::get('/demandeurincomplet', [AdminController::class, 'demandeursIncomplets'])->name('admin.demandeurincomplet');
    Route::get('/liste_demandeur', [DemandeurController::class, 'index'])->name('liste.utilisateurs');
    Route::get('/nombre_inscrit', [NombreInscritController::class, 'index'])->name('liste.inscrit');
    Route::get('/compteactif', [ActifController::class, 'index'])->name('liste.complet');
    Route::get('/comptepasactif', [PasActifController::class, 'index'])->name('liste.pascomplet');
    Route::get('/sans_diplome', [SansDiplomeController::class, 'index'])->name('liste.sansdiplome');
    Route::get('/avec_diplome', [AvecDiplomeController::class, 'index'])->name('liste.avecdiplome');
    Route::get('/demandeur_masculin', [DemandeurMasculinController::class, 'index'])->name('liste.masculin');
    Route::get('/demandeur_feminin', [DemandeurFemininController::class, 'index'])->name('liste.feminin');
});
