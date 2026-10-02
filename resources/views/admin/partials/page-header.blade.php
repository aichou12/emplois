@php
    $adminRouteName = request()->route()?->getName() ?? '';
    $adminPageHeader = match (true) {
        $adminRouteName === 'admin.users' => ['Tableau de bord', 'Vue d’ensemble des inscriptions et des dossiers candidats'],
        $adminRouteName === 'liste.utilisateurs' => ['Candidats', 'Recherche, filtres, fiches et actions sur les comptes'],
        str_starts_with($adminRouteName, 'admin.communications') => ['Communications', 'Préparez et suivez vos messages destinés aux candidats'],
        str_starts_with($adminRouteName, 'admin.settings.emails') => ['Paramètres · E-mails', 'Personnalisation des e-mails automatiques envoyés aux candidats'],
        $adminRouteName === 'admin.settings' => ['Paramètres', 'Configuration de l’accès usager et de la page de connexion'],
        str_starts_with($adminRouteName, 'admin.security') => ['Sécurité & accès', 'Connexions récentes, comptes suspendus et adresses IP bloquées'],
        $adminRouteName === 'admin.demandeurincomplet' => ['Dossiers incomplets', 'Suivi des comptes qui n’ont pas encore de profil candidat'],
        $adminRouteName === 'liste.inscrit' => ['Inscriptions', 'Comptes inscrits en ' . now()->year],
        $adminRouteName === 'liste.complet' => ['Comptes activés', 'Candidats dont le compte est activé'],
        $adminRouteName === 'liste.pascomplet' => ['Comptes non activés', 'Candidats dont le compte reste à activer'],
        $adminRouteName === 'liste.avecdiplome' => ['Candidats avec diplôme', 'Profils disposant d’un diplôme renseigné'],
        $adminRouteName === 'liste.sansdiplome' => ['Candidats sans diplôme', 'Profils déclarés sans diplôme'],
        $adminRouteName === 'liste.masculin' => ['Candidats hommes', 'Profils candidats de sexe masculin'],
        $adminRouteName === 'liste.feminin' => ['Candidates femmes', 'Profils candidats de sexe féminin'],
        str_starts_with($adminRouteName, 'admin.edit') => ['Modifier un dossier candidat', 'Mise à jour des informations du candidat'],
        default => ['Administration', 'Gestion des demandeurs d’emploi'],
    };

    $adminHeaderUser = auth()->user();
    $adminHeaderName = trim(($adminHeaderUser->firstname ?? '') . ' ' . ($adminHeaderUser->lastname ?? ''));
    if ($adminHeaderName === '') {
        $adminHeaderName = $adminHeaderUser->username ?? 'Administrateur';
    }
    $adminHeaderInitial = mb_strtoupper(mb_substr($adminHeaderName, 0, 1));
@endphp

<header class="main-header pgde-page-header">
    <button class="pgde-admin-menu-toggle" type="button" data-admin-sidebar-toggle aria-label="Ouvrir le menu" aria-expanded="false">
        <i class="fas fa-bars" aria-hidden="true"></i>
    </button>

    <div class="pgde-page-heading">
        <h1>{{ $adminPageHeader[0] }}</h1>
        <p>{{ $adminPageHeader[1] }}</p>
    </div>

    <details class="pgde-admin-account">
        <summary class="pgde-admin-account-trigger" aria-label="Ouvrir le menu du compte administrateur">
            <span class="pgde-admin-account-avatar" aria-hidden="true">{{ $adminHeaderInitial }}</span>
            <span class="pgde-admin-account-copy">
                <strong>{{ $adminHeaderName }}</strong>
                <small>Administrateur</small>
            </span>
            <i class="fas fa-chevron-down pgde-admin-account-chevron" aria-hidden="true"></i>
        </summary>
        <div class="pgde-admin-account-menu">
            <a href="{{ route('logout') }}">
                <i class="fas fa-sign-out-alt" aria-hidden="true"></i>
                Déconnexion
            </a>
        </div>
    </details>
</header>
