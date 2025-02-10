<?php
namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
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
    // Validate credentials
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    // Authenticate the user
    if (Auth::attempt($credentials)) {
        // Get the logged-in user
        $user = Auth::user();

        // Check if the user has an associated 'info' record
        $info = $user->info; // Assuming the relationship is set up in the User model

        // Redirect to 'info.edit' if the form has been submitted (is_submitted == 1)
        if ($info && $info->is_submitted == 1) {
            return redirect()->route('info.edit', $info->id);
        }

        // Otherwise, redirect to 'info.create' if the form is not submitted
        return redirect()->route('info.create');
    }

    // If authentication fails, return an error message
    return back()->withErrors([
        'email' => 'Les informations d\'identification sont incorrectes.',
    ]);
}

    
}
