@php
    $siteHeaderUser = auth()->user();
    $siteHeaderSubtitle = $subtitle ?? ($siteHeaderUser
        ? 'Espace personnel'
        : "Portail officiel d’enregistrement des candidats");
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

<header class="site-header">
    <div class="header-container">
        <div class="header-left-brand">
            <img src="{{ asset('images/logoPGDE.png') }}" alt="Logo PGDE" class="header-logo-pgde">
            <span class="header-left-message">Votre parcours vers la fonction publique</span>
        </div>

        <a class="header-brand" href="{{ $siteHeaderUser ? route('home') : route('login') }}" aria-label="Accueil PGDE">
            <img src="{{ asset('images/mfp.png') }}" alt="Ministère de la Fonction Publique" class="header-logo">
            <span class="header-brand-title">Plateforme de gestion des demandes d’emploi</span>
            <span class="header-brand-sub">{{ $siteHeaderSubtitle }}</span>
        </a>

        <div class="header-account-slot">
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
                                <small>Espace usager</small>
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
            @endif
        </div>
    </div>
</header>

<style>
    .site-header { width:100%; background:#fff; border-bottom:1px solid #e5e9e6; box-shadow:0 3px 14px rgba(0,75,43,.08); position:relative; z-index:100; }
    .site-header .header-container { position:relative; width:min(100%, 1320px); min-height:120px; margin:0 auto; padding:8px 24px; display:grid; grid-template-columns:minmax(190px,1fr) minmax(360px,1.7fr) minmax(220px,1fr); align-items:center; gap:16px; }
    .site-header .header-left-brand { grid-column:1; display:flex; min-width:0; flex-direction:column; align-items:flex-start; justify-content:center; }
    .site-header .header-logo-pgde { display:block; width:auto; height:68px; max-width:140px; object-fit:contain; }
    .site-header .header-left-message { margin-top:3px; color:#68736b; font-size:10px; font-weight:500; line-height:1.3; }
    .site-header .header-brand { grid-column:2; display:flex; min-width:0; flex-direction:column; align-items:center; justify-content:center; color:inherit; text-align:center; text-decoration:none; }
    .site-header .header-logo { display:block; width:auto; height:42px; max-width:140px; margin-bottom:4px; object-fit:contain; }
    .site-header .header-brand-title { color:#145f3a; font-size:16px; font-weight:700; line-height:1.25; }
    .site-header .header-brand-sub { margin-top:2px; color:#68736b; font-size:11px; font-weight:500; line-height:1.3; }
    .site-header .header-account-slot { grid-column:3; display:flex; justify-content:flex-end; min-width:0; }
    .site-header-account { position:relative; color:#26382d; }
    .site-header-account summary { display:flex; align-items:center; gap:9px; min-width:194px; max-width:260px; padding:6px 10px 6px 7px; border:1px solid #e1e9e3; border-radius:12px; background:#fff; box-shadow:0 2px 7px rgba(20,60,35,.05); cursor:pointer; list-style:none; transition:border-color .15s ease, box-shadow .15s ease, background .15s ease; }
    .site-header-account summary::-webkit-details-marker { display:none; }
    .site-header-account summary:hover, .site-header-account[open] summary { border-color:#a9cdb6; background:#fbfdfb; box-shadow:0 5px 14px rgba(20,60,35,.1); }
    .account-avatar { display:grid; width:34px; height:34px; flex:0 0 34px; place-items:center; border-radius:50%; background:#e8f4ec; color:#08723e; font-size:14px; font-weight:700; }
    .account-summary-text { display:flex; min-width:0; flex:1; flex-direction:column; text-align:left; }
    .account-summary-caption { color:#758179; font-size:10px; font-weight:600; line-height:1.3; text-transform:uppercase; letter-spacing:.55px; }
    .account-summary-name { overflow:hidden; color:#26382d; font-size:12px; font-weight:700; line-height:1.45; text-overflow:ellipsis; white-space:nowrap; }
    .account-chevron { width:17px; height:17px; flex:0 0 17px; fill:none; stroke:#66776b; stroke-width:1.7; stroke-linecap:round; stroke-linejoin:round; transition:transform .15s ease; }
    .site-header-account[open] .account-chevron { transform:rotate(180deg); }
    .site-header-account-menu { position:absolute; top:calc(100% + 10px); right:0; z-index:110; width:292px; padding:9px; border:1px solid #e3e9e4; border-radius:16px; background:#fff; box-shadow:0 18px 42px rgba(25,48,32,.16); }
    .account-menu-heading { display:flex; align-items:center; gap:11px; padding:12px; border:1px solid #edf1ed; border-radius:12px; background:linear-gradient(135deg,#f7faf7,#f0f6f1); }
    .account-menu-avatar { display:grid; width:40px; height:40px; flex:0 0 40px; place-items:center; border:1px solid #dce9df; border-radius:12px; background:#fff; color:#08723e; font-size:15px; font-weight:700; box-shadow:0 2px 5px rgba(20,60,35,.05); }
    .account-menu-identity { display:flex; min-width:0; flex-direction:column; gap:3px; }
    .account-menu-identity span { overflow:hidden; color:#26382d; font-size:13px; font-weight:700; text-overflow:ellipsis; white-space:nowrap; }
    .account-menu-identity small { color:#758179; font-size:10px; font-weight:500; }
    .account-registration-number { display:flex; align-items:center; justify-content:space-between; gap:12px; margin:10px 2px 8px; padding:10px 12px; border-left:3px solid #8bb69a; border-radius:7px; background:#f8faf8; color:#69746c; font-size:11px; }
    .account-registration-number strong { color:#39443d; font-size:13px; font-weight:700; letter-spacing:.03em; }
    .site-header-account-menu > a { display:flex; align-items:center; gap:10px; padding:10px 11px; border-radius:9px; color:#435148; font-size:12px; font-weight:600; text-decoration:none; transition:background .15s ease, color .15s ease; }
    .account-action-password { color:#176b43 !important; }
    .account-action-password svg { background:#edf6f0; }
    .account-action-password:hover, .account-action-password:focus { background:#edf6f0; color:#075c36 !important; }
    .account-action-logout { margin-top:3px; border-top:1px solid #f1e6e5; border-radius:0 0 9px 9px; color:#a83232 !important; }
    .account-action-logout svg { background:#fff0ef; }
    .account-action-logout:hover, .account-action-logout:focus { background:#fff0ef; color:#8f2020 !important; }
    .site-header-account-menu svg { width:19px; height:19px; flex:0 0 19px; padding:2px; border-radius:6px; background:#f0f4f1; fill:none; stroke:currentColor; stroke-width:1.5; stroke-linecap:round; stroke-linejoin:round; }
    @media (max-width:850px) {
        .site-header .header-container { min-height:108px; padding:7px 16px; grid-template-columns:minmax(130px,.7fr) minmax(280px,1.6fr) minmax(180px,.9fr); gap:8px; }
        .site-header .header-logo-pgde { height:58px; max-width:118px; }
        .site-header .header-left-message { font-size:9px; }
        .site-header .header-logo { height:38px; }
        .site-header .header-brand-title { font-size:14px; }
        .site-header-account summary { min-width:168px; }
    }
    @media (max-width:640px) {
        .site-header .header-container { min-height:0; padding:10px 12px; grid-template-columns:1fr; gap:8px; }
        .site-header .header-left-brand { position:absolute; top:8px; left:12px; z-index:1; }
        .site-header .header-logo-pgde { width:38px; height:38px; }
        .site-header .header-left-message { display:none; }
        .site-header .header-brand { grid-column:1; }
        .site-header .header-logo { height:32px; margin-bottom:3px; }
        .site-header .header-brand-title { max-width:100%; font-size:13px; }
        .site-header .header-brand-sub { display:none; }
        .site-header .header-account-slot { grid-column:1; justify-content:center; }
        .site-header-account summary { min-width:0; max-width:min(100%,300px); padding:4px 10px 4px 6px; }
        .account-avatar { width:30px; height:30px; flex-basis:30px; font-size:12px; }
        .site-header-account-menu { right:50%; width:min(292px, calc(100vw - 24px)); transform:translateX(50%); }
    }
    @media print { .site-header { display:none !important; } }
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
