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
        $regions = Region::all();
        $departements = Departement::all();
        $emplois = Emploi::all();
        $handicaps = Handicap::all();
        $academins = Academic::all();
        $utilisateurs = Utilisateur::all();
        $utilisateurConnecte = auth()->user();
        $secteurs = Secteur::all();
        return view('userdata.create', compact('regions', 'departements', 'emplois', 'handicaps', 'academins', 'utilisateurs', 'utilisateurConnecte', 'secteurs'));
    }

    // Sauvegarder les données du formulaire
    public function store(Request $request)
{
    $validated = $request->validate([
        'departementnaiss_id'      => 'required|exists:departement,id',
        'departementresidence_id'  => 'nullable|exists:departement,id',
        'emploi1_id'               => 'required|exists:emploi,id',
        'emploi2_id'               => 'nullable|exists:emploi,id',
        'handicap_id'              => 'nullable|exists:handicap,id',
        'academic_id'              => 'required|exists:academic,id',
        'datenaiss'                => 'required|date',
        'lieuresidence'            => 'required|string',
        'lieunaiss'                => 'required|string',
        'genre'                    => 'required|string',
        'situationmatrimoniale'    => 'nullable|string',
        'telephone1'               => 'required|string',
        'telephone2'               => 'nullable|string',
        'nombreenfant'             => 'nullable|integer',
        'diplome'                  => 'nullable|string',
        'autresdiplomes'           => 'nullable|string',
        'experiences'              => 'nullable|string',
        'motivation'               => 'nullable|string',
        'anneediplome'             => 'nullable|integer',
        'anneeexperience1'         => 'nullable|integer',
        'anneeexperience2'         => 'nullable|integer',
        'specialite'               => 'nullable|string',
        'etablissementdiplome'     => 'nullable|string',
        'regionnaiss_id'           => 'required|exists:region,id',
        'regionresidence_id'       => 'nullable|exists:region,id',
        'nombreanneeexpe'          => 'nullable|integer',
        'posteoccupe'              => 'nullable|string',
        'employeur'                => 'nullable|string',
        'cv_summary'               => 'nullable|string|max:1000', // Nouveau champ résumé du CV
        'diplome_file'             => 'nullable|array', // Permet de télécharger plusieurs fichiers
        'diplome_file.*'           => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
        'cv_file'                  => 'nullable|array',
        'cv_file.*'                => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
        'photo_profil'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    // Forcer l'id de l'utilisateur connecté
    $validated['utilisateur_id'] = auth()->user()->id;

    // Traitement des fichiers de diplôme
    if ($request->hasFile('diplome_file')) {
        $diplome_paths = [];
        foreach ($request->file('diplome_file') as $file) {
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/diplome'), $filename);
            $diplome_paths[] = 'uploads/diplome/' . $filename;
        }
        $validated['diplome_file'] = json_encode($diplome_paths);
    }

    // Traitement de plusieurs fichiers CV
    if ($request->hasFile('cv_file')) {
        $cv_paths = [];
        foreach ($request->file('cv_file') as $file) {
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/cv'), $filename);
            $cv_paths[] = 'uploads/cv/' . $filename;
        }
        $validated['cv_file'] = json_encode($cv_paths);
    }

    // Traitement de la photo de profil
    if ($request->hasFile('photo_profil')) {
        $file = $request->file('photo_profil');
        $filename = time().'_'.$file->getClientOriginalName();
        $destinationPath = public_path('uploads/photos');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $file->move($destinationPath, $filename);
        $validated['photo_profil'] = 'uploads/photos/' . $filename;
    }

    // Créer la nouvelle entrée
    $userdata = Userdata::create($validated);

    return redirect()->route('userdata.edit', $userdata->id)
                     ->with('success', 'Données enregistrées avec succès');
}


    // Méthode pour afficher le formulaire d'édition
    public function edit($id)
    {
        $userdata = Userdata::findOrFail($id);
        $utilisateurs = Utilisateur::all();
        $departements = Departement::all();
        $emplois = Emploi::all();
        $handicap = Handicap::all();
        $academins = Academic::all();
        $regions = Region::all();
        $utilisateurConnecte = auth()->user();
        $secteurs = Secteur::all();
        return view('userdata.edit', compact('userdata', 'utilisateurs', 'departements', 'emplois', 'handicap', 'academins', 'regions', 'secteurs', 'utilisateurConnecte'));
    }

    // Méthode pour mettre à jour l'utilisateur
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'utilisateur_id'           => 'nullable|exists:utilisateur,id',
            'departementnaiss_id'      => 'nullable|exists:departement,id',
            'departementresidence_id'  => 'nullable|exists:departement,id',
            'emploi1_id'               => 'nullable|exists:emploi,id',
            'emploi2_id'               => 'nullable|exists:emploi,id',
            'handicap_id'              => 'nullable|exists:handicap,id',
            'academic_id'              => 'required|exists:academic,id',
            'datenaiss'                => 'nullable|date',
            'lieuresidence'            => 'nullable|string',
            'lieunaiss'                => 'nullable|string',
            'genre'                    => 'nullable|string',
            'situationmatrimoniale'    => 'nullable|string',
            'telephone1'               => 'nullable|string',
            'telephone2'               => 'nullable|string',
            'nombreenfant'             => 'nullable|integer',
            'diplome'                  => 'nullable|string',
            'autresdiplomes'           => 'nullable|string',
            'experiences'              => 'nullable|string',
            'motivation'               => 'nullable|string',
            'anneediplome'             => 'nullable|integer',
            'anneeexperience1'         => 'nullable|integer',
            'anneeexperience2'         => 'nullable|integer',
            'specialite'               => 'nullable|string',
            'etablissementdiplome'     => 'nullable|string',
            'regionnaiss_id'           => 'nullable|exists:region,id',
            'regionresidence_id'       => 'nullable|exists:region,id',
            'nombreanneeexpe'          => 'nullable|integer',
            'posteoccupe'              => 'nullable|string',
            'employeur'                => 'nullable|string',
            'diplome_file.*'           => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
            'cv_file.*'                => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
            'photo_profil'             => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
             'cv_summary'               => 'nullable|string|max:1000'
        ]);
        
        // Forcer l'id de l'utilisateur connecté
        $validated['utilisateur_id'] = auth()->user()->id;
        $userdata = Userdata::findOrFail($id);
    
        // 🔹 Suppression des fichiers sélectionnés (base et disque)
        if ($request->has('deleted_files')) {
            // On récupère la liste des fichiers à supprimer (séparés par un point-virgule)
            $filesToDelete = array_filter(explode(';', $request->deleted_files));
            
            // Supprime les fichiers du disque
            foreach ($filesToDelete as $file) {
                if (file_exists(public_path($file))) {
                    unlink(public_path($file));
                }
            }
            
            // Met à jour la liste des fichiers déjà stockés dans la base
            $existingFiles = $userdata->diplome_file ? json_decode($userdata->diplome_file, true) : [];
            // Filtrer pour retirer ceux qui sont dans la liste à supprimer
            $existingFiles = array_filter($existingFiles, function($f) use ($filesToDelete) {
                return !in_array($f, $filesToDelete);
            });
            $validated['diplome_file'] = json_encode(array_values($existingFiles));
        } else {
            // Si aucun fichier n'est marqué pour suppression, garder les existants
            $validated['diplome_file'] = $userdata->diplome_file;
        }
        
        // 🔹 Gestion des nouveaux fichiers Diplôme
        $diplome_paths = $userdata->diplome_file ? json_decode($userdata->diplome_file, true) : [];
        if ($request->hasFile('diplome_file')) {
            foreach ($request->file('diplome_file') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/diplome'), $filename);
                $diplome_paths[] = 'uploads/diplome/' . $filename;
            }
        }
        $validated['diplome_file'] = json_encode($diplome_paths);
        
        // 🔹 Gestion des fichiers CV (similaire)
        $cv_paths = $userdata->cv_file ? json_decode($userdata->cv_file, true) : [];
        if ($request->hasFile('cv_file')) {
            foreach ($request->file('cv_file') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/cv'), $filename);
                $cv_paths[] = 'uploads/cv/' . $filename;
            }
        }
        $validated['cv_file'] = json_encode($cv_paths);
        
        // 🔹 Gestion de la photo de profil
        if ($request->hasFile('photo_profil')) {
            $file = $request->file('photo_profil');
            $filename = time().'_'.$file->getClientOriginalName();
            $destinationPath = public_path('uploads/photos');
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }
            $file->move($destinationPath, $filename);
            $validated['photo_profil'] = 'uploads/photos/' . $filename;
        }
        
        // 🔹 Mise à jour des données
        $userdata->update($validated);
        
        session()->flash('success', 'Données mises à jour avec succès');
        return redirect()->route('userdata.edit', $userdata->id);
    }
    
    

    // Méthode pour récupérer les emplois en fonction du secteur
    public function getEmplois($id)
    {
        $emplois = Emploi::where('secteur_id', $id)->get();
        return response()->json($emplois);
    }

    // Méthode pour récupérer les départements en fonction de la région
    public function getDepartements($region_id)
    {
        $departements = Departement::where('region_id', $region_id)->get();
        return response()->json($departements);
    }
    public function deleteFile(Request $request)
{
    $request->validate([
        'file' => 'required|string',
        'userdata_id' => 'required|exists:userdata,id',
    ]);

    $userdata = Userdata::findOrFail($request->userdata_id);
    $fileToDelete = $request->file;

    // Récupération des fichiers actuels
    $existingFiles = $userdata->diplome_file ? json_decode($userdata->diplome_file, true) : [];

    // Vérifier si le fichier existe dans la liste
    if (($key = array_search($fileToDelete, $existingFiles)) !== false) {
        // Supprimer le fichier de la liste
        unset($existingFiles[$key]);

        // Supprimer physiquement le fichier du serveur
        if (file_exists(public_path($fileToDelete))) {
            unlink(public_path($fileToDelete));
        }

        // Mettre à jour la base de données
        $userdata->update(['diplome_file' => json_encode(array_values($existingFiles))]);

        return response()->json(['success' => true, 'message' => 'Fichier supprimé avec succès.']);
    }

    return response()->json(['success' => false, 'message' => 'Fichier non trouvé.'], 404);
}
public function deleteCvFile(Request $request)
{
    $request->validate([
        'file' => 'required|string',
        'userdata_id' => 'required|exists:userdata,id',
    ]);

    $userdata = Userdata::findOrFail($request->userdata_id);
    $fileToDelete = $request->file;

    // Récupération des fichiers actuels
    $existingFiles = $userdata->cv_file ? json_decode($userdata->cv_file, true) : [];

    // Vérifier si le fichier existe dans la liste
    if (($key = array_search($fileToDelete, $existingFiles)) !== false) {
        // Supprimer le fichier de la liste
        unset($existingFiles[$key]);

        // Supprimer physiquement le fichier du serveur
        if (file_exists(public_path($fileToDelete))) {
            unlink(public_path($fileToDelete));
        }

        // Mettre à jour la base de données
        $userdata->update(['cv_file' => json_encode(array_values($existingFiles))]);

        return response()->json(['success' => true, 'message' => 'Fichier CV supprimé avec succès.']);
    }

    return response()->json(['success' => false, 'message' => 'Fichier CV non trouvé.'], 404);
}

}
