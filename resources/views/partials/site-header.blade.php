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
    <div class="header-container-fluid">
        <div class="header-main-row">
            <!-- 1. GAUCHE : logo + nom du Ministère -->
            <div class="header-col-left">
                <a href="https://www.fonctionpublique.gouv.sn" target="_blank" rel="noopener noreferrer" class="navbar-brand-mfp" title="Ministère de la Fonction Publique, du Travail et de la Réforme du Service public">
                    <img id="logo-mfp" class="logo-mfp" src="{{ asset('images/logo_from_site_mfp.png') }}" alt="Logo Ministère de la Fonction Publique">
                    <span class="mfpnom-link">
                        <span>Ministère de la Fonction Publique, du Travail</span>
                        <span>et de la Réforme du Service public</span>
                    </span>
                </a>
            </div>

            <!-- 2. MILIEU : nom de la plateforme -->
            <div class="header-col-center">
                <a href="{{ $siteHeaderUser ? route('home') : url('/') }}" class="pgde-title-link">
                    Plateforme de Gestion des Demandes d'Emploi à la Fonction publique
                </a>
            </div>

            <!-- 3. DROITE : Guide du candidat + Mon dossier / Connexion -->
            <div class="header-col-right">
                @if ($siteHeaderUser)
                    @unless (request()->routeIs('guide'))
                        <a href="{{ route('guide') }}" class="btn-header-action is-outline" title="Guide du candidat">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5zM4 20.5A2.5 2.5 0 0 0 6.5 23H20v-5M8 7h8M8 11h6" /></svg>
                            <span>Guide</span>
                        </a>
                    @endunless
                    @unless (request()->routeIs('userdata.create', 'userdata.edit'))
                        <a href="{{ route('home') }}" class="btn-header-action" title="Accéder à mon dossier de demande d'emploi">
                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 4h6l2 2h8v14H4z M8 12h8 M8 16h5" /></svg>
                            <span>Mon dossier</span>
                        </a>
                    @endunless
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
                @else
                    {{-- Visiteur : action principale verte + lien discret de connexion --}}
                    <div class="header-guest-actions">
                        @unless (request()->routeIs('guide'))
                            <a href="{{ route('guide') }}" class="btn-header-action" title="Conditions, étapes, documents et questions fréquentes">
                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 5.5A2.5 2.5 0 0 1 6.5 3H20v15H6.5A2.5 2.5 0 0 0 4 20.5zM4 20.5A2.5 2.5 0 0 0 6.5 23H20v-5M8 7h8M8 11h6" /></svg>
                                <span>Guide du candidat</span>
                                <svg class="btn-header-arrow" viewBox="0 0 24 24" aria-hidden="true"><path d="M5 12h14M13 6l6 6-6 6" /></svg>
                            </a>
                        @endunless
                        {{-- Connexion et inscription ont déjà leur propre lien dans la page --}}
                        @if (!request()->routeIs('login', 'register'))
                            <a href="{{ route('login') }}" class="header-login-link">Se connecter</a>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Bandeau gris : réseaux officiels du Ministère -->
    <div class="header-title-band">
        <div class="header-container-fluid header-title-inner">
            <!-- Boutons jaunes : guide d'inscription + réseaux officiels du Ministère -->
            <nav class="header-quick-links" aria-label="Réseaux sociaux du Ministère">
                <a href="{{ config('social.facebook') }}" target="_blank" rel="noopener noreferrer" class="quick-link" title="Facebook du Ministère">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M13.5 22v-8.2h2.8l.4-3.2h-3.2V8.5c0-.9.3-1.6 1.6-1.6h1.7V4.1c-.3 0-1.3-.1-2.5-.1-2.5 0-4.2 1.5-4.2 4.3v2.4H7.3v3.2h2.8V22h3.4Z"/></svg>
                    <span class="visually-hidden">Facebook</span>
                </a>
                <a href="{{ config('social.twitter') }}" target="_blank" rel="noopener noreferrer" class="quick-link" title="X (Twitter) du Ministère">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M17.8 3h3.1l-6.8 7.7L22 21h-6.2l-4.9-6.4L5.3 21H2.2l7.2-8.3L1.8 3h6.4l4.4 5.8L17.8 3Zm-1.1 16.2h1.7L7.4 4.7H5.6l11.1 14.5Z"/></svg>
                    <span class="visually-hidden">X (Twitter)</span>
                </a>
                <a href="{{ config('social.youtube') }}" target="_blank" rel="noopener noreferrer" class="quick-link" title="YouTube du Ministère">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M23 7.2a3 3 0 0 0-2.1-2.1C19 4.6 12 4.6 12 4.6s-7 0-8.9.5A3 3 0 0 0 1 7.2 31 31 0 0 0 .5 12a31 31 0 0 0 .5 4.8 3 3 0 0 0 2.1 2.1c1.9.5 8.9.5 8.9.5s7 0 8.9-.5a3 3 0 0 0 2.1-2.1c.4-1.6.5-3.2.5-4.8s-.1-3.2-.5-4.8ZM9.7 15V9l5.8 3-5.8 3Z"/></svg>
                    <span class="visually-hidden">YouTube</span>
                </a>
                <a href="{{ config('social.linkedin') }}" target="_blank" rel="noopener noreferrer" class="quick-link" title="LinkedIn du Ministère">
                    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M6.9 21H2.6V8.7h4.3V21ZM4.7 7a2.5 2.5 0 1 1 0-5 2.5 2.5 0 0 1 0 5ZM21.5 21h-4.3v-6c0-1.4 0-3.3-2-3.3s-2.3 1.6-2.3 3.2V21H8.6V8.7h4.1v1.7h.1c.6-1.1 2-2.2 4-2.2 4.3 0 5.1 2.8 5.1 6.5V21Z"/></svg>
                    <span class="visually-hidden">LinkedIn</span>
                </a>
            </nav>
        </div>
    </div>

