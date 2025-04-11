<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur; 
use App\Models\Userdata;
class AvecDiplomeController extends Controller
{
    public function index(Request $request)
    {
        // On garde une requête query, PAS get() ici
        $query = Utilisateur::whereHas('userdata', function ($query) {
            $query->where('academic_id', '!=', 20);
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
    
        return view('admin.avec_diplome', compact('utilisateurs'));
    }
 
}
