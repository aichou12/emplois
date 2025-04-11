<?php

namespace App\Http\Controllers;

use App\Models\Userdata;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class DemandeurController extends Controller
{
    public function index(Request $request)
    {
        $query = Utilisateur::has('userdata'); // Ne récupérer que ceux qui ont une relation userdata
    
        // Mapping des champs du formulaire vers les colonnes en BDD
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
    
        $utilisateurs = $query->paginate(50);
    
        return view('admin.liste_demandeur', compact('utilisateurs'));
    }
}
    
