<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Artisan::command('user:activate-nin {nin? : Le NIN ou CNI du candidat} {--password=passer : Nouveau mot de passe}', function () {
    $nin = $this->argument('nin');
    if (!$nin) {
        $nin = $this->ask('Veuillez saisir le NIN (CNI) du compte');
    }

    $nin = trim((string) $nin);
    if (empty($nin)) {
        $this->error('Le NIN ne peut pas être vide.');
        return 1;
    }

    $cleanNin = preg_replace('/[^a-zA-Z0-9]/', '', $nin);

    $user = \App\Models\Utilisateur::where('numberid', $nin)
        ->orWhereRaw("REPLACE(REPLACE(numberid, '-', ''), ' ', '') = ?", [$cleanNin])
        ->first();

    if (!$user) {
        $this->error("❌ Aucun compte trouvé avec le NIN : {$nin}");
        return 1;
    }

    $this->info('--------------------------------------------------');
    $this->info('Utilisateur trouvé :');
    $this->line("  ID        : {$user->id}");
    $this->line("  Nom       : {$user->firstname} {$user->lastname}");
    $this->line("  Username  : {$user->username}");
    $this->line("  Email     : {$user->email}");
    $this->line("  NIN (CNI) : {$user->numberid}");

    $status = $user->enabled ? '<fg=green>Actif</>' : '<fg=red>Inactif</>';
    $this->line("  Statut    : {$status}");

    $blocked = \App\Models\SecurityBlockedAccount::where('utilisateur_id', $user->id)
        ->whereNull('released_at')
        ->exists();
    if ($blocked) {
        $this->warn('  Sécurité  : Compte temporairement bloqué par le système anti-intrusion.');
    }
    $this->info('--------------------------------------------------');

    $newPassword = $this->option('password') ?: 'passer';

    // Activation et mise à jour du mot de passe
    $user->enabled = 1;
    $user->password = \Illuminate\Support\Facades\Hash::make($newPassword);
    $user->save();

    // Déblocage sécurité éventuel
    if ($blocked) {
        \App\Models\SecurityBlockedAccount::where('utilisateur_id', $user->id)
            ->whereNull('released_at')
            ->update(['released_at' => now()]);
        $this->info('🔓 Compte débloqué des restrictions de sécurité.');
    }

    $this->info('✅ Le compte est désormais ACTIF.');
    $this->info("🔑 Mot de passe réinitialisé à : <fg=yellow;options=bold>{$newPassword}</>");
    $this->line("Le candidat peut se connecter avec son identifiant ({$user->username} ou {$user->email}) et le mot de passe : {$newPassword}");

    return 0;
})->purpose('Vérifier un compte par NIN, l\'activer s\'il est inactif et réinitialiser son mot de passe');
