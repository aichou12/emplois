<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte — Plateforme de Gestion des Demandes d'Emploi</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">
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
            --color-primary: #008C45;
            --color-primary-dark: #006B35;
            --color-primary-light: #EBF7F0;
            --color-secondary: #FFC107;
            --color-secondary-dark: #D99F00;
            --color-danger: #ED2939;

            /* Couleurs Neutres */
            --color-text: #1D1D1B;
            --color-text-secondary: #575A7B;
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
            --shadow-card: 0 12px 36px rgba(29, 29, 27, 0.07);
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
            padding: 36px 16px;
            width: 100%;
        }

        .login-card {
            width: 100%;
            max-width: 480px;
            background: var(--color-white);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-card);
            border: 1px solid var(--color-border);
            padding: 40px 36px;
            transition: box-shadow 0.2s ease;
        }

        .emblem-wrapper {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            margin: 0 auto 16px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .emblem-wrapper img {
            width: 78px;
            height: 78px;
            object-fit: contain;
        }

        .login-card h1 {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 24px;
            text-align: center;
            margin: 0 0 6px;
            color: var(--color-text);
        }

        .login-card .lead {
            font-size: 13px;
            color: var(--color-text-secondary);
            text-align: center;
            line-height: 1.5;
            margin: 0 0 24px;
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
            margin-bottom: 16px;
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
            box-shadow: 0 0 0 3px rgba(0, 140, 69, 0.12);
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
            margin: 6px 0 22px;
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
        .btn-primary {
            width: 100%;
            background: var(--color-primary);
            color: var(--color-white);
            border: none;
            border-radius: var(--radius-sm);
            padding: 12px 16px;
            font-family: var(--font-heading);
            font-size: 14.5px;
            font-weight: 600;
            cursor: pointer;
            box-shadow: 0 3px 10px rgba(0, 140, 69, 0.22);
            transition: all 0.18s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }

        .btn-primary:hover {
            background: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0, 140, 69, 0.30);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Séparateur */
        .divider {
            display: flex;
            align-items: center;
            gap: 12px;
            margin: 22px 0;
            color: var(--color-text-secondary);
            font-size: 12px;
            text-transform: lowercase;
        }

        .divider::before, .divider::after {
            content: "";
            flex: 1;
            height: 1px;
            background: var(--color-border);
        }

        /* Bouton Contour (Vert) */
        .btn-outline {
            width: 100%;
            background: var(--color-white);
            color: var(--color-primary);
            border: 1.5px solid var(--color-primary);
            border-radius: var(--radius-sm);
            padding: 11px 16px;
            font-family: var(--font-heading);
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            transition: all 0.15s ease;
        }

        .btn-outline:hover {
            background: var(--color-primary-light);
            border-color: var(--color-primary-dark);
            color: var(--color-primary-dark);
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
            background: rgba(29, 29, 27, 0.55);
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



        }

        /* Smartphones (< 576px) */
        @media (max-width: 576px) {
            .main-wrapper {
                padding: 20px 12px;
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
        /* Inscription : même identité visuelle, avec une mise en page adaptée aux champs supplémentaires. */
        .register-main { align-items: center; }
        .register-layout { width: min(100%, 760px); display: block; }
        .register-card { width: 100%; max-width: none; padding: 34px 32px; }
        .register-grid { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 0 14px; }
        .register-grid .field { min-width: 0; }
        .field-error { margin-top: 5px; color: var(--color-danger); font-size: 12px; }
        .field-input.is-invalid { border-color: var(--color-danger); }
.register-links { margin-top: 18px; text-align: center; color: var(--color-text-secondary); font-size: 13px; }
        .register-links a { color: var(--color-primary); font-weight: 600; text-decoration: none; }
        .register-links a:hover { color: var(--color-primary-dark); text-decoration: underline; }
        .register-card .btn-primary { margin-top: 4px; }
        .register-success-note { margin-bottom: 16px; }

        @media (max-width: 900px) {
            .register-layout { max-width: 760px; }
        }
        @media (max-width: 576px) {
            .register-card { padding: 28px 20px; }
            .register-grid { grid-template-columns: minmax(0, 1fr); gap: 0; }
        }
    </style>
</head>
<body>
    @include('partials.site-header')
<main class="main-wrapper register-main">
        <div class="register-layout">
            <section class="login-card register-card" aria-labelledby="register-title">
                <div class="emblem-wrapper">
                    <img src="{{ asset('images/logoPGDE.png') }}" alt="Logo de la plateforme">
                </div>
                <h1 id="register-title">Créer un compte</h1>
                <p class="lead">Renseignez les informations ci-dessous pour créer votre compte candidat.</p>

                @if (session('success'))
                    <div class="alert-success register-success-note" role="status">
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
                        <div class="field">
                            <label for="firstname">Prénom</label>
                            <div class="field-input @error('firstname') is-invalid @enderror">
                                <i class="fas fa-user field-icon" aria-hidden="true"></i>
                                <input type="text" id="firstname" name="firstname" value="{{ old('firstname') }}" placeholder="Votre prénom" required autocomplete="given-name" autofocus>
                            </div>
                            @error('firstname')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="lastname">Nom</label>
                            <div class="field-input @error('lastname') is-invalid @enderror">
                                <i class="fas fa-user field-icon" aria-hidden="true"></i>
                                <input type="text" id="lastname" name="lastname" value="{{ old('lastname') }}" placeholder="Votre nom" required autocomplete="family-name">
                            </div>
                            @error('lastname')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="username">Nom d'utilisateur</label>
                            <div class="field-input @error('username') is-invalid @enderror">
                                <i class="fas fa-at field-icon" aria-hidden="true"></i>
                                <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Choisissez un nom d'utilisateur" required autocomplete="username">
                            </div>
                            @error('username')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="numberid">CNI ou passeport</label>
                            <div class="field-input @error('numberid') is-invalid @enderror">
                                <i class="fas fa-id-card field-icon" aria-hidden="true"></i>
                                <input type="text" id="numberid" name="numberid" value="{{ old('numberid') }}" placeholder="Votre numéro de pièce d'identité" required pattern="[A-Za-z0-9]+" title="Utilisez uniquement des lettres et des chiffres." maxlength="255" autocomplete="off" autocapitalize="characters">
                            </div>
                            @error('numberid')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="email">Adresse e-mail</label>
                            <div class="field-input @error('email') is-invalid @enderror">
                                <i class="fas fa-envelope field-icon" aria-hidden="true"></i>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="nom@exemple.com" required autocomplete="email">
                            </div>
                            @error('email')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="email_confirmation">Confirmer l'adresse e-mail</label>
                            <div class="field-input @error('email_confirmation') is-invalid @enderror">
                                <i class="fas fa-envelope field-icon" aria-hidden="true"></i>
                                <input type="email" id="email_confirmation" name="email_confirmation" value="{{ old('email_confirmation') }}" placeholder="Confirmez votre adresse e-mail" required autocomplete="email">
                            </div>
                            @error('email_confirmation')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="password">Mot de passe</label>
                            <div class="field-input @error('password') is-invalid @enderror">
                                <i class="fas fa-lock field-icon" aria-hidden="true"></i>
                                <input type="password" id="password" name="password" placeholder="8 caractères minimum" required pattern="(?=.*[A-Z])(?=.*\d).{8,}" title="Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre." autocomplete="new-password">
                                <button type="button" class="toggle-pass" onclick="toggleRegisterPassword('password', 'togglePasswordIcon')" aria-label="Afficher ou masquer le mot de passe"><i id="togglePasswordIcon" class="fas fa-eye"></i></button>
                            </div>
                            @error('password')<p class="field-error">{{ $message }}</p>@enderror
                        </div>
                        <div class="field">
                            <label for="password_confirmation">Confirmer le mot de passe</label>
                            <div class="field-input">
                                <i class="fas fa-lock field-icon" aria-hidden="true"></i>
                                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Confirmez votre mot de passe" required autocomplete="new-password">
                                <button type="button" class="toggle-pass" onclick="toggleRegisterPassword('password_confirmation', 'togglePasswordConfirmationIcon')" aria-label="Afficher ou masquer la confirmation"><i id="togglePasswordConfirmationIcon" class="fas fa-eye"></i></button>
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn-primary">
                        <i class="fas fa-user-plus" aria-hidden="true"></i>
                        <span>S'inscrire</span>
                    </button>
                </form>

                <p class="register-links">Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p>
            </section>
</div>
    </main>

    @include('partials.user-footer')

    <script>
        document.getElementById('numberid')?.addEventListener('input', function () {
            this.value = this.value.replace(/[^A-Za-z0-9]/g, '');
        });

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
