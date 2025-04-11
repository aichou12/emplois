<?php

namespace App\Http\Controllers;

use App\Models\Userdata;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
class DemandeurFemininController extends Controller
{
    //
  /*   public function index()
    {
        // Récupérer les utilisateurs dont le genre est "Homme" dans la table `userdata`
        $demandeursFeminins = Utilisateur::whereHas('userdata', function($query) {
            $query->where('genre', 'Feminin'); // Assurez-vous que 'genre' est bien le nom du champ dans la table `userdata`
        })->get();
        $utilisateur = Utilisateur::first(); 
     
        // Retourner la vue avec les utilisateurs masculins
        return view('admin.demandeur_feminin', compact('demandeursFeminins','utilisateur'));
    } */


    public function index(Request $request)
    {
        // On garde une requête query, PAS get() ici
        $query = Utilisateur::whereHas('userdata', function($query) {
            $query->where('genre', 'Feminin');
        })->with('userdata');
        $filters = [
            'id' => 'id',
            'identity_number' => 'numberid',
            'username' => 'username',
            'email' => 'email',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'isActif' => 'enabled',
            'isRecruted' => 'recruted',
        ];
    
        foreach ($filters as $formField => $dbColumn) {
            if ($request->filled($formField)) {
                if (in_array($formField, ['isActif', 'isRecruted'])) {
                    $query->where($dbColumn, $request->input($formField));
                } else {
                    $query->where($dbColumn, 'like', '%' . $request->input($formField) . '%');
                }
            }
        }
    
        // Maintenant, paginate fonctionne
        $utilisateurs = $query->paginate(50);
    
        return view('admin.demandeur_feminin', compact('utilisateurs'));
    }
}
