<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Modifier un candidat — Administration PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-sidebar-sage-v4">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        .pgde-edit-card { max-width: 1080px; margin: 0 auto; padding: 30px; border: 1px solid #e3ebe5; border-radius: 18px; background: linear-gradient(180deg,#fff 0%,#fff 78%,#fcfdfc 100%); box-shadow: 0 12px 34px rgba(28, 55, 37, .065); }
        .pgde-edit-profile-heading { display: flex; align-items: center; gap: 15px; margin-bottom: 12px; }
        .pgde-edit-avatar { display: grid; width: 58px; height: 58px; flex: 0 0 58px; place-items: center; border: 1px solid #cfe4d4; border-radius: 16px; color: #087844; background: linear-gradient(145deg,#f2faf4,#dcefe1); box-shadow: inset 0 1px 0 rgba(255,255,255,.9); font: 700 18px "Inter", "Public Sans", sans-serif; }
        .pgde-edit-title-copy { min-width: 0; }
        .pgde-edit-kicker { display: block; margin-bottom: 3px; color: #728178; font-size: 10px; font-weight: 700; letter-spacing: .1em; }
        .pgde-edit-card h2 { margin: 0; color: #24332a; font: 700 21px/1.3 "Inter", "Public Sans", sans-serif; overflow-wrap: anywhere; }
        .pgde-edit-title-copy p { margin: 4px 0 0; color: #758078; font-size: 12px; }
        .pgde-edit-card > .pgde-edit-description { margin: 0 0 22px; color: #686d70; font-size: 13px; }
        .pgde-edit-section-heading { display: flex; align-items: center; gap: 9px; margin: 0 0 15px; padding-bottom: 11px; border-bottom: 1px solid #edf1ed; color: #314538; font-size: 13px; font-weight: 700; }
        .pgde-edit-section-heading i { color: #16824c; }
        .pgde-edit-card .form-label { margin-bottom: 7px; color: #343a36; font-size: 13px; font-weight: 600; }
        .pgde-edit-card .form-control { min-height: 44px; border-color: #dce5de; border-radius: 9px; box-shadow: none; }
        .pgde-edit-card .form-control:focus { border-color: #5aa879; box-shadow: 0 0 0 3px rgba(0, 140, 69, .1); }
        .pgde-edit-meta { display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; margin-bottom: 22px; }
        .pgde-edit-meta-status { display: flex; flex-wrap: wrap; align-items: center; gap: 8px; }
        .pgde-edit-status { display: inline-flex; align-items: center; gap: 7px; padding: 8px 12px; border-radius: 999px; color: #28643d; background: #eaf5ed; font-size: 12px; font-weight: 600; }
        .pgde-edit-status.is-pending { color: #8b6500; background: #fff5d9; }
        .pgde-edit-status.is-recruited { color: #856300; background: #fff5d9; }
        .pgde-recruit-open { display: inline-flex; min-height: 46px; align-items: center; gap: 10px; padding: 6px 14px 6px 7px; border: 1px solid #eadba8; border-radius: 13px; color: #73570c; background: linear-gradient(135deg, #fffdf6, #fff6da); box-shadow: 0 2px 7px rgba(125, 94, 10, .07); font-size: 13px; font-weight: 700; transition: border-color .16s ease, background .16s ease, transform .16s ease, box-shadow .16s ease; }
        .pgde-recruit-open:hover { transform: translateY(-2px); border-color: #dfc56f; background: linear-gradient(135deg, #fff9e6, #ffefbf); box-shadow: 0 5px 12px rgba(125, 94, 10, .12); }
        .pgde-recruit-icon { display: grid; width: 32px; height: 32px; flex: 0 0 32px; place-items: center; border: 1px solid rgba(222, 184, 74, .5); border-radius: 10px; color: #916d0a; background: linear-gradient(145deg, #ffefb9, #ffe39a); font-size: 14px; }
        .pgde-recruit-arrow { margin-left: 3px; color: #aa8a35; font-size: 11px; transition: transform .16s ease; }
        .pgde-recruit-open:hover .pgde-recruit-arrow { transform: translateX(2px); }
        .pgde-recruit-open:disabled { border-color: #e5e7e5; color: #a2a8a3; background: #f1f2f1; box-shadow: none; cursor: not-allowed; transform: none; }
        .pgde-recruit-open:disabled .pgde-recruit-icon { border-color: #e2e4e2; color: #9da39e; background: #e9ebe9; }
        .pgde-recruit-note { flex-basis: 100%; margin: -5px 0 0; color: #808780; font-size: 12px; }
        .pgde-recruit-dialog { width: min(480px, calc(100% - 32px)); padding: 30px; border: 1px solid #e5e5e5; border-radius: 14px; background: #fff; box-shadow: 0 12px 36px rgba(29, 29, 27, .07); color: #1d1d1b; }
        .pgde-recruit-dialog::backdrop { background: rgba(244, 246, 245, .16); -webkit-backdrop-filter: blur(3px); backdrop-filter: blur(3px); }
        .pgde-recruit-dialog-icon { display: grid; width: 54px; height: 54px; margin: 0 auto 14px; place-items: center; border: 1px solid #f0dfa8; border-radius: 50%; color: #9b7200; background: #fff8df; }
        .pgde-recruit-dialog h2 { margin: 0 0 8px; font: 700 20px/1.35 "Poppins", sans-serif; text-align: center; }
        .pgde-recruit-dialog p { margin: 0 0 20px; color: #575a7b; font-size: 13px; text-align: center; }
        .pgde-recruit-dialog-name { display: block; margin-bottom: 22px; padding: 10px 13px; border: 1px solid #e9ebdf; border-left: 4px solid #008c45; border-radius: 6px; color: #425748; background: #f7f9f2; font-size: 14px; font-weight: 600; text-align: center; }
        .pgde-recruit-dialog-actions { display: flex; justify-content: flex-end; gap: 9px; }
        .pgde-recruit-dialog-actions button { min-height: 40px; padding: 8px 14px; border: 1px solid #e3e8e3; border-radius: 8px; color: #5e685f; background: #fff; font-size: 13px; font-weight: 600; }
        .pgde-recruit-dialog-actions .pgde-recruit-confirm { border-color: #008c45; color: #fff; background: #008c45; }
        .pgde-recruit-dialog-actions .pgde-recruit-confirm:hover { background: #006b35; }
        .pgde-edit-password-note { margin: -3px 0 0; color: #777f79; font-size: 12px; }
        .pgde-edit-support-grid { display: grid; grid-template-columns: minmax(250px,.82fr) minmax(0,1.18fr); gap: 14px; margin: 0 0 24px; }
        .pgde-edit-support-card { min-width: 0; padding: 17px; border: 1px solid #e4ece6; border-radius: 12px; background: #fbfdfb; }
        .pgde-edit-support-card.is-recovery { background: linear-gradient(135deg,#f4faf5,#fff 75%); }
        .pgde-edit-support-title { display: flex; align-items: center; gap: 8px; margin: 0 0 8px; color: #314538; font-size: 13px; font-weight: 700; }
        .pgde-edit-support-title i { color: #16824c; }
        .pgde-edit-support-description { margin: 0 0 13px; color: #758078; font-size: 11px; line-height: 1.55; overflow-wrap: anywhere; }
        .pgde-reset-open { display: inline-flex; min-height: 37px; align-items: center; gap: 8px; padding: 0 12px; border: 1px solid #cfe3d4; border-radius: 8px; color: #087844; background: #fff; font-size: 11px; font-weight: 700; cursor: pointer; transition: background .15s ease,border-color .15s ease,transform .15s ease; }
        .pgde-reset-open:hover { transform: translateY(-1px); border-color: #a8ceb2; background: #f1f8f3; }
        .pgde-edit-last-login { display: flex; justify-content: space-between; gap: 12px; margin-bottom: 10px; padding-bottom: 10px; border-bottom: 1px solid #e9efea; color: #78847b; font-size: 10px; }
        .pgde-edit-last-login strong { color: #3a4e40; font-size: 11px; font-weight: 700; text-align: right; }
        .pgde-edit-failure-list { display: grid; gap: 7px; }
        .pgde-edit-failure-row { display: flex; align-items: center; justify-content: space-between; gap: 10px; color: #66736a; font-size: 10px; }
        .pgde-edit-failure-row strong { color: #8e514b; font-weight: 600; }
        .pgde-edit-no-failures { margin: 0; color: #768379; font-size: 10px; }
        .pgde-reset-dialog { width: min(460px,calc(100% - 30px)); padding: 25px; border: 1px solid #e1e9e3; border-radius: 15px; color: #26342b; background: #fff; box-shadow: 0 22px 65px rgba(14,36,22,.18); }
        .pgde-reset-dialog::backdrop { background: rgba(17,32,23,.28); backdrop-filter: blur(3px); }
        .pgde-reset-dialog h2 { margin: 0 0 8px; font: 700 18px/1.35 "Inter", "Public Sans", sans-serif; }
        .pgde-reset-dialog p { margin: 0 0 13px; color: #707d74; font-size: 12px; line-height: 1.55; }
        .pgde-reset-email { display: block; margin-bottom: 18px; padding: 10px 12px; border: 1px solid #e3ece5; border-radius: 8px; color: #3d5946; background: #f7faf7; font-size: 12px; font-weight: 700; overflow-wrap: anywhere; }
        .pgde-reset-dialog-actions { display: flex; justify-content: flex-end; gap: 8px; }
        .pgde-reset-dialog-actions button { min-height: 38px; padding: 0 12px; border: 1px solid #e1e8e2; border-radius: 8px; color: #59675d; background: #fff; font-size: 11px; font-weight: 700; cursor: pointer; }
        .pgde-reset-dialog-actions button[type="submit"] { border-color: #087844; color: #fff; background: #087844; }
        .pgde-reset-dialog-actions button[type="submit"]:hover { background: #06683a; }
        .pgde-edit-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 10px; margin-top: 25px; padding-top: 20px; border-top: 1px solid #edf1ed; }
        .pgde-edit-actions .btn { min-height: 42px; padding: 9px 16px; border-radius: 9px; font-weight: 600; }
        .pgde-edit-actions .btn-save { border: 0; color: #fff; background: #008c45; }
        .pgde-edit-actions .btn-save:hover { color: #fff; background: #006b35; }
        @media (max-width: 760px) { .pgde-edit-support-grid { grid-template-columns: 1fr; } }
        @media (max-width: 600px) { .pgde-edit-card { padding: 20px 16px; } .pgde-edit-avatar { width: 49px; height: 49px; flex-basis: 49px; border-radius: 14px; font-size: 16px; } .pgde-edit-card h2 { font-size: 18px; } .pgde-edit-actions { flex-direction: column-reverse; } .pgde-edit-actions .btn { width: 100%; } .pgde-reset-dialog-actions { flex-direction: column-reverse; } .pgde-reset-dialog-actions button { width: 100%; } }
    </style>
    <style>
        :root {
            --color-primary: #008c45;
            --color-primary-dark: #006b35;
            --color-secondary: #ffc107;
            --color-secondary-dark: #d99f00;
            --color-danger: #ed2939;
            --color-text: #1d1d1b;
            --color-text-secondary: #575a7b;
            --color-border: #e5e5e5;
            --color-white: #ffffff;
            --color-soft: #fafaf8;
            --font-heading: "Poppins", sans-serif;
            --font-body: "DM Sans", sans-serif;
            --radius-sm: 4px;
            --radius-md: 10px;
            --radius-lg: 16px;
        }
        body { font-family: var(--font-body); color: var(--color-text); }
        .pgde-edit-card { position: relative; overflow: hidden; max-width: 1080px; padding: 32px; border-color: var(--color-border); border-radius: var(--radius-lg); background: var(--color-white); box-shadow: 0 1px 2px rgba(20,30,24,.03),0 16px 40px rgba(20,30,24,.06); }
        .pgde-edit-card > * { position: relative; z-index: 1; }
        .pgde-edit-profile-heading { gap: 16px; margin-bottom: 14px; }
        .pgde-edit-avatar { display: grid; width: 58px; height: 58px; flex: 0 0 58px; place-items: center; padding: 3px; border: 0; border-radius: 50%; color: transparent; background: conic-gradient(from 180deg,var(--color-primary),var(--color-secondary),var(--color-primary)); font-size: 0; }
        .pgde-edit-avatar::after { display: grid; width: 100%; height: 100%; place-items: center; border: 2px solid var(--color-white); border-radius: 50%; color: var(--color-primary-dark); background: var(--color-white); content: attr(data-initials); font: 600 17px var(--font-heading); }
        .pgde-edit-kicker { margin-bottom: 4px; color: var(--color-primary); font: 600 11px var(--font-heading); letter-spacing: .06em; text-transform: uppercase; }
        .pgde-edit-card h2 { color: var(--color-text); font: 600 22px/1.3 var(--font-heading); }
        .pgde-edit-title-copy p { color: var(--color-text-secondary); font-size: 12.5px; }
        .pgde-edit-card > .pgde-edit-description { margin-bottom: 24px; color: var(--color-text-secondary); font-size: 13.5px; line-height: 1.6; }
        .pgde-edit-section-heading { margin-bottom: 16px; padding-bottom: 10px; border-color: var(--color-border); color: var(--color-text); font: 600 13.5px var(--font-heading); }
        .pgde-edit-section-heading::before { width: 14px; height: 14px; flex: none; border-radius: 50% 50% 50% 4px; background: linear-gradient(135deg,var(--color-primary),var(--color-secondary)); content: ""; }
        .pgde-edit-section-heading i { display: none; }
        .pgde-edit-card .form-label { color: var(--color-text-secondary); font-size: 13px; font-weight: 500; }
        .pgde-edit-card .form-control { border: 1px solid var(--color-border); border-radius: var(--radius-sm); color: var(--color-text); font: 14.5px var(--font-body); transition: border-color .18s ease,box-shadow .18s ease; }
        .pgde-edit-card .form-control:focus { border-color: var(--color-primary); box-shadow: 0 0 0 3px rgba(0,140,69,.14); }
        .pgde-edit-meta { margin-bottom: 24px; }
        .pgde-edit-status { padding: 7px 13px; border: 1px solid rgba(0,140,69,.22); border-radius: 20px; color: var(--color-primary-dark); background: rgba(0,140,69,.09); font-weight: 600; }
        .pgde-edit-status.is-pending, .pgde-edit-status.is-recruited { border: 1px solid rgba(217,159,0,.3); color: var(--color-secondary-dark); background: rgba(255,193,7,.16); }
        .pgde-recruit-open { padding-right: 16px; border: 1px solid rgba(217,159,0,.35); border-radius: 20px 20px 20px 6px; color: var(--color-secondary-dark); background: rgba(255,193,7,.1); font: 600 13.5px var(--font-body); }
        .pgde-recruit-open:hover { background: rgba(255,193,7,.18); box-shadow: 0 6px 16px rgba(217,159,0,.18); }
        .pgde-recruit-icon { border: 0; border-radius: 50%; color: var(--color-secondary-dark); background: rgba(255,193,7,.22); }
        .pgde-recruit-open:disabled { border-color: var(--color-border); color: var(--color-text-secondary); background: var(--color-soft); }
        .pgde-recruit-open:disabled .pgde-recruit-icon { color: var(--color-text-secondary); background: var(--color-border); }
        .pgde-recruit-note { color: var(--color-text-secondary); }
        .pgde-recruit-dialog,.pgde-reset-dialog { border-color: var(--color-border); border-radius: var(--radius-lg); color: var(--color-text); background: var(--color-white); box-shadow: 0 20px 50px rgba(20,30,24,.14); }
        .pgde-recruit-dialog::backdrop,.pgde-reset-dialog::backdrop { background: rgba(29,29,27,.35); backdrop-filter: blur(2px); }
        .pgde-recruit-dialog h2,.pgde-reset-dialog h2 { font-family: var(--font-heading); font-weight: 600; }
        .pgde-recruit-dialog p,.pgde-reset-dialog p { color: var(--color-text-secondary); line-height: 1.6; }
        .pgde-recruit-dialog-name,.pgde-reset-email { border-color: var(--color-border); border-left: 4px solid var(--color-primary); border-radius: var(--radius-sm); color: var(--color-text); background: var(--color-soft); }
        .pgde-recruit-dialog-actions button,.pgde-reset-dialog-actions button { border-color: var(--color-border); border-radius: var(--radius-sm); color: var(--color-text-secondary); font: 600 12.5px var(--font-body); }
        .pgde-recruit-dialog-actions .pgde-recruit-confirm,.pgde-reset-dialog-actions button[type="submit"] { border-color: var(--color-primary); color: #fff; background: var(--color-primary); box-shadow: 0 3px 10px rgba(0,140,69,.25); }
        .pgde-edit-support-grid { gap: 16px; margin-bottom: 26px; }
        .pgde-edit-support-card { padding: 18px 19px; border-color: var(--color-border); border-radius: var(--radius-md); background: var(--color-soft); }
        .pgde-edit-support-card.is-recovery { background: linear-gradient(135deg,rgba(0,140,69,.05),rgba(255,193,7,.05)); }
        .pgde-edit-support-title { color: var(--color-text); font: 600 13.5px var(--font-heading); }
        .pgde-edit-support-title i { color: var(--color-primary); font-size: 12px; }
        .pgde-edit-support-description { color: var(--color-text-secondary); font-size: 12px; line-height: 1.6; }
        .pgde-reset-open { border-color: var(--color-primary); border-radius: var(--radius-sm); color: var(--color-primary); font: 600 12.5px var(--font-body); }
        .pgde-reset-open:hover { background: rgba(0,140,69,.07); }
        .pgde-edit-last-login { border-color: var(--color-border); color: var(--color-text-secondary); font-size: 11px; }
        .pgde-edit-last-login strong { color: var(--color-text); font-size: 12px; font-weight: 600; }
        .pgde-edit-failure-row { color: var(--color-text-secondary); font-size: 11px; }
        .pgde-edit-failure-row strong { color: var(--color-danger); font-weight: 600; }
        .pgde-edit-no-failures { color: var(--color-text-secondary); font-size: 11px; font-style: italic; }
        .pgde-edit-actions { margin-top: 28px; padding-top: 22px; border-color: var(--color-border); }
        .pgde-edit-actions .btn { border-radius: var(--radius-sm); font: 600 14px var(--font-body); }
        .pgde-edit-actions .btn-light { border: 1px solid var(--color-border); color: var(--color-text-secondary); background: var(--color-white); }
        .pgde-edit-actions .btn-save { background: var(--color-primary); box-shadow: 0 3px 10px rgba(0,140,69,.25); }
        .pgde-edit-actions .btn-save:hover { background: var(--color-primary-dark); box-shadow: 0 8px 18px rgba(0,140,69,.3); }
        .alert-success { border: 1px solid rgba(0,140,69,.25); border-radius: var(--radius-sm); color: var(--color-primary-dark); background: rgba(0,140,69,.08); }
        .alert-danger { border-left: 4px solid var(--color-danger); border-radius: var(--radius-sm); color: var(--color-text); background: #fff5f5; }
        @media (max-width: 600px) { .pgde-edit-card { padding: 22px 16px; } .pgde-edit-avatar { width: 50px; height: 50px; flex-basis: 50px; } .pgde-edit-avatar::after { font-size: 15px; } .pgde-edit-card h2 { font-size: 18px; } }
    </style>
</head>
<body>
    @include('partials.site-header')
    <div class="wrapper pgde-admin-wrapper">
        @include('admin.partials.sidebar')
        <main class="main-panel pgde-admin-main">
            @include('admin.partials.page-header')
            <div class="container">
                <div class="page-inner">
                    @if(session('success'))
                        <div class="alert alert-success" role="status">{{ session('success') }}</div>
                    @endif
                    @if(session('error'))
                        <div class="alert alert-danger" role="alert">{{ session('error') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="alert alert-danger" role="alert">
                            <strong>Vérifie les informations saisies.</strong>
                            <ul class="mb-0 mt-2">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                        </div>
                    @endif

                    <section class="pgde-edit-card" aria-labelledby="pgde-edit-title">
                        <div class="pgde-edit-profile-heading">
                            <span class="pgde-edit-avatar" data-initials="{{ mb_strtoupper(mb_substr($utilisateur->firstname ?: $utilisateur->username, 0, 1) . mb_substr($utilisateur->lastname ?? '', 0, 1)) }}" aria-hidden="true"></span>
                            <div class="pgde-edit-title-copy">
                                <span class="pgde-edit-kicker">PROFIL CANDIDAT</span>
                                <h2 id="pgde-edit-title">{{ trim($utilisateur->firstname . ' ' . $utilisateur->lastname) ?: $utilisateur->username }}</h2>
                                <p>{{ '@' . $utilisateur->username }} <span aria-hidden="true">·</span> Dossier n° {{ $utilisateur->id }}</p>
                            </div>
                        </div>
                        <div class="pgde-edit-meta">
                            <div class="pgde-edit-meta-status">
                                @if($utilisateur->hasVerifiedEmail())
                                    <span class="pgde-edit-status"><i class="fas fa-check-circle" aria-hidden="true"></i> Adresse e-mail vérifiée</span>
                                @else
                                    <span class="pgde-edit-status is-pending"><i class="fas fa-clock" aria-hidden="true"></i> Adresse e-mail non vérifiée</span>
                                @endif
                                @if($utilisateur->recruted)
                                    <span class="pgde-edit-status is-recruited"><i class="fas fa-briefcase" aria-hidden="true"></i> Recruté</span>
                                @endif
                            </div>
                            @if($utilisateur->recruted)
                                <button class="pgde-recruit-open" type="button" disabled><span class="pgde-recruit-icon"><i class="fas fa-check" aria-hidden="true"></i></span><span>Déjà recruté</span></button>
                            @elseif(!$utilisateur->enabled)
                                <button class="pgde-recruit-open" type="button" disabled title="Le compte doit être activé avant le recrutement"><span class="pgde-recruit-icon"><i class="fas fa-award" aria-hidden="true"></i></span><span>Marquer comme recruté</span><i class="fas fa-arrow-right pgde-recruit-arrow" aria-hidden="true"></i></button>
                                <p class="pgde-recruit-note">Le compte doit être activé avant de pouvoir le recruter.</p>
                            @elseif(!$utilisateur->userdata)
                                <button class="pgde-recruit-open" type="button" disabled title="Le dossier doit être complet avant le recrutement"><span class="pgde-recruit-icon"><i class="fas fa-award" aria-hidden="true"></i></span><span>Marquer comme recruté</span><i class="fas fa-arrow-right pgde-recruit-arrow" aria-hidden="true"></i></button>
                                <p class="pgde-recruit-note">Le dossier doit être complet avant de pouvoir le recruter.</p>
                            @else
                                <button class="pgde-recruit-open" type="button" id="pgdeOpenRecruitDialog"><span class="pgde-recruit-icon"><i class="fas fa-award" aria-hidden="true"></i></span><span>Marquer comme recruté</span><i class="fas fa-arrow-right pgde-recruit-arrow" aria-hidden="true"></i></button>
                            @endif
                        </div>

                        <div class="pgde-edit-support-grid">
                            <section class="pgde-edit-support-card is-recovery" aria-labelledby="pgde-reset-title">
                                <h3 class="pgde-edit-support-title" id="pgde-reset-title"><i class="fas fa-life-ring" aria-hidden="true"></i> Assistance à la connexion</h3>
                                <p class="pgde-edit-support-description">Envoie un lien sécurisé pour que l’usager choisisse un nouveau mot de passe. Le lien sera adressé à <strong>{{ $utilisateur->email }}</strong>.</p>
                                <button class="pgde-reset-open" type="button" id="pgdeOpenResetDialog"><i class="fas fa-paper-plane" aria-hidden="true"></i> Envoyer un lien de réinitialisation</button>
                            </section>

                            <section class="pgde-edit-support-card" aria-labelledby="pgde-login-activity-title">
                                <h3 class="pgde-edit-support-title" id="pgde-login-activity-title"><i class="fas fa-history" aria-hidden="true"></i> Activité de connexion</h3>
                                <div class="pgde-edit-last-login"><span>Dernière connexion réussie</span><strong>{{ $lastSuccessfulLogin?->created_at?->format('d/m/Y à H:i') ?? 'Aucune connexion enregistrée' }}</strong></div>
                                <div class="pgde-edit-failure-list">
                                    @forelse($recentLoginFailures as $loginFailure)
                                        <div class="pgde-edit-failure-row">
                                            <strong>{{ ['password_rejected' => 'Mot de passe refusé', 'account_not_found' => 'Compte introuvable', 'account_not_activated' => 'Compte non activé', 'account_blocked' => 'Compte suspendu', 'admin_access_denied' => 'Accès admin refusé', 'rate_limited' => 'Trop de tentatives'][$loginFailure->result] ?? 'Échec de connexion' }}</strong>
                                            <time datetime="{{ $loginFailure->created_at?->toIso8601String() }}">{{ $loginFailure->created_at?->format('d/m/Y H:i') ?? 'Date inconnue' }}</time>
                                        </div>
                                    @empty
                                        <p class="pgde-edit-no-failures">Aucun échec de connexion récent.</p>
                                    @endforelse
                                </div>
                            </section>
                        </div>

                        <form action="{{ route('admin.update', $utilisateur->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="pgde-edit-section-heading"><i class="fas fa-user-edit" aria-hidden="true"></i><span>Informations du compte</span></div>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label" for="firstname">Prénom</label>
                                    <input class="form-control" id="firstname" name="firstname" value="{{ old('firstname', $utilisateur->firstname) }}" required autocomplete="given-name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="lastname">Nom</label>
                                    <input class="form-control" id="lastname" name="lastname" value="{{ old('lastname', $utilisateur->lastname) }}" required autocomplete="family-name">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="username">Nom d’utilisateur</label>
                                    <input class="form-control" id="username" name="username" value="{{ old('username', $utilisateur->username) }}" required autocomplete="username">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="numberid">Numéro de dossier</label>
                                    <input class="form-control" id="numberid" name="numberid" value="{{ old('numberid', $utilisateur->numberid) }}" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label" for="email">Adresse e-mail</label>
                                    <input class="form-control" id="email" name="email" type="email" value="{{ old('email', $utilisateur->email) }}" required autocomplete="email">
                                </div>
                                <div class="col-12"><div class="pgde-edit-section-heading mb-0 mt-3"><i class="fas fa-key" aria-hidden="true"></i><span>Accès et mot de passe</span></div></div>
                                <div class="col-md-6">
                                    <label class="form-label" for="password">Nouveau mot de passe</label>
                                    <input class="form-control" id="password" name="password" type="password" minlength="6" autocomplete="new-password">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label" for="password_confirmation">Confirmer le mot de passe</label>
                                    <input class="form-control" id="password_confirmation" name="password_confirmation" type="password" minlength="6" autocomplete="new-password">
                                </div>
                                <div class="col-12"><p class="pgde-edit-password-note">6 caractères minimum. Le mot de passe actuel n’est jamais affiché.</p></div>
                            </div>
                            <div class="pgde-edit-actions">
                                <a class="btn btn-light" href="{{ route('liste.utilisateurs') }}">Retour à la liste</a>
                                <button class="btn btn-save" type="submit"><i class="fas fa-save me-1" aria-hidden="true"></i> Enregistrer les modifications</button>
                            </div>
                        </form>
                    </section>
                    <dialog class="pgde-reset-dialog" id="pgdeResetDialog" aria-labelledby="pgdeResetDialogTitle" aria-describedby="pgdeResetDialogDescription">
                        <h2 id="pgdeResetDialogTitle">Envoyer un lien de réinitialisation ?</h2>
                        <p id="pgdeResetDialogDescription">Un lien sécurisé de changement de mot de passe sera envoyé à cette adresse. Le mot de passe actuel ne sera pas communiqué.</p>
                        <strong class="pgde-reset-email">{{ $utilisateur->email }}</strong>
                        <form action="{{ route('admin.users.send-password-reset', $utilisateur->id) }}" method="POST" class="pgde-reset-dialog-actions">
                            @csrf
                            <button type="button" id="pgdeCancelResetDialog">Annuler</button>
                            <button type="submit"><i class="fas fa-paper-plane" aria-hidden="true"></i> Envoyer le lien</button>
                        </form>
                    </dialog>
                    @if(!$utilisateur->recruted && $utilisateur->enabled && $utilisateur->userdata)
                        <dialog class="pgde-recruit-dialog" id="pgdeRecruitDialog" aria-labelledby="pgdeRecruitDialogTitle" aria-describedby="pgdeRecruitDialogDescription">
                            <span class="pgde-recruit-dialog-icon"><i class="fas fa-briefcase" aria-hidden="true"></i></span>
                            <h2 id="pgdeRecruitDialogTitle">Confirmer le recrutement ?</h2>
                            <p id="pgdeRecruitDialogDescription">Le candidat sera marqué comme recruté dans la liste.</p>
                            <strong class="pgde-recruit-dialog-name">{{ trim($utilisateur->firstname . ' ' . $utilisateur->lastname) ?: $utilisateur->username }}</strong>
                            <form action="{{ route('admin.recruter', $utilisateur->id) }}" method="POST" class="pgde-recruit-dialog-actions">
                                @csrf
                                <button type="button" id="pgdeCancelRecruitDialog">Annuler</button>
                                <button class="pgde-recruit-confirm" type="submit"><i class="fas fa-check me-1" aria-hidden="true"></i> Confirmer le recrutement</button>
                            </form>
                        </dialog>
                    @endif
                </div>
            </div>
        </main>
    </div>
    <script src="{{ asset('assets/js/pgde-admin.js') }}?v=settings-dropdown-v1"></script>
    <script>
        const recruitDialog = document.getElementById('pgdeRecruitDialog');
        const openRecruitDialog = document.getElementById('pgdeOpenRecruitDialog');
        const cancelRecruitDialog = document.getElementById('pgdeCancelRecruitDialog');
        if (recruitDialog && openRecruitDialog && cancelRecruitDialog) {
            openRecruitDialog.addEventListener('click', () => recruitDialog.showModal());
            cancelRecruitDialog.addEventListener('click', () => recruitDialog.close());
            recruitDialog.addEventListener('click', (event) => {
                if (event.target === recruitDialog) recruitDialog.close();
            });
        }
        const resetDialog = document.getElementById('pgdeResetDialog');
        const openResetDialog = document.getElementById('pgdeOpenResetDialog');
        const cancelResetDialog = document.getElementById('pgdeCancelResetDialog');
        if (resetDialog && openResetDialog && cancelResetDialog) {
            openResetDialog.addEventListener('click', () => resetDialog.showModal());
            cancelResetDialog.addEventListener('click', () => resetDialog.close());
            resetDialog.addEventListener('click', (event) => {
                if (event.target === resetDialog) resetDialog.close();
            });
        }
    </script>
</body>
</html>
