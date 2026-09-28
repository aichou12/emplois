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
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-weights-v2">
    <style>
        .pgde-edit-card { max-width: 940px; margin: 0 auto; padding: 28px; border: 1px solid #e5ebe6; border-radius: 16px; background: #fff; box-shadow: 0 8px 28px rgba(28, 55, 37, .055); }
        .pgde-edit-card h2 { margin: 0 0 6px; color: #1d1d1b; font: 700 20px/1.3 "Poppins", sans-serif; }
        .pgde-edit-card > p { margin: 0 0 24px; color: #686d70; font-size: 13px; }
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
        .pgde-edit-actions { display: flex; flex-wrap: wrap; justify-content: flex-end; gap: 10px; margin-top: 25px; padding-top: 20px; border-top: 1px solid #edf1ed; }
        .pgde-edit-actions .btn { min-height: 42px; padding: 9px 16px; border-radius: 9px; font-weight: 600; }
        .pgde-edit-actions .btn-save { border: 0; color: #fff; background: #008c45; }
        .pgde-edit-actions .btn-save:hover { color: #fff; background: #006b35; }
        @media (max-width: 600px) { .pgde-edit-card { padding: 20px 16px; } .pgde-edit-actions { flex-direction: column-reverse; } .pgde-edit-actions .btn { width: 100%; } }
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
                        <h2 id="pgde-edit-title">Profil candidat</h2>
                        <p>Modifie les informations du compte. Laisse les champs de mot de passe vides si tu ne souhaites pas le changer.</p>
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

                        <form action="{{ route('admin.update', $utilisateur->id) }}" method="POST">
                            @csrf
                            @method('PUT')
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
    <script src="{{ asset('assets/js/pgde-admin.js') }}"></script>
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
    </script>
</body>
</html>
