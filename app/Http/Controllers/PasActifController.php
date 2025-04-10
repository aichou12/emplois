<?php

namespace App\Http\Controllers;
use App\Models\Userdata;
use App\Models\Utilisateur;
use Illuminate\Http\Request;

class PasActifController extends Controller
{
    public function index()
    {
        // Récupérer tous les utilisateurs
       // $utilisateurs = Utilisateur::all();
        
        // Récupérer le premier utilisateur (optionnel)
        $utilisateur = Utilisateur::first(); 
      //  $utilisateurs = Utilisateur::Has('userdata')->get();
        $utilisateurs = Utilisateur::where('enabled', false)->get();
     
        // Récupérer les utilisateurs recrutés et non recrutés
        $recrutedUsers = Utilisateur::where('recruted', true)->count();
        $notRecrutedUsers = Utilisateur::where('recruted', false)->count();
        
        // Récupérer les listes des utilisateurs recrutés et non recrutés
        $recrutedList = Utilisateur::where('recruted', true)->get();
        $notRecrutedList = Utilisateur::where('recruted', false)->get();
        
        // Récupérer le nombre total d'utilisateurs
        $totalUsers = Utilisateur::count();  // Nombre total d'utilisateurs
        
        $totalMales = Userdata::where('genre', 'Masculin')->count();
        $totalFemales = Userdata::where('genre', 'Feminin')->count();
        $sansdiplome=Userdata::where('academic_id','20')->count();
        $avecdiplome = Userdata::where('academic_id', '!=', 20)->count();

        // Récupérer le nombre d'inscrits de l'année en cours
        $currentYear = now()->year; // Récupère l'année actuelle
        $currentYearUsers = Utilisateur::whereYear('date_inscription', $currentYear)->count(); // Utilisateurs inscrits cette année
        
        // Retourner la vue avec toutes les données
        return view('admin.pasactif', compact(
            'utilisateurs', 
            'utilisateur', 
            'recrutedUsers', 
            'notRecrutedUsers', 
            'recrutedList', 
            'notRecrutedList', 
            'totalUsers',
            'totalMales', 
            'totalFemales',
            'currentYearUsers',
            'sansdiplome',
            'avecdiplome' // Ajouter cette ligne pour passer le nombre d'inscrits de l'année en cours à la vue
        ));
    }
       
}
