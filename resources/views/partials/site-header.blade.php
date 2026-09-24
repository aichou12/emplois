@php
    $siteHeaderUser = auth()->user();
    $siteHeaderSubtitle = $subtitle ?? ($siteHeaderUser
        ? 'Espace personnel'
        : "Portail officiel d’enregistrement des candidats");
@endphp

<header class="site-header">
    <div class="header-container">
        <div class="header-brand-left">
            <img src="{{ asset('images/dss.png') }}" alt="Armoiries de la République du Sénégal" class="header-logo">
            <div class="header-brand-text">
                <span class="header-brand-title">République du Sénégal</span>
                <span class="header-brand-sub">Un peuple, un but, une foi</span>
            </div>
        </div>

        <div class="header-center">
            <h2 class="header-center-title">Plateforme de Gestion des Demandes d’Emploi</h2>
            <span class="header-center-sub">{{ $siteHeaderSubtitle }}</span>
        </div>

        <div class="header-brand-right">
            <img src="{{ asset('images/mfp.png') }}" alt="Ministère de la Fonction Publique" class="header-logo header-logo-ministry">
            <div class="header-brand-text">
                <span class="header-brand-title">Ministère de la Fonction Publique</span>
                <span class="header-brand-sub">et de la Réforme du Service Public</span>
                @if($siteHeaderUser)
                    <details class="site-header-account">
                        <summary>{{ $siteHeaderUser->firstname }} {{ $siteHeaderUser->lastname }}</summary>
                        <div class="site-header-account-menu">
                            <a href="{{ route('password.edit') }}">Modifier le mot de passe</a>
                            <a href="{{ route('logout') }}">Déconnexion</a>
                        </div>
                    </details>
                @endif
            </div>
        </div>
    </div>
</header>

<style>
    .site-header { width: 100%; background: #fff; border-bottom: 1px solid #e5e8e5; box-shadow: 0 3px 14px rgba(0, 75, 43, .09); }
    .site-header .header-container { width: min(100%, 1240px); min-height: 92px; margin: 0 auto; padding: 12px 24px; display: flex; align-items: center; justify-content: space-between; gap: 20px; }
    .site-header .header-brand-left, .site-header .header-brand-right { display: flex; align-items: center; gap: 12px; min-width: 0; color: inherit; text-decoration: none; }
    .site-header .header-logo { width: auto; height: 48px; object-fit: contain; flex: 0 0 auto; }
    .site-header .header-logo-ministry { height: 54px; }
    .site-header .header-brand-text { display: flex; flex-direction: column; min-width: 0; }
    .site-header .header-brand-title { color: #222b25; font-size: 13px; font-weight: 700; line-height: 1.3; }
    .site-header .header-brand-sub { color: #68736b; font-size: 11px; font-style: italic; line-height: 1.35; }
    .site-header .header-center { flex: 1 1 auto; min-width: 0; padding: 0 8px; text-align: center; }
    .site-header .header-center-title { margin: 0; color: #145f3a; font-size: 17px; font-weight: 700; line-height: 1.3; }
    .site-header .header-center-sub { color: #68736b; font-size: 12px; font-weight: 500; }
    .site-header-account { position: relative; margin-top: 5px; color: #145f3a; font-size: 12px; }
    .site-header-account summary { cursor: pointer; font-weight: 600; }
    .site-header-account-menu { position: absolute; z-index: 20; top: calc(100% + 7px); right: 0; min-width: 190px; padding: 6px; background: #fff; border: 1px solid #e2e7e2; border-radius: 8px; box-shadow: 0 8px 24px rgba(20, 50, 30, .14); }
    .site-header-account-menu a { display: block; padding: 9px 10px; border-radius: 5px; color: #344239; text-decoration: none; }
    .site-header-account-menu a:hover, .site-header-account-menu a:focus { color: #145f3a; background: #f0f6f1; }
    @media (max-width: 900px) {
        .site-header .header-container { flex-wrap: wrap; justify-content: center; gap: 12px 18px; padding: 12px 16px; }
        .site-header .header-brand-left, .site-header .header-brand-right { flex: 1 1 40%; }
        .site-header .header-brand-right { justify-content: flex-end; }
        .site-header .header-center { order: 3; flex-basis: 100%; }
    }
    @media (max-width: 560px) {
        .site-header .header-container { display: grid; grid-template-columns: 1fr; gap: 10px; text-align: center; }
        .site-header .header-brand-left, .site-header .header-brand-right { justify-content: center; }
        .site-header .header-brand-left { order: 1; }
        .site-header .header-center { order: 2; padding: 0; }
        .site-header .header-brand-right { order: 3; }
        .site-header .header-logo { height: 40px; }
        .site-header .header-logo-ministry { height: 44px; }
        .site-header .header-center-title { font-size: 15px; }
        .site-header .header-center-sub { font-size: 11px; }
        .site-header-account-menu { right: 50%; transform: translateX(50%); }
    }
    @media print {
        .site-header { display: none !important; }
    }
</style>
