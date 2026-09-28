<?php

namespace App\Http\Controllers;

use App\Models\Userdata;
use App\Models\Utilisateur;
use App\Models\Academic;
use App\Models\Region;
use App\Models\Secteur;
use Illuminate\Http\Request;

class DemandeurController extends Controller
{
    public function index(Request $request)
    {
        // Une seule liste regroupe désormais tous les comptes et les dossiers candidats.
        $query = Utilisateur::query()
            ->where(function ($users) {
                $users->whereNull('roles')->orWhere('roles', 'not like', '%admin%');
            })
            ->with(['userdata.regionResidence', 'userdata.pays', 'userdata.academic', 'userdata.emploi1.secteur']);

        if ($request->input('dossier') === 'complet') {
            $query->whereHas('userdata');
        } elseif ($request->input('dossier') === 'incomplet') {
            $query->whereDoesntHave('userdata');
        }

        if ($request->input('diplome') === 'avec') {
            $query->whereHas('userdata', fn ($userdata) => $userdata->where('academic_id', '!=', 20));
        } elseif ($request->input('diplome') === 'sans') {
            $query->whereHas('userdata', fn ($userdata) => $userdata->where('academic_id', 20));
        } elseif (ctype_digit((string) $request->input('diplome', ''))) {
            $query->whereHas('userdata', fn ($userdata) => $userdata->where('academic_id', (int) $request->input('diplome')));
        }

        if (in_array($request->input('genre'), ['Masculin', 'Feminin'], true)) {
            $query->whereHas('userdata', fn ($userdata) => $userdata->where('genre', $request->input('genre')));
        }

        if ($request->filled('region')) {
            $query->whereHas('userdata', fn ($userdata) => $userdata->where('regionresidence_id', $request->input('region')));
        }

        if ($request->filled('secteur')) {
            $query->whereHas('userdata.emploi1', fn ($emploi) => $emploi->where('secteur_id', $request->input('secteur')));
        }

        if ($request->input('statut') === 'complet') {
            $query->whereHas('userdata');
        } elseif ($request->input('statut') === 'incomplet') {
            $query->whereDoesntHave('userdata');
        } elseif ($request->input('statut') === 'actif') {
            $query->where('enabled', true);
        } elseif ($request->input('statut') === 'inactif') {
            $query->where('enabled', false);
        } elseif ($request->input('statut') === 'recrute') {
            $query->where('recruted', true);
        } elseif ($request->input('statut') === 'non_recrute') {
            $query->where('recruted', false);
        }

        if ($request->filled('recherche')) {
            $search = trim($request->input('recherche'));
            $query->where(function ($users) use ($search) {
                $users->where('firstname', 'like', '%' . $search . '%')
                    ->orWhere('lastname', 'like', '%' . $search . '%')
                    ->orWhere('username', 'like', '%' . $search . '%')
                    ->orWhere('numberid', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%')
                    ->orWhereHas('userdata', fn ($userdata) => $userdata->where('telephone1', 'like', '%' . $search . '%'));

                if (ctype_digit($search)) {
                    $users->orWhere('id', (int) $search);
                }
            });
        }

        if (preg_match('/^\d{4}$/', (string) $request->input('annee_inscription', ''))) {
            $query->whereYear('date_inscription', $request->input('annee_inscription'));
        }
    
        // Mapping des champs du formulaire vers les colonnes en BDD
        $filters = [
            'id' => 'id',
            'identity_number' => 'numberid',
            'username' => 'username',
            'email' => 'email',
            'firstname' => 'firstname',
            'lastname' => 'lastname',
            'isActif' => 'enabled',
            'isRecruted' => 'recruted',
        ];
    
        foreach ($filters as $formField => $dbColumn) {
            if ($request->filled($formField)) {
                if (in_array($formField, ['isActif', 'isRecruted'])) {
                    $query->where($dbColumn, $request->input($formField));
                } else {
                    $query->where($dbColumn, 'like', '%' . $request->input($formField) . '%');
                }
            }
        }
    
        $utilisateurs = $query->paginate(10)->withQueryString();
        $regions = Region::orderBy('libelle')->get(['id', 'libelle']);
        $secteurs = Secteur::orderBy('libelle')->get(['id', 'libelle']);
        $academics = Academic::orderBy('libelle')->get(['id', 'libelle']);

        return view('admin.liste_demandeur', compact('utilisateurs', 'regions', 'secteurs', 'academics'));
    }
}
    
