<?php
namespace App\Http\Controllers;

use App\Models\Userdata;
use App\Models\Utilisateur;
use App\Models\Region;
use App\Models\Departement;
use App\Models\Emploi;
use App\Models\Handicap;
use App\Models\Academic;

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

        return view('userdata.create', compact('regions', 'departements', 'emplois', 'handicaps', 'academins', 'utilisateurs'));
    }

    // Sauvegarder les données du formulaire
    public function store(Request $request)
    {
        $validated = $request->validate([
            'utilisateur_id' => 'required|exists:utilisateur,id',
            'departementnaiss_id' => 'required|exists:departement,id',
            'departementresidence_id' => 'required|exists:departement,id',
            'emploi1_id' => 'required|exists:emploi,id',
            'emploi2_id' => 'nullable|exists:emploi,id',
            'handicap_id' => 'nullable|exists:handicap,id',
            'academic_id' => 'required|exists:academin,id',
            'datenaiss' => 'required|date',
            'lieuresidence' => 'required|string',
            'lieunaiss' => 'required|string',
            'genre' => 'required|string',
            'situationmatrimoniale' => 'nullable|string',
            'telephone1' => 'required|string',
            'telephone2' => 'nullable|string',
            'nombreenfants' => 'nullable|integer',
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
            'diplome' => 'nullable|string',
           'nombreanneeexpe' => 'nullable|integer',
                'posteoccupe' => 'nullable|string',
                'employeur' => 'nullable|string',
        ]);

        // Créer une nouvelle entrée Userdata
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
            $handicaps = Handicap::all(); // Récupérer les handicaps
            $academins = Academic::all(); // Récupérer les diplômes
            $regions = Region::all(); // Récupérer les régions

            return view('userdata.edit', compact('userdata', 'utilisateurs', 'departements', 'emplois', 'handicaps', 'academins', 'regions'));
        }

        // Méthode pour mettre à jour l'utilisateur
        public function update(Request $request, $id)
        {
            $validated = $request->validate([
                'utilisateur_id' => 'required|exists:utilisateur,id',
                'departementnaiss_id' => 'required|exists:departement,id',
                'departementresidence_id' => 'required|exists:departement,id',
                'emploi1_id' => 'required|exists:emploi,id',
                'emploi2_id' => 'nullable|exists:emploi,id',
                'handicap_id' => 'nullable|exists:handicap,id',
                'academic_id' => 'required|exists:academin,id',
                'datenaiss' => 'required|date',
                'lieuresidence' => 'required|string',
                'lieunaiss' => 'required|string',
                'genre' => 'required|string',
                'situationmatrimoniale' => 'nullable|string',
                'telephone1' => 'required|string',
                'telephone2' => 'nullable|string',
                'nombreenfants' => 'nullable|integer',
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

            ]);

            // Find the userdata entry and update it
            $userdata = Userdata::findOrFail($id);
            $userdata->update($validated);

            // Redirect to a success page or back to the edit page
            return redirect()->route('userdata.edit', $userdata->id)->with('success', 'Données mises à jour avec succès');
        }

    }

