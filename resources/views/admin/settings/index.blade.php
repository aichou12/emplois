<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Paramètres — Administration PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/plugins.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/kaiadmin.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-admin.css') }}?v=admin-sidebar-sage-v4">
    <link rel="stylesheet" href="{{ asset('assets/css/pgde-settings.css') }}?v=settings-v5">
</head>
<body>
    @include('partials.site-header')

    <div class="wrapper pgde-admin-wrapper">
        @include('admin.partials.sidebar')
        <main class="main-panel pgde-admin-main">
            @include('admin.partials.page-header')
            <div class="container">
                <div class="page-inner">
                    <div class="pgde-settings-page">
                        @if(session('success'))
                            <div class="pgde-settings-alert is-success" role="status"><i class="fas fa-check-circle" aria-hidden="true"></i>{{ session('success') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="pgde-settings-alert is-error" role="alert">
                                <i class="fas fa-exclamation-circle" aria-hidden="true"></i>
                                <div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div>
                            </div>
                        @endif

                        <div class="pgde-settings-hero">
                            <div class="pgde-settings-hero-copy">
                                <span class="pgde-settings-eyebrow">CONFIGURATION DE LA PLATEFORME</span>
                                <h2>Paramètres généraux</h2>
                                <p>Gérez l’accès des usagers, les inscriptions et la vidéo affichée sur la page de connexion.</p>
                            </div>
                            <span class="pgde-settings-hero-icon" aria-hidden="true"><i class="fas fa-sliders-h"></i></span>
                        </div>

                        <form action="{{ route('admin.settings.update') }}" method="POST" class="pgde-settings-form">
                            @csrf
                            @method('PUT')

                            <section class="pgde-settings-card" aria-labelledby="user-access-title">
                                <div class="pgde-settings-card-heading">
                                    <span class="pgde-settings-icon is-green"><i class="fas fa-door-open" aria-hidden="true"></i></span>
                                    <div><h3 id="user-access-title">Accès à l’espace usager</h3><p>Suspendez temporairement les pages destinées aux candidats. L’administration restera accessible.</p></div>
                                </div>

                                <label class="pgde-settings-switch-row" for="user-area-blocked">
                                    <span class="pgde-settings-switch-copy">
                                        <strong>Bloquer l’accès aux usagers</strong>
                                        <small>Une page d’information remplacera les pages usager pendant la suspension.</small>
                                    </span>
                                    <input id="user-area-blocked" class="pgde-settings-switch-input" type="checkbox" name="user_area_blocked" value="1" @checked(old('user_area_blocked', $settings['user_area_blocked']) === '1')>
                                    <span class="pgde-settings-switch" aria-hidden="true"></span>
                                </label>

                                <div class="pgde-settings-field">
                                    <label for="user-area-message">Message affiché aux usagers</label>
                                    <textarea id="user-area-message" name="user_area_message" rows="4" maxlength="500" required>{{ old('user_area_message', $settings['user_area_message']) }}</textarea>
                                    <small>500 caractères maximum. Le message apparaît sur une page dédiée avec le logo PGDE.</small>
                                </div>
                            </section>

                            <section class="pgde-settings-card" aria-labelledby="registration-title">
                                <div class="pgde-settings-card-heading">
                                    <span class="pgde-settings-icon is-yellow"><i class="fas fa-user-plus" aria-hidden="true"></i></span>
                                    <div><h3 id="registration-title">Création de compte</h3><p>Fermez les nouvelles inscriptions sans empêcher les usagers déjà inscrits d’accéder à leur espace.</p></div>
                                </div>
                                <label class="pgde-settings-switch-row" for="registration-blocked">
                                    <span class="pgde-settings-switch-copy">
                                        <strong>Suspendre uniquement les inscriptions</strong>
                                        <small>Le formulaire d’inscription web et l’inscription mobile afficheront un message d’indisponibilité.</small>
                                    </span>
                                    <input id="registration-blocked" class="pgde-settings-switch-input" type="checkbox" name="registration_blocked" value="1" @checked(old('registration_blocked', $settings['registration_blocked']) === '1')>
                                    <span class="pgde-settings-switch" aria-hidden="true"></span>
                                </label>
                                <p class="pgde-settings-note"><i class="fas fa-info-circle" aria-hidden="true"></i> Le blocage général de l’espace usager ci-dessus suspend également les inscriptions.</p>
                            </section>

                            <section class="pgde-settings-card" aria-labelledby="login-video-title">
                                <div class="pgde-settings-card-heading">
                                    <span class="pgde-settings-icon is-yellow"><i class="fab fa-youtube" aria-hidden="true"></i></span>
                                    <div><h3 id="login-video-title">Vidéo de la page de connexion</h3><p>Remplacez le lien YouTube présenté à côté du formulaire de connexion.</p></div>
                                </div>
                                <div class="pgde-settings-field">
                                    <label for="login-video-url">Lien de la vidéo YouTube</label>
                                    <input id="login-video-url" type="url" name="login_video_url" value="{{ old('login_video_url', $settings['login_video_url']) }}" placeholder="https://www.youtube.com/watch?v=…" required>
                                    <small>Les liens YouTube standards, courts et d’intégration sont acceptés.</small>
                                </div>
                            </section>

                            <div class="pgde-settings-actions">
                                <span><i class="fas fa-shield-alt" aria-hidden="true"></i> Ces réglages s’appliquent dès leur enregistrement.</span>
                                <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Enregistrer les paramètres</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pgde-admin.js') }}?v=settings-dropdown-v1"></script>
</body>
</html>
