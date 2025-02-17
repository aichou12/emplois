<?php
namespace App\Http\Controllers;

use App\Models\Userdata;
use App\Models\Utilisateur;
use App\Models\Region;
use App\Models\Departement;
use App\Models\Emploi;
use App\Models\Handicap;
use App\Models\Academic;
use App\Models\Secteur;
use Illuminate\Http\Request;

class UserdataController extends Controller
{
    // Afficher le formulaire
    public function create()
    {
        // Récupérer les données nécessaires pour remplir les listes déroulantes
        $regions = Region::all();
        $departements = Departement::all();
        $emplois = Emploi::all();
        $handicaps = Handicap::all();
        $academins = Academic::all();
        $utilisateurs = Utilisateur::all();
        $utilisateurConnecte = auth()->user();
        $secteurs = Secteur::all();
        return view('userdata.create', compact('regions', 'departements', 'emplois', 'handicaps', 'academins', 'utilisateurs','utilisateurConnecte','secteurs'));
    }

    // Sauvegarder les données du formulaire
    public function store(Request $request)
    {
        $validated = $request->validate([
            'departementnaiss_id' => 'required|exists:departement,id',
            'departementresidence_id' => 'required|exists:departement,id',
            'emploi1_id' => 'required|exists:emploi,id',
            'emploi2_id' => 'nullable|exists:emploi,id',
            'handicap_id' => 'nullable|exists:handicap,id',
            'academic_id' => 'required|exists:academic,id',
            'datenaiss' => 'required|date',
            'lieuresidence' => 'required|string',
            'lieunaiss' => 'required|string',
            'genre' => 'required|string',
            'situationmatrimoniale' => 'nullable|string',
            'telephone1' => 'required|string',
            'telephone2' => 'nullable|string',
            'nombreenfant' => 'nullable|integer',
            'diplome' => 'nullable|string',
            'autresdiplomes' => 'nullable|string',
            'experiences' => 'nullable|string',
            'motivation' => 'nullable|string',
            'anneediplome' => 'nullable|integer',
            'anneeexperience1' => 'nullable|integer',
            'anneeexperience2' => 'nullable|integer',
            'specialite' => 'nullable|string',
            'etablissementdiplome' => 'nullable|string',
            'regionnaiss_id' => 'required|exists:region,id',
            'regionresidence_id' => 'required|exists:region,id',
            'nombreanneeexpe' => 'nullable|integer',
            'posteoccupe' => 'nullable|string',
            'employeur' => 'nullable|string',
            'diplome_file' => 'nullable|string',
            'cv_file' => 'nullable|string',
    

        ]);
        
        // Ajouter l'ID de l'utilisateur connecté directement à la requête validée
        $validated['utilisateur_id'] = auth()->user()->id;
        if ($request->hasFile('diplome_file')) {
            $validated['diplome_file'] = $request->file('diplome_file')->store('documents', 'public');
        }
        
        if ($request->hasFile('cv_file')) {
            $validated['cv_file'] = $request->file('cv_file')->store('documents', 'public');
        }
        // Créer une nouvelle entrée Userdata avec les données validées
        $userdata = Userdata::create($validated);
    
        // Rediriger vers la page d'édition avec un message de succès
        return redirect()->route('userdata.edit', $userdata->id)->with('success', 'Données enregistrées avec succès');
    }
    

        // Méthode pour afficher le formulaire d'édition
        public function edit($id)
        {
            $userdata = Userdata::findOrFail($id); // Trouver l'utilisateur avec l'ID
            $utilisateurs = Utilisateur::all(); // Récupérer les utilisateurs
            $departements = Departement::all(); // Récupérer les départements
            $emplois = Emploi::all(); // Récupérer les emplois
            $handicap = Handicap::all(); // Récupérer les handicaps
            $academins = Academic::all(); // Récupérer les diplômes
            $regions = Region::all(); // Récupérer les régions
            $utilisateurConnecte = auth()->user();
            $secteurs = Secteur::all();
            return view('userdata.edit', compact('userdata', 'utilisateurs', 'departements', 'emplois', 'handicap', 'academins', 'regions','secteurs','utilisateurConnecte'));
        }

        // Méthode pour mettre à jour l'utilisateur
        public function update(Request $request, $id)
        {
            $validated = $request->validate([
                'utilisateur_id' => 'required|exists:utilisateur,id',
                'departementnaiss_id' => 'required|exists:departement,id',
                'departementresidence_id' => 'nullable|exists:departement,id',
                'emploi1_id' => 'required|exists:emploi,id',
                'emploi2_id' => 'nullable|exists:emploi,id',
                'handicap_id' => 'nullable|exists:handicap,id',
                'academic_id' => 'required|exists:academic,id',
                'datenaiss' => 'required|date',
                'lieuresidence' => 'required|string',
                'lieunaiss' => 'required|string',
                'genre' => 'required|string',
                'situationmatrimoniale' => 'nullable|string',
                'telephone1' => 'required|string',
                'telephone2' => 'nullable|string',
                'nombreenfant' => 'nullable|integer',
                'diplome' => 'nullable|string',
                'autresdiplomes' => 'nullable|string',
                'experiences' => 'nullable|string',
                'motivation' => 'nullable|string',
                'anneediplome' => 'nullable|integer',
                'anneeexperience1' => 'nullable|integer',
                'anneeexperience2' => 'nullable|integer',
                'specialite' => 'nullable|string',
                'etablissementdiplome' => 'nullable|string',
                'regionnaiss_id' => 'nullable|exists:region,id',
                'regionresidence_id' => 'required|exists:region,id',
                'nombreanneeexpe' => 'nullable|integer',
                'posteoccupe' => 'nullable|string',
                'employeur' => 'nullable|string',
                'diplome_file' => 'nullable|string',
         'cv_file' => 'nullable|string',

            ]);
        
            $validated['utilisateur_id'] = auth()->user()->id;
        
            // Trouver et mettre à jour l'entrée Userdata
            $userdata = Userdata::findOrFail($id);
            if ($request->hasFile('diplome_file')) {
                $validated['diplome_file'] = $request->file('diplome_file')->store('documents', 'public');
            }
            
            if ($request->hasFile('cv_file')) {
                $validated['cv_file'] = $request->file('cv_file')->store('documents', 'public');
            }
            $userdata->update($validated);
        
            // Ajouter un message de succès dans la session
            session()->flash('success', 'Données mises à jour avec succès');
        
            // Rediriger vers la page d'édition avec le message de succès
            return redirect()->route('userdata.edit', $userdata->id);
        }
        
        public function getEmplois($id)
        {
            $emplois = Emploi::where('secteur_id', $id)->get();
            return response()->json($emplois);
        }
        public function getDepartements($region_id)
{
    $departements = Departement::where('region_id', $region_id)->get();
    return response()->json($departements);
}

        
    }

