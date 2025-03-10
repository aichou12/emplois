<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;

class AdminController extends Controller
{
  public function index()
{
    // Récupérer tous les utilisateurs
    $utilisateurs = Utilisateur::all();
    
    // Récupérer le premier utilisateur (optionnel)
    $utilisateur = Utilisateur::first(); 
    
    // Récupérer les utilisateurs recrutés et non recrutés
    $recrutedUsers = Utilisateur::where('recruted', true)->count();
    $notRecrutedUsers = Utilisateur::where('recruted', false)->count();
    
    // Récupérer les listes des utilisateurs recrutés et non recrutés
    $recrutedList = Utilisateur::where('recruted', true)->get();
    $notRecrutedList = Utilisateur::where('recruted', false)->get();
    
    // Récupérer le nombre total d'utilisateurs
    $totalUsers = Utilisateur::count();  // Nombre total d'utilisateurs
    
    // Retourner la vue avec toutes les données
    return view('admin.index', compact('utilisateurs', 'utilisateur', 'recrutedUsers', 'notRecrutedUsers', 'recrutedList', 'notRecrutedList', 'totalUsers'));
}


    
    public function edit($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.edit', compact('utilisateur'));
    }
    public function destroy($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Delete the user
        $utilisateur->delete();

        // Redirect back to the user list or show a success message
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
    public function recruter($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Set the 'recruted' status to true
        $utilisateur->recruted = true;
        $utilisateur->save();

        // Redirect back with a success message
        return redirect()->route('admin.users')->with('success', 'Utilisateur recruté avec succès!');
    }
}
