<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\Userdata;
use App\Services\PasswordService;
use App\Services\PlatformSettings;
use App\Services\SecurityAccessService;

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
            'username' => [
                'required',
                'string',
                'min:3',
                'max:50',
                'regex:/^[a-zA-Z0-9._-]+$/',
                'not_regex:/@/',
                'unique:utilisateur,username',
                'unique:utilisateur,email',
            ],
            'numberid' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9]+$/', 'unique:utilisateur'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                'unique:utilisateur,email',
                'unique:utilisateur,username',
                'confirmed',
            ],
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cet email est déjà utilisé ou correspond à un nom d\'utilisateur existant.',
            'email.confirmed' => 'Les adresses email ne correspondent pas.',
            'password.confirmed' => 'Les mots de passe ne correspondent pas.',
            'username.min' => 'Le nom d\'utilisateur doit comporter au moins 3 caractères.',
            'username.max' => 'Le nom d\'utilisateur ne doit pas dépasser 50 caractères.',
            'username.regex' => 'Le nom d\'utilisateur ne peut contenir que des lettres, chiffres, tirets (-), tirets bas (_) et points (.) sans espaces.',
            'username.not_regex' => 'Le nom d\'utilisateur ne peut pas être une adresse e-mail (le symbole @ est interdit).',
            'username.unique' => 'Ce nom d\'utilisateur est déjà pris ou correspond à une adresse e-mail existante.',
            'numberid.unique' => 'Ce cni ou passport existe déjà.',
            'numberid.regex' => 'Le numéro de CNI ou de passeport doit contenir uniquement des lettres et des chiffres.',
        ]);

        // Rôle standard par défaut (aucun privilège administrateur accordable lors de l'inscription)
        $role = 'a:0:{}';

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
            ->with('registration_success', $utilisateur->email);
    }

    // Afficher le formulaire de connexion
    public function showLoginForm(PlatformSettings $settings)
    {
        return view('auth.login', [
            'loginVideoEmbedUrl' => PlatformSettings::youtubeEmbedUrl($settings->all()['login_video_url'] ?? null),
        ]);
    }
    public function showAdminLoginForm()
{
    return view('auth.admin-login');
}
    public function adminLogin(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $candidates = $this->findUsersByLogin($credentials['username']);

        if ($candidates->isEmpty()) {
            return back()->withErrors([
                'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
            ])->withInput($request->only('username'));
        }

        $authenticatedUser = null;
        $hasNonAdminMatch = false;

        foreach ($candidates as $candidate) {
            if ($this->verifyAndMigratePassword($candidate, $credentials['password'])) {
                if ($candidate->hasRole('admin')) {
                    $authenticatedUser = $candidate;
                    break;
                } else {
                    $hasNonAdminMatch = true;
                }
            }
        }

        if (!$authenticatedUser) {
            if ($hasNonAdminMatch) {
                return back()->withErrors([
                    'login' => 'Vous n\'avez pas les permissions d\'accéder à cette section.',
                ])->withInput($request->only('username'));
            }

            return back()->withErrors([
                'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
            ])->withInput($request->only('username'));
        }

        if (app(SecurityAccessService::class)->isAccountBlocked($authenticatedUser->id)) {
            return back()->withErrors(['login' => 'Ce compte est temporairement suspendu. Veuillez contacter l’administration.'])->withInput($request->only('username'));
        }

        Auth::login($authenticatedUser);
        app(SecurityAccessService::class)->recordSuccessfulLogin($authenticatedUser, $request, 'admin');
        $request->session()->regenerate();
        return redirect()->route('admin.users');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required|string|max:255',
            'password' => 'required|string',
        ]);

        $candidates = $this->findUsersByLogin($credentials['username']);

        if ($candidates->isEmpty()) {
            return back()->withErrors([
                'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
            ])->withInput($request->only('username'));
        }

        $authenticatedUser = null;

        foreach ($candidates as $candidate) {
            if ($this->verifyAndMigratePassword($candidate, $credentials['password'])) {
                $authenticatedUser = $candidate;
                break;
            }
        }

        if (!$authenticatedUser) {
            return back()->withErrors([
                'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
            ])->withInput($request->only('username'));
        }

        if (app(SecurityAccessService::class)->isAccountBlocked($authenticatedUser->id)) {
            return back()->withErrors(['login' => 'Ce compte est temporairement suspendu. Veuillez contacter l’administration.'])->withInput($request->only('username'));
        }

        Auth::login($authenticatedUser);
        app(SecurityAccessService::class)->recordSuccessfulLogin($authenticatedUser, $request, 'web');
        $request->session()->regenerate();
        return $this->redirectUserdata($authenticatedUser);
    }

    /**
     * Recherche les comptes correspondant à un nom d'utilisateur ou une adresse e-mail.
     * Trie les résultats selon le format saisi (priorité à l'email si un @ est présent).
     *
     * @return \Illuminate\Database\Eloquent\Collection<int, Utilisateur>
     */
    private function findUsersByLogin(string $identifier)
    {
        $identifier = trim($identifier);
        $canonical = mb_strtolower($identifier, 'UTF-8');
        $isEmailFormat = str_contains($identifier, '@');

        $users = Utilisateur::where(function ($query) use ($identifier, $canonical) {
            $query->where('username_canonical', $canonical)
                ->orWhere('email_canonical', $canonical)
                ->orWhere('username', $identifier)
                ->orWhere('email', $identifier);
        })->get();

        if ($users->isEmpty()) {
            return $users;
        }

        return $users->sortBy(function ($user) use ($canonical, $identifier, $isEmailFormat) {
            if ($isEmailFormat) {
                return ($user->email_canonical === $canonical || $user->email === $identifier) ? 0 : 1;
            }
            return ($user->username_canonical === $canonical || $user->username === $identifier) ? 0 : 1;
        })->values();
    }

    /** Recherche un compte unique avec son nom d'utilisateur ou son adresse e-mail. */
    private function findUserByLogin(string $identifier): ?Utilisateur
    {
        return $this->findUsersByLogin($identifier)->first();
    }

    /**
     * Vérifie le mot de passe (Bcrypt ou ancien hash Symfony 3) et migre vers Bcrypt si nécessaire.
     */
    private function verifyAndMigratePassword(Utilisateur $utilisateur, string $password): bool
    {
        if (password_get_info($utilisateur->password)['algo'] === PASSWORD_BCRYPT) {
            return Hash::check($password, $utilisateur->password);
        }

        if ($utilisateur->salt) {
            $hashedSymfonyPassword = $this->passwordService->hashSymfony3Password(
                $password,
                $utilisateur->salt
            );

            if (hash_equals($utilisateur->password, $hashedSymfonyPassword)) {
                $utilisateur->password = Hash::make($password);
                $utilisateur->salt = null;
                $utilisateur->save();
                return true;
            }
        }

        return false;
    }
    /**
     * Vérifie si l'utilisateur a déjà des données dans Userdata et redirige correctement
     */
    private function redirectUserdata($utilisateur)
    {
        if (!$utilisateur->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->withErrors(['email' => 'Veuillez vérifier votre adresse e-mail avant de continuer.']);
        }

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

    // Déconnexion
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
