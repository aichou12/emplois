@php
    $siteHeaderUser = auth()->user();
    $siteHeaderIsAdmin = $siteHeaderUser && $siteHeaderUser->hasRole('admin');
    $siteHeaderAccountName = $siteHeaderUser
        ? trim(($siteHeaderUser->firstname ?? '') . ' ' . ($siteHeaderUser->lastname ?? ''))
        : '';
    $siteHeaderRegistrationNumber = request()->routeIs('userdata.edit') && isset($userdata)
        ? $userdata->utilisateur_id
        : null;
    if ($siteHeaderAccountName === '' && $siteHeaderUser) {
        $siteHeaderAccountName = $siteHeaderUser->username ?? 'Mon compte';
    }
    $siteHeaderInitial = $siteHeaderUser
        ? mb_strtoupper(mb_substr($siteHeaderAccountName, 0, 1))
        : '';
@endphp

@if ($siteHeaderIsAdmin)
    <style>
        .site-header { display: none !important; }
        .main-header-logo { display: none !important; }
        .main-header .navbar .profile-pic { display: none !important; }
        .main-header .navbar .dropdown-menu {
            position: static !important;
            display: block !important;
            float: none !important;
            min-width: 0;
            margin: 0;
            padding: 0;
            border: 0;
            background: transparent;
            box-shadow: none;
        }
        .main-header .navbar .dropdown-item {
            display: inline-flex;
            width: auto;
            align-items: center;
            padding: 9px 13px;
            border: 1px solid #f0d9d7;
            border-radius: 9px;
            color: #a83232 !important;
            background: #fff;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
        }
        .main-header .navbar .dropdown-item:hover { border-color: #ebc2bf; background: #fff5f4; }
        .pgde-admin-main .main-header .navbar .container-fluid { justify-content: space-between; }
    </style>
@else
<header class="site-header">
    <!-- Ligne tricolore institutionnelle Sénégal -->
    <div class="header-tricolor-bar"></div>

    <div class="header-container-fluid">
        <div class="header-main-row">
            <!-- 1. GAUCHE : Logo République du Sénégal + Devise -->
            <div class="header-col-senegal">
                <a href="https://www.fonctionpublique.gouv.sn" target="_blank" rel="noopener noreferrer" class="senegal-logo" title="République du Sénégal">
                    <img id="logo-senegal" class="logo-senegal" src="{{ asset('images/logo-republique-du-senegal.png') }}" alt="Logo République du Sénégal">
                    <div class="senegal-labels">
                        <span class="rds">République du Sénégal</span>
                        <span class="pbf">Un peuple, Un but, Une foi</span>
                    </div>
                </a>
            </div>

            <!-- 2. MILIEU : Ministère de la Fonction Publique & Plateforme de Gestion des Demandes d'Emploi -->
            <div class="header-col-center">
                <div class="navbar-header-custom">
                    <a href="https://www.fonctionpublique.gouv.sn" target="_blank" rel="noopener noreferrer" class="navbar-brand-mfp" title="Ministère de la Fonction Publique">
                        <img id="logo-mfp" class="logo-mfp" src="{{ asset('images/logo_from_site_mfp.png') }}" alt="Logo Ministère de la Fonction Publique">
                    </a>

                    <div class="brand-text-block">
                        <a href="https://www.fonctionpublique.gouv.sn" target="_blank" rel="noopener noreferrer" class="mfpnom-link">
                            Ministère de la Fonction Publique, du Travail et de la Réforme du Service public
                        </a>
                        <a href="{{ $siteHeaderUser ? route('home') : url('/') }}" class="pgde-title-link">
                            Plateforme de Gestion des Demandes d'Emploi
                        </a>
                    </div>
                </div>
            </div>

            <!-- 3. DROITE : Compte ou Connexion -->
            <div class="header-col-right">
                @if ($siteHeaderUser)
                    <details class="site-header-account">
                        <summary aria-label="Ouvrir le menu du compte de {{ $siteHeaderAccountName }}">
                            <span class="account-avatar" aria-hidden="true">{{ $siteHeaderInitial }}</span>
                            <span class="account-summary-text">
                                <span class="account-summary-caption">Mon compte</span>
                                <span class="account-summary-name">{{ $siteHeaderAccountName }}</span>
                            </span>
                            <svg class="account-chevron" viewBox="0 0 20 20" aria-hidden="true"><path d="m5 7.5 5 5 5-5" /></svg>
                        </summary>
                        <div class="site-header-account-menu">
                            <div class="account-menu-heading">
                                <span class="account-menu-avatar" aria-hidden="true">{{ $siteHeaderInitial }}</span>
                                <div class="account-menu-identity">
                                    <span>{{ $siteHeaderAccountName }}</span>
                                    <small>{{ $siteHeaderIsAdmin ? 'Espace administration' : 'Espace usager' }}</small>
                                </div>
                            </div>
                            @if ($siteHeaderRegistrationNumber)
                                <div class="account-registration-number">
                                    <span>Numéro d’inscription</span>
                                    <strong>{{ $siteHeaderRegistrationNumber }}</strong>
                                </div>
                            @endif
                            <a class="account-action-password" href="{{ route('password.edit') }}">
                                <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M4 8V6a6 6 0 0 1 12 0v2M3 8h14v10H3zM10 12v2" /></svg>
                                Modifier le mot de passe
                            </a>
                            <a class="account-action-logout" href="{{ route('logout') }}">
                                <svg viewBox="0 0 20 20" aria-hidden="true"><path d="M8 3H4v14h4M11 6l4 4-4 4m4-4H7" /></svg>
                                Déconnexion
                            </a>
                        </div>
                    </details>
                @elseif (!request()->routeIs('login'))
                    <a href="{{ route('login') }}" class="btn-header-login" title="Se connecter">
                        <i class="fas fa-sign-in-alt me-1"></i> <span>Connexion</span>
                    </a>
                @endif
            </div>
        </div>
    </div>
</header>

<style>
    /* =========================================================================
       HEADER INSTITUTIONNEL ÉPURÉ & AÉRÉ (STYLE FONCTION PUBLIQUE SÉNÉGAL)
       ========================================================================= */
    .site-header {
        width: 100%;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0, 75, 43, 0.05);
        position: relative;
        z-index: 1000;
        font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Ligne tricolore Sénégal */
    .header-tricolor-bar {
        height: 3.5px;
        width: 100%;
        background: linear-gradient(90deg, #008C45 0%, #008C45 33.3%, #FFC107 33.3%, #FFC107 66.6%, #ED2939 66.6%, #ED2939 100%);
    }

    .header-container-fluid {
        width: 100%;
        max-width: 1440px;
        margin: 0 auto;
        padding: 12px 28px;
    }

    .header-main-row {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
    }

    /* 1. Colonne Gauche : République du Sénégal */
    .header-col-senegal {
        flex: 0 0 auto;
    }

    .senegal-logo {
        display: flex;
        align-items: center;
        gap: 12px;
        text-decoration: none;
    }

    .logo-senegal {
        width: 72px;
        height: auto;
        max-height: 78px;
        object-fit: contain;
        display: block;
        transition: transform 0.2s ease;
    }

    .logo-senegal:hover {
        transform: scale(1.04);
    }

    .senegal-labels {
        display: flex;
        flex-direction: column;
        line-height: 1.3;
    }

    .rds {
        font-family: 'Poppins', sans-serif;
        font-size: 16px;
        font-weight: 700;
        color: #0f172a;
        letter-spacing: 0.5px;
        text-transform: uppercase;
        display: block;
    }

    .pbf {
        font-size: 13px;
        font-weight: 600;
        color: #008C45;
        font-style: italic;
        margin-top: 4px;
        display: block;
    }

    /* 2. Colonne Milieu : Ministère & Titre Plateforme */
    .header-col-center {
        flex: 1 1 auto;
        display: flex;
        justify-content: center;
        min-width: 0;
    }

    .navbar-header-custom {
        display: flex;
        align-items: center;
        gap: 20px;
        text-align: left;
    }

    .navbar-brand-mfp {
        display: flex;
        align-items: center;
        text-decoration: none;
        flex-shrink: 0;
    }

    .logo-mfp {
        width: auto;
        height: 78px;
        max-width: 170px;
        object-fit: contain;
        display: block;
    }

    .brand-text-block {
        display: flex;
        flex-direction: column;
        justify-content: center;
        min-width: 0;
        gap: 5px;
    }

    .mfpnom-link {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        font-weight: 600;
        color: #334155;
        text-decoration: none;
        letter-spacing: 0.2px;
        line-height: 1.4;
        transition: color 0.15s ease;
    }

    .mfpnom-link:hover {
        color: #008C45;
    }

    .pgde-title-link {
        font-family: 'Poppins', sans-serif;
        font-size: 21px;
        font-weight: 800;
        color: #008C45;
        text-decoration: none;
        line-height: 1.25;
        letter-spacing: -0.3px;
        transition: color 0.15s ease;
    }

    .pgde-title-link:hover {
        color: #006B35;
    }

    /* 3. Colonne Droite : Compte / Connexion */
    .header-col-right {
        flex: 0 0 auto;
        display: flex;
        justify-content: flex-end;
        align-items: center;
    }

    .btn-header-login {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 7px 16px;
        border-radius: 8px;
        background: #008C45;
        border: 1px solid #008C45;
        color: #ffffff;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.2s ease;
    }

    .btn-header-login:hover {
        background: #006B35;
        border-color: #006B35;
        color: #ffffff;
    }

    /* Menu compte connecté */
    .site-header-account {
        position: relative;
        color: #1e293b;
    }

    .site-header-account summary {
        display: flex;
        align-items: center;
        gap: 9px;
        min-width: 175px;
        max-width: 250px;
        padding: 5px 10px 5px 6px;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        background: #ffffff;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.04);
        cursor: pointer;
        list-style: none;
        transition: all 0.15s ease;
    }

    .site-header-account summary::-webkit-details-marker { display: none; }

    .site-header-account summary:hover,
    .site-header-account[open] summary {
        border-color: #008C45;
        background: #fbfdfb;
        box-shadow: 0 3px 10px rgba(0, 140, 69, 0.09);
    }

    .account-avatar {
        display: grid;
        width: 32px;
        height: 32px;
        flex: 0 0 32px;
        place-items: center;
        border-radius: 50%;
        background: #e8f5e9;
        color: #008C45;
        font-size: 13px;
        font-weight: 700;
    }

    .account-summary-text {
        display: flex;
        min-width: 0;
        flex: 1;
        flex-direction: column;
        text-align: left;
    }

    .account-summary-caption {
        color: #64748b;
        font-size: 9px;
        font-weight: 600;
        line-height: 1.2;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .account-summary-name {
        overflow: hidden;
        color: #1e293b;
        font-size: 11.5px;
        font-weight: 700;
        line-height: 1.35;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .account-chevron {
        width: 15px;
        height: 15px;
        flex: 0 0 15px;
        fill: none;
        stroke: #64748b;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
        transition: transform 0.15s ease;
    }

    .site-header-account[open] .account-chevron {
        transform: rotate(180deg);
    }

    .site-header-account-menu {
        position: absolute;
        top: calc(100% + 8px);
        right: 0;
        z-index: 1100;
        width: 275px;
        padding: 8px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        background: #ffffff;
        box-shadow: 0 14px 32px rgba(0, 0, 0, 0.1);
    }

    .account-menu-heading {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        border: 1px solid #eef2f6;
        border-radius: 10px;
        background: #f8fafc;
    }

    .account-menu-avatar {
        display: grid;
        width: 36px;
        height: 36px;
        flex: 0 0 36px;
        place-items: center;
        border: 1px solid #d1e7dd;
        border-radius: 10px;
        background: #ffffff;
        color: #008C45;
        font-size: 14px;
        font-weight: 700;
    }

    .account-menu-identity {
        display: flex;
        min-width: 0;
        flex-direction: column;
        gap: 2px;
    }

    .account-menu-identity span {
        overflow: hidden;
        color: #1e293b;
        font-size: 12.5px;
        font-weight: 700;
        text-overflow: ellipsis;
        white-space: nowrap;
    }

    .account-menu-identity small {
        color: #64748b;
        font-size: 10px;
        font-weight: 500;
    }

    .account-registration-number {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 10px;
        margin: 8px 0 6px;
        padding: 8px 10px;
        border-left: 3px solid #008C45;
        border-radius: 6px;
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
    }

    .account-registration-number strong {
        color: #1e293b;
        font-size: 12px;
        font-weight: 700;
    }

    .site-header-account-menu > a {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 8px 10px;
        border-radius: 8px;
        color: #334155;
        font-size: 11.5px;
        font-weight: 600;
        text-decoration: none;
        transition: all 0.15s ease;
    }

    .account-action-password {
        color: #008C45 !important;
    }

    .account-action-password:hover {
        background: #f0fdf4;
    }

    .account-action-logout {
        margin-top: 3px;
        border-top: 1px solid #f1f5f9;
        color: #dc2626 !important;
    }

    .account-action-logout:hover {
        background: #fef2f2;
    }

    .site-header-account-menu svg {
        width: 17px;
        height: 17px;
        flex: 0 0 17px;
        padding: 2px;
        border-radius: 5px;
        background: #f1f5f9;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.6;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* =========================================================================
       RESPONSIVE DESIGN (TABLETTES ET MOBILES)
       ========================================================================= */
    @media (max-width: 1024px) {
        .header-container-fluid {
            padding: 10px 18px;
        }
        .header-main-row {
            gap: 16px;
        }
        .mfpnom-link {
            font-size: 10.5px;
        }
        .pgde-title-link {
            font-size: 14.5px;
        }
    }

    @media (max-width: 860px) {
        .header-main-row {
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .header-col-senegal {
            order: 1;
        }
        .header-col-right {
            order: 2;
        }
        .header-col-center {
            order: 3;
            flex: 1 1 100%;
            justify-content: flex-start;
            border-top: 1px solid #f1f5f9;
            padding-top: 10px;
            margin-top: 4px;
        }
    }

    @media (max-width: 600px) {
        .logo-senegal {
            width: 36px;
        }
        .rds {
            font-size: 11px;
        }
        .pbf {
            font-size: 9px;
        }
        .logo-mfp {
            height: 42px;
        }
        .navbar-header-custom {
            gap: 10px;
        }
        .mfpnom-link {
            font-size: 9.5px;
        }
        .pgde-title-link {
            font-size: 13px;
        }
        .site-header-account summary {
            min-width: 0;
            padding: 4px 6px;
        }
        .account-summary-text {
            display: none;
        }
    }

    @media print {
        .site-header { display: none !important; }
    }
</style>

<script>
    (() => {
        const accountMenus = document.querySelectorAll('.site-header-account');
        if (!accountMenus.length) return;

        document.addEventListener('click', event => {
            accountMenus.forEach(menu => {
                if (menu.open && !menu.contains(event.target)) menu.open = false;
            });
        });

        document.addEventListener('keydown', event => {
            if (event.key !== 'Escape') return;
            accountMenus.forEach(menu => {
                if (menu.open) {
                    menu.open = false;
                    menu.querySelector('summary')?.focus();
                }
            });
        });
    })();
</script>
@endif
