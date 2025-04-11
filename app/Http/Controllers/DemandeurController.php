<?php

namespace App\Http\Controllers;

use App\Models\Userdata;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class DemandeurController extends Controller
{
    public function index()
    {
        // Récupérer tous les utilisateurs ayant une inscription complète (relation avec userdata)
        $utilisateurs = Utilisateur::has('userdata')->paginate(50); // Pagination


        return view('admin.liste_demandeur', compact(
            'utilisateurs',
          
          
        ));
    }
}
