<?php

namespace App\Http\Resources;

use App\Models\Academic;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CandidatProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $userdata = $this;
        $user = $userdata->utilisateur;

        // 1. Décodage des Formations
        $formations = [];
        if (!empty($userdata->autresdiplomes)) {
            $rawFormations = is_array($userdata->autresdiplomes) 
                ? $userdata->autresdiplomes 
                : json_decode($userdata->autresdiplomes, true);

            if (is_array($rawFormations)) {
                $academicLevels = Academic::pluck('libelle', 'id')->toArray();
                foreach ($rawFormations as $idx => $f) {
                    $aid = (string)($f['academic_id'] ?? '');
                    $isSansDiplome = ($aid === '20' || $aid === 'sansdiplome');
                    $levelName = $isSansDiplome ? 'Sans diplôme' : ($academicLevels[$aid] ?? null);

                    $formations[] = [
                        'id' => $idx + 1,
                        'academic_id' => $aid === 'sansdiplome' ? 20 : (is_numeric($aid) ? (int)$aid : null),
                        'academic_label' => $levelName,
                        'is_sans_diplome' => $isSansDiplome,
                        'diplome' => $isSansDiplome ? null : ($f['diplome'] ?? null),
                        'anneediplome' => $isSansDiplome ? null : ($f['anneediplome'] ?? null),
                        'specialite' => $isSansDiplome ? null : ($f['specialite'] ?? null),
                        'etablissementdiplome' => $isSansDiplome ? null : ($f['etablissementdiplome'] ?? null),
                        'diplome_file_url' => !empty($f['diplome_file']) ? asset($f['diplome_file']) : null,
                        'diplome_file_name' => !empty($f['diplome_file']) ? basename($f['diplome_file']) : null,
                    ];
                }
            }
        } elseif (!empty($userdata->academic_id)) {
            $isSansDiplome = ($userdata->academic_id == 20);
            $formations[] = [
                'id' => 1,
                'academic_id' => (int)$userdata->academic_id,
                'academic_label' => $isSansDiplome ? 'Sans diplôme' : ($userdata->academic->libelle ?? null),
                'is_sans_diplome' => $isSansDiplome,
                'diplome' => $isSansDiplome ? null : $userdata->diplome,
                'anneediplome' => $isSansDiplome ? null : $userdata->anneediplome,
                'specialite' => $isSansDiplome ? null : $userdata->specialite,
                'etablissementdiplome' => $isSansDiplome ? null : $userdata->etablissementdiplome,
                'diplome_file_url' => !empty($userdata->diplome_file) ? asset($userdata->diplome_file) : null,
                'diplome_file_name' => !empty($userdata->diplome_file) ? basename($userdata->diplome_file) : null,
            ];
        }

        // 2. Décodage des Expériences
        $experiences = [];
        if (!empty($userdata->experiences)) {
            $rawExp = is_array($userdata->experiences) 
                ? $userdata->experiences 
                : json_decode($userdata->experiences, true);

            if (is_array($rawExp)) {
                foreach ($rawExp as $idx => $e) {
                    $years = $e['years'] ?? null;
                    if (is_numeric($years) && $years > 70) {
                        $years = null; // Nettoyage année legacy
                    }
                    $experiences[] = [
                        'id' => $idx + 1,
                        'poste' => $e['poste'] ?? null,
                        'employeur' => $e['employeur'] ?? null,
                        'years' => is_numeric($years) ? (int)$years : null,
                        'description' => $e['description'] ?? null,
                    ];
                }
            }
        } elseif (!empty($userdata->posteoccupe) || !empty($userdata->employeur)) {
            $years = $userdata->nombreanneeexpe;
            if (is_numeric($years) && $years > 70) {
                $years = null;
            }
            $experiences[] = [
                'id' => 1,
                'poste' => $userdata->posteoccupe,
                'employeur' => $userdata->employeur,
                'years' => is_numeric($years) ? (int)$years : null,
                'description' => null,
            ];
        }

        // 3. Décodage des fichiers CV
        $cvFiles = [];
        if (!empty($userdata->cv_file)) {
            $rawCv = is_array($userdata->cv_file) 
                ? $userdata->cv_file 
                : json_decode($userdata->cv_file, true);

            if (is_array($rawCv)) {
                foreach ($rawCv as $file) {
                    $cvFiles[] = [
                        'file_path' => $file,
                        'file_url' => asset($file),
                        'file_name' => basename($file),
                    ];
                }
            } elseif (is_string($userdata->cv_file)) {
                $cvFiles[] = [
                    'file_path' => $userdata->cv_file,
                    'file_url' => asset($userdata->cv_file),
                    'file_name' => basename($userdata->cv_file),
                ];
            }
        }

        // 4. Calcul du taux de complétion du dossier
        $fieldsCount = 0;
        $filledCount = 0;
        $checkFields = [
            $userdata->telephone1, $userdata->datenaiss, $userdata->lieunaiss,
            $userdata->genre, $userdata->regionresidence_id, $userdata->departementresidence_id,
            !empty($formations), !empty($experiences), $userdata->emploi1_id,
        ];
        foreach ($checkFields as $field) {
            $fieldsCount++;
            if (!empty($field)) {
                $filledCount++;
            }
        }
        $completionPercentage = round(($filledCount / $fieldsCount) * 100);

        return [
            'userdata_id' => $userdata->id,
            'candidat_number' => $user ? $user->id : null,
            'completion_percentage' => $completionPercentage,

            // Compte / Compte utilisateur
            'account' => [
                'id' => $user->id ?? null,
                'firstname' => $user->firstname ?? null,
                'lastname' => $user->lastname ?? null,
                'fullname' => trim(($user->firstname ?? '') . ' ' . ($user->lastname ?? '')),
                'email' => $user->email ?? null,
                'numberid' => $user->numberid ?? null,
                'username' => $user->username ?? null,
                'enabled' => (bool) ($user->enabled ?? false),
            ],

            // Étape 1 : Identité & Résidence
            'identity' => [
                'telephone1' => $userdata->telephone1,
                'telephone2' => $userdata->telephone2,
                'datenaiss' => $userdata->datenaiss,
                'lieunaiss' => $userdata->lieunaiss,
                'genre' => $userdata->genre,
                'situationmatrimoniale' => $userdata->situationmatrimoniale,
                'nombreenfant' => (int) ($userdata->nombreenfant ?? 0),
                'lieuresidence' => $userdata->lieuresidence ?? 'Sénégal',
                'region_naissance' => $userdata->regionNaissance ? [
                    'id' => $userdata->regionNaissance->id,
                    'libelle' => $userdata->regionNaissance->libelle,
                ] : null,
                'departement_naissance' => $userdata->departementNaissance ? [
                    'id' => $userdata->departementNaissance->id,
                    'libelle' => $userdata->departementNaissance->libelle,
                ] : null,
                'region_residence' => $userdata->regionResidence ? [
                    'id' => $userdata->regionResidence->id,
                    'libelle' => $userdata->regionResidence->libelle,
                ] : null,
                'departement_residence' => $userdata->departementResidence ? [
                    'id' => $userdata->departementResidence->id,
                    'libelle' => $userdata->departementResidence->libelle,
                ] : null,
                'handicap' => $userdata->handicap ? [
                    'id' => $userdata->handicap->id,
                    'libelle' => $userdata->handicap->libelle,
                ] : null,
                'has_handicap' => !empty($userdata->handicap_id),
                'photo_profil_url' => $userdata->photo_profil ? asset($userdata->photo_profil) : asset('images/images.png'),
            ],

            // Étape 2 : Formations & Diplômes
            'formations' => $formations,

            // Étape 3 : Expériences professionnelles
            'experiences' => $experiences,
            'has_experience' => count($experiences) > 0,

            // Étape 4 : Projet professionnel & CV
            'target_jobs' => [
                'cv_summary' => $userdata->cv_summary,
                'emploi1' => $userdata->emploi1 ? [
                    'id' => $userdata->emploi1->id,
                    'libelle' => $userdata->emploi1->libelle,
                ] : null,
                'anneeexperience1' => (int) ($userdata->anneeexperience1 ?? 0),
                'emploi2' => $userdata->emploi2 ? [
                    'id' => $userdata->emploi2->id,
                    'libelle' => $userdata->emploi2->libelle,
                ] : null,
                'anneeexperience2' => (int) ($userdata->anneeexperience2 ?? 0),
                'cv_files' => $cvFiles,
            ],
        ];
    }
}
