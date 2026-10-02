<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer mon compte — Plateforme de Gestion des Demandes d'Emploi</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">

    <!-- Polices de la charte : Poppins & DM Sans + FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

    <style>
        /* =========================================================================
           VARIABLES ET DESIGN SYSTEM (CHARTE GRAPHIQUE)
           ========================================================================= */
        :root {
            /* Couleurs Institutionnelles */
            --color-primary: #00843F;
            --color-primary-dark: #006B33;
            --color-primary-light: #EBF7F0;
            --color-secondary: #FCC207;
            --color-secondary-dark: #D9A606;
            --color-danger: #ED2939;

            /* Couleurs Neutres */
            --color-text: #282B2D;
            --color-text-secondary: #6C757D;
            --color-white: #FFFFFF;
            --color-border: #E5E5E5;
            --color-bg: #F4F6F5;
            --color-field: #FAFAFA;
            --color-field-focus: #FFFFFF;

            /* Typographies */
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'DM Sans', sans-serif;

            /* Rayons & Ombres */
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --shadow-subtle: 0 2px 10px rgba(0, 0, 0, 0.04);
            --shadow-card: 0 12px 36px rgba(40, 43, 45, 0.07);
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-body);
            font-size: 15px;
            color: var(--color-text);
            background-color: var(--color-bg);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== 1. HEADER INSTITUTIONNEL ===== */

