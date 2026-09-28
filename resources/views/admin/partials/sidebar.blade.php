<aside class="pgde-admin-sidebar" id="pgdeAdminSidebar" aria-label="Navigation administration">
    <div class="pgde-admin-sidebar-brand">
        <a href="{{ route('admin.users') }}" class="pgde-admin-brand-link" aria-label="Tableau de bord PGDE">
            <img src="{{ asset('images/logoPGDE.png') }}" alt="Logo PGDE">
            <span class="pgde-admin-brand-copy">
                <strong>Administration</strong>
                <small>Emploi — Fonction Publique</small>
            </span>
        </a>
    </div>

    <nav class="pgde-admin-nav" aria-label="Menu principal">
        <a href="{{ route('admin.users') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('admin.users') ? 'is-active' : '' }}"
           @if(request()->routeIs('admin.users')) aria-current="page" @endif>
            <i class="fas fa-home pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Tableau de bord</span>
        </a>
        <a href="{{ route('liste.utilisateurs') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('liste.utilisateurs', 'admin.edit*') ? 'is-active' : '' }}"
           @if(request()->routeIs('liste.utilisateurs', 'admin.edit*')) aria-current="page" @endif>
            <i class="fas fa-users pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Candidats</span>
        </a>
        <a href="{{ route('admin.demandeurincomplet') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('admin.demandeurincomplet') ? 'is-active' : '' }}"
           @if(request()->routeIs('admin.demandeurincomplet')) aria-current="page" @endif>
            <i class="fas fa-folder-open pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Dossiers incomplets</span>
        </a>

        <span class="pgde-admin-nav-separator">Listes &amp; statistiques</span>
        <a href="{{ route('liste.inscrit') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('liste.inscrit') ? 'is-active' : '' }}"
           @if(request()->routeIs('liste.inscrit')) aria-current="page" @endif>
            <i class="fas fa-chart-bar pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Inscriptions</span>
        </a>
        <a href="{{ route('liste.complet') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('liste.complet') ? 'is-active' : '' }}"
           @if(request()->routeIs('liste.complet')) aria-current="page" @endif>
            <i class="fas fa-user-check pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Comptes activés</span>
        </a>
        <a href="{{ route('liste.pascomplet') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('liste.pascomplet') ? 'is-active' : '' }}"
           @if(request()->routeIs('liste.pascomplet')) aria-current="page" @endif>
            <i class="fas fa-user-clock pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Comptes non activés</span>
        </a>
        <a href="{{ route('liste.avecdiplome') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('liste.avecdiplome') ? 'is-active' : '' }}"
           @if(request()->routeIs('liste.avecdiplome')) aria-current="page" @endif>
            <i class="fas fa-graduation-cap pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Avec diplôme</span>
        </a>
        <a href="{{ route('liste.sansdiplome') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('liste.sansdiplome') ? 'is-active' : '' }}"
           @if(request()->routeIs('liste.sansdiplome')) aria-current="page" @endif>
            <i class="fas fa-book-open pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Sans diplôme</span>
        </a>
        <a href="{{ route('liste.masculin') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('liste.masculin') ? 'is-active' : '' }}"
           @if(request()->routeIs('liste.masculin')) aria-current="page" @endif>
            <i class="fas fa-mars pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Hommes</span>
        </a>
        <a href="{{ route('liste.feminin') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('liste.feminin') ? 'is-active' : '' }}"
           @if(request()->routeIs('liste.feminin')) aria-current="page" @endif>
            <i class="fas fa-venus pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Femmes</span>
        </a>
    </nav>

    <div class="pgde-admin-sidebar-footer">
        <button class="pgde-admin-collapse" type="button" data-admin-sidebar-toggle aria-label="Réduire le menu" aria-expanded="true">
            <i class="fas fa-angle-double-left" aria-hidden="true"></i>
            <span class="pgde-admin-collapse-text">Réduire le menu</span>
        </button>
    </div>
</aside>
<button class="pgde-admin-overlay" type="button" data-admin-sidebar-close aria-label="Fermer le menu" tabindex="-1"></button>
