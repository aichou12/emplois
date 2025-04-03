<?php

namespace App\Http\Controllers;

use App\Models\Userdata;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
class DemandeurFemininController extends Controller
{
    //
    public function index()
    {
        // Récupérer les utilisateurs dont le genre est "Homme" dans la table `userdata`
        $demandeursFeminins = Utilisateur::whereHas('userdata', function($query) {
            $query->where('genre', 'Femme'); // Assurez-vous que 'genre' est bien le nom du champ dans la table `userdata`
        })->get();
        $utilisateur = Utilisateur::first(); 
     
        // Retourner la vue avec les utilisateurs masculins
        return view('admin.demandeur_feminin', compact('demandeursFeminins','utilisateur'));
    }
}
