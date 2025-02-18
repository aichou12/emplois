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
            'regionnaiss_id' => 'required|exists:region,id',
            'regionresidence_id' => 'nullable|exists:region,id',
            'nombreanneeexpe' => 'nullable|integer',
            'posteoccupe' => 'nullable|string',
            'employeur' => 'nullable|string',
            'diplome_file' => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
            'cv_file'       => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
            'photo_profil'  => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // On force l'id de l'utilisateur connecté,
        // peu importe ce qui vient de l'input "utilisateur_id" du formulaire
        $validated['utilisateur_id'] = auth()->user()->id;

        // Diplôme
        if ($request->hasFile('diplome_file')) {
            $validated['diplome_file'] = $request->file('diplome_file')->store('documents', 'public');
        }

        // CV
        if ($request->hasFile('cv_file')) {
            $validated['cv_file'] = $request->file('cv_file')->store('documents', 'public');
        }

        // ➡️ Photo (ce bloc manquait)
        if ($request->hasFile('photo_profil')) {
            $file = $request->file('photo_profil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $destinationPath = public_path('uploads/photos');

            // Créer le dossier s'il n'existe pas
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            // Déplacer le fichier
            $file->move($destinationPath, $filename);

            // Chemin relatif à stocker en base
            $validated['photo_profil'] = 'uploads/photos/'.$filename;
        }

        // Créer la nouvelle entrée
        $userdata = Userdata::create($validated);

        return redirect()->route('userdata.edit', $userdata->id)
                         ->with('success', 'Données enregistrées avec succès');
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
                'regionresidence_id' => 'nullable|exists:region,id',
                'nombreanneeexpe' => 'nullable|integer',
                'posteoccupe' => 'nullable|string',
                'employeur' => 'nullable|string',
                'diplome_file' => 'nullable|string',
                'cv_file' => 'nullable|string',
                'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',  // Ajout de la validation pour la photo

            ]);

            $validated['utilisateur_id'] = auth()->user()->id;

            // Trouver et mettre à jour l'entrée Userdata
            $userdata = Userdata::findOrFail($id);
            if ($request->hasFile('diplome_file')) {
                $validated['diplome_file'] = $request->file('diplome_file')->store('documents', 'public');
            }
             // Traitement de l'upload de la photo
             if ($request->hasFile('photo_profil')) {
                $file = $request->file('photo_profil');  // Récupérer le fichier
                $filename = time() . '_' . $file->getClientOriginalName(); // Générer un nom unique
                $destinationPath = public_path('uploads/photos');  // Définir le dossier cible

                // Vérifier si le dossier existe, sinon le créer
                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0777, true);
                }

                // Déplacer le fichier vers le dossier public/uploads/photos
                $file->move($destinationPath, $filename);

                // Stocker uniquement le chemin relatif dans la base de données
                $validated['photo_profil'] = 'uploads/photos/' . $filename;
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

