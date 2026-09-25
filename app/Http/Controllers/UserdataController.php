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
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\UserdataDraft;
use Illuminate\Validation\Rule;
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

        $draft = UserdataDraft::where('utilisateur_id', auth()->id())->first();

        return view('userdata.create', compact('regions', 'departements', 'emplois', 'handicaps', 'academins', 'utilisateurs', 'utilisateurConnecte', 'secteurs', 'countries', 'draft'));
    }

    /** Sauvegarde uniquement l'étape courante dans le brouillon privé du compte. */
    public function saveDraftStep(Request $request)
    {
        $step = (int) $request->input('step');
        if ($step < 1 || $step > 4) {
            return response()->json(['message' => 'Étape invalide.'], 422);
        }

        $rules = [
            1 => ['datenaiss' => 'required|date', 'lieunaiss' => 'required|string|max:255', 'genre' => 'required|in:Masculin,Feminin', 'telephone1' => ['required', 'regex:/^[0-9]{7,15}$/'], 'regionnaiss_id' => 'required|exists:region,id', 'departementnaiss_id' => 'required|exists:departement,id', 'situationmatrimoniale' => 'required|string', 'nombreenfant' => 'required|integer|min:0|max:30', 'is_abroad' => 'required|in:0,1', 'lieuresidence' => 'required|string', 'regionresidence_id' => 'required_if:is_abroad,0|nullable|exists:region,id', 'departementresidence_id' => 'required_if:is_abroad,0|nullable|exists:departement,id', 'country_id' => 'required_if:is_abroad,1|nullable|exists:countries,id', 'addresse' => 'required_if:is_abroad,1|nullable|string|max:500', 'handicap' => 'required|in:0,1', 'handicap_id' => 'required_if:handicap,1|nullable|exists:handicap,id', 'telephone2' => 'nullable|regex:/^[0-9]{7,15}$/', 'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192'],
            2 => ['formations' => 'required|array|min:1', 'formations.*.academic_id' => 'required', 'formations.*.anneediplome' => 'nullable|integer|min:1900|max:' . now()->year, 'formations.*.diplome_file' => 'nullable|file|mimes:pdf,doc,docx,rtf,txt,jpg,jpeg,png|max:4096'],
            3 => ['hasExperience' => 'required|in:oui,non', 'experiences' => 'nullable|array', 'experiences.*.years' => 'nullable|integer|min:0|max:70'],
            4 => ['secteur1_id' => 'required|exists:secteur,id', 'emploi1_id' => 'required|exists:emploi,id', 'secteur2_id' => 'required|exists:secteur,id', 'emploi2_id' => 'required|exists:emploi,id', 'cv_summary' => 'nullable|string|max:1000', 'anneeexperience1' => 'nullable|integer|min:0|max:50', 'anneeexperience2' => 'nullable|integer|min:0|max:50'],
        ];
        $request->validate($rules[$step], $this->localizedValidationMessages(), $this->localizedValidationAttributes());

        $keys = [
            1 => ['datenaiss','lieunaiss','genre','telephone1','telephone2','regionnaiss_id','departementnaiss_id','situationmatrimoniale','nombreenfant','is_abroad','lieuresidence','regionresidence_id','departementresidence_id','country_id','addresse','handicap','handicap_id'],
            2 => ['formations'],
            3 => ['hasExperience','experiences'],
            4 => ['secteur1_id','emploi1_id','secteur2_id','emploi2_id','cv_summary','anneeexperience1','anneeexperience2'],
        ];
        $existing = UserdataDraft::firstOrNew(['utilisateur_id' => auth()->id()]);
        $payload = $existing->payload ?? [];
        $formationIndexMap = [];
        foreach ($keys[$step] as $key) {
            if ($request->exists($key)) {
                $value = $request->input($key);
                if ($key === 'formations' && is_array($value)) {
                    foreach (array_keys($value) as $newIndex => $oldIndex) $formationIndexMap[(string) $oldIndex] = (string) $newIndex;
                    $value = array_values($value);
                } elseif ($key === 'experiences' && is_array($value)) {
                    $value = array_values($value);
                }
                $payload[$key] = $value;
            } elseif ($step === 1 || $step === 3) {
                unset($payload[$key]);
            }
        }
        if ($step === 1) {
            if (($payload['is_abroad'] ?? null) === '1') {
                unset($payload['regionresidence_id'], $payload['departementresidence_id']);
            } else {
                unset($payload['country_id'], $payload['addresse']);
            }
            if (($payload['handicap'] ?? null) === '0') unset($payload['handicap_id']);
        }

        $files = $existing->files ?? [];
        if ($step === 2 && $formationIndexMap) {
            $reindexedFiles = [];
            foreach ($files as $key => $meta) {
                if (preg_match('/^formations\.(\d+)\.diplome_file$/', $key, $match)) {
                    if (isset($formationIndexMap[$match[1]])) $reindexedFiles['formations.' . $formationIndexMap[$match[1]] . '.diplome_file'] = $meta;
                    else if (!empty($meta['path'])) Storage::disk('local')->delete($meta['path']);
                } else {
                    $reindexedFiles[$key] = $meta;
                }
            }
            $files = $reindexedFiles;
        }
        $uploads = [];
        if ($step === 1 && $request->hasFile('photo_profil')) {
            $uploads['photo_profil'] = $request->file('photo_profil');
        } elseif ($step === 2) {
            foreach ($request->file('formations', []) as $index => $formation) {
                if (!empty($formation['diplome_file'])) {
                    if (isset($formationIndexMap[(string) $index])) {
                        $uploads['formations.' . $formationIndexMap[(string) $index] . '.diplome_file'] = $formation['diplome_file'];
                    }
                }
            }
        }
        foreach ($uploads as $key => $file) {
            if (!$file->isValid()) continue;
            if (!empty($files[$key]['path'])) Storage::disk('local')->delete($files[$key]['path']);
            $path = $file->store("userdata-drafts/" . auth()->id(), 'local');
            $files[$key] = ['path' => $path, 'name' => $file->getClientOriginalName(), 'mime' => $file->getMimeType()];
        }
        if ($step === 2) {
            $activeIndexes = array_map('strval', array_keys($payload['formations'] ?? []));
            foreach ($files as $key => $meta) {
                if (preg_match('/^formations\.(\d+)\.diplome_file$/', $key, $match) && !in_array($match[1], $activeIndexes, true)) {
                    Storage::disk('local')->delete($meta['path'] ?? '');
                    unset($files[$key]);
                }
            }
        }

        $existing->payload = $payload;
        $existing->files = $files;
        $existing->current_step = min($step + 1, 4);
        $existing->save();

        return response()->json(['saved' => true, 'next_step' => $existing->current_step]);
    }


    // Sauvegarder les données du formulaire
    public function store(Request $request)
    {
        $draft = UserdataDraft::where('utilisateur_id', auth()->id())->first();
        if ($draft) {
            $request->merge(array_replace_recursive($draft->payload ?? [], $request->except('_token')));
            foreach (($draft->files ?? []) as $key => $meta) {
                if (empty($meta['path']) || !Storage::disk('local')->exists($meta['path'])) continue;
                $file = new UploadedFile(Storage::disk('local')->path($meta['path']), $meta['name'] ?? basename($meta['path']), $meta['mime'] ?? null, UPLOAD_ERR_OK, true);
                if ($key === 'photo_profil' && !$request->hasFile('photo_profil')) {
                    $request->files->set('photo_profil', $file);
                } elseif (preg_match('/^formations\.(\d+)\.diplome_file$/', $key, $match)) {
                    $formationsFiles = $request->file('formations', []);
                    if (empty($formationsFiles[$match[1]]['diplome_file'])) $formationsFiles[$match[1]]['diplome_file'] = $file;
                    $request->files->set('formations', $formationsFiles);
                }
            }
        }
        if ($request->input('is_abroad') === '1') {
            $request->merge(['regionresidence_id' => null, 'departementresidence_id' => null]);
        } else {
            $request->merge(['country_id' => null, 'addresse' => null]);
        }
        if ($request->input('handicap') === '0') $request->merge(['handicap_id' => null]);

        // 1) Validation
        $validated = $request->validate([
            // Step 1
            'datenaiss'                  => 'required|date',
            'lieuresidence'              => 'required|string',
            'lieunaiss'                  => 'required|string',
            'genre'                      => 'required|in:Masculin,Feminin',
            'telephone1'                 => ['required', 'regex:/^[0-9]{7,15}$/'],
            'telephone2'                 => ['nullable', 'regex:/^[0-9]{7,15}$/'],
            'situationmatrimoniale'      => 'required|string',
            'regionnaiss_id'             => 'required|exists:region,id',
            'regionresidence_id'         => 'required_if:is_abroad,0|nullable|exists:region,id',
            'departementnaiss_id'        => 'required|exists:departement,id',
            'departementresidence_id'    => 'required_if:is_abroad,0|nullable|exists:departement,id',
            'handicap'                   => 'required|in:0,1',
            'handicap_id'                => 'required_if:handicap,1|nullable|exists:handicap,id',
            'nombreenfant'               => 'required|integer|min:0|max:30',
            'is_abroad'                  => 'required|in:0,1',
            'country_id'                 => 'required_if:is_abroad,1|nullable|exists:countries,id',
            'addresse'                   => 'required_if:is_abroad,1|nullable|string|max:500',

            // Step 2 (formations multiples)
            'formations'                        => 'required|array|min:1',
            'formations.*.academic_id'          => ['required', Rule::in(array_merge(['sansdiplome'], Academic::pluck('id')->map(fn ($id) => (string) $id)->all()))],
            'formations.*.diplome'              => 'nullable',
            'formations.*.anneediplome'         => 'nullable|integer|min:1900|max:' . now()->year,
            'formations.*.specialite'           => 'nullable',
            'formations.*.etablissementdiplome' => 'nullable',

            // Fichiers des formations et photo de profil
            'formations.*.diplome_file' => 'nullable|file|mimes:pdf,doc,docx,rtf,txt,jpg,jpeg,png|max:4096',
            'photo_profil'   => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',

            // Step 3 (expériences multiples)
            'hasExperience'                   => 'required|in:oui,non',
            'experiences'                     => 'nullable|array',
            'experiences.*.description'       => 'nullable',
            'experiences.*.years'             => 'nullable|integer|min:0|max:70',
            'experiences.*.poste'             => 'nullable',
            'experiences.*.employeur'         => 'nullable',

            // Step 4
            'emploi1_id'        => ['required', Rule::exists('emploi', 'id')->where('secteur_id', $request->input('secteur1_id'))],
            'emploi2_id'        => ['required', Rule::exists('emploi', 'id')->where('secteur_id', $request->input('secteur2_id'))],
            'secteur1_id'       => 'required|exists:secteur,id',
            'secteur2_id'       => 'required|exists:secteur,id',
            'anneeexperience1'  => 'nullable|integer',
            'anneeexperience2'  => 'nullable|integer',
            'cv_summary'        => 'nullable|string|max:1000',
        ], $this->localizedValidationMessages(), $this->localizedValidationAttributes());

        // Validation approfondie des fichiers diplômes
        if ($request->hasFile('diplome_file')) {
            $rawFiles = is_array($request->file('diplome_file')) 
                ? \Illuminate\Support\Arr::flatten($request->file('diplome_file')) 
                : [$request->file('diplome_file')];
            foreach ($rawFiles as $f) {
                if ($f instanceof \Illuminate\Http\UploadedFile) {
                    $ext = strtolower($f->getClientOriginalExtension());
                    $allowed = ['pdf', 'doc', 'docx', 'rtf', 'txt', 'jpg', 'jpeg', 'png'];
                    if (!in_array($ext, $allowed) || $f->getSize() > 4194304) {
                        return back()->withInput()->withErrors(['diplome_file' => 'Le fichier '.$f->getClientOriginalName().' doit être au format PDF, DOC, DOCX, JPG ou PNG et ne pas dépasser 4 Mo.']);
                    }
                }
            }
        }

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
            ->map(function ($f, $index) use ($request) {
                // Convention "Sans diplôme" => 20 (en string) ; sinon l'ID en string
                $aid = (string) ($f['academic_id'] ?? '');
                if ($aid === 'sansdiplome') {
                    $aid = '20';
                }
                $diplome = is_array($f['diplome'] ?? null) ? implode(' ', $f['diplome']) : (string)($f['diplome'] ?? '');
                $annee   = is_array($f['anneediplome'] ?? null) ? '' : (string)($f['anneediplome'] ?? '');
                $spec    = is_array($f['specialite'] ?? null) ? implode(' ', $f['specialite']) : (string)($f['specialite'] ?? '');
                $etab    = is_array($f['etablissementdiplome'] ?? null) ? implode(' ', $f['etablissementdiplome']) : (string)($f['etablissementdiplome'] ?? '');
                $file = $this->storeDiplomeFile($request->file("formations.$index.diplome_file"));

                return [
                    'academic_id'          => $aid,
                    'diplome'              => $diplome,
                    'anneediplome'         => $annee,
                    'specialite'           => $spec,
                    'etablissementdiplome' => $etab,
                    'diplome_file'        => $file,
                ];
            })
            ->values();

        // Stockage JSON EXACTEMENT comme souhaité
        $validated['autresdiplomes'] = $formations->isNotEmpty() ? $formations->toJson() : null;

        // Mappage de la 1ʳᵉ formation vers les colonnes simples
        if ($formations->isNotEmpty()) {
            $first = $formations->first();
            $firstAcademicId = (int) $first['academic_id'];

            if ($firstAcademicId === 20 && !Academic::where('id', 20)->exists()) {
                Academic::insert(['id' => 20, 'libelle' => 'Sans diplôme']);
            }

            $validated['academic_id']         = $firstAcademicId;
            $validated['diplome']             = $first['diplome'] !== '' ? $first['diplome'] : null;
            $validated['anneediplome']        = ($first['anneediplome'] !== '' && is_numeric($first['anneediplome'])) ? (int) $first['anneediplome'] : null;
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
           FICHIERS : diplômes / photo
           ===================================================== */
        // Les justificatifs sont désormais stockés dans chaque formation.
        $validated['diplome_file'] = null;

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

        if ($draft) {
            foreach (($draft->files ?? []) as $file) {
                if (!empty($file['path'])) Storage::disk('local')->delete($file['path']);
            }
            $draft->delete();
        }

        return redirect()
            ->route('userdata.summary', $userdata->id)
            ->with('success', "Inscription terminée. Votre numéro d’inscription est le " . $userdata->utilisateur_id . ".");
    }

    // Méthode pour afficher le formulaire d'édition
    public function edit($id)
    {
        $userdata = Userdata::findOrFail($id);

        // Contrôle d'accès IDOR
        if ($userdata->utilisateur_id !== auth()->id() && (!auth()->user() || !auth()->user()->hasRole('admin'))) {
            abort(403, 'Accès non autorisé.');
        }

        $experiences = [];
        if (!empty($userdata->experiences)) {
            $decoded = json_decode($userdata->experiences, true);
            if (is_array($decoded)) {
                $experiences = $decoded;
            }
        }

        $formations = [];
        if (!empty($userdata->autresdiplomes)) {
            $decodedFormations = json_decode($userdata->autresdiplomes, true);
            if (is_array($decodedFormations)) {
                $formations = $decodedFormations;
            }
        }

        $legacyFiles = [];

        // Associer temporairement les anciens fichiers globaux aux formations par position.
        if (!empty($userdata->diplome_file)) {
            $legacyFiles = json_decode($userdata->diplome_file, true) ?: [];
            foreach ($formations as $index => &$formation) {
                if (empty($formation['diplome_file']) && !empty($legacyFiles[$index])) {
                    $formation['diplome_file'] = $legacyFiles[$index];
                }
            }
            unset($formation);
        }
        if (empty($formations) && !empty($userdata->academic_id)) {
            $formations = [[
                'academic_id' => $userdata->academic_id == 20 ? 'sansdiplome' : (string)$userdata->academic_id,
                'diplome' => $userdata->diplome ?? '',
                'anneediplome' => $userdata->anneediplome ? (string)$userdata->anneediplome : '',
                'specialite' => $userdata->specialite ?? '',
                'etablissementdiplome' => $userdata->etablissementdiplome ?? '',
                'diplome_file' => $legacyFiles[0] ?? null,
            ]];
        }

        $utilisateurs = Utilisateur::all();
        $departements = Departement::all();
        $emplois = Emploi::all();
        $handicap = Handicap::all();
        $academins = Academic::all();
        $regions = Region::all();
        $utilisateurConnecte = auth()->user();
        $secteurs = Secteur::all();
        return view('userdata.edit', compact('userdata', 'formations', 'experiences', 'utilisateurs', 'departements', 'emplois', 'handicap', 'academins', 'regions', 'secteurs', 'utilisateurConnecte'));
    }

    /**
     * Valide côté serveur l'étape courante du formulaire d'édition sans enregistrer le dossier.
     */
    public function validateEditStep(Request $request, $id)
    {
        $userdata = Userdata::findOrFail($id);

        if ($userdata->utilisateur_id !== auth()->id() && (!auth()->user() || !auth()->user()->hasRole('admin'))) {
            abort(403, 'Accès non autorisé.');
        }

        $step = (int) $request->input('step');
        $rulesByStep = $this->updateValidationRules();

        if (!array_key_exists($step, $rulesByStep)) {
            return response()->json(['message' => 'Étape invalide.'], 422);
        }

        $request->validate($rulesByStep[$step], $this->localizedValidationMessages(), $this->localizedValidationAttributes());

        return response()->json(['valid' => true]);
    }

    /** Règles partagées par la validation progressive et la sauvegarde finale. */
    private function updateValidationRules(): array
    {
        return [
            1 => [
                'departementnaiss_id'       => 'nullable|exists:departement,id',
                'departementresidence_id'   => 'nullable|exists:departement,id',
                'datenaiss'                 => 'nullable|date',
                'lieuresidence'             => 'nullable|string',
                'lieunaiss'                 => 'nullable|string',
                'genre'                     => 'nullable|string',
                'situationmatrimoniale'     => 'nullable|string',
                'telephone1'                => ['nullable', 'regex:/^[0-9]{7,15}$/'],
                'telephone2'                => ['nullable', 'regex:/^[0-9]{7,15}$/'],
                'regionnaiss_id'            => 'nullable|exists:region,id',
                'regionresidence_id'        => 'nullable|exists:region,id',
                'handicap_id'               => 'nullable|exists:handicap,id',
                'handicap'                  => 'nullable|in:0,1',
                'nombreenfant'              => 'nullable|integer|min:0|max:30',
                'photo_profil'              => 'nullable|image|mimes:jpeg,png,jpg,gif|max:8192',
            ],
            2 => [
                'formations'                         => 'nullable|array',
                'formations.*.academic_id'           => 'nullable',
                'formations.*.diplome'               => 'nullable',
                'formations.*.anneediplome'          => 'nullable|integer|min:1900|max:' . now()->year,
                'formations.*.specialite'            => 'nullable',
                'formations.*.etablissementdiplome'  => 'nullable',
                'formations.*.existing_diplome_file' => 'nullable|string',
                'formations.*.diplome_file'          => 'nullable|file|mimes:pdf,doc,docx,rtf,txt,jpg,jpeg,png|max:4096',
                'diplome_file'                       => 'nullable',
                'deleted_files'                      => 'nullable|string',
            ],
            3 => [
                'hasExperience'                 => 'nullable|in:oui,non',
                'experiences'                   => 'nullable|array',
                'experiences.*.description'     => 'nullable',
                'experiences.*.years'           => 'nullable|integer|min:0|max:70',
                'experiences.*.poste'           => 'nullable',
                'experiences.*.employeur'       => 'nullable',
            ],
            4 => [
                'cv_summary'        => 'nullable|string|max:1000',
                'emploi1_id'        => 'nullable|exists:emploi,id',
                'emploi2_id'        => 'nullable|exists:emploi,id',
                'anneeexperience1'  => 'nullable|integer|min:0|max:50',
                'anneeexperience2'  => 'nullable|integer|min:0|max:50',
            ],
        ];
    }

    private function localizedValidationMessages(): array
    {
        return [
            'formations.*.anneediplome.integer' => 'L’année d’obtention doit être un nombre entier.',
            'formations.*.anneediplome.min' => 'L’année d’obtention doit être au moins égale à :min.',
            'formations.*.anneediplome.max' => 'L’année d’obtention ne peut pas dépasser :max.',
            'formations.*.diplome_file.max' => 'Le justificatif du diplôme ne doit pas dépasser 4 Mo.',
            'experiences.*.years.integer' => 'Le nombre d’années d’expérience doit être un nombre entier.',
            'experiences.*.years.min' => 'Le nombre d’années d’expérience ne peut pas être négatif.',
            'experiences.*.years.max' => 'Le nombre d’années d’expérience ne peut pas dépasser :max ans.',
        ];
    }

    private function localizedValidationAttributes(): array
    {
        return [
            'formations.*.anneediplome' => 'année d’obtention',
            'formations.*.diplome_file' => 'justificatif du diplôme',
            'experiences.*.years' => 'nombre d’années d’expérience',
        ];
    }

    // Méthode pour mettre à jour l'utilisateur
    public function update(Request $request, $id)
    {
        $userdata = Userdata::findOrFail($id);

        // Contrôle d'accès IDOR
        if ($userdata->utilisateur_id !== auth()->id() && (!auth()->user() || !auth()->user()->hasRole('admin'))) {
            abort(403, 'Accès non autorisé.');
        }

    // Valider toutes les étapes une dernière fois avant l'enregistrement.
    $validated = $request->validate(array_merge(...array_values($this->updateValidationRules())), $this->localizedValidationMessages(), $this->localizedValidationAttributes());

    // Validation approfondie des fichiers diplômes
    if ($request->hasFile('diplome_file')) {
        $rawFiles = is_array($request->file('diplome_file')) 
            ? \Illuminate\Support\Arr::flatten($request->file('diplome_file')) 
            : [$request->file('diplome_file')];
        foreach ($rawFiles as $f) {
            if ($f instanceof \Illuminate\Http\UploadedFile) {
                $ext = strtolower($f->getClientOriginalExtension());
                $allowed = ['pdf', 'doc', 'docx', 'rtf', 'txt', 'jpg', 'jpeg', 'png'];
                if (!in_array($ext, $allowed) || $f->getSize() > 4194304) {
                    return back()->withInput()->withErrors(['diplome_file' => 'Le fichier '.$f->getClientOriginalName().' doit être au format PDF, DOC, DOCX, JPG ou PNG et ne pas dépasser 4 Mo.']);
                }
            }
        }
    }

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
    $existingFormations = $userdata->autresdiplomes
        ? (json_decode($userdata->autresdiplomes, true) ?: [])
        : [];
    $legacyDiplomeFiles = $userdata->diplome_file
        ? (json_decode($userdata->diplome_file, true) ?: [])
        : [];
    $knownDiplomeFiles = collect($existingFormations)
        ->pluck('diplome_file')
        ->filter()
        ->merge($legacyDiplomeFiles)
        ->values()
        ->all();

    $formations = collect($request->input('formations', []))
        ->filter(fn($f) => is_array($f) && isset($f['academic_id']) && $f['academic_id'] !== null && $f['academic_id'] !== '')
        ->map(function ($f, $index) use ($request, $existingFormations, $legacyDiplomeFiles, $knownDiplomeFiles) {
            $aid = (string) ($f['academic_id'] ?? '');
            if ($aid === 'sansdiplome') {
                $aid = '20';
            }
            $diplome = is_array($f['diplome'] ?? null) ? implode(' ', $f['diplome']) : (string)($f['diplome'] ?? '');
            $annee   = is_array($f['anneediplome'] ?? null) ? '' : (string)($f['anneediplome'] ?? '');
            $spec    = is_array($f['specialite'] ?? null) ? implode(' ', $f['specialite']) : (string)($f['specialite'] ?? '');
            $etab    = is_array($f['etablissementdiplome'] ?? null) ? implode(' ', $f['etablissementdiplome']) : (string)($f['etablissementdiplome'] ?? '');
            $postedOldFile = $f['existing_diplome_file'] ?? null;
            $oldFile = in_array($postedOldFile, $knownDiplomeFiles, true)
                ? $postedOldFile
                : ($existingFormations[$index]['diplome_file'] ?? ($legacyDiplomeFiles[$index] ?? null));
            $newFile = $request->file("formations.$index.diplome_file");
            $file = $oldFile;

            if ($newFile instanceof \Illuminate\Http\UploadedFile && $newFile->isValid()) {
                $file = $this->storeDiplomeFile($newFile);
                if ($oldFile && file_exists(public_path($oldFile))) {
                    @unlink(public_path($oldFile));
                }
            }

            return [
                'academic_id'          => $aid,
                'diplome'              => $diplome,
                'anneediplome'         => $annee,
                'specialite'           => $spec,
                'etablissementdiplome' => $etab,
                'diplome_file'        => $file,
            ];
        })
        ->values();

    if ($formations->isNotEmpty()) {
        $first = $formations->first();
        $academicId = $first['academic_id'];

        if ($academicId === '20' || $academicId === 'sansdiplome') {
            if (!Academic::where('id', 20)->exists()) {
                Academic::insert(['id' => 20, 'libelle' => 'Sans diplôme']);
            }
            // Convention: "sans diplôme" = 20
            $validated['academic_id'] = 20;
            $validated['diplome'] = null;
            $validated['anneediplome'] = null;
            $validated['specialite'] = null;
            $validated['etablissementdiplome'] = null;
        } else {
            $validated['academic_id']        = (int) $academicId;
            $validated['diplome']            = $first['diplome'] !== '' ? $first['diplome'] : null;
            $validated['anneediplome']        = ($first['anneediplome'] !== '' && is_numeric($first['anneediplome'])) ? (int) $first['anneediplome'] : null;
            $validated['specialite']         = $first['specialite'] !== '' ? $first['specialite'] : null;
            $validated['etablissementdiplome']= $first['etablissementdiplome'] !== '' ? $first['etablissementdiplome'] : null;
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
    if (!is_array($existingDiplomeFiles)) {
        $existingDiplomeFiles = [];
    }

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
        $rawFiles = is_array($request->file('diplome_file')) 
            ? \Illuminate\Support\Arr::flatten($request->file('diplome_file')) 
            : [$request->file('diplome_file')];
        foreach ($rawFiles as $file) {
            if ($file instanceof \Illuminate\Http\UploadedFile && $file->isValid()) {
                $filename = time().'_'.uniqid().'_'.preg_replace('/[^a-zA-Z0-9._-]/', '', $file->getClientOriginalName());
                $file->move(public_path('uploads/diplome'), $filename);
                $existingDiplomeFiles[] = 'uploads/diplome/' . $filename;
            }
        }
    }
    $validated['diplome_file'] = !empty($existingDiplomeFiles) ? json_encode(array_values($existingDiplomeFiles)) : null;

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
    } else {
        unset($validated['photo_profil']);
    }

    // 3) Mise à jour
    $userdata->update($validated);

    return redirect()->route('userdata.summary', $userdata->id)
                     ->with('success', 'Données mises à jour avec succès');
}








    // Méthode pour récupérer les emplois en fonction du secteur
    private function storeDiplomeFile(?\Illuminate\Http\UploadedFile $file): ?string
    {
        if (!$file || !$file->isValid()) {
            return null;
        }

        $destinationPath = public_path('uploads/diplome');
        if (!is_dir($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }

        $filename = time().'_'.uniqid().'_'.preg_replace(
            '/[^a-zA-Z0-9._-]/',
            '',
            $file->getClientOriginalName()
        );
        $file->move($destinationPath, $filename);

        return 'uploads/diplome/'.$filename;
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

    // Contrôle d'accès IDOR
    if ($userdata->utilisateur_id !== auth()->id() && (!auth()->user() || !auth()->user()->hasRole('admin'))) {
        return response()->json(['success' => false, 'message' => 'Accès non autorisé.'], 403);
    }

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

    // Contrôle d'accès IDOR
    if ($userdata->utilisateur_id !== auth()->id() && (!auth()->user() || !auth()->user()->hasRole('admin'))) {
        return response()->json(['success' => false, 'message' => 'Accès non autorisé.'], 403);
    }

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
public function updatePhotoProfil(Request $request, $id = null)
{
    // Validation du fichier
    $request->validate([
        'photo_profil' => 'required|image|max:2048', // Limite à 2 Mo
    ]);

    // Résolution de l'ID cible (paramètre d'URL, paramètre dans le form, ou userdata de l'utilisateur connecté)
    $targetId = $id ?? $request->input('userdata_id') ?? $request->input('id');
    if ($targetId) {
        $userData = Userdata::findOrFail($targetId);
    } else {
        $userData = Userdata::where('utilisateur_id', auth()->id())->firstOrFail();
    }

    // Sécurisation IDOR
    if ($userData->utilisateur_id !== auth()->id() && (!auth()->user() || !auth()->user()->hasRole('admin'))) {
        return response()->json(['success' => false, 'message' => 'Non autorisé.'], 403);
    }

    if ($request->hasFile('photo_profil')) {
        if ($userData->photo_profil && file_exists(public_path($userData->photo_profil))) {
            @unlink(public_path($userData->photo_profil));
        }

        $file = $request->file('photo_profil');
        $filename = time() . '_' . $file->getClientOriginalName();
        $destinationPath = public_path('uploads/photos');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0777, true);
        }
        $file->move($destinationPath, $filename);

        $userData->photo_profil = 'uploads/photos/' . $filename;
        $userData->save();

        // Retourner la nouvelle URL de la photo dans la réponse
        return response()->json([
            'success' => true,
            'photo_profil' => asset('uploads/photos/' . $filename)
        ]);
    }

    return response()->json(['success' => false], 400);
}



public function summary($id)
{
    $userdata = Userdata::findOrFail($id);

    // Contrôle d'accès IDOR
    if ($userdata->utilisateur_id !== auth()->id() && (!auth()->user() || !auth()->user()->hasRole('admin'))) {
        abort(403, 'Accès non autorisé.');
    }

    $academic = Academic::all();

    // Formatage de la date avant d'envoyer à la vue
    $userdata->datenaiss = Carbon::parse($userdata->datenaiss)->format('d/m/Y');

    return view('userdata.summary', compact('userdata', 'academic'));
}


public function resume($id)
{
    // Récupérer l'utilisateur avec les données associées (userdata)
    $utilisateur = Utilisateur::with('userdata')->findOrFail($id);

    // Contrôle d'accès IDOR (l'utilisateur doit être le propriétaire du profil ou un admin)
    if ($utilisateur->id !== auth()->id() && (!auth()->user() || !auth()->user()->hasRole('admin'))) {
        abort(403, 'Accès non autorisé.');
    }

    // Retourner la vue avec l'utilisateur et ses données associées
    return view('userdata.resume', compact('utilisateur'));
}

}
