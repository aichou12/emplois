<?php

namespace Database\Seeders;

use App\Models\Utilisateur;
use Illuminate\Database\QueryException;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use RuntimeException;

class AdminUserSeeder extends Seeder
{
    /**
     * Create one administrator account without changing existing accounts.
     * Run explicitly with: php artisan db:seed --class=AdminUserSeeder
     */
    public function run(): void
    {
        $command = $this->command;

        if (!$command) {
            throw new RuntimeException('Ce seeder doit être lancé depuis Artisan afin de saisir les identifiants de façon interactive.');
        }

        $firstname = trim((string) $command->ask('Prénom de l’administrateur'));
        $lastname = trim((string) $command->ask('Nom de l’administrateur'));
        $username = trim((string) $command->ask('Nom d’utilisateur'));
        $email = trim((string) $command->ask('Adresse e-mail'));
        $numberid = trim((string) $command->ask('Numéro CNI ou passeport'));
        $password = (string) $command->secret('Mot de passe (12 caractères minimum)');

        $validator = Validator::make([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'username' => $username,
            'email' => $email,
            'numberid' => $numberid,
            'password' => $password,
        ], [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'min:3', 'max:50', 'regex:/^[a-zA-Z0-9._-]+$/'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'numberid' => ['required', 'string', 'max:255', 'regex:/^[A-Za-z0-9]+$/'],
            'password' => ['required', 'string', Password::min(12)->mixedCase()->numbers()->symbols()],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $command->error($error);
            }

            throw new RuntimeException('Les informations du compte administrateur ne sont pas valides. Aucun compte n’a été modifié.');
        }

        $canonicalUsername = mb_strtolower($username, 'UTF-8');
        $canonicalEmail = mb_strtolower($email, 'UTF-8');

        $identityCollision = Utilisateur::query()
            ->where(function ($query) use ($username, $canonicalUsername, $email, $canonicalEmail) {
                $query->whereRaw('LOWER(username) = ?', [$canonicalUsername])
                    ->orWhereRaw('LOWER(username_canonical) = ?', [$canonicalUsername])
                    ->orWhereRaw('LOWER(email) = ?', [$canonicalEmail])
                    ->orWhereRaw('LOWER(email_canonical) = ?', [$canonicalEmail])
                    // Login accepts either field, so also prevent cross-field collisions.
                    ->orWhereRaw('LOWER(username) = ?', [$canonicalEmail])
                    ->orWhereRaw('LOWER(username_canonical) = ?', [$canonicalEmail])
                    ->orWhereRaw('LOWER(email) = ?', [$canonicalUsername])
                    ->orWhereRaw('LOWER(email_canonical) = ?', [$canonicalUsername]);
            })
            ->exists();

        if ($identityCollision) {
            throw new RuntimeException('Ce nom d’utilisateur ou cette adresse e-mail est déjà associé à un compte. Aucun compte n’a été modifié.');
        }

        if (Utilisateur::query()
            ->whereRaw('LOWER(numberid) = ?', [mb_strtolower($numberid, 'UTF-8')])
            ->exists()) {
            throw new RuntimeException('Ce numéro CNI ou passeport est déjà associé à un compte. Aucun compte n’a été modifié.');
        }

        if (!$command->confirm('Créer ce nouveau compte administrateur ?', false)) {
            $command->warn('Création annulée. Aucun compte n’a été modifié.');
            return;
        }

        $administrator = new Utilisateur();
        $administrator->firstname = $firstname;
        $administrator->lastname = $lastname;
        $administrator->username = $username;
        $administrator->email = $email;
        $administrator->numberid = $numberid;
        $administrator->password = Hash::make($password);
        $administrator->enabled = true;
        $administrator->roles = serialize(['role_admin']);
        $administrator->date_inscription = now();

        try {
            $administrator->save();
        } catch (QueryException $exception) {
            // A concurrent account creation or a database unique index must never
            // cause an existing candidate account to be promoted or overwritten.
            throw new RuntimeException('Le compte n’a pas été créé, probablement parce qu’un identifiant vient d’être utilisé. Aucun compte existant n’a été modifié.', previous: $exception);
        }

        $command->info('Le compte administrateur a été créé. Aucun compte existant n’a été modifié.');
    }
}
