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
    public function register(Request $request)
    {
        // 1) Validation des données du formulaire
        $validatedData = $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'username' => 'required|string|max:180|unique:utilisateur',
            'numberid' => 'required|string|max:255|unique:utilisateur',
            'email' => 'required|string|email|max:255|unique:utilisateur',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        // 2) Déterminer le rôle
        $role = 'a:0:{}'; // Valeur par défaut si aucun rôle n'est spécifié
    
        // Vérifier si l'utilisateur veut être un admin (par exemple, en passant un paramètre is_admin)
        if ($request->has('is_admin') && $request->is_admin) {
            $role = 'a:1:{i:0;s:5:"admin";}'; // Rôle admin
        }
    
        // 3) Création de l'utilisateur
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
    
        // 4) Déclencher l'événement Registered => envoi du mail de vérification
        event(new Registered($utilisateur));
    
        // 5) Rediriger vers la page de connexion avec un message
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
        return back()->withErrors(['username' => 'Nom d\'utilisateur ou mot de passe incorrect.']);
    }

    if (!$utilisateur->enabled) {
        return back()->withErrors(['username' => 'Votre compte n\'a pas encore été activé. Veuillez vérifier votre email.']);
    }

    // Connecter l'utilisateur
    Auth::login($utilisateur);

    // Mettre à jour la date de la dernière connexion
    $utilisateur->update(['last_login' => now()]);

    $request->session()->regenerate();

    // Vérifier si l'utilisateur a le rôle 'admin'
    if ($utilisateur->hasRole('admin')) {
        // Si l'utilisateur est un admin, rediriger vers la page des utilisateurs admin
        return redirect()->route('admin.users'); // Redirection vers la vue admin.users.index
    }

    // Vérifier si l'utilisateur a déjà des données dans userdata
    $userdata = Userdata::where('utilisateur_id', $utilisateur->id)->first();
    if ($userdata) {
        // Si des données existent, rediriger vers l'édition
        return redirect()->route('userdata.edit', $userdata->id);
    } else {
        // Sinon, rediriger vers la création
        return redirect()->route('userdata.create');
    }
}



// Modifier le mot de passe
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






