<?php

namespace App\Http\Controllers;
use App\Models\Userdata;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
class DemandeurMasculinController extends Controller
{
    public function index()
    {
        // Récupérer les utilisateurs dont le genre est "Homme" dans la table `userdata`
        $demandeursMasculins = Utilisateur::whereHas('userdata', function($query) {
            $query->where('genre', 'Masculin'); // Assurez-vous que 'genre' est bien le nom du champ dans la table `userdata`
        })->get();
        $utilisateur = Utilisateur::first(); 
     
        // Retourner la vue avec les utilisateurs masculins
        return view('admin.demandeur_masculin', compact('demandeursMasculins','utilisateur'));
    }
    
}
