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

        // Utilisateur connecté ou premier pour l'affichage
        $utilisateur = auth()->user() ?? Utilisateur::first();

        // Statistiques générales
        $totalUsers = Userdata::count(); // Nombre total de demandeurs avec inscription
        $totalMales = Userdata::where('genre', 'Masculin')->count();
        $totalFemales = Userdata::where('genre', 'Feminin')->count();
        $sansdiplome = Userdata::where('academic_id', 20)->count();
        $avecdiplome = Userdata::where('academic_id', '!=', 20)->count();

        $recrutedUsers = Utilisateur::where('recruted', true)->has('userdata')->count();
        $notRecrutedUsers = Utilisateur::where('recruted', false)->has('userdata')->count();

        $currentYear = now()->year;
        $currentYearUsers = Utilisateur::whereYear('date_inscription', $currentYear)
            ->has('userdata')
            ->count();

        return view('admin.liste_demandeur', compact(
            'utilisateurs',
            'utilisateur',
            'recrutedUsers',
            'notRecrutedUsers',
            'totalUsers',
            'totalMales',
            'totalFemales',
            'currentYearUsers',
            'sansdiplome',
            'avecdiplome'
        ));
    }
}
