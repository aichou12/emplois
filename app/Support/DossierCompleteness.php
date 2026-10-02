<?php

namespace App\Support;

use App\Models\Userdata;

/**
 * Calcule l'état de complétude d'un dossier candidat pour le récapitulatif.
 * Chaque point indique l'étape du formulaire où le compléter (1 à 4).
 */
class DossierCompleteness
{
    /**
     * @return array{percent: int, missing: list<array{label: string, step: int, required: bool}>}
     */
    public static function evaluate(Userdata $userdata, array $formations): array
    {
        $hasDiploma = collect($formations)->contains(
            fn (array $formation): bool => !in_array($formation['academic_id'] ?? null, ['sansdiplome', '20'], true)
        );
        $hasDiplomaFile = collect($formations)->contains(
            fn (array $formation): bool => !empty($formation['diplome_file'])
        );
        $isAbroad = !empty($userdata->country_id);

        $checks = [
            ['label' => 'Photo d\'identité', 'step' => 1, 'required' => false, 'done' => !empty($userdata->photo_profil)],
            ['label' => 'Date de naissance', 'step' => 1, 'required' => true, 'done' => !empty($userdata->datenaiss)],
            ['label' => 'Lieu de naissance', 'step' => 1, 'required' => true, 'done' => !empty($userdata->lieunaiss)],
            ['label' => 'Téléphone', 'step' => 1, 'required' => true, 'done' => !empty($userdata->telephone1)],
            ['label' => 'Situation familiale', 'step' => 1, 'required' => true, 'done' => !empty($userdata->situationmatrimoniale)],
            [
                'label' => 'Lieu de résidence',
                'step' => 1,
                'required' => true,
                'done' => $isAbroad ? !empty($userdata->addresse) : !empty($userdata->departementresidence_id),
            ],
            ['label' => 'Au moins une formation', 'step' => 2, 'required' => true, 'done' => !empty($formations)],
            [
                'label' => 'Justificatif de diplôme',
                'step' => 2,
                'required' => false,
                // Sans diplôme : aucun justificatif attendu
                'done' => !$hasDiploma || $hasDiplomaFile,
            ],
            ['label' => 'Premier emploi visé', 'step' => 4, 'required' => true, 'done' => !empty($userdata->emploi1_id)],
            ['label' => 'Second emploi visé', 'step' => 4, 'required' => true, 'done' => !empty($userdata->emploi2_id)],
            ['label' => 'Résumé de votre profil', 'step' => 4, 'required' => false, 'done' => !empty($userdata->cv_summary)],
        ];

        $doneCount = count(array_filter($checks, fn (array $check): bool => $check['done']));
        $missing = array_values(array_map(
            fn (array $check): array => ['label' => $check['label'], 'step' => $check['step'], 'required' => $check['required']],
            array_filter($checks, fn (array $check): bool => !$check['done'])
        ));

        // Les points obligatoires manquants en premier
        usort($missing, fn (array $a, array $b): int => $b['required'] <=> $a['required']);

        return [
            'percent' => (int) round($doneCount / count($checks) * 100),
            'missing' => $missing,
        ];
    }
}
