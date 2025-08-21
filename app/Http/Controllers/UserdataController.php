<?php
namespace App\Http\Controllers;

use App\Models\Userdata;
use App\Models\Utilisateur;
use App\Models\Region;
use App\Models\Departement;
use App\Models\Emploi;
use App\Models\Handicap;
use App\Models\Utlisateur;
use App\Models\Academic;
use App\Models\Secteur;
use Illuminate\Http\Request;
use App\Models\Country;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
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
        $countries = Country::all(); // Ajouter cette ligne pour récupérer les pays

        return view('userdata.create', compact('regions', 'departements', 'emplois', 'handicaps', 'academins', 'utilisateurs', 'utilisateurConnecte', 'secteurs', 'countries')); // Ajouter 'countries' dans le compact
    }


    // Sauvegarder les données du formulaire
    public function store(Request $request)
    {
        // 1) Validation
        $validated = $request->validate([
            // Step 1
            'datenaiss'                  => 'required|date',
            'lieuresidence'              => 'required|string',
            'lieunaiss'                  => 'required|string',
            'genre'                      => 'required|string',
            'telephone1'                 => 'required|string',
            'telephone2'                 => 'nullable|string',
            'situationmatrimoniale'      => 'nullable|string',
            'regionnaiss_id'             => 'nullable|exists:region,id',
            'regionresidence_id'         => 'nullable|exists:region,id',
            'departementnaiss_id'        => 'nullable|exists:departement,id',
            'departementresidence_id'    => 'nullable|exists:departement,id',
            'handicap_id'                => 'nullable|exists:handicap,id',
            'nombreenfant'               => 'nullable|integer',
            'country_id'                 => 'nullable|exists:countries,id',
            'addresse'                   => 'nullable|string',

            // Step 2 (formations multiples)
            'formations'                        => 'nullable|array',
            'formations.*.academic_id'          => 'required',
            'formations.*.diplome'              => 'nullable|string',
            'formations.*.anneediplome'         => 'nullable|integer',
            'formations.*.specialite'           => 'nullable|string',
            'formations.*.etablissementdiplome' => 'nullable|string',

            // Fichiers formations / CV
            'diplome_file'   => 'nullable|array',
            'diplome_file.*' => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
            'cv_file'        => 'nullable|array',
            'cv_file.*'      => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
            'photo_profil'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',

            // Step 3 (expériences multiples)
            'hasExperience'                   => 'nullable|in:oui,non',
            'experiences'                     => 'nullable|array',
            'experiences.*.description'       => 'nullable|string',
            'experiences.*.years'             => 'nullable|integer',
            'experiences.*.poste'             => 'nullable|string',
            'experiences.*.employeur'         => 'nullable|string',

            // Step 4
            'emploi1_id'        => 'required|exists:emploi,id',
            'emploi2_id'        => 'required|exists:emploi,id',
            'anneeexperience1'  => 'nullable|integer',
            'anneeexperience2'  => 'nullable|integer',
            'cv_summary'        => 'nullable|string|max:1000',
        ]);

        // 2) Utilisateur connecté
        $validated['utilisateur_id'] = auth()->id();

        // Si l'utilisateur a coché "Non" pour handicap (radio 'handicap' côté vue)
        if ($request->input('handicap') == '0') {
            $validated['handicap_id'] = null;
        }

        /* =====================================================
           FORMATIONS : sérialiser dans "autresdiplomes" (JSON)
           + mapper la 1ère formation vers colonnes simples
           ===================================================== */
        $formationsInput = $request->input('formations', []);
        $formations = collect($formationsInput)
            ->filter(function ($f) {
                return is_array($f) && isset($f['academic_id']) && $f['academic_id'] !== null && $f['academic_id'] !== '';
            })
            ->map(function ($f) {
                // Convention "Sans diplôme" => 20 (en string) ; sinon l'ID en string
                $aid = (string) ($f['academic_id'] ?? '');
                if ($aid === 'sansdiplome') {
                    $aid = '20';
                }
                return [
                    'academic_id'          => $aid,                                     // string
                    'diplome'              => (string) ($f['diplome']              ?? ''), // string
                    'anneediplome'         => (string) ($f['anneediplome']         ?? ''), // string
                    'specialite'           => (string) ($f['specialite']           ?? ''), // string
                    'etablissementdiplome' => (string) ($f['etablissementdiplome'] ?? ''), // string
                ];
            })
            ->values();

        // Stockage JSON EXACTEMENT comme souhaité
        $validated['autresdiplomes'] = $formations->isNotEmpty() ? $formations->toJson() : null;

        // Mappage de la 1ʳᵉ formation vers les colonnes simples
        if ($formations->isNotEmpty()) {
            $first = $formations->first(); // déjà normalisé en string
            $validated['academic_id']         = (int) $first['academic_id']; // 20 si "sans diplôme"
            $validated['diplome']             = $first['diplome'] !== '' ? $first['diplome'] : null;
            $validated['anneediplome']        = $first['anneediplome'] !== '' ? (int) $first['anneediplome'] : null;
            $validated['specialite']          = $first['specialite'] !== '' ? $first['specialite'] : null;
            $validated['etablissementdiplome']= $first['etablissementdiplome'] !== '' ? $first['etablissementdiplome'] : null;
        } else {
            $validated['academic_id']          = null;
            $validated['diplome']              = null;
            $validated['anneediplome']         = null;
            $validated['specialite']           = null;
            $validated['etablissementdiplome'] = null;
        }

        /* =====================================================
           EXPÉRIENCES : sérialiser dans "experiences" (JSON)
           + mappage partiel (1ère + somme des années)
           ===================================================== */
        $experiences = collect($request->input('experiences', []))
            ->filter(fn($e) =>
                is_array($e) && (
                    filled($e['description'] ?? null) ||
                    filled($e['poste'] ?? null) ||
                    filled($e['employeur'] ?? null)
                )
            )
            ->values();

        if ($request->input('hasExperience') === 'oui' && $experiences->isNotEmpty()) {
            $validated['experiences']     = $experiences->toJson();
            $firstExp                     = $experiences->first();
            $validated['posteoccupe']     = $firstExp['poste'] ?? null;
            $validated['employeur']       = $firstExp['employeur'] ?? null;
            $validated['nombreanneeexpe'] = $experiences->sum(fn($e) => (int)($e['years'] ?? 0));
        } else {
            $validated['experiences']     = null;
            $validated['posteoccupe']     = null;
            $validated['employeur']       = null;
            $validated['nombreanneeexpe'] = null;
        }

        /* =====================================================
           FICHIERS : diplômes / CV / photo
           ===================================================== */
        // Diplômes (tous les fichiers des blocs -> un seul tableau JSON)
        if ($request->hasFile('diplome_file')) {
            $diplome_paths = [];
            foreach ($request->file('diplome_file') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/diplome'), $filename);
                $diplome_paths[] = 'uploads/diplome/' . $filename;
            }
            $validated['diplome_file'] = json_encode($diplome_paths);
        }

        // CV (plusieurs possibles)
        if ($request->hasFile('cv_file')) {
            $cv_paths = [];
            foreach ($request->file('cv_file') as $file) {
                $filename = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/cv'), $filename);
                $cv_paths[] = 'uploads/cv/' . $filename;
            }
            $validated['cv_file'] = json_encode($cv_paths);
        }

        // Photo de profil
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

        // 3) Création
        $userdata = Userdata::create($validated);

        return redirect()
            ->route('userdata.summary', $userdata->id)
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
 // Méthode pour mettre à jour l'utilisateur
public function update(Request $request, $id)
{
    $userdata = Userdata::findOrFail($id);

    // 1) Validation (inclut les tableaux formations/expériences)
    $validated = $request->validate([
        // Step 1
        'departementnaiss_id'       => 'nullable|exists:departement,id',
        'departementresidence_id'   => 'nullable|exists:departement,id',
        'datenaiss'                 => 'nullable|date',
        'lieuresidence'             => 'nullable|string',
        'lieunaiss'                 => 'nullable|string',
        'genre'                     => 'nullable|string',
        'situationmatrimoniale'     => 'nullable|string',
        'telephone1'                => 'nullable|string',
        'telephone2'                => 'nullable|string',
        'regionnaiss_id'            => 'nullable|exists:region,id',
        'regionresidence_id'        => 'nullable|exists:region,id',
        'handicap_id'               => 'nullable|exists:handicap,id',
        'nombreenfant'              => 'nullable|integer',
        'cv_summary'                => 'nullable|string|max:1000',

        // Step 2 (formations multiples)
        'formations'                        => 'nullable|array',
        'formations.*.academic_id'          => 'required',
        'formations.*.diplome'              => 'nullable|string',
        'formations.*.anneediplome'         => 'nullable|integer',
        'formations.*.specialite'           => 'nullable|string',
        'formations.*.etablissementdiplome' => 'nullable|string',

        // Fichiers
        'diplome_file'   => 'nullable|array',
        'diplome_file.*' => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
        'cv_file'        => 'nullable|array',
        'cv_file.*'      => 'nullable|file|mimes:pdf,doc,docx,rtf,txt|max:2048',
        'photo_profil'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'deleted_files'      => 'nullable|string', // diplômes à supprimer (séparés par ;)
        'deleted_cv_files'   => 'nullable|string', // cv à supprimer (séparés par ;)

        // Step 3 (expériences multiples)
        'hasExperience'                   => 'nullable|in:oui,non',
        'experiences'                     => 'nullable|array',
        'experiences.*.description'       => 'nullable|string',
        'experiences.*.years'             => 'nullable|integer',
        'experiences.*.poste'             => 'nullable|string',
        'experiences.*.employeur'         => 'nullable|string',

        // Step 4
        'emploi1_id'       => 'nullable|exists:emploi,id',
        'emploi2_id'       => 'nullable|exists:emploi,id',
        'anneeexperience1' => 'nullable|integer',
        'anneeexperience2' => 'nullable|integer',
    ]);

    // Forcer l'id de l'utilisateur connecté
    $validated['utilisateur_id'] = auth()->id();

    // Si l'utilisateur a coché "Non" handicap dans le formulaire
    if ($request->input('handicap') == '0') {
        $validated['handicap_id'] = null;
    }

    /* =========================
       FORMATIONS (multi -> JSON)
       + mapping de la 1ère vers colonnes simples
       ========================= */
    $formations = collect($request->input('formations', []))
        ->filter(fn($f) => is_array($f) && isset($f['academic_id']) && $f['academic_id'] !== null)
        ->values();

    if ($formations->isNotEmpty()) {
        $first = $formations->first();
        $academicId = $first['academic_id'];

        if ($academicId === 'sansdiplome') {
            // Convention: "sans diplôme" = 20
            $validated['academic_id'] = 20;
            $validated['diplome'] = null;
            $validated['anneediplome'] = null;
            $validated['specialite'] = null;
            $validated['etablissementdiplome'] = null;
        } else {
            $validated['academic_id']        = (int) $academicId;
            $validated['diplome']            = $first['diplome'] ?? null;
            $validated['anneediplome']       = $first['anneediplome'] ?? null;
            $validated['specialite']         = $first['specialite'] ?? null;
            $validated['etablissementdiplome']= $first['etablissementdiplome'] ?? null;
        }

        // Stocker TOUTES les formations en JSON
        $validated['autresdiplomes'] = $formations->toJson();
    } else {
        $validated['autresdiplomes'] = null;
    }

    /* =========================
       EXPERIENCES (multi -> JSON)
       + mapping partiel (1ère + somme années)
       ========================= */
    $exps = collect($request->input('experiences', []))
        ->filter(fn($e) => is_array($e) && (filled($e['description'] ?? null) || filled($e['poste'] ?? null) || filled($e['employeur'] ?? null)))
        ->values();

    if ($request->input('hasExperience') === 'oui' && $exps->isNotEmpty()) {
        $validated['experiences']     = $exps->toJson();
        $firstExp                     = $exps->first();
        $validated['posteoccupe']     = $firstExp['poste'] ?? null;
        $validated['employeur']       = $firstExp['employeur'] ?? null;
        $validated['nombreanneeexpe'] = $exps->sum(fn($e) => (int)($e['years'] ?? 0));
    } else {
        $validated['experiences']     = null;
        $validated['posteoccupe']     = null;
        $validated['employeur']       = null;
        $validated['nombreanneeexpe'] = null;
    }

    /* =========================
       FICHIERS Diplôme
       ========================= */
    $existingDiplomeFiles = $userdata->diplome_file ? json_decode($userdata->diplome_file, true) : [];

    // Supprimer les fichiers cochés côté front
    if ($request->filled('deleted_files')) {
        $toDelete = array_filter(explode(';', $request->deleted_files));
        foreach ($toDelete as $file) {
            if (file_exists(public_path($file))) {
                @unlink(public_path($file));
            }
        }
        $existingDiplomeFiles = array_values(array_diff($existingDiplomeFiles, $toDelete));
    }

    // Ajouter les nouveaux fichiers
    if ($request->hasFile('diplome_file')) {
        foreach ($request->file('diplome_file') as $file) {
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/diplome'), $filename);
            $existingDiplomeFiles[] = 'uploads/diplome/' . $filename;
        }
    }
    $validated['diplome_file'] = $existingDiplomeFiles ? json_encode($existingDiplomeFiles) : null;

    /* =========================
       FICHIERS CV
       ========================= */
    $existingCvFiles = $userdata->cv_file ? json_decode($userdata->cv_file, true) : [];

    // (Optionnel) suppression via un champ hidden 'deleted_cv_files'
    if ($request->filled('deleted_cv_files')) {
        $toDeleteCv = array_filter(explode(';', $request->deleted_cv_files));
        foreach ($toDeleteCv as $file) {
            if (file_exists(public_path($file))) {
                @unlink(public_path($file));
            }
        }
        $existingCvFiles = array_values(array_diff($existingCvFiles, $toDeleteCv));
    }

    // Ajout de nouveaux CV
    if ($request->hasFile('cv_file')) {
        foreach ($request->file('cv_file') as $file) {
            $filename = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/cv'), $filename);
            $existingCvFiles[] = 'uploads/cv/' . $filename;
        }
    }
    $validated['cv_file'] = $existingCvFiles ? json_encode($existingCvFiles) : null;

    /* =========================
       PHOTO DE PROFIL
       ========================= */
    if ($request->hasFile('photo_profil')) {
        if ($userdata->photo_profil && file_exists(public_path($userdata->photo_profil))) {
            @unlink(public_path($userdata->photo_profil));
        }
        $file = $request->file('photo_profil');
        $filename = time().'_'.$file->getClientOriginalName();
        $destinationPath = public_path('uploads/photos');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $file->move($destinationPath, $filename);
        $validated['photo_profil'] = 'uploads/photos/' . $filename;
    }

    // 3) Mise à jour
    $userdata->update($validated);

    return redirect()->route('userdata.summary', $userdata->id)
                     ->with('success', 'Données mises à jour avec succès');
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

    Log::info("Suppression du fichier: ".$fileToDelete); // Ajouter une ligne de log pour déboguer

    // Récupération des fichiers actuels
    $existingFiles = $userdata->cv_file ? json_decode($userdata->cv_file, true) : [];

    // Vérifier si le fichier existe dans la liste
    if (($key = array_search($fileToDelete, $existingFiles)) !== false) {
        // Supprimer le fichier de la liste
        unset($existingFiles[$key]);

        // Supprimer physiquement le fichier du serveur
        if (file_exists(public_path($fileToDelete))) {
            unlink(public_path($fileToDelete));
            Log::info("Fichier supprimé: ".$fileToDelete); // Log pour vérifier que le fichier est bien supprimé
        }

        // Mettre à jour la base de données
        $userdata->update(['cv_file' => json_encode(array_values($existingFiles))]);

        return response()->json(['success' => true, 'message' => 'Fichier CV supprimé avec succès.']);
    }

    return response()->json(['success' => false, 'message' => 'Fichier CV non trouvé.'], 404);
}
public function updatePhotoProfil(Request $request, $id)
{
    // Validation du fichier
    $request->validate([
        'photo_profil' => 'required|image|max:2048', // Limite à 2 Mo
    ]);

    $userData = Userdata::findOrFail($id); // Trouver l'utilisateur ou le userdata par ID

    if ($request->hasFile('photo_profil')) {
        // Enregistrement du fichier dans le dossier 'public/uploads'
        $file = $request->file('photo_profil');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('uploads', $filename, 'public');

        // Mettre à jour le champ de la photo de profil dans la base de données
        $userData->photo_profil = 'storage/' . $path;
        $userData->save();

        // Retourner la nouvelle URL de la photo dans la réponse
        return response()->json([
            'success' => true,
            'photo_profil' => asset('storage/' . $path)
        ]);
    }

    return response()->json(['success' => false], 400);
}



public function summary($id)
{
    $academic = Academic::all();
    $userdata = Userdata::findOrFail($id);

    // Formatage de la date avant d'envoyer à la vue
    $userdata->datenaiss = Carbon::parse($userdata->datenaiss)->format('d/m/Y');

    return view('userdata.summary', compact('userdata', 'academic'));
}


public function resume($id)
{
    // Récupérer l'utilisateur avec les données associées (userdata)
    $utilisateur = Utilisateur::with('userdata')->findOrFail($id);

    // Retourner la vue avec l'utilisateur et ses données associées
    return view('userdata.resume', compact('utilisateur'));
}

}
