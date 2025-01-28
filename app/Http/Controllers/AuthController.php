<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function create()
{
    
   
return view('auth.login');  // Affiche le formulaire d'inscription
}
    // Afficher le formulaire d'inscription
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    // Soumettre les informations d'inscription
    public function register(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
           
            'cni' => 'required|string|max:255|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        // Création de l'utilisateur
        User::create([
            'name' => $validatedData['name'],
         
            'cni' => $validatedData['cni'],
            'email' => $validatedData['email'],
            'password' => Hash::make($validatedData['password']),
        ]);

        // Rediriger vers la page de connexion avec un message de succès
        return redirect()->route('login')->with('success', 'Votre compte a été créé avec succès !');
    }

    // Afficher le formulaire de connexion
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Soumettre les informations de connexion
    public function login(Request $request)
    {
        // Validation des données
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
    
        // Authentifier l'utilisateur
        if (Auth::attempt($credentials)) {
            // Rediriger vers la page info.create après une connexion réussie
            return redirect()->route('info.create');
        }
    
        // Si l'authentification échoue
        return back()->withErrors([
            'email' => 'Les informations d\'identification sont incorrectes.',
        ]);
    }
    
    

    // Déconnexion de l'utilisateur
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
