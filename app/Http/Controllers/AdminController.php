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
        
        // Retourner la vue avec les utilisateurs
        return view('admin.users.index', compact('utilisateurs'));
    }
}
