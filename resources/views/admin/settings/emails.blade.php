<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-mails — Paramètres PGDE</title>
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
            <div class="container"><div class="page-inner">
                <div class="pgde-settings-page">
                    @if(session('success'))
                        <div class="pgde-settings-alert is-success" role="status"><i class="fas fa-check-circle" aria-hidden="true"></i>{{ session('success') }}</div>
                    @endif
                    @if($errors->any())
                        <div class="pgde-settings-alert is-error" role="alert"><i class="fas fa-exclamation-circle" aria-hidden="true"></i><div>@foreach($errors->all() as $error)<div>{{ $error }}</div>@endforeach</div></div>
                    @endif

                    <div class="pgde-settings-intro">
                        <span class="pgde-settings-intro-icon"><i class="fas fa-envelope-open-text" aria-hidden="true"></i></span>
                        <div><h2>Modèles d’e-mails</h2><p>Personnalisez les messages envoyés lors de l’activation d’un compte et d’une réinitialisation de mot de passe.</p></div>
                    </div>

                    <div class="pgde-email-notice"><i class="fas fa-lock" aria-hidden="true"></i><span>Les liens sécurisés, les boutons d’action et leur durée de validité sont générés automatiquement et ne peuvent pas être modifiés ici.</span></div>

                    <form action="{{ route('admin.settings.emails.update') }}" method="POST" class="pgde-settings-form">
                        @csrf
                        @method('PUT')
                        @foreach([
                            ['verify', 'mail_verify', 'Activation du compte', 'fas fa-user-check', 'Le candidat confirme son adresse e-mail pour activer son compte.'],
                            ['reset', 'mail_reset', 'Réinitialisation du mot de passe', 'fas fa-key', 'Le candidat reçoit un lien pour choisir un nouveau mot de passe.'],
                        ] as [$type, $prefix, $title, $icon, $description])
                            <section class="pgde-settings-card pgde-email-card" aria-labelledby="email-{{ $type }}-title">
                                <div class="pgde-settings-card-heading">
                                    <span class="pgde-settings-icon {{ $type === 'verify' ? 'is-green' : 'is-yellow' }}"><i class="{{ $icon }}" aria-hidden="true"></i></span>
                                    <div><h3 id="email-{{ $type }}-title">{{ $title }}</h3><p>{{ $description }}</p></div>
                                </div>
                                <div class="pgde-settings-field">
                                    <label for="{{ $prefix }}-subject">Objet de l’e-mail</label>
                                    <input id="{{ $prefix }}-subject" name="{{ $prefix }}_subject" value="{{ old($prefix . '_subject', $settings[$prefix . '_subject']) }}" maxlength="180" required>
                                </div>
                                <div class="pgde-settings-field">
                                    <label for="{{ $prefix }}-intro">Message principal</label>
                                    <textarea id="{{ $prefix }}-intro" name="{{ $prefix }}_intro" rows="4" maxlength="1500" required>{{ old($prefix . '_intro', $settings[$prefix . '_intro']) }}</textarea>
                                    <small>Le message s’affiche après « Bonjour » et avant le bouton d’action.</small>
                                </div>
                                <div class="pgde-settings-field">
                                    <label for="{{ $prefix }}-signature">Signature</label>
                                    <textarea id="{{ $prefix }}-signature" name="{{ $prefix }}_signature" rows="3" maxlength="300" required>{{ old($prefix . '_signature', $settings[$prefix . '_signature']) }}</textarea>
                                    <small>Utilisez un retour à la ligne pour séparer les lignes de la signature.</small>
                                </div>
                                <div class="pgde-email-card-actions">
                                    <a class="pgde-email-preview-link" href="{{ route('admin.settings.emails.preview', $type) }}" target="_blank" rel="noopener"><i class="far fa-eye" aria-hidden="true"></i> Prévisualiser le modèle enregistré</a>
                                    <span><i class="fas fa-check-circle" aria-hidden="true"></i> Version HTML et texte incluses</span>
                                </div>
                            </section>
                        @endforeach
                        <div class="pgde-settings-actions">
                            <span><i class="fas fa-shield-alt" aria-hidden="true"></i> Les changements s’appliquent aux prochains e-mails envoyés.</span>
                            <button type="submit"><i class="fas fa-check" aria-hidden="true"></i> Enregistrer les modèles</button>
                        </div>
                    </form>

                    <section class="pgde-settings-card pgde-email-test" aria-labelledby="email-test-title">
                        <div class="pgde-settings-card-heading">
                            <span class="pgde-settings-icon is-green"><i class="fas fa-paper-plane" aria-hidden="true"></i></span>
                            <div><h3 id="email-test-title">Envoyer un e-mail test</h3><p>Vérifiez le rendu dans votre boîte de réception. L’action du bouton renverra vers la page de connexion.</p></div>
                        </div>
                        <form action="{{ route('admin.settings.emails.test') }}" method="POST" class="pgde-email-test-form">
                            @csrf
                            <label class="pgde-settings-field" for="test-email-template">
                                <span>Modèle</span>
                                <select id="test-email-template" name="template" required>
                                    <option value="verify">Activation du compte</option>
                                    <option value="reset">Réinitialisation du mot de passe</option>
                                </select>
                            </label>
                            <label class="pgde-settings-field" for="test-email-address">
                                <span>Adresse de réception</span>
                                <input id="test-email-address" type="email" name="email" value="{{ old('email') }}" placeholder="vous@exemple.fr" maxlength="255" required>
                            </label>
                            <button type="submit"><i class="fas fa-paper-plane" aria-hidden="true"></i> Envoyer le test</button>
                        </form>
                    </section>
                </div>
            </div></div>
        </main>
    </div>
    <script src="{{ asset('assets/js/core/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/kaiadmin.min.js') }}"></script>
    <script src="{{ asset('assets/js/pgde-admin.js') }}?v=settings-dropdown-v1"></script>
</body>
</html>