/* ===== 3. CONTENU PRINCIPAL (FORMULAIRE CENTRÉ) ===== */
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: clamp(16px, 2.5vh, 28px) 16px;
            width: 100%;
        }

        /* Deux colonnes de même largeur : connexion | parcours + vidéo */
        .login-layout {
            width: min(100%, 920px);
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            align-items: stretch;
            gap: 24px;
        }

        .login-card {
            width: 100%;
            max-width: none;
            background: var(--color-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            border: 1px solid var(--color-border);
            padding: 28px 32px;
            transition: box-shadow 0.2s ease;
        }

        .emblem-wrapper {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            margin: 0 auto 10px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .emblem-wrapper img {
            width: 60px;
            height: 60px;
            object-fit: contain;
        }

        .login-card h1 {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 22px;
            text-align: center;
            margin: 0 0 4px;
            color: var(--color-text);
        }

        .login-card .lead {
            font-size: 13px;
            color: var(--color-text-secondary);
            text-align: center;
            line-height: 1.5;
            margin: 0 0 18px;
        }

        /* Alertes */
        .alert-danger {
            border-radius: var(--radius-sm);
            background: #FDF2F2;
            color: #991B1B;
            border-left: 4px solid var(--color-danger);
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            border-radius: var(--radius-sm);
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
            border-left: 4px solid var(--color-primary);
            padding: 10px 14px;
            font-size: 13px;
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        /* Champs du formulaire */
        .field {
            margin-bottom: 12px;
        }

        /* Libellé lu par les lecteurs d'écran mais invisible à l'écran */
        .visually-hidden {
            position: absolute;
            width: 1px;
            height: 1px;
            overflow: hidden;
            clip: rect(0 0 0 0);
            white-space: nowrap;
        }

        .field label {
            display: block;
            font-size: 12.5px;
            font-weight: 600;
            color: var(--color-text);
            margin-bottom: 6px;
        }

        .field-input {
            display: flex;
            align-items: center;
            background: var(--color-field);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            padding: 0 14px;
            transition: all 0.2s ease;
        }

        .field-input:focus-within {
            background: var(--color-field-focus);
            border-color: var(--color-primary);
            box-shadow: 0 0 0 3px rgba(0, 132, 63, 0.12);
        }

        .field-input i.field-icon {
            color: var(--color-text-secondary);
            font-size: 14px;
            width: 18px;
            text-align: center;
            margin-right: 8px;
        }

        .field-input input {
            flex: 1;
            border: none;
            background: transparent;
            outline: none;
            padding: 12px 0;
            font-family: var(--font-body);
            font-size: 14px;
            color: var(--color-text);
            width: 100%;
        }

        .field-input input::placeholder {
            color: #9CA3AF;
            font-size: 13.5px;
        }

        .field-input .toggle-pass {
            cursor: pointer;
            color: var(--color-text-secondary);
            font-size: 14px;
            background: none;
            border: none;
            padding: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: color 0.15s ease;
        }

        .field-input .toggle-pass:hover {
            color: var(--color-primary);
        }

        /* Options : Remember & Forgot */
        .row-between {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin: 4px 0 18px;
            font-size: 13px;
            flex-wrap: wrap;
            gap: 8px;
        }

        .remember-label {
            display: flex;
            align-items: center;
            gap: 7px;
            color: var(--color-text-secondary);
            cursor: pointer;
            user-select: none;
        }

        .remember-label input[type="checkbox"] {
            accent-color: var(--color-primary);
            width: 16px;
            height: 16px;
            cursor: pointer;
        }

        .forgot-link {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 600;
            font-size: 12.5px;
            transition: color 0.15s ease;
        }

        .forgot-link:hover {
            color: var(--color-primary-dark);
            text-decoration: underline;
        }

        /* Bouton Primaire (Vert) */
        /* Boutons d'action : même hauteur, même forme, flèche qui glisse au survol */
        .btn-primary,
        .btn-outline {
            width: 100%;
            min-height: 44px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 18px;
            border: 0;
            border-radius: 10px;
            font-family: var(--font-heading);
            font-size: 14.5px;
            font-weight: 600;
            letter-spacing: .01em;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background .2s ease, box-shadow .2s ease, transform .12s ease;
        }

        .btn-primary {
            background: linear-gradient(180deg, #00954A 0%, var(--color-primary) 100%);
            color: var(--color-white);
            box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset, 0 6px 16px rgba(0, 132, 63, .24);
        }

        .btn-arrow {
            font-size: 13px;
            opacity: .85;
            transition: transform .2s ease;
        }

        .btn-primary:hover .btn-arrow,
        .btn-outline:hover .btn-arrow { transform: translateX(4px); }

        .btn-primary:active,
        .btn-outline:active { transform: translateY(1px); }

        .btn-primary:focus-visible,
        .btn-outline:focus-visible {
            outline: 3px solid rgba(0, 132, 63, .35);
            outline-offset: 2px;
        }

        .btn-primary:hover {
            background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset, 0 8px 20px rgba(0, 132, 63, .3);
        }

        /* Séparateur */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 16px 0;
            color: var(--color-text-secondary);
            font-size: 12.5px;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--color-border);
        }

        /* Créer un compte : gris doux, texte blanc (action secondaire) */
        .btn-outline {
            background: #6c757d;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(40, 52, 45, .16);
        }

        .btn-outline:hover {
            background: #5a6268;
            color: #ffffff;
            box-shadow: 0 6px 16px rgba(40, 52, 45, .22);
        }

        /* ===== 4. FOOTER INSTITUTIONNEL ===== */
        .site-footer {
            background: #ECEEEC;
            border-top: 1px solid var(--color-border);
            text-align: center;
            font-size: 12.5px;
            color: var(--color-text-secondary);
            padding: 18px 20px;
            width: 100%;
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .footer-links {
            margin-bottom: 6px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            gap: 12px;
        }

        .footer-links a {
            color: var(--color-primary);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.15s ease;
        }

        .footer-links a:hover {
            color: var(--color-primary-dark);
            text-decoration: underline;
        }

        .footer-copy {
            margin: 0;
            font-size: 11.5px;
            color: #64748B;
        }

        /* ===== 5. MODAL ALERTE ===== */
        .modal-overlay {
            position: fixed;
            inset: 0;
            display: none;
            align-items: center;
            justify-content: center;
            background: rgba(40, 43, 45, 0.55);
            backdrop-filter: blur(2px);
            z-index: 9999;
            padding: 16px;
        }

        .modal-card {
            background: var(--color-white);
            padding: 24px;
            border-radius: var(--radius-md);
            box-shadow: 0 16px 36px rgba(0, 0, 0, 0.18);
            max-width: 480px;
            width: 100%;
            text-align: center;
            animation: zoomIn 0.25s ease-out;
        }

        @keyframes zoomIn {
            from { transform: scale(0.92); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-card p {
            font-size: 14.5px;
            color: var(--color-text);
            line-height: 1.6;
            margin-bottom: 18px;
        }

        .btn-modal-close {
            padding: 9px 22px;
            background: var(--color-primary);
            color: #fff;
            border: none;
            border-radius: var(--radius-sm);
            font-family: var(--font-heading);
            font-weight: 600;
            font-size: 13.5px;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-modal-close:hover {
            background: var(--color-primary-dark);
        }

        /* =========================================================================
           RESPONSIVE DESIGN ADAPTÉ AUX ÉCRANS
           ========================================================================= */

        /* Tablettes (max 992px) */
        @media (max-width: 992px) {
            .login-layout {
                width: min(100%, 480px);
                grid-template-columns: minmax(0, 1fr);
                gap: 18px;
            }
        }

        /* Smartphones (< 576px) */
        @media (max-width: 576px) {
            .main-wrapper {
                padding: 18px 12px 24px;
            }

            .login-layout {
                width: 100%;
                gap: 14px;
            }

            .login-card {
                padding: 28px 20px;
                border-radius: var(--radius-md);
            }

            .login-card h1 {
                font-size: 21px;
            }

            .footer-links {
                flex-direction: column;
                gap: 6px;
            }
        }

        @media (max-width: 360px) {
            .login-card { padding: 24px 16px; }
        }

        /* =========================================================================
           INSCRIPTION : formulaire à gauche, informations utiles à droite (comme la connexion)
           ========================================================================= */
        .register-layout {
            width: min(100%, 1040px);
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .register-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 0 12px;
        }

        .register-grid .field { min-width: 0; }

        /* Groupes de champs : petit intitulé discret pour se repérer sans libellés */
        .field-group-title {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 4px 0 8px;
            color: #8a958f;
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .08em;
            text-transform: uppercase;
        }

        .field-group-title::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--color-border);
        }

        .field-error {
            margin-top: 5px;
            color: var(--color-danger);
            font-size: 12px;
        }

        .field-input.is-invalid { border-color: var(--color-danger); }

        .error-list { margin: 4px 0 0 16px; }

        /* Règle du mot de passe, affichée sous les champs */
        .password-hint {
            grid-column: 1 / -1;
            display: flex;
            align-items: center;
            gap: 6px;
            margin: -4px 0 14px;
            color: var(--color-text-secondary);
            font-size: 12px;
        }

        .password-hint i { color: var(--color-primary); }

        .register-card .btn-primary { margin-top: 2px; }

        /* ===== Carte d'informations (droite) ===== */
        .register-info {
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            gap: 20px;
            min-width: 0;
            padding: 30px 30px 26px;
            background: var(--color-white);
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
        }

        /* Séparateur placé entre deux blocs : même espace au-dessus et en dessous */
        .info-sep {
            width: 100%;
            height: 1px;
            margin: 0;
            border: 0;
            background: var(--color-border);
        }

        .info-block h2 {
            display: flex;
            align-items: center;
            gap: 10px;
            margin: 0 0 12px;
            font-family: var(--font-heading);
            font-size: 15px;
            font-weight: 600;
            color: var(--color-text);
        }

        .info-block h2 .tile {
            display: grid;
            place-items: center;
            width: 32px;
            height: 32px;
            flex-shrink: 0;
            border-radius: 9px;
            background: #F4F5F6;
            color: var(--color-primary);
            font-size: 14px;
        }

        /* Liste « à avoir sous la main » */
        .info-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .info-list li {
            display: grid;
            grid-template-columns: 18px minmax(0, 1fr);
            gap: 10px;
            font-size: 14px;
            line-height: 1.45;
            color: var(--color-text);
        }

        .info-list li > i { margin-top: 3px; color: var(--color-primary); font-size: 13px; }
        .info-list li span { color: var(--color-text-secondary); }

        /* Étapes après l'inscription : vraie suite d'actions, donc numérotées */
        .info-steps {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
            counter-reset: info-step;
        }

        .info-steps li {
            display: grid;
            grid-template-columns: 26px minmax(0, 1fr);
            gap: 10px;
            align-items: center;
            font-size: 14px;
            line-height: 1.45;
            counter-increment: info-step;
        }

        .info-steps li::before {
            content: counter(info-step);
            display: grid;
            place-items: center;
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #F4F5F6;
            color: var(--color-text);
            font-family: var(--font-heading);
            font-size: 12.5px;
            font-weight: 700;
        }

        .info-steps li strong { font-weight: 600; }
        .info-steps li span { color: var(--color-text-secondary); }

        /* Conditions d'inscription */
        .info-conditions { display: flex; flex-wrap: wrap; gap: 8px; }

        .info-chip {
            display: inline-flex;
            align-items: center;
            gap: 7px;
            padding: 6px 11px;
            border: 1px solid var(--color-border);
            border-radius: 999px;
            background: #F4F5F6;
            color: var(--color-text);
            font-size: 12.5px;
            font-weight: 500;
        }

        .info-chip i { color: var(--color-primary); font-size: 12px; }

        /* Lien vers le guide, en bas de la carte */
        .info-guide-link {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 13px 14px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-md);
            color: var(--color-text);
            font-size: 13px;
            text-decoration: none;
            transition: border-color .15s ease, background .15s ease;
        }

        .info-guide-link > i:first-child { color: var(--color-primary); font-size: 15px; }
        .info-guide-link strong { color: var(--color-primary-dark); font-weight: 600; }
        .info-guide-arrow { margin-left: auto; color: var(--color-text-secondary); font-size: 12px; transition: transform .15s ease; }
        .info-guide-link:hover { border-color: var(--color-primary); background: #F7FAF8; }
        .info-guide-link:hover .info-guide-arrow { transform: translateX(3px); color: var(--color-primary); }
        .info-guide-link:focus-visible { outline: 3px solid rgba(0, 132, 63, .35); outline-offset: 2px; }

        @media (max-width: 992px) {
            .register-layout { width: min(100%, 640px); grid-template-columns: minmax(0, 1fr); }
            .register-info { justify-content: flex-start; }
        }

        @media (max-width: 576px) {
            .register-grid { grid-template-columns: minmax(0, 1fr); gap: 0; }
            .register-info { padding: 20px 16px; gap: 18px; border-radius: var(--radius-md); justify-content: flex-start; }
        }
    </style>
</head>

<body>
    @include('partials.site-header')

    <main class="main-wrapper">
        <div class="login-layout register-layout">
          <section class="login-card register-card" aria-labelledby="register-title">

            <div class="emblem-wrapper">
                <img src="{{ asset('images/logoPGDE.png') }}" alt="Logo de la plateforme">
            </div>

            <h1 id="register-title">Créer mon compte</h1>
            <p class="lead">Créez votre compte candidat en une minute.</p>

            @if (session('success'))
                <div class="alert-success" role="status">
                    <i class="fas fa-check-circle" aria-hidden="true"></i>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-danger" role="alert">
                    <i class="fas fa-exclamation-triangle" aria-hidden="true"></i>
                    <div>
                        <strong>Veuillez corriger les erreurs suivantes :</strong>
                        <ul class="error-list">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif

            <form action="{{ route('register.store') }}" method="POST">
                @csrf
                <div class="register-grid">
                    <p class="field-group-title">Informations personnelles</p>

                    <div class="field">
                        <label for="firstname" class="visually-hidden">Prénom</label>
                        <div class="field-input @error('firstname') is-invalid @enderror">
                            <i class="fas fa-user field-icon" aria-hidden="true"></i>
                            <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Prénom" required autocomplete="given-name" autofocus>
                        </div>
                        @error('firstname')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="lastname" class="visually-hidden">Nom</label>
                        <div class="field-input @error('lastname') is-invalid @enderror">
                            <i class="fas fa-user field-icon" aria-hidden="true"></i>
                            <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" placeholder="Nom" required autocomplete="family-name">
                        </div>
                        @error('lastname')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="numberid" class="visually-hidden">Numéro de CNI ou de passeport</label>
                        <div class="field-input @error('numberid') is-invalid @enderror">
                            <i class="fas fa-id-card field-icon" aria-hidden="true"></i>
                            <input type="text" id="numberid" name="numberid" value="{{ old('numberid') }}" placeholder="N° CNI ou passeport" required pattern="[A-Za-z0-9]+" title="Utilisez uniquement des lettres et des chiffres." maxlength="255" autocomplete="off" autocapitalize="characters">
                        </div>
                        @error('numberid')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="username" class="visually-hidden">Nom d'utilisateur</label>
                        <div class="field-input @error('username') is-invalid @enderror">
                            <i class="fas fa-at field-icon" aria-hidden="true"></i>
                            <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Nom d'utilisateur (ex : adama.diop)" required pattern="[A-Za-z0-9._-]+" minlength="3" maxlength="50" title="Lettres, chiffres, tirets, underscores et points uniquement. Pas d'adresse e-mail ni de symbole @." autocomplete="username">
                        </div>
                        @error('username')<p class="field-error">{{ $message }}</p>@enderror
                    </div>

                    <p class="field-group-title">Informations de connexion</p>

                    <div class="field">
                        <label for="email" class="visually-hidden">Adresse e-mail</label>
                        <div class="field-input @error('email') is-invalid @enderror">
                            <i class="fas fa-envelope field-icon" aria-hidden="true"></i>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Adresse e-mail" required autocomplete="email">
                        </div>
                        @error('email')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="email_confirmation" class="visually-hidden">Confirmer l'adresse e-mail</label>
                        <div class="field-input @error('email_confirmation') is-invalid @enderror">
                            <i class="fas fa-envelope-circle-check field-icon" aria-hidden="true"></i>
                            <input type="email" id="email_confirmation" name="email_confirmation" value="{{ old('email_confirmation') }}" placeholder="Confirmez l'e-mail" required autocomplete="email">
                        </div>
                        @error('email_confirmation')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="password" class="visually-hidden">Mot de passe</label>
                        <div class="field-input @error('password') is-invalid @enderror">
                            <i class="fas fa-lock field-icon" aria-hidden="true"></i>
                            <input type="password" id="password" name="password" placeholder="Mot de passe" required pattern="(?=.*[A-Z])(?=.*\d).{8,}" title="Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre." autocomplete="new-password" aria-describedby="password-hint">
                            <button type="button" class="toggle-pass" onclick="toggleRegisterPassword('password', 'togglePasswordIcon')" aria-label="Afficher ou masquer le mot de passe"><i id="togglePasswordIcon" class="fas fa-eye"></i></button>
                        </div>
                        @error('password')<p class="field-error">{{ $message }}</p>@enderror
                    </div>
                    <div class="field">
                        <label for="password_confirmation" class="visually-hidden">Confirmer le mot de passe</label>
                        <div class="field-input">
                            <i class="fas fa-lock field-icon" aria-hidden="true"></i>
                            <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmez le mot de passe" required autocomplete="new-password">
                            <button type="button" class="toggle-pass" onclick="toggleRegisterPassword('password_confirmation', 'togglePasswordConfirmationIcon')" aria-label="Afficher ou masquer la confirmation"><i id="togglePasswordConfirmationIcon" class="fas fa-eye"></i></button>
                        </div>
                    </div>

                    <p class="password-hint" id="password-hint">
                        <i class="fas fa-circle-info" aria-hidden="true"></i>
                        8 caractères minimum, dont une majuscule et un chiffre.
                    </p>
                </div>

                <button type="submit" class="btn-primary">
                    <span>Créer mon compte</span>
                    <i class="fas fa-arrow-right btn-arrow" aria-hidden="true"></i>
                </button>
            </form>

            <div class="divider">Déjà inscrit ?</div>

            <a href="{{ route('login') }}" class="btn-outline">
                <i class="fas fa-right-to-bracket" aria-hidden="true"></i>
                <span>Se connecter</span>
            </a>
          </section>

          <!-- Informations utiles avant / après l'inscription -->
          <aside class="register-info" aria-label="Informations utiles">
              <section class="info-block" aria-labelledby="info-before">
                  <h2 id="info-before"><span class="tile" aria-hidden="true"><i class="fas fa-clipboard-list"></i></span>Avant de commencer</h2>
                  <ul class="info-list">
                      <li><i class="fas fa-envelope" aria-hidden="true"></i><div>Une <strong>adresse e-mail</strong> que vous consultez</div></li>
                      <li><i class="fas fa-lock" aria-hidden="true"></i><div>Un <strong>mot de passe</strong> <span>de 8 caractères minimum</span></div></li>
                  </ul>
              </section>

              <hr class="info-sep">

              <section class="info-block" aria-labelledby="info-after">
                  <h2 id="info-after"><span class="tile" aria-hidden="true"><i class="fas fa-route"></i></span>Après votre inscription</h2>
                  <ol class="info-steps">
                      <li><div><strong>Activez votre compte</strong> <span>via l'e-mail reçu</span></div></li>
                      <li><div><strong>Connectez-vous</strong></div></li>
                      <li><div><strong>Complétez votre dossier</strong></div></li>
                  </ol>
              </section>

              <hr class="info-sep">

              <section class="info-block" aria-labelledby="info-who">
                  <h2 id="info-who"><span class="tile" aria-hidden="true"><i class="fas fa-user-check"></i></span>Qui peut s'inscrire ?</h2>
                  <div class="info-conditions">
                      <span class="info-chip"><i class="fas fa-flag" aria-hidden="true"></i> Tout Sénégalais</span>
                      <span class="info-chip"><i class="fas fa-earth-africa" aria-hidden="true"></i> Au Sénégal ou à l'étranger</span>
                      <span class="info-chip"><i class="fas fa-cake-candles" aria-hidden="true"></i> De 18 à 60 ans</span>
                  </div>
              </section>

              <a href="{{ route('guide') }}" class="info-guide-link">
                  <i class="fas fa-book-open" aria-hidden="true"></i>
                  <span><strong>Besoin d'aide ?</strong> Consultez le guide du candidat</span>
                  <i class="fas fa-arrow-right info-guide-arrow" aria-hidden="true"></i>
              </a>
          </aside>
        </div>
    </main>

    @include('partials.user-footer')

    <script>
        document.getElementById('username')?.addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-z0-9._-]/g, '');
        });

        document.getElementById('numberid')?.addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
        });

        // Afficher / masquer un mot de passe
        function toggleRegisterPassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.classList.toggle('fa-eye', !show);
            icon.classList.toggle('fa-eye-slash', show);
        }
    </script>
</body>
</html>
