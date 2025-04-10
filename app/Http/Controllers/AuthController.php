<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\Userdata;
use App\Services\PasswordService;

class AuthController extends Controller
{
    protected $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    // Afficher le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Soumettre le formulaire d'inscription
    public function register(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:180|unique:utilisateur',
            'numberid' => 'required|string|max:255|unique:utilisateur',
            'email' => 'required|string|email|max:255|unique:utilisateur|confirmed',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cet email est déjà utilisé.',
            'email.confirmed' => 'Les adresses email ne correspondent pas.',
            'username.unique' => 'Ce nom d\'utilisateur existe déjà.',
            'numberid.unique' => 'Ce cni ou passport existe déjà.',
        ]);

        // Vérifier si le numéro de CNI existe déjà
        if (Utilisateur::where('numberid', $validatedData['numberid'])->exists()) {
            return back()->withErrors(['numberid' => 'Ce numéro de CNI est déjà utilisé.'])->withInput();
        }

        // Rôle par défaut
        $role = 'a:0:{}';
        if ($request->has('is_admin') && $request->is_admin) {
            $role = 'a:1:{i:0;s:5:"admin";}';
        }

        // Création de l'utilisateur
        $utilisateur = Utilisateur::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'username' => $validatedData['username'],
            'numberid' => $validatedData['numberid'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'enabled' => 0,
            'date_inscription' => now(),
            'roles' => $role,
        ]);

        event(new Registered($utilisateur));

        return redirect()->route('login')
            ->with('success', 'Votre compte a été créé ! Vérifiez votre boîte mail pour activer votre compte.');
    }

    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }
    public function showAdminLoginForm()
{
    return view('auth.admin-login');
}
public function adminLogin(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $utilisateur = Utilisateur::where('username', $credentials['username'])->first();

    if (!$utilisateur) {
        return back()->withErrors([
            'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
        ])->withInput($request->only('username'));
    }

    // Vérifier si c'est un admin AVANT de continuer
    if (!$utilisateur->hasRole('admin')) {
        return back()->withErrors([
            'login' => 'Vous n\'avez pas les permissions d\'accéder à cette section.',
        ])->withInput($request->only('username'));
    }

    // Authentification Bcrypt
    if (password_get_info($utilisateur->password)['algo'] === PASSWORD_BCRYPT) {
        if (Hash::check($credentials['password'], $utilisateur->password)) {
            Auth::login($utilisateur);
            $utilisateur->update(['last_login' => now()]);
            $request->session()->regenerate();
            return redirect()->route('admin.users');
        }
    }
    // Authentification ancien hash Symfony
    elseif ($utilisateur->salt) {
        $hashedSymfonyPassword = $this->passwordService->hashSymfony3Password(
            $credentials['password'],
            $utilisateur->salt
        );

        if (hash_equals($utilisateur->password, $hashedSymfonyPassword)) {
            // Update to bcrypt
            $utilisateur->password = Hash::make($credentials['password']);
            $utilisateur->salt = null;
            $utilisateur->save();

            Auth::login($utilisateur);
            $utilisateur->update(['last_login' => now()]);
            $request->session()->regenerate();
            return redirect()->route('admin.users');
        }
    }

    return back()->withErrors([
        'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
    ])->withInput($request->only('username'));
}


    public function login(Request $request)
{
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    $utilisateur = Utilisateur::where('username', $credentials['username'])->first();

    if (!$utilisateur) {
        return back()->withErrors([
            'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
        ])->withInput($request->only('username'));
    }

    // Vérifier Bcrypt
    if (password_get_info($utilisateur->password)['algo'] === PASSWORD_BCRYPT) {
        if (Hash::check($credentials['password'], $utilisateur->password)) {
            Auth::login($utilisateur);
            $request->session()->regenerate();
            return $this->redirectUserdata($utilisateur);
        }
    }
    // Vérifier ancien hash Symfony
    elseif ($utilisateur->salt) {
        $hashedSymfonyPassword = $this->passwordService->hashSymfony3Password(
            $credentials['password'],
            $utilisateur->salt
        );

        if (hash_equals($utilisateur->password, $hashedSymfonyPassword)) {
            $utilisateur->password = Hash::make($credentials['password']);
            $utilisateur->salt = null;
            $utilisateur->save();

            Auth::login($utilisateur);
            $request->session()->regenerate();
            return $this->redirectUserdata($utilisateur);
        }
    }

    return back()->withErrors([
        'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
    ])->withInput($request->only('username'));
}
    /**
     * Vérifie si l'utilisateur a déjà des données dans Userdata et redirige correctement
     */
    private function redirectUserdata($utilisateur)
    {
        $userdata = Userdata::where('utilisateur_id', $utilisateur->id)->first();

        if ($userdata) {
            return redirect()->route('userdata.summary', $userdata->id);
        } else {
            return redirect()->route('userdata.create');
        }
    }

    // Modifier le mot de passe
    public function changePassword(Request $request)
    {
        $validatedData = $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        $utilisateur = Auth::user();

        if (!Hash::check($validatedData['current_password'], $utilisateur->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        $utilisateur->password = Hash::make($validatedData['new_password']);
        $utilisateur->save();

        $userdata = Userdata::where('utilisateur_id', $utilisateur->id)->first();
        session()->flash('success', 'Votre mot de passe a été mis à jour avec succès.');

        return redirect()->route('userdata.summary', $userdata ? $userdata->id : 'default')
                         ->with('success', 'Votre mot de passe a été mis à jour avec succès.');
    }
}

