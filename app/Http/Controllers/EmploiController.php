<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Emploi;

class EmploiController extends Controller
{
    public function getEmplois($secteur_id)
    {
        // Récupérer les emplois associés au secteur
        $emplois = Emploi::where('secteur_id', $secteur_id)->get();

        // Retourner les emplois sous forme de JSON
        return response()->json($emplois);
    }
}

