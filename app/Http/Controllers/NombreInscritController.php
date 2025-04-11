<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur; // Assurez-vous que le modèle Utilisateur est importé
use Carbon\Carbon;
use App\Models\Userdata;
class NombreInscritController extends Controller
{
    //
    public function indexe()
    {
        // Récupérer l'année courante
        $currentYear = Carbon::now()->year;

        // Récupérer les utilisateurs inscrits durant l'année courante
        $utilisateurs = Utilisateur::whereYear('date_inscription', $currentYear)->get();
        $utilisateur = Utilisateur::first(); 
        // Retourner la vue avec les utilisateurs récupérés
        return view('admin.nombre_inscrit', compact('utilisateurs','utilisateur'));
    }
    public function index()
    {
        $currentYear = Carbon::now()->year;
        // Récupérer tous les utilisateurs ayant une inscription complète (relation avec userdata)
        $utilisateurs = Utilisateur::has('userdata')->paginate(50); // Pagination
        $utilisateurs_annee = Utilisateur::whereYear('date_inscription', $currentYear)->get();
      
        
     $currentYear = now()->year;
        $currentYearUsers = Utilisateur::whereYear('date_inscription', $currentYear)
            ->has('userdata')
            ->count();

        return view('admin.nombre_inscrit', compact(
            'utilisateurs',
            'utilisateurs_annee'
        ));
    }
}
