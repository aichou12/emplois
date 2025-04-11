<?php

namespace App\Http\Controllers;
use App\Models\Userdata;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class ActifController extends Controller
{
    public function index(Request $request)
    {
        // On garde une requête query, PAS get() ici
        $query = Utilisateur::where('enabled', true);
    
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
    
        return view('admin.actif', compact('utilisateurs'));
    }
    
       
   
}