</header>

<!-- Polices du header : chargées ici car toutes les pages ne les incluent pas (ex. dossier candidat) -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">

<style>
    /* =========================================================================
       HEADER INSTITUTIONNEL ÉPURÉ & AÉRÉ (STYLE FONCTION PUBLIQUE SÉNÉGAL)
       ========================================================================= */
    /* Le header calcule ses tailles lui-même, quelle que soit la page qui l'inclut */
    .site-header,
    .site-header *,
    .site-header *::before,
    .site-header *::after { box-sizing: border-box; }

    .site-header {
        width: 100%;
        background: #ffffff;
        border-bottom: 1px solid #e2e8f0;
        box-shadow: 0 2px 10px rgba(0, 75, 43, 0.05);
        position: relative;
        z-index: 1000;
        font-family: 'DM Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
    }

    /* Tailles fluides : elles suivent la largeur d'écran entre un minimum et un maximum */
    .header-container-fluid {
        width: 100%;
        max-width: 1200px; /* aligné sur le contenu des pages */
        margin: 0 auto;
        padding: 0 clamp(14px, 2vw, 20px);
    }

    /* Ligne principale : Ministère | nom de la plateforme (centré) | actions */
    .header-main-row {
        display: grid;
        grid-template-columns: auto minmax(0, 1fr) auto;
        gap: clamp(12px, 1.6vw, 24px);
        align-items: stretch;
        min-height: clamp(60px, 5.2vw, 68px);
    }

    /* Gauche : logo + nom du Ministère */
    .header-col-left {
        display: flex;
        align-items: center;
        padding: 6px 0;
        min-width: 0;
    }

    /* Nom du ministère sur deux lignes */
    .mfpnom-link {
        display: flex;
        flex-direction: column;
        min-width: 0;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(10px, 0.8vw, 11.5px);
        font-weight: 600;
        line-height: 1.4;
        color: #1a1a1a;
        letter-spacing: 0.02em;
        text-transform: uppercase;
        transition: color 0.15s ease;
    }

    .mfpnom-link span { white-space: nowrap; }

    .navbar-brand-mfp:hover .mfpnom-link { color: #008C45; }

    /* Milieu : nom de la plateforme centré */
    .header-col-center {
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 6px 0;
        min-width: 0;
        justify-self: center;
        max-width: 560px;
        text-align: center;
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
        height: clamp(38px, 3.8vw, 50px);
        max-width: 140px;
        flex-shrink: 0;
        object-fit: contain;
        display: block;
    }

    /* 3. Droite : Compte / Connexion */
    .header-col-right {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 12px;
        padding-left: clamp(10px, 1.5vw, 18px);
    }

    /* Bandeau gris du nom de la plateforme */
    .header-title-band {
        background: #f2f2f2;
    }

    .header-title-inner {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        gap: 20px;
        min-height: clamp(38px, 3.2vw, 42px);
    }

    /* Nom de la plateforme : même police que le nom du ministère (Poppins) */
    .pgde-title-link {
        font-family: 'Poppins', sans-serif;
        text-transform: uppercase;
        font-size: clamp(12.5px, 1.1vw, 15px);
        font-weight: 600;
        color: #000000;
        text-decoration: none;
        letter-spacing: -0.005em;
        line-height: 1.3;
        text-wrap: balance;
        transition: color 0.15s ease;
    }

    .pgde-title-link:hover {
        color: #006B35;
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
        width: clamp(28px, 2.3vw, 30px);
        height: clamp(28px, 2.3vw, 30px);
        background: #F7C600;
        color: #1a1a1a;
        text-decoration: none;
        transition: background 0.15s ease, transform 0.15s ease;
    }

    .quick-link:hover,
    .quick-link:focus-visible {
        background: #008C45;
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

    .visually-hidden {
        position: absolute;
        width: 1px;
        height: 1px;
        overflow: hidden;
        clip: rect(0 0 0 0);
        white-space: nowrap;
    }

    /* Boutons du header : même style que les boutons de connexion (dégradé, coins arrondis, flèche) */
    .btn-header-action {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        min-height: 40px;
        padding: 0 clamp(14px, 1.4vw, 18px);
        border-radius: 10px;
        background: linear-gradient(180deg, #009A4C 0%, #008C45 100%);
        color: #ffffff;
        font-family: 'Poppins', sans-serif;
        font-size: clamp(12.5px, 0.95vw, 13.5px);
        font-weight: 600;
        letter-spacing: .01em;
        white-space: nowrap;
        text-decoration: none;
        box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset, 0 6px 16px rgba(0, 140, 69, .24);
        transition: background .2s ease, box-shadow .2s ease, transform .12s ease;
    }

    .btn-header-action:hover,
    .btn-header-action:focus-visible {
        background: linear-gradient(180deg, #008C45 0%, #006B35 100%);
        color: #ffffff;
        box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset, 0 8px 20px rgba(0, 140, 69, .3);
    }

    .btn-header-action:active { transform: translateY(1px); }

    .btn-header-action:focus-visible {
        outline: 3px solid rgba(0, 140, 69, .35);
        outline-offset: 2px;
    }

    .btn-header-action svg.btn-header-arrow {
        width: 15px;
        height: 15px;
        opacity: .85;
        transition: transform .2s ease;
    }

    .btn-header-action:hover svg.btn-header-arrow { transform: translateX(4px); }

    .btn-header-action svg {
        width: 16px;
        height: 16px;
        flex-shrink: 0;
        fill: none;
        stroke: currentColor;
        stroke-width: 1.8;
        stroke-linecap: round;
        stroke-linejoin: round;
    }

    /* Variante contour, pour l'action secondaire (Guide quand on est connecté) */
    .btn-header-action.is-outline {
        background: #5b6b62;
        color: #ffffff;
        box-shadow: 0 4px 12px rgba(40, 52, 45, .16);
    }

    .btn-header-action.is-outline:hover,
    .btn-header-action.is-outline:focus-visible {
        background: #46534b;
        color: #ffffff;
    }

    /* Visiteur : bouton vert + lien de connexion empilés */
    .header-guest-actions {
        display: flex;
        flex-direction: column;
        align-items: flex-end;
        gap: 6px;
    }

    .header-login-link {
        font-size: clamp(11.5px, 0.9vw, 12.5px);
        font-weight: 600;
        color: #33443a;
        text-decoration: underline;
        text-decoration-color: #c9d6cd;
        text-underline-offset: 3px;
        white-space: nowrap;
    }

    .header-login-link:hover {
        color: #008C45;
        text-decoration-color: #008C45;
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
    /* =========================================================================
       RESPONSIVE
       > 1200 px : 3 colonnes complètes
       ≤ 1200 px : compte réduit à l'avatar
       ≤ 960 px  : 2 lignes (Sénégal + actions / Ministère pleine largeur)
       ≤ 600 px  : téléphone, boutons en icônes, bandeau titre sur 2 lignes
       ≤ 380 px  : petits téléphones
       ========================================================================= */
    /* Compte en mode compact (avatar) : le nom complet est affiché dans le menu déroulant */
    .site-header-account summary { min-width: 0; padding: 4px 6px; }
    .account-summary-text { display: none; }

    /* Tablettes : nom du ministère masqué, le logo reste */
    @media (max-width: 960px) {
        .header-main-row { min-height: 0; }
        .header-col-left,
        .header-col-center { padding: 8px 0; }
        .logo-mfp { height: 40px; }
        .mfpnom-link { display: none; }
    }

    /* Téléphones */
    @media (max-width: 600px) {
        .header-container-fluid { padding: 0 14px; }

        /* Actions : boutons réduits à l'icône, lien de connexion à côté */
        .header-guest-actions { flex-direction: row; align-items: center; gap: 10px; }
        .header-login-link { font-size: 12px; }
        .btn-header-action span { display: none; }
        .btn-header-action { min-height: 36px; padding: 0 9px; }
        .btn-header-action svg.btn-header-arrow { display: none; }
        .btn-header-action svg { width: 17px; height: 17px; }
        .header-col-right { gap: 8px; }

        /* Ligne 1 : logo + actions ; ligne 2 : nom de la plateforme centré */
        .header-main-row {
            grid-template-columns: minmax(0, 1fr) auto;
            grid-template-areas:
                "left right"
                "center center";
            gap: 0 12px;
        }
        .header-col-left { grid-area: left; }
        .header-col-right { grid-area: right; }
        .header-col-center {
            grid-area: center;
            max-width: none;
            border-top: 1px solid #eef1ef;
        }
        .logo-mfp { height: 34px; }

        .header-title-inner { min-height: 0; padding-top: 6px; padding-bottom: 6px; }
        .pgde-title-link { font-size: 13px; }
        .header-quick-links { gap: 6px; }
        .quick-link { width: 26px; height: 26px; }

    }

    /* Petits téléphones */
    @media (max-width: 380px) {
        .header-login-link { font-size: 11.5px; }
        .logo-mfp { height: 30px; }
        .pgde-title-link { font-size: 12px; }
        .quick-link { width: 24px; height: 24px; }
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
