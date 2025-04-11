<?php

namespace App\Http\Controllers;
use App\Models\Userdata;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class DemandeurIncompletController extends Controller
{
    public function index()
    {
       
       
        // Récupérer le nombre d'inscrits de l'année en cours
        $currentYear = now()->year; // Récupère l'année actuelle
        $currentYearUsers = Utilisateur::whereYear('date_inscription', $currentYear)->count(); // Utilisateurs inscrits cette année
        
        // Retourner la vue avec toutes les données
        return view('admin.demandeurincomplet', compact(
           
            
            'currentYearUsers',
           // Ajouter cette ligne pour passer le nombre d'inscrits de l'année en cours à la vue
        ));
    }
       
}
