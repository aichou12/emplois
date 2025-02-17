<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\EmploiController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\CheckAccountEnabled;
use Illuminate\Support\Facades\Password;
use Illuminate\Http\Request;
use App\Http\Controllers\UserdataController;
use App\Http\Controllers\RegionController;
use App\Models\Departement;


Route::get('/departements-par-region/{regionId}', function ($regionId) {
    return response()->json(Departement::where('region_id', $regionId)->get());
});
// routes/web.php

// web.php

use App\Models\User;
Route::get('/userdata/redirect', [UserdataController::class, 'redirectBasedOnUserdata'])->name('userdata.redirect');

Route::get('/check-email', function (Request $request) {
    $email = $request->query('email');
    
    $emailExists = User::where('email', $email)->exists();
    
    return response()->json(['exists' => $emailExists]);
});


Route::get('/get-departements/{region_id}', [RegionController::class, 'getDepartements']);



Route::get('/getDepartements/{regionId}', function ($regionId) {
    $departements = Departement::where('region_id', $regionId)->get();
    return response()->json($departements);
});

// Redirection par défaut vers la page de connexion
Route::get('/', function () {
    return redirect()->route('login');
});

// =============== AUTHENTIFICATION ===============

// Page de connexion
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Soumission du formulaire de connexion
Route::post('/login', [AuthController::class, 'login'])->name('login.store');

// Page d'inscription
Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Soumission du formulaire d'inscription
Route::post('/register', [AuthController::class, 'register'])->name('register.store');

// =============== VÉRIFICATION PAR EMAIL (Custom) ===============

// 1) Page "Vérifiez votre email" (uniquement accessible si user connecté)
Route::get('/email/verify', [VerificationController::class, 'notice'])
    ->middleware('auth')
    ->name('verification.notice');

// 2) Lien de vérification dans l'email
//    IMPORTANT : pas de 'auth' => l'utilisateur n'est pas connecté quand il clique
Route::get('/email/verify/{id}/{hash}', [VerificationController::class, 'verify'])
    ->middleware(['signed', 'throttle:6,1'])
    ->name('verification.verify');

// 3) Renvoyer l’email de vérification (nécessite d’être connecté pour renvoyer)
Route::post('/email/verification-notification', [VerificationController::class, 'send'])
    ->middleware(['auth', 'throttle:6,1'])
    ->name('verification.send');

// =============== ROUTES PROTÉGÉES PAR “enabled” ===============
// L’utilisateur doit être connecté ET son compte doit être activé (enabled = 1)
Route::middleware([CheckAccountEnabled::class])->group(function () {
    Route::get('/home', [InfoController::class, 'index'])->name('home');
    Route::get('/info/create', [InfoController::class, 'create'])->name('info.create');
});

// =============== EXEMPLE DE PAGE SUPPLÉMENTAIRE ===============
// Si vous voulez une page accessible après la connexion/activation
// vous pouvez la mettre dans le group "CheckAccountEnabled" ou ailleurs.


// use Illuminate\Support\Facades\Mail;

// Route::get('/test-mail', function () {
    // try {
     //    Mail::raw('Ceci est un test d\'envoi d\'email depuis Laravel.', function ($message) {
    //         $message->to('mbayedieng@esp.sn')
                //     ->subject('Test Email Laravel');
      //   });
      //   return 'Email envoyé avec succès.';
   //  } catch (\Exception $e) {
    //     return 'Erreur lors de l\'envoi de l\'email : ' . $e->getMessage();
   //  }
// });


// Routes protégées par l'authentification et la vérification d'email
// Route::group(['middleware' => ['auth', 'verified']], function () {
    // Routes pour la gestion des informations
   //  Route::get('/info/create', [InfoController::class, 'create'])->name('info.create');
   //  Route::post('/info', [InfoController::class, 'store'])->name('info.store');
   //  Route::get('/info', [InfoController::class, 'index'])->name('info.index');

    // Exemple d'autres routes protégées
   //  Route::get('/emplois/{secteur_id}', [EmploiController::class, 'getEmplois'])->name('getEmplois');
// });


//mot de passe
// Formulaire pour demander la réinitialisation
Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->middleware('guest')->name('password.request');

// Envoi de l'email de réinitialisation
Route::post('/forgot-password', function (Request $request) {
    $request->validate(['email' => 'required|email']);

    $status = Password::sendResetLink($request->only('email'));

    return $status === Password::RESET_LINK_SENT
        ? back()->with(['status' => __($status)])
        : back()->withErrors(['email' => __($status)]);
})->middleware('guest')->name('password.email');

// Formulaire pour réinitialiser le mot de passe
Route::get('/reset-password/{token}', function ($token) {
    return view('auth.reset-password', ['token' => $token]);
})->middleware('guest')->name('password.reset');

// Mise à jour du mot de passe
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

            // Connecter automatiquement l'utilisateur après la réinitialisation
            Auth::login($user);

            // Régénérer la session pour éviter tout problème de cache
            $request->session()->regenerate();
        }
    );

    return $status === Password::PASSWORD_RESET
        ? redirect()->route('login')->with('success', __($status))
        : back()->withErrors(['email' => [__($status)]]);
})->middleware('guest')->name('password.update');

Route::get('/userdata/create', [UserdataController::class, 'create'])->name('userdata.create');
Route::post('/userdata', [UserdataController::class, 'store'])->name('userdata.store');
Route::get('/userdata/{id}/edit', [UserdataController::class, 'edit'])->name('userdata.edit');
Route::put('/userdata/{id}', [UserdataController::class, 'update'])->name('userdata.update');



Route::get('/departements/{region_id}', [UserdataController::class, 'getDepartements']);
