<?php

namespace App\Http\Controllers;
use App\Models\Userdata;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use App\Models\ListeUtilisateur;

class AdminController extends Controller
{
    public function index()
    {
        // Récupérer tous les utilisateurs
       // $utilisateurs = Utilisateur::all();

       $utilisateurs = ListeUtilisateur::paginate(50); // 50 utilisateurs par page

$totalUsers = $utilisateurs->count();
$utilisateur = $utilisateurs->first(); // Pour l'affichage dans le header


        // Récupérer le premier utilisateur (optionnel)
       // $utilisateur = Utilisateur::first();

        // Récupérer les utilisateurs recrutés et non recrutés
        $recrutedUsers = Utilisateur::where('recruted', true)->count();
        $notRecrutedUsers = Utilisateur::where('recruted', false)->count();

        // Récupérer les listes des utilisateurs recrutés et non recrutés
        $recrutedList = Utilisateur::where('recruted', true)->get();
        $notRecrutedList = Utilisateur::where('recruted', false)->get();

        // Récupérer le nombre total d'utilisateurs
        $totalUsers = Userdata::count();
       // $incomplet = Utilisateur::count(); // Nombre total d'utilisateurs
       $incomplet = Utilisateur::doesntHave('userdata')->count();
        $totalMales = Userdata::where('genre', 'Homme')->count();
        $totalFemales = Userdata::where('genre', 'Femme')->count();
        $sansdiplome=Userdata::where('academic_id','20')->count();
        $avecdiplome = Userdata::where('academic_id', '!=', 20)->count();

        // Récupérer le nombre d'inscrits de l'année en cours
        $currentYear = now()->year; // Récupère l'année actuelle
        $currentYearUsers = Utilisateur::whereYear('date_inscription', $currentYear)->count(); // Utilisateurs inscrits cette année
        $activeUsers = Utilisateur::where('enabled', true)->count();
        $inactiveUsers = Utilisateur::where('enabled', false)->count();

        // Retourner la vue avec toutes les données
        return view('admin.index', compact(
            'utilisateurs',
            'utilisateur',
            'recrutedUsers',
            'notRecrutedUsers',
            'incomplet',
            'recrutedList',
            'notRecrutedList',
            'totalUsers',
            'totalMales',
            'totalFemales',
            'currentYearUsers',
            'sansdiplome',
            'avecdiplome',
            'inactiveUsers',
            'activeUsers' // Ajouter cette ligne pour passer le nombre d'inscrits de l'année en cours à la vue
        ));
    }


    public function demandeursIncomplets(Request $request)
{
    $query = ListeUtilisateur::query();

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
            // Pour les booléens, on fait un match exact
            if (in_array($formField, ['isActif', 'isRecruted'])) {
                $query->where($dbColumn, $request->input($formField));
            } else {
                $query->where($dbColumn, 'like', '%' . $request->input($formField) . '%');
            }
        }
    }

    $utilisateurs = $query->paginate(50); // ou le nombre que tu veux afficher par page

    $utilisateur = $utilisateurs->first();
    $incomplet = ListeUtilisateur::count();

    return view('admin.demandeurincomplet', compact('utilisateurs', 'utilisateur', 'incomplet'));
}




    public function editactif($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.editactif', compact('utilisateur'));
    }
    public function updateactif(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed',
            'recruted' => 'nullable|max:180', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
            'recruted' => $validated['recruted'],
        ];


        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.editactif', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function editnombreinscrit($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.editnombreinscrit', compact('utilisateur'));
    }
    public function updatenombreinscrit(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
        ];

        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.editnombreinscrit', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }
    public function editpasactif($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.editpasactif', compact('utilisateur'));
    }
    public function updatepasactif(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
        ];

        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.editpasactif', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }
    public function editincomplet($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.editincomplet', compact('utilisateur'));
    }
    public function updateincomplet(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
        ];

        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.editincomplet', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }


    public function editsansdiplome($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.editsansdiplome', compact('utilisateur'));
    }
    public function updatesansdiplome(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
        ];

        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.editsansdiplome', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function editavecdiplome($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.editavecdiplome', compact('utilisateur'));
    }

    public function updateavecdiplome(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
        ];

        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.editavecdiplome', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function edit($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.edit', compact('utilisateur'));
    }


    public function update(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
        ];

        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.edit', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }


    public function editmasculin($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.editmasculin', compact('utilisateur'));
    }
    public function updatemasculin(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
        ];

        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.editmasculin', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function editfeminin($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Return the edit view with the user data
        return view('admin.editfeminin', compact('utilisateur'));
    }
    public function updatefeminin(Request $request, $id)
    {
        // Trouver l'utilisateur à modifier
        $utilisateur = Utilisateur::findOrFail($id);

        // Validation des données
        $validated = $request->validate([
            'numberid' => 'required|max:255',
            'username' => 'required|max:180',
            'firstname' => 'required|max:255',
            'lastname' => 'required|max:255',
            'email' => 'required|email|max:180',
            'password' => 'nullable|min:6|confirmed', // Validation pour le mot de passe (si fourni)
        ]);

        // Préparer un tableau des données à mettre à jour
        $updateData = [
            'numberid' => $validated['numberid'],
            'username' => $validated['username'],
            'firstname' => $validated['firstname'],
            'lastname' => $validated['lastname'],
            'email' => $validated['email'],
        ];

        // Mise à jour du mot de passe si un nouveau mot de passe est fourni
        if (!empty($validated['password'])) {
            $updateData['password'] = bcrypt($validated['password']);
        }

        // Vérifier si 'recruted' est présent dans la requête, sinon le laisser tel quel
        if ($request->has('recruted')) {
            $updateData['recruted'] = $request->input('recruted') ? 1 : 0;
        }

        // Mise à jour de l'utilisateur avec les données valides
        $utilisateur->update($updateData);

        // Retourner à la même page d'édition avec un message de succès
        return redirect()->route('admin.editfeminin', ['user' => $id])
                         ->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroy($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Delete the user
        $utilisateur->delete();

        // Redirect back to the user list or show a success message
        return redirect()->route('admin.users')->with('success', 'User deleted successfully.');
    }
    public function recruter($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        // Set the 'recruted' status to true
        $utilisateur->recruted = true;
        $utilisateur->save();

        // Redirect back with a success message
        return redirect()->route('admin.users')->with('success', 'Utilisateur recruté avec succès!');
    }
    public function searchUsers(Request $request)
    {
        $search = $request->get('search');

        // Rechercher les utilisateurs qui correspondent à la recherche
        $utilisateur = Utilisateur::where('firstname', 'LIKE', "%$search%")
                            ->orWhere('lastname', 'LIKE', "%$search%")
                            ->orWhere('email', 'LIKE', "%$search%")
                            ->orWhere('numberid', 'LIKE', "%$search%") // Ajouter la recherche sur le CNI
                            ->get();

        // Retourner la vue avec les résultats de la recherche
        return view('admin.index', ['utilisateur' => $utilisateur]);
    }

}
