<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class PasswordController extends Controller
{
    // Affiche le formulaire de modification du mot de passe
    public function edit()
    {
        return view('auth.change-password');
    }


    // Traite la mise à jour du mot de passe
    public function update(Request $request)
{
    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:8|confirmed',
    ]);

    $user = Auth::user();

    // Vérifier le mot de passe actuel
    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
    }

    // Mettre à jour le mot de passe
    $user->password = Hash::make($request->new_password);
    $user->save();

    // Au lieu de rediriger vers login, on redirige vers la même page
    // pour que le code SweetAlert s'exécute :
    return redirect()
        ->route('password.edit') // ou la route qui affiche VRAIMENT la vue avec le SweetAlert
        ->with('success', 'Votre mot de passe a été réinitialisé avec succès.');
}


}
