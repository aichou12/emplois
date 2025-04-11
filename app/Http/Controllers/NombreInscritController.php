<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur; // Assurez-vous que le modèle Utilisateur est importé
use Carbon\Carbon;
use App\Models\Userdata;
class NombreInscritController extends Controller
{
    public function index(Request $request)
    {
        $currentYear = now()->year;
    
        // Démarrage de la requête avec jointure vers userdata
       
        $query = Utilisateur::whereYear('date_inscription', $currentYear) ;// Ne récupérer que ceux qui ont une relation userdata

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
    
        $utilisateurs_annee = $query->paginate(50);
    
        return view('admin.nombre_inscrit', compact('utilisateurs_annee'));
    }
  

  
    
}
