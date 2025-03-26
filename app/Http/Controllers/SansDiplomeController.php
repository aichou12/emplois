<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur; 
use App\Models\Userdata;
class SansDiplomeController extends Controller
{
    //

    public function index()
    {
        $utilisateur = Utilisateur::first(); 
      
        // Récupérer les utilisateurs sans diplôme avec leurs informations
        $sansDiplomeUsers = Utilisateur::whereHas('userdata', function ($query) {
            $query->where('academic_id', 20);
        })->with('userdata')->get();
    
        // Retourner la vue avec les données
        return view('admin.sans_diplome', compact('sansDiplomeUsers','utilisateur'));
    }
    

}
