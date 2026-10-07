<?php

namespace App\Http\Controllers;
use App\Models\Userdata;
use App\Models\Utilisateur;
use App\Models\Academic;
use App\Models\Emploi;
use App\Models\Region;
use App\Models\SecurityLoginEvent;
use Illuminate\Http\Request;
use App\Models\ListeUtilisateur;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Password;
use Carbon\Carbon;

class AdminController extends Controller
{
    public function index()
    {
        // Récupérer le nombre total d'utilisateurs
        $totalUsers = Userdata::count();
        $incomplet = Utilisateur::doesntHave('userdata')->count();
        $totalMales = Userdata::where('genre', 'Masculin')->count();
        $totalFemales = Userdata::where('genre', 'Feminin')->count();

        // Récupérer le nombre d'inscrits de l'année en cours
        $currentYear = now()->year;
        $currentYearUsers = Utilisateur::whereYear('date_inscription', $currentYear)->count();
        $activeUsers = Utilisateur::where('enabled', true)->count();
        $registeredUsers = Utilisateur::count();
        $diasporaUsers = Userdata::whereNotNull('country_id')->count();

        $weekStart = now()->startOfWeek()->subWeeks(7);
        $trendEnd = $weekStart->copy()->addWeeks(8);
        $dailyRegistrationCounts = Utilisateur::query()
            ->where('date_inscription', '>=', $weekStart)
            ->where('date_inscription', '<', $trendEnd)
            ->selectRaw('DATE(date_inscription) as registration_day, COUNT(*) as total')
            ->groupBy('registration_day')
            ->pluck('total', 'registration_day');

        $weeklyRegistrationCounts = [];
        foreach ($dailyRegistrationCounts as $date => $count) {
            $week = Carbon::parse($date)->startOfWeek()->toDateString();
            $weeklyRegistrationCounts[$week] = ($weeklyRegistrationCounts[$week] ?? 0) + (int) $count;
        }

        $registrationTrend = collect(range(0, 7))->map(function ($weekOffset) use ($weekStart, $weeklyRegistrationCounts) {
            $start = $weekStart->copy()->addWeeks($weekOffset);

            return [
                'label' => $start->format('d/m'),
                'count' => (int) ($weeklyRegistrationCounts[$start->toDateString()] ?? 0),
            ];
        });

        $regionCounts = Userdata::query()
            ->selectRaw('regionresidence_id, COUNT(*) as total')
            ->whereNotNull('regionresidence_id')
            ->groupBy('regionresidence_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $regionsById = Region::whereIn('id', $regionCounts->pluck('regionresidence_id'))
            ->pluck('libelle', 'id');
        $regionStats = $regionCounts->map(fn ($row) => [
            'label' => $regionsById[$row->regionresidence_id] ?? 'Région inconnue',
            'count' => (int) $row->total,
        ])->values();

        $academicCounts = Userdata::query()
            ->selectRaw('academic_id, COUNT(*) as total')
            ->groupBy('academic_id')
            ->orderByDesc('total')
            ->limit(5)
            ->get();
        $academicsById = Academic::whereIn('id', $academicCounts->pluck('academic_id')->filter())
            ->pluck('libelle', 'id');
        $academicStats = $academicCounts->map(fn ($row) => [
            'label' => $row->academic_id === null
                ? 'Non renseigné'
                : ($academicsById[$row->academic_id] ?? 'Niveau inconnu'),
            'count' => (int) $row->total,
        ])->values();

        $employmentTotals = collect();
        foreach (['emploi1_id', 'emploi2_id'] as $employmentColumn) {
            Userdata::query()
                ->selectRaw($employmentColumn . ' as emploi_id, COUNT(*) as total')
                ->whereNotNull($employmentColumn)
                ->groupBy($employmentColumn)
                ->get()
                ->each(function ($row) use ($employmentTotals) {
                    $employmentTotals->put(
                        $row->emploi_id,
                        ($employmentTotals->get($row->emploi_id, 0)) + (int) $row->total
                    );
                });
        }
        $employmentTotals = $employmentTotals->sortDesc()->take(5);
        $employmentsById = Emploi::whereIn('id', $employmentTotals->keys())->pluck('libelle', 'id');
        $employmentStats = $employmentTotals->map(fn ($count, $id) => [
            'label' => $employmentsById[$id] ?? 'Emploi inconnu',
            'count' => (int) $count,
        ])->values();

        // Retourner la vue avec toutes les données
        return view('admin.index', compact(
            'incomplet',
            'totalUsers',
            'totalMales',
            'totalFemales',
            'currentYearUsers',
            'activeUsers',
            'registeredUsers',
            'diasporaUsers',
            'registrationTrend',
            'regionStats',
            'academicStats',
            'employmentStats'
        ));
    }


    public function demandeursIncomplets(Request $request)
{
    $query = ListeUtilisateur::query();


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
        $lastSuccessfulLogin = SecurityLoginEvent::where('utilisateur_id', $utilisateur->id)
            ->where('result', 'success')
            ->latest('created_at')
            ->first();
        $recentLoginFailures = SecurityLoginEvent::where('utilisateur_id', $utilisateur->id)
            ->whereNotNull('result')
            ->where('result', '!=', 'success')
            ->latest('created_at')
            ->limit(5)
            ->get();

        // Return the edit view with the user data
        return view('admin.edit', compact('utilisateur', 'lastSuccessfulLogin', 'recentLoginFailures'));
    }

    public function sendPasswordResetLink($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        try {
            $status = Password::broker('utilisateur')->sendResetLink([
                'email' => $utilisateur->email,
            ]);
        } catch (\Throwable $exception) {
            report($exception);

            return back()->with('error', 'Le lien de réinitialisation n’a pas pu être envoyé. Vérifie la configuration du service mail.');
        }

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('success', 'Le lien de réinitialisation a été envoyé à ' . $utilisateur->email . '.');
        }

        if ($status === Password::RESET_THROTTLED) {
            return back()->with('error', 'Un lien vient déjà d’être demandé. Patiente quelques minutes avant de réessayer.');
        }

        return back()->with('error', 'Le lien de réinitialisation n’a pas pu être envoyé. Vérifie que l’adresse du compte est valide.');
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
        $utilisateur = Utilisateur::findOrFail($id);

        if ((int) auth()->id() === (int) $utilisateur->id) {
            return back()->with('error', 'Vous ne pouvez pas supprimer votre propre compte administrateur.');
        }

        if ($utilisateur->hasRole('admin')) {
            return back()->with('error', 'La suppression d’un compte administrateur depuis cette liste est interdite.');
        }

        DB::transaction(function () use ($utilisateur) {
            // La base n'a pas de suppression en cascade pour userdata.utilisateur_id.
            $utilisateur->userdata()->delete();
            $utilisateur->delete();
        });

        return back()->with('success', 'Le compte utilisateur a été supprimé.');
    }

    public function resendVerification($id)
    {
        $utilisateur = Utilisateur::findOrFail($id);

        if ($utilisateur->hasVerifiedEmail()) {
            return back()->with('error', 'Ce compte est déjà activé.');
        }

        try {
            $utilisateur->sendEmailVerificationNotification();
        } catch (\Throwable $exception) {
            report($exception);

            return back()->with('error', 'Le mail n’a pas pu être envoyé. Vérifiez la configuration du service mail.');
        }

        return back()->with('success', 'Le mail d’activation a été envoyé à ' . $utilisateur->email . '.');
    }
    public function recruter($id)
    {
        // Find the user by ID
        $utilisateur = Utilisateur::findOrFail($id);

        if (!$utilisateur->enabled || !$utilisateur->userdata()->exists()) {
            return back()->with('error', 'Seuls les comptes activés avec un dossier complet peuvent être marqués comme recrutés.');
        }

        if ($utilisateur->recruted) {
            return back()->with('error', 'Ce candidat est déjà marqué comme recruté.');
        }

        $utilisateur->recruted = true;
        $utilisateur->save();

        // Redirect back with a success message
        return back()->with('success', 'Le candidat a été marqué comme recruté.');
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
