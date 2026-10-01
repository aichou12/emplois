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
        <a href="{{ route('admin.settings') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('admin.settings') ? 'is-active' : '' }}"
           @if(request()->routeIs('admin.settings')) aria-current="page" @endif>
            <i class="fas fa-sliders-h pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Paramètres</span>
        </a>
        <a href="{{ route('admin.security') }}"
           class="pgde-admin-nav-link {{ request()->routeIs('admin.security*') ? 'is-active' : '' }}"
           @if(request()->routeIs('admin.security*')) aria-current="page" @endif>
            <i class="fas fa-shield-alt pgde-admin-nav-icon" aria-hidden="true"></i>
            <span class="pgde-admin-nav-text">Sécurité & accès</span>
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
