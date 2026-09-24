<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\Utilisateur;
use App\Services\PasswordService;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthApiController extends Controller
{
    protected PasswordService $passwordService;

    public function __construct(PasswordService $passwordService)
    {
        $this->passwordService = $passwordService;
    }

    /**
     * Inscription d'un nouveau candidat via l'application mobile.
     */
    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:180|unique:utilisateur,username',
            'numberid' => 'required|string|max:255|unique:utilisateur,numberid',
            'email' => 'required|string|email|max:255|unique:utilisateur,email',
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cet email est déjà associé à un compte.',
            'username.unique' => 'Ce nom d\'utilisateur est déjà pris.',
            'numberid.unique' => 'Ce numéro CNI / Passeport est déjà enregistré.',
            'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.',
            'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation des données.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        $utilisateur = Utilisateur::create([
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'username' => $validated['username'],
            'username_canonical' => strtolower($validated['username']),
            'numberid' => $validated['numberid'],
            'email' => $validated['email'],
            'email_canonical' => strtolower($validated['email']),
            'password' => Hash::make($validated['password']),
            'enabled' => 0,
            'date_inscription' => now(),
            'roles' => 'a:0:{}',
        ]);

        event(new Registered($utilisateur));

        return response()->json([
            'success' => true,
            'message' => 'Compte créé. Vérifiez votre adresse e-mail pour l’activer avant de vous connecter.',
            'data' => [
                'user' => new UserResource($utilisateur),
                'email_verification_required' => true,
            ],
        ], 201);
    }

    /**
     * Connexion via l'application mobile (username ou email).
     */
    public function login(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'login' => 'required|string',
            'password' => 'required|string',
            'device_name' => 'nullable|string',
        ], [
            'login.required' => 'L\'identifiant ou l\'email est obligatoire.',
            'password.required' => 'Le mot de passe est obligatoire.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiant ou mot de passe manquant.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $loginInput = $request->input('login');
        $passwordInput = $request->input('password');
        $deviceName = $request->input('device_name', 'mobile_app');

        // Recherche par nom d'utilisateur OU par email
        $utilisateur = Utilisateur::where('username', $loginInput)
            ->orWhere('email', $loginInput)
            ->orWhere('username_canonical', strtolower($loginInput))
            ->orWhere('email_canonical', strtolower($loginInput))
            ->first();

        if (!$utilisateur) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants invalides.',
                'errors' => [
                    'login' => ['Nom d\'utilisateur ou mot de passe incorrect.'],
                ],
            ], 401);
        }

        $passwordValid = false;

        // 1. Vérification Bcrypt standard
        if (password_get_info($utilisateur->password)['algo'] === PASSWORD_BCRYPT) {
            $passwordValid = Hash::check($passwordInput, $utilisateur->password);
        }
        // 2. Migration ancien hash Symfony si présent
        elseif ($utilisateur->salt) {
            $hashedSymfony = $this->passwordService->hashSymfony3Password($passwordInput, $utilisateur->salt);
            if (hash_equals($utilisateur->password, $hashedSymfony)) {
                $utilisateur->password = Hash::make($passwordInput);
                $utilisateur->salt = null;
                $utilisateur->save();
                $passwordValid = true;
            }
        }

        if (!$passwordValid) {
            return response()->json([
                'success' => false,
                'message' => 'Identifiants invalides.',
                'errors' => [
                    'password' => ['Nom d\'utilisateur ou mot de passe incorrect.'],
                ],
            ], 401);
        }

        if (!$utilisateur->hasVerifiedEmail()) {
            return response()->json([
                'success' => false,
                'code' => 'email_not_verified',
                'message' => 'Vérifiez votre adresse e-mail pour activer votre compte avant de vous connecter.',
            ], 403);
        }

        // Mise à jour de la date de dernière connexion
        $utilisateur->update(['last_login' => now()]);

        // Génération du token Sanctum
        $token = $utilisateur->createToken($deviceName)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Connexion réussie.',
            'data' => [
                'user' => new UserResource($utilisateur->load('userdata')),
                'token' => $token,
                'token_type' => 'Bearer',
            ],
        ], 200);
    }

    /**
     * Récupère les données du compte connecté.
     */
    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'message' => 'Données du profil récupérées.',
            'data' => [
                'user' => new UserResource($user->load('userdata')),
            ],
        ], 200);
    }

    /**
     * Déconnexion (révocation du token de la session mobile).
     */
    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();

        if ($user && $user->currentAccessToken()) {
            $user->currentAccessToken()->delete();
        }

        return response()->json([
            'success' => true,
            'message' => 'Déconnexion réussie. Le jeton d\'accès a été révoqué.',
        ], 200);
    }

    /**
     * Demande de réinitialisation de mot de passe par e-mail.
     */
    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|max:255',
        ], [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation.',
                'errors' => $validator->errors(),
            ], 422);
        }

        Password::sendResetLink($request->only('email'));

        return response()->json([
            'success' => true,
            'message' => 'Si cette adresse correspond à un compte, un lien de réinitialisation lui a été envoyé.',
        ], 200);
    }

    /** Renvoie le lien d’activation sans révéler si l’adresse possède un compte. */
    public function resendVerification(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $email = strtolower(trim($validated['email']));
        $utilisateur = Utilisateur::where('email_canonical', $email)->first();

        if ($utilisateur && !$utilisateur->hasVerifiedEmail()) {
            $utilisateur->sendEmailVerificationNotification();
        }

        return response()->json([
            'success' => true,
            'message' => 'Si un compte non activé correspond à cette adresse, un nouveau lien lui a été envoyé.',
        ]);
    }
}
