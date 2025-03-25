<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Models\Userdata;

class AuthController extends Controller
{
    // Afficher le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Soumettre le formulaire d'inscription
    // Soumettre le formulaire d'inscription
    public function register(Request $request)
    {
        // Validation des données du formulaire
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:180|unique:utilisateur',
            'numberid' => 'required|string|max:255|unique:utilisateur', // Validation unique pour CNI
            'email' => 'required|string|email|max:255|unique:utilisateur|confirmed', // Validation email avec confirmation
            'password' => 'required|string|min:8|confirmed',
        ], [
            'email.email' => 'L\'adresse email n\'est pas valide.', // Message personnalisé pour email invalide
            'email.unique' => 'Cet email est déjà utilisé.', // Message pour email déjà utilisé
            'email.confirmed' => 'Les adresses email ne correspondent pas.', // Message pour email non confirmé
        ]);
    
        // Vérifier si le numéro de CNI existe déjà dans la base
        $existingCni = Utilisateur::where('numberid', $validatedData['numberid'])->first();
        if ($existingCni) {
            // Retourner l'erreur si le CNI existe déjà
            return back()->withErrors(['numberid' => 'Ce numéro de CNI est déjà utilisé.'])->withInput();
        }
    
        // Création de l'utilisateur
        $role = 'a:0:{}'; // Valeur par défaut si aucun rôle n'est spécifié
    
        if ($request->has('is_admin') && $request->is_admin) {
            $role = 'a:1:{i:0;s:5:"admin";}'; // Rôle admin
        }
    
        // Création de l'utilisateur
        $utilisateur = Utilisateur::create([
            'firstname' => $validatedData['firstname'],
            'lastname' => $validatedData['lastname'],
            'username' => $validatedData['username'],
            'numberid' => $validatedData['numberid'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
            'enabled' => 0, // Par défaut désactivé jusqu'à l'activation par email
            'date_inscription' => now(),
            'roles' => $role, // Assigner le rôle admin si nécessaire
        ]);
    
        // Déclencher l'événement Registered => envoi du mail de vérification
        event(new Registered($utilisateur));
    
        // Rediriger vers une page de confirmation
        return redirect()->route('register')
            ->with('success', 'Votre compte a été créé ! Vérifiez votre boîte mail pour activer votre compte.');
    }
    



    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Soumettre le formulaire de connexion
 // Soumettre le formulaire de connexion

 public function login(Request $request)
 {
     // Validation des informations de connexion
     $credentials = $request->validate([
         'username' => 'required|string',
         'password' => 'required|string',
     ]);
 
     // Récupérer l'utilisateur
     $utilisateur = Utilisateur::where('username', $credentials['username'])->first();
 
     if (!$utilisateur || !Hash::check($credentials['password'], $utilisateur->password)) {
         return back()->withErrors([
             'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
         ])->withInput($request->only('username'));
     }
 
     if (!$utilisateur->enabled) {
         return back()->withErrors([
             'login' => 'Votre compte n\'a pas encore été activé. Veuillez vérifier votre email.',
         ])->withInput($request->only('username'));
     }
 
     // Connecter l'utilisateur
     Auth::login($utilisateur);
 
     // Mettre à jour la date de la dernière connexion
     $utilisateur->update(['last_login' => now()]);
 
     $request->session()->regenerate();
 
     // Vérifier si l'utilisateur a le rôle 'admin'
     if ($utilisateur->hasRole('admin')) {
         return redirect()->route('admin.users');
     }
 
     // Vérifier si l'utilisateur a déjà des données dans userdata
     $userdata = Userdata::where('utilisateur_id', $utilisateur->id)->first();
     if ($userdata) {
         return redirect()->route('userdata.summary', $userdata->id);
     } else {
         return redirect()->route('userdata.create');
     }
 }
 // In AuthController.php
public function showAdminLoginForm()
{
    return view('auth.admin-login');
}
public function adminLogin(Request $request)
{
    // Validation des informations de connexion
    $credentials = $request->validate([
        'username' => 'required|string',
        'password' => 'required|string',
    ]);
    
    // Récupérer l'utilisateur
    $utilisateur = Utilisateur::where('username', $credentials['username'])->first();

    if (!$utilisateur || !Hash::check($credentials['password'], $utilisateur->password)) {
        return back()->withErrors([
            'login' => 'Nom d\'utilisateur ou mot de passe incorrect.',
        ])->withInput($request->only('username'));
    }

    // Vérifier si l'utilisateur a le rôle 'admin'
    if (!$utilisateur->hasRole('admin')) {
        return back()->withErrors([
            'login' => 'Vous n\'avez pas les permissions d\'accéder à cette section.',
        ])->withInput($request->only('username'));
    }

    // Connecter l'utilisateur
    Auth::login($utilisateur);

    // Mettre à jour la date de la dernière connexion
    $utilisateur->update(['last_login' => now()]);

    $request->session()->regenerate();

    return redirect()->route('admin.users'); // Rediriger vers le tableau de bord admin
}

// Modifier le mot de passe
public function changePassword(Request $request)
{
    // Validation des données
    $validatedData = $request->validate([
        'current_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    // Récupérer l'utilisateur authentifié
    $utilisateur = Auth::user();

    // Vérifier si le mot de passe actuel est correct
    if (!Hash::check($validatedData['current_password'], $utilisateur->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }

    // Mettre à jour le mot de passe
    $utilisateur->password = Hash::make($validatedData['new_password']);
    $utilisateur->save();

    // Récupérer les données de l'utilisateur dans la table userdata
    $userdata = Userdata::where('utilisateur_id', $utilisateur->id)->first();

    // Rediriger avec un message de succès
    return redirect()->route('userdata.edit', $userdata ? $userdata->id : 'default')->with('success', 'Votre mot de passe a été mis à jour avec succès.');
}



}

