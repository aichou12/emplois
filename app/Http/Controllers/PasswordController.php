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
            'current_password'      => 'required',
            'new_password'          => 'nullable|min:8|confirmed',
        ]);
    
        $user = Auth::user();
    
        // Vérifier que le mot de passe actuel est correct
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Le mot de passe actuel est incorrect']);
        }
    
        // Si un nouveau mot de passe est fourni, le mettre à jour
        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
            $user->save();
    
            return redirect()->back()->with('success', 'Votre mot de passe a été modifié');
        }
    
        // Sinon, aucun changement n'est effectué
        return redirect()->back()->with('success', 'Aucun changement n\'a été effectué');
    }
    
}
