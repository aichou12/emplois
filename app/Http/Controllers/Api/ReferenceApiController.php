<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Academic;
use App\Models\Departement;
use App\Models\Emploi;
use App\Models\Handicap;
use App\Models\Region;
use App\Models\Secteur;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReferenceApiController extends Controller
{
    /**
     * Liste des régions du Sénégal.
     * Paramètre optionnel : ?with_departements=1
     */
    public function getRegions(Request $request): JsonResponse
    {
        $query = Region::query()->select('id', 'libelle');

        if ($request->boolean('with_departements')) {
            $query->with(['departements' => function ($q) {
                $q->select('id', 'libelle', 'region_id')->orderBy('libelle', 'asc');
            }]);
        }

        $regions = $query->orderBy('libelle', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des régions récupérée.',
            'data' => $regions,
        ], 200);
    }

    /**
     * Liste des départements pour une région donnée.
     */
    public function getDepartementsByRegion(int $regionId): JsonResponse
    {
        $departements = Departement::where('region_id', $regionId)
            ->select('id', 'libelle', 'region_id')
            ->orderBy('libelle', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des départements récupérée.',
            'region_id' => $regionId,
            'data' => $departements,
        ], 200);
    }

    /**
     * Liste des niveaux de formation académique / diplômes.
     */
    public function getNiveauxFormation(): JsonResponse
    {
        $niveaux = Academic::select('id', 'libelle')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des niveaux de formation récupérée.',
            'data' => $niveaux,
        ], 200);
    }

    /**
     * Liste des secteurs d'activité.
     * Paramètre optionnel : ?with_emplois=1
     */
    public function getSecteurs(Request $request): JsonResponse
    {
        $query = Secteur::query()->select('id', 'libelle');

        if ($request->boolean('with_emplois')) {
            $query->with(['emplois' => function ($q) {
                $q->select('id', 'libelle', 'secteur_id')->orderBy('libelle', 'asc');
            }]);
        }

        $secteurs = $query->orderBy('libelle', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des secteurs d\'activité récupérée.',
            'data' => $secteurs,
        ], 200);
    }

    /**
     * Liste des emplois/métiers rattachés à un secteur spécifique.
     */
    public function getEmploisBySecteur(int $secteurId): JsonResponse
    {
        $emplois = Emploi::where('secteur_id', $secteurId)
            ->select('id', 'libelle', 'secteur_id')
            ->orderBy('libelle', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des emplois du secteur récupérée.',
            'secteur_id' => $secteurId,
            'data' => $emplois,
        ], 200);
    }

    /**
     * Liste complète de tous les emplois (avec recherche optionnelle ?search=...).
     */
    public function getAllEmplois(Request $request): JsonResponse
    {
        $search = $request->query('search');

        $query = Emploi::query()
            ->select('id', 'libelle', 'secteur_id')
            ->with(['secteur:id,libelle']);

        if (!empty($search)) {
            $query->where('libelle', 'LIKE', '%' . $search . '%');
        }

        $emplois = $query->orderBy('libelle', 'asc')->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des emplois récupérée.',
            'count' => $emplois->count(),
            'data' => $emplois,
        ], 200);
    }

    /**
     * Liste des types de handicap.
     */
    public function getHandicaps(): JsonResponse
    {
        $handicaps = Handicap::select('id', 'libelle')
            ->orderBy('id', 'asc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Liste des handicaps récupérée.',
            'data' => $handicaps,
        ], 200);
    }

    /**
     * Bundle complet de toutes les données de référence en une seule requête.
     * Idéal pour le chargement initial et la mise en cache sur l'application mobile.
     */
    public function getAllReferences(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Ensemble des données de référence récupéré.',
            'data' => [
                'regions' => Region::with(['departements:id,libelle,region_id'])->orderBy('libelle', 'asc')->get(['id', 'libelle']),
                'niveaux_formation' => Academic::orderBy('id', 'asc')->get(['id', 'libelle']),
                'secteurs' => Secteur::with(['emplois:id,libelle,secteur_id'])->orderBy('libelle', 'asc')->get(['id', 'libelle']),
                'emplois' => Emploi::orderBy('libelle', 'asc')->get(['id', 'libelle', 'secteur_id']),
                'handicaps' => Handicap::orderBy('id', 'asc')->get(['id', 'libelle']),
            ],
        ], 200);
    }
}
