<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur; 
use App\Models\Userdata;
class AvecDiplomeController extends Controller
{
    public function index()
    {
        $utilisateur = Utilisateur::first(); 
    
        // Récupérer les utilisateurs avec diplôme (academic_id différent de 20)
        $avecDiplomeUsers = Utilisateur::whereHas('userdata', function ($query) {
            $query->where('academic_id', '!=', 20);
        })->with('userdata')->get();
    
        // Retourner la vue avec les données
        return view('admin.avec_diplome', compact('avecDiplomeUsers', 'utilisateur'));
    }
    
}
