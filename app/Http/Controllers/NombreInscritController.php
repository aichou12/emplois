<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur; // Assurez-vous que le modèle Utilisateur est importé
use Carbon\Carbon;
class NombreInscritController extends Controller
{
    //
    public function index()
    {
        // Récupérer l'année courante
        $currentYear = Carbon::now()->year;

        // Récupérer les utilisateurs inscrits durant l'année courante
        $utilisateurs = Utilisateur::whereYear('date_inscription', $currentYear)->get();
        $utilisateur = Utilisateur::first(); 
        // Retourner la vue avec les utilisateurs récupérés
        return view('admin.nombre_inscrit', compact('utilisateurs','utilisateur'));
    }
}
