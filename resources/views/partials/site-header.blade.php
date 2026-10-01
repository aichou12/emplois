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
            <!-- 1. GAUCHE : Drapeau, République du Sénégal, Devise (empilés) -->
            <div class="header-col-left">
                <a href="https://www.fonctionpublique.gouv.sn" target="_blank" rel="noopener noreferrer" class="senegal-logo" title="République du Sénégal">
                    <img id="logo-senegal" class="logo-senegal" src="{{ asset('images/logo-republique-du-senegal.png') }}" alt="Drapeau de la République du Sénégal">
                    <span class="rds">République du<br>Sénégal</span>
                    <span class="pbf">Un peuple, Un but, Une foi</span>
                </a>
            </div>

            <!-- 2. MILIEU : Logo + nom du Ministère (deux lignes) -->
            <div class="header-col-center">
                <a href="https://www.fonctionpublique.gouv.sn" target="_blank" rel="noopener noreferrer" class="navbar-brand-mfp" title="Ministère de la Fonction Publique, du Travail et de la Réforme du Service public">
                    <img id="logo-mfp" class="logo-mfp" src="{{ asset('images/logo_from_site_mfp.png') }}" alt="Logo Ministère de la Fonction Publique">
                    <span class="mfpnom-link">
                        <span>Ministère de la Fonction Publique, du</span>
                        <span>Travail et de la Réforme du Service public</span>
                    </span>
                </a>
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

    <!-- Bandeau gris du nom de la plateforme (style barre de menu du site du Ministère) -->
    <div class="header-title-band">
        <div class="header-container-fluid header-title-inner">
            <a href="{{ $siteHeaderUser ? route('home') : url('/') }}" class="pgde-title-link">
                Plateforme de Gestion des Demandes d'Emploi
            </a>
            <!-- Boutons jaunes : guide d'inscription + réseaux officiels du Ministère -->
            <nav class="header-quick-links" aria-label="Aide et réseaux du Ministère">
                @if (file_exists(public_path('docs/guide-inscription.pdf')))
                    <a href="{{ asset('docs/guide-inscription.pdf') }}" target="_blank" rel="noopener" class="quick-link quick-link-guide" title="Guide d'inscription (PDF)">
                        <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M12 22a10 10 0 1 1 0-20 10 10 0 0 1 0 20Zm-.1-6.2a1.2 1.2 0 1 0 0 2.4 1.2 1.2 0 0 0 0-2.4Zm.2-9.6c-2 0-3.5 1.2-3.7 3.1h2.2c.1-.8.7-1.3 1.5-1.3s1.4.5 1.4 1.2c0 .6-.3 1-1.1 1.5-1.1.7-1.6 1.4-1.5 2.7v.4h2.1v-.3c0-.7.3-1 1.2-1.6 1-.6 1.6-1.4 1.6-2.7 0-1.8-1.5-3-3.7-3Z"/></svg>
                        <span>Guide d'inscription</span>
                    </a>
                @endif
                <a href="https://www.facebook.com/fonctionpubliqueSn" target="_blank" rel="noopener noreferrer" class="quick-link" title="Facebook du Ministère">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.5c0-.9.3-1.6 1.6-1.6h1.7V4.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.4H7.3v3.2h2.8V22h3.4Z"/></svg>
                    <span class="visually-hidden">Facebook</span>
                </a>
                <a href="https://twitter.com/FpubliqueSn" target="_blank" rel="noopener noreferrer" class="quick-link" title="X (Twitter) du Ministère">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.8 3h3.1l-6.8 7.7L22 21h-6.2l-4.9-6.4L5.3 21H2.2l7.2-8.3L1.8 3h6.4l4.4 5.8L17.8 3Zm-1.1 16.2h1.7L7.4 4.7H5.6l11.1 14.5Z"/></svg>
                    <span class="visually-hidden">X (Twitter)</span>
                </a>
                <a href="https://www.youtube.com/@fpubliquesn4927" target="_blank" rel="noopener noreferrer" class="quick-link" title="YouTube du Ministère">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12a31 31 0 0 0 .5 4.8 3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1c.4-1.6.5-3.2.5-4.8s-.1-3.2-.5-4.8ZM9.7 15V9l5.8 3-5.8 3Z"/></svg>
                    <span class="visually-hidden">YouTube</span>
                </a>
                <a href="https://www.linkedin.com/company/minist%C3%A8re-de-la-fonction-publique-et-de-la-transformation-du-secteur-public/" target="_blank" rel="noopener noreferrer" class="quick-link" title="LinkedIn du Ministère">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.9 21H2.6V8.7h4.3V21ZM4.7 7a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5ZM21.5 21h-4.3v-6c0-1.4 0-3.3-2-3.3s-2.3 1.6-2.3 3.2V21H8.6V8.7h4.1v1.7h.1c.6-1.1 2-2.2 4-2.2 4.3 0 5.1 2.8 5.1 6.5V21Z"/></svg>
                    <span class="visually-hidden">LinkedIn</span>
                </a>
            </nav>
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
        height: 4px;
        width: 100%;
        background: linear-gradient(90deg, #00853F 0 33.33%, #FDEF42 33.33% 66.66%, #E31B23 66.66% 100%);
    }

    /* Tailles fluides : elles suivent la largeur d'écran entre un minimum et un maximum */
    .header-container-fluid {
        width: 100%;
        max-width: 1200px; /* aligné sur le contenu des pages */
        margin: 0 auto;
        padding: 0 clamp(14px, 2vw, 20px);
    }

    /* Ligne institutionnelle : Sénégal | Ministère | Compte */
    .header-main-row {
        display: grid;
        grid-template-columns: auto 1fr auto;
        align-items: stretch;
        min-height: clamp(76px, 7.5vw, 96px);
    }

    /* 1. Gauche : bloc République empilé et centré, séparé par un filet */
    .header-col-left {
        display: flex;
        align-items: center;
        padding: 10px clamp(14px, 2.2vw, 28px) 10px 0;
        border-right: 1px solid #e5e7eb;
    }

    .senegal-logo {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 6px;
        text-align: center;
        text-decoration: none;
    }

    .logo-senegal {
        width: auto;
        height: clamp(30px, 3vw, 40px);
        object-fit: contain;
        display: block;
    }

    .rds {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(11px, 1vw, 13px);
        font-weight: 700;
        line-height: 1.3;
        color: #1a1a1a;
        letter-spacing: 0.04em;
        text-transform: uppercase;
    }

    .pbf {
        font-size: clamp(10px, 0.85vw, 11.5px);
        font-weight: 400;
        color: #3d3d3d;
        letter-spacing: 0.03em;
    }

    /* 2. Centre : Ministère, logo + nom en capitales sur deux lignes */
    .header-col-center {
        display: flex;
        align-items: center;
        padding: 10px clamp(14px, 2.2vw, 28px);
        min-width: 0;
    }

    .navbar-brand-mfp {
        display: flex;
        align-items: center;
        gap: clamp(10px, 1.3vw, 16px);
        text-decoration: none;
        min-width: 0;
    }

    .logo-mfp {
        width: auto;
        height: clamp(44px, 5vw, 64px);
        max-width: 140px;
        flex-shrink: 0;
        object-fit: contain;
        display: block;
    }

    .mfpnom-link {
        display: flex;
        flex-direction: column;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(12px, 1.25vw, 16px);
        font-weight: 600;
        line-height: 1.45;
        color: #1a1a1a;
        letter-spacing: 0.03em;
        text-transform: uppercase;
        transition: color 0.15s ease;
    }

    .navbar-brand-mfp:hover .mfpnom-link {
        color: #00853F;
    }

    /* 3. Droite : Compte / Connexion */
    .header-col-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        padding-left: clamp(10px, 1.5vw, 18px);
    }

    /* Bandeau gris du nom de la plateforme */
    .header-title-band {
        background: #f2f2f2;
    }

    .header-title-inner {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        min-height: clamp(46px, 4.2vw, 54px);
    }

    .pgde-title-link {
        font-family: 'Poppins', sans-serif;
        font-size: clamp(13px, 1.2vw, 16px);
        font-weight: 700;
        color: #00853F;
        text-decoration: none;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        line-height: 1.3;
        transition: color 0.15s ease;
    }

    .pgde-title-link:hover {
        color: #006B32;
    }

    /* Boutons jaunes carrés, comme les réseaux sociaux du site officiel */
    .header-quick-links {
        display: flex;
        align-items: center;
        gap: clamp(6px, 0.7vw, 10px);
        flex-shrink: 0;
    }

    .quick-link {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        width: clamp(32px, 2.8vw, 36px);
        height: clamp(32px, 2.8vw, 36px);
        background: #F7C600;
        color: #1a1a1a;
        text-decoration: none;
        transition: background 0.15s ease, transform 0.15s ease;
    }

    .quick-link:hover,
    .quick-link:focus-visible {
        background: #00853F;
        color: #ffffff;
        transform: translateY(-2px);
    }

    .quick-link:focus-visible {
        outline: 2px solid #1a1a1a;
        outline-offset: 2px;
    }

    .quick-link svg {
        width: 46%;
        height: 46%;
        fill: currentColor;
        flex-shrink: 0;
    }

    /* Le guide porte un libellé, il est donc plus large */
    .quick-link-guide {
        width: auto;
        padding: 0 clamp(10px, 1vw, 14px);
        font-family: 'Poppins', sans-serif;
        font-size: clamp(10.5px, 0.85vw, 12px);
        font-weight: 700;
        letter-spacing: 0.05em;
        text-transform: uppercase;
        white-space: nowrap;
    }

    .quick-link-guide svg {
        width: 20px;
        height: 20px;
    }

    .visually-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0 0 0 0);
        white-space: nowrap;
    }

    .btn-header-login {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: clamp(7px, 0.7vw, 9px) clamp(14px, 1.5vw, 20px);
        border-radius: 3px;
        background: #00853F;
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(12px, 0.95vw, 13px);
        font-weight: 600;
        letter-spacing: 0.06em;
        white-space: nowrap;
        text-transform: uppercase;
        text-decoration: none;
        transition: background 0.2s ease;
    }

    .btn-header-login:hover {
        background: #006B32;
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
    /* Écrans moyens : compte réduit à l'avatar */
    @media (max-width: 1200px) {
        .site-header-account summary { min-width: 0; padding: 4px 6px; }
        .account-summary-text { display: none; }
    }

    /* Mobile : Sénégal + compte sur la 1re ligne, Ministère en dessous */
    @media (max-width: 680px) {
        .header-main-row {
            grid-template-columns: 1fr auto;
            grid-template-areas: "left right" "center center";
            min-height: 0;
        }
        .header-col-left { grid-area: left; border-right: 0; padding: 10px 0; }
        .senegal-logo { flex-direction: row; text-align: left; gap: 10px; }
        .senegal-logo .pbf { display: none; }
        .header-col-right { grid-area: right; }
        .header-col-center { grid-area: center; padding: 10px 0; border-top: 1px solid #e5e7eb; }
        .logo-senegal { height: 34px; }
        .rds { font-size: 12px; }
        .logo-mfp { height: 44px; }
        .mfpnom-link { font-size: 12px; letter-spacing: 0.02em; }
        .pgde-title-link { font-size: 14px; letter-spacing: 0.04em; }
        .quick-link-guide span { display: none; }
        .quick-link-guide { width: 34px; padding: 0; }
        .quick-link { width: 34px; height: 34px; }
        .header-quick-links { gap: 6px; }
    }

    /* Très petits écrans : le nom du ministère passe sur plusieurs lignes */
    @media (max-width: 420px) {
        .header-title-inner { flex-wrap: wrap; justify-content: center; padding-top: 8px; padding-bottom: 8px; text-align: center; }
        .mfpnom-link { font-size: 11px; }
        .mfpnom-link span { display: inline; }
        .mfpnom-link { display: block; }
        .logo-mfp { height: 38px; }
        .pgde-title-link { font-size: 12.5px; letter-spacing: 0.02em; }
        .btn-header-login { padding: 8px 12px; font-size: 11px; }
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
