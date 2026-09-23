<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CandidatProfileResource;
use App\Models\Userdata;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CandidatApiController extends Controller
{
    /**
     * Récupère ou initialise l'enregistrement Userdata du candidat connecté.
     */
    protected function getOrCreateUserdata(int $userId): Userdata
    {
        $userdata = Userdata::where('utilisateur_id', $userId)->first();

        if (!$userdata) {
            $userdata = Userdata::create([
                'utilisateur_id' => $userId,
                'lieuresidence' => 'Sénégal',
            ]);
        }

        return $userdata;
    }

    /**
     * Chargement des relations pour le formatage du profil.
     */
    protected function loadProfileRelations(Userdata $userdata): Userdata
    {
        return $userdata->load([
            'utilisateur',
            'regionNaissance',
            'departementNaissance',
            'regionResidence',
            'departementResidence',
            'academic',
            'emploi1',
            'emploi2',
            'handicap',
        ]);
    }

    /**
     * Récupération du profil complet du candidat connecté.
     */
    public function getProfile(Request $request): JsonResponse
    {
        $user = $request->user();
        $userdata = $this->getOrCreateUserdata($user->id);
        $userdata = $this->loadProfileRelations($userdata);

        return response()->json([
            'success' => true,
            'message' => 'Profil candidat récupéré avec succès.',
            'data' => new CandidatProfileResource($userdata),
        ], 200);
    }

    /**
     * Mise à jour de l'Étape 1 : Identité & Résidence.
     */
    public function updateIdentity(Request $request): JsonResponse
    {
        $user = $request->user();
        $userdata = $this->getOrCreateUserdata($user->id);

        $validator = Validator::make($request->all(), [
            'telephone1' => 'nullable|string|max:20',
            'telephone2' => 'nullable|string|max:20',
            'datenaiss' => 'nullable|date',
            'lieunaiss' => 'nullable|string|max:255',
            'genre' => 'nullable|in:Masculin,Feminin,Homme,Femme',
            'situationmatrimoniale' => 'nullable|string|max:50',
            'nombreenfant' => 'nullable|integer|min:0|max:50',
            'lieuresidence' => 'nullable|string|max:50',
            'regionnaiss_id' => 'nullable|exists:region,id',
            'departementnaiss_id' => 'nullable|exists:departement,id',
            'regionresidence_id' => 'nullable|exists:region,id',
            'departementresidence_id' => 'nullable|exists:departement,id',
            'handicap_id' => 'nullable|exists:handicap,id',
            'has_handicap' => 'nullable|boolean',
            'photo_profil' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
        ], [
            'telephone1.max' => 'Le numéro de téléphone est trop long.',
            'datenaiss.date' => 'La date de naissance n\'est pas valide.',
            'photo_profil.image' => 'La photo de profil doit être une image valide.',
            'photo_profil.max' => 'La taille de la photo ne doit pas dépasser 4 Mo.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation des informations personnelles.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $validated = $validator->validated();

        // Normalisation du genre
        if (isset($validated['genre'])) {
            if ($validated['genre'] === 'Homme') $validated['genre'] = 'Masculin';
            if ($validated['genre'] === 'Femme') $validated['genre'] = 'Feminin';
        }

        // Gestion du handicap
        if (isset($validated['has_handicap']) && !$validated['has_handicap']) {
            $validated['handicap_id'] = null;
        }

        // Gestion de l'upload de photo si fournie
        if ($request->hasFile('photo_profil')) {
            $photo = $request->file('photo_profil');
            $fileName = time() . '_' . Str::random(8) . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('uploads/photos'), $fileName);
            $validated['photo_profil'] = 'uploads/photos/' . $fileName;
        }

        $userdata->update($validated);
        $userdata = $this->loadProfileRelations($userdata);

        return response()->json([
            'success' => true,
            'message' => 'Informations personnelles mises à jour.',
            'data' => (new CandidatProfileResource($userdata))->toArray($request)['identity'],
        ], 200);
    }

    /**
     * Mise à jour de l'Étape 2 : Formations & Diplômes.
     */
    public function updateFormations(Request $request): JsonResponse
    {
        $user = $request->user();
        $userdata = $this->getOrCreateUserdata($user->id);

        $validator = Validator::make($request->all(), [
            'formations' => 'nullable|array',
            'formations.*.academic_id' => 'nullable',
            'formations.*.diplome' => 'nullable|string|max:255',
            'formations.*.anneediplome' => 'nullable|string|max:10',
            'formations.*.specialite' => 'nullable|string|max:255',
            'formations.*.etablissementdiplome' => 'nullable|string|max:255',
            'formations.*.diplome_file' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation des formations.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $formationsInput = $request->input('formations', []);
        $formations = collect($formationsInput)
            ->filter(function ($f) {
                return is_array($f) && !empty($f['academic_id']);
            })
            ->map(function ($f) {
                $aid = (string)($f['academic_id'] ?? '');
                if ($aid === 'sansdiplome' || $aid === '20') {
                    $aid = '20';
                    return [
                        'academic_id' => $aid,
                        'diplome' => null,
                        'anneediplome' => null,
                        'specialite' => null,
                        'etablissementdiplome' => null,
                        'diplome_file' => null,
                    ];
                }

                return [
                    'academic_id' => $aid,
                    'diplome' => (string)($f['diplome'] ?? ''),
                    'anneediplome' => (string)($f['anneediplome'] ?? ''),
                    'specialite' => (string)($f['specialite'] ?? ''),
                    'etablissementdiplome' => (string)($f['etablissementdiplome'] ?? ''),
                    'diplome_file' => $f['diplome_file'] ?? null,
                ];
            })
            ->values();

        // Enregistrement JSON
        $dataToUpdate = [
            'autresdiplomes' => $formations->isNotEmpty() ? $formations->toJson() : null,
        ];

        // Mappage de la 1ère formation vers les colonnes individuelles pour rétrocompatibilité
        if ($formations->isNotEmpty()) {
            $first = $formations->first();
            $dataToUpdate['academic_id'] = (int)$first['academic_id'];
            $dataToUpdate['diplome'] = $first['diplome'] ?: null;
            $dataToUpdate['anneediplome'] = ($first['anneediplome'] && is_numeric($first['anneediplome'])) ? (int)$first['anneediplome'] : null;
            $dataToUpdate['specialite'] = $first['specialite'] ?: null;
            $dataToUpdate['etablissementdiplome'] = $first['etablissementdiplome'] ?: null;
            $dataToUpdate['diplome_file'] = $first['diplome_file'] ?: null;
        } else {
            $dataToUpdate['academic_id'] = null;
            $dataToUpdate['diplome'] = null;
            $dataToUpdate['anneediplome'] = null;
            $dataToUpdate['specialite'] = null;
            $dataToUpdate['etablissementdiplome'] = null;
            $dataToUpdate['diplome_file'] = null;
        }

        $userdata->update($dataToUpdate);
        $userdata = $this->loadProfileRelations($userdata);

        return response()->json([
            'success' => true,
            'message' => 'Formations et diplômes enregistrés avec succès.',
            'data' => (new CandidatProfileResource($userdata))->toArray($request)['formations'],
        ], 200);
    }

    /**
     * Mise à jour de l'Étape 3 : Expériences professionnelles.
     */
    public function updateExperiences(Request $request): JsonResponse
    {
        $user = $request->user();
        $userdata = $this->getOrCreateUserdata($user->id);

        $validator = Validator::make($request->all(), [
            'has_experience' => 'nullable|boolean',
            'experiences' => 'nullable|array',
            'experiences.*.poste' => 'nullable|string|max:255',
            'experiences.*.employeur' => 'nullable|string|max:255',
            'experiences.*.years' => 'nullable|numeric|min:0|max:70',
            'experiences.*.description' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation des expériences.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $hasExp = $request->boolean('has_experience', true);
        $experiencesInput = $request->input('experiences', []);

        if (!$hasExp || empty($experiencesInput)) {
            $userdata->update([
                'experiences' => null,
                'posteoccupe' => null,
                'employeur' => null,
                'nombreanneeexpe' => null,
            ]);
        } else {
            $experiences = collect($experiencesInput)
                ->filter(function ($e) {
                    return is_array($e) && (!empty($e['poste']) || !empty($e['employeur']));
                })
                ->map(function ($e) {
                    return [
                        'poste' => (string)($e['poste'] ?? ''),
                        'employeur' => (string)($e['employeur'] ?? ''),
                        'years' => isset($e['years']) && is_numeric($e['years']) ? (int)$e['years'] : 0,
                        'description' => (string)($e['description'] ?? ''),
                    ];
                })
                ->values();

            $first = $experiences->first();
            $totalYears = $experiences->sum('years');

            $userdata->update([
                'experiences' => $experiences->isNotEmpty() ? $experiences->toJson() : null,
                'posteoccupe' => $first['poste'] ?? null,
                'employeur' => $first['employeur'] ?? null,
                'nombreanneeexpe' => $totalYears > 0 ? (int)$totalYears : null,
            ]);
        }

        $userdata = $this->loadProfileRelations($userdata);

        return response()->json([
            'success' => true,
            'message' => 'Expériences professionnelles enregistrées.',
            'data' => (new CandidatProfileResource($userdata))->toArray($request)['experiences'],
        ], 200);
    }

    /**
     * Mise à jour de l'Étape 4 : Projet professionnel & Emplois ciblés.
     */
    public function updateTargetJobs(Request $request): JsonResponse
    {
        $user = $request->user();
        $userdata = $this->getOrCreateUserdata($user->id);

        $validator = Validator::make($request->all(), [
            'cv_summary' => 'nullable|string|max:1000',
            'emploi1_id' => 'nullable|exists:emploi,id',
            'anneeexperience1' => 'nullable|integer|min:0|max:50',
            'emploi2_id' => 'nullable|exists:emploi,id',
            'anneeexperience2' => 'nullable|integer|min:0|max:50',
        ], [
            'cv_summary.max' => 'Le résumé du profil ne doit pas dépasser 1000 caractères.',
            'emploi1_id.exists' => 'Le premier emploi sélectionné est invalide.',
            'emploi2_id.exists' => 'Le deuxième emploi sélectionné est invalide.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur de validation du projet professionnel.',
                'errors' => $validator->errors(),
            ], 422);
        }

        $userdata->update($validator->validated());
        $userdata = $this->loadProfileRelations($userdata);

        return response()->json([
            'success' => true,
            'message' => 'Projet professionnel et choix d\'emplois enregistrés.',
            'data' => (new CandidatProfileResource($userdata))->toArray($request)['target_jobs'],
        ], 200);
    }
}
