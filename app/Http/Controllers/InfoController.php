<?php
namespace App\Http\Controllers;

use App\Models\Info;
use App\Models\Secteur; // Add this for the Secteur model
use App\Models\Emploi;  // Add this for the Emploi model
use Illuminate\Http\Request;

class InfoController extends Controller
{
    public function create()
    {
        // Pass available secteurs and emplois to the view for dropdowns
        $secteurs = Secteur::all();
        $emplois = Emploi::all();

        return view('info.create', compact('secteurs', 'emplois'));

    }

    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'cni' => 'required|string|max:255',
            'genre' => 'required|in:Masculin,Feminin',
            'datenaiss' => 'required|date',
            'lieu' => 'required|string|max:255',
            'situation' => 'required|in:Célibataire,Marié(e),Divorcé(e),Veuf/Veuve',
            'nombrenfant' => 'required|integer',
            'exp_professionnelle' => 'required|string',
            'nombrexp' => 'required|integer',
            'dernierposte' => 'required|string|max:255',
            'dernieremp' => 'required|string|max:255',
            'cv' => 'required|string',
            'lettremoti' => 'required|string',
            'lieu_residence' => 'required|exists:countries,id',
            'adresse' => 'required|string|max:255',
            'handicap' => 'required|boolean',
            'diplome' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'intitule_diplome' => 'required|string|max:255',
            'annee_obs' => 'required|integer',
            'specialite' => 'required|string|max:255',
            'autre_diplome' => 'nullable|string|max:255',
            'secteur_id' => 'required|exists:secteurs,id',
        ]);

        // Générer un numéro unique composé uniquement de chiffres
        $numero = 'Num-' . rand(10000000, 99999999);

        // Créer une nouvelle entrée dans la base de données avec le numéro généré et is_submitted = 0
        $info = Info::create(array_merge($validated, [
            'numero' => $numero,
            'is_submitted' => 1, // Définir is_submitted à 0 par défaut
            'user_id' => auth()->id(), // Associer l'utilisateur connecté
        ]));

        // Retourner une réponse
        return redirect()->route('info.create')->with([
            'success' => 'Information ajoutée avec succès!',
            'numero' => $numero,
        ]);
    }






    public function index()
    {
        // Récupérer toutes les informations depuis la base de données
        $infos = Info::all();

        // Retourner la vue avec les données
        return view('info.index', compact('infos'));
    }
    public function edit($id)
{
    $info = Info::findOrFail($id);
    return view('info.edit', compact('info'));
}
public function update(Request $request, $id)
{
    $info = Info::findOrFail($id);

    // Vérifier si l'utilisateur clique sur "Soumettre"
    $isSubmitted = $request->has('soumettre') ? 1 : $info->is_submitted;

    $info->update(array_merge($request->all(), [
        'is_submitted' => $isSubmitted
    ]));

    return redirect()->route('info.edit', $id)->with('success', 'Information mise à jour avec succès.');
}


public function destroy($id)
{
    $info = Info::findOrFail($id);
    $info->delete();

    return redirect()->route('info.index')->with('success', 'Information supprimée avec succès.');
}

}
