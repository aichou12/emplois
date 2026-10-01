<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Connexion — Plateforme de Gestion des Demandes d'Emploi</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">

    <!-- Polices de la Charte Graphique : Poppins & DM Sans + FontAwesome -->
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
            background: linear-gradient(180deg, #009A4C 0%, var(--color-primary) 100%);
            color: var(--color-white);
            box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset, 0 6px 16px rgba(0, 140, 69, .24);
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
            outline: 3px solid rgba(0, 140, 69, .35);
            outline-offset: 2px;
        }

        .btn-primary:hover {
            background: linear-gradient(180deg, var(--color-primary) 0%, var(--color-primary-dark) 100%);
            box-shadow: 0 1px 0 rgba(255, 255, 255, .2) inset, 0 8px 20px rgba(0, 140, 69, .3);
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
            background: #5b6b62;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(40, 52, 45, .16);
        }

        .btn-outline:hover {
            background: #46534b;
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
    </style>
</head>

<body>

    <!-- 1. Header Institutionnel Multi-Plateforme -->
    @include('partials.site-header')

<!-- 3. Modal d'accueil -->
    <div id="alertModal" class="modal-overlay">
        <div class="modal-card">
            <div style="width:48px; height:48px; border-radius:50%; background:var(--color-primary-light); color:var(--color-primary); display:flex; align-items:center; justify-content:center; margin:0 auto 12px; font-size:20px;">
                <i class="fas fa-info-circle"></i>
            </div>
            @if (session()->has('registration_success'))
                <div style="width:48px; height:48px; border-radius:50%; background:var(--color-primary-light); color:var(--color-primary); display:flex; align-items:center; justify-content:center; margin:0 auto 12px; font-size:20px;">
                    <i class="fas fa-envelope-circle-check" aria-hidden="true"></i>
                </div>
                <h2 style="font-family:var(--font-heading); font-size:20px; margin:0 0 10px;">Vérifiez votre boîte mail</h2>
                <p role="status" aria-live="polite">
                    Votre compte a été créé. Un e-mail d’activation a été envoyé à
                    <strong>{{ session('registration_success') }}</strong>.
                    Ouvrez-le et cliquez sur le lien pour activer votre compte avant de vous connecter.
                </p>
            @else
                <p>
                    Cette plateforme s'adresse à <strong>tout Sénégalais</strong> souhaitant intégrer la fonction publique.<br><br>
                    Si vous êtes Sénégalais établi à l'étranger, vous pouvez également soumettre votre candidature.<br><br>
                    <strong>Votre engagement fait notre fierté. Ensemble, renforçons notre administration !</strong>
                </p>
            @endif
            <button onclick="closeModal()" class="btn-modal-close">
                {{ session()->has('registration_success') ? 'J’ai compris' : 'Continuer vers la connexion' }}
            </button>
        </div>
    </div>

    <!-- 4. Contenu Principal / Formulaire de Connexion Centré -->
    <main class="main-wrapper">
        <div class="login-layout">
          <div class="login-card">

            <div class="emblem-wrapper">
                <img src="{{ asset('images/logoPGDE.png') }}" alt="Sénégal">
            </div>

            <h1>Connexion</h1>
            <p class="lead">Accédez à votre dossier de candidature.</p>

            @if ($errors->has('login'))
                <div class="alert-danger">
                    <i class="fas fa-exclamation-triangle"></i>
                    <span>{{ $errors->first('login') }}</span>
                </div>
            @endif

            @if (session('status'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <!-- Nom d'utilisateur ou Email -->
                <div class="field">
                    <label for="username" class="visually-hidden">Nom d'utilisateur ou Email</label>
                    <div class="field-input">
                        <i class="fas fa-user field-icon"></i>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" placeholder="Votre nom d'utilisateur ou email" required autocomplete="username" autofocus>
                    </div>
                </div>

                <!-- Mot de passe -->
                <div class="field">
                    <label for="password" class="visually-hidden">Mot de passe</label>
                    <div class="field-input">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required autocomplete="current-password">
                        <button type="button" class="toggle-pass" onclick="togglePassword()" aria-label="Afficher ou masquer le mot de passe">
                            <i id="togglePasswordIcon" class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Options : Se souvenir de moi & Mot de passe oublié -->
                <div class="row-between">
                    <label class="remember-label">
                        <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Se souvenir de moi</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">Mot de passe oublié ?</a>
                    @endif
                </div>

                <!-- Bouton Connexion Primaire Vert -->
                <button type="submit" class="btn-primary">
                    <span>Se connecter</span>
                    <i class="fas fa-arrow-right btn-arrow" aria-hidden="true"></i>
                </button>
            </form>

            <div class="divider">Nouveau sur la plateforme ?</div>

            <!-- Bouton Inscription Gris -->
            <a href="{{ route('register') }}" class="btn-outline">
                <i class="fas fa-user-plus" aria-hidden="true"></i>
                <span>Créer un compte</span>
            </a>

          </div>

          @include('partials.auth-side')
        </div>
    </main>

    <!-- 5. Footer Institutionnel -->
    @include('partials.user-footer')

    <!-- Scripts Javascript -->
    <script>
        // Afficher / Masquer le mot de passe
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Modale d'alerte (affichée 1 fois par session)
        function showModal(autoClose = true) {
            const modal = document.getElementById('alertModal');
            if (modal) {
                modal.style.display = 'flex';
                if (autoClose) setTimeout(closeModal, 6000);
            }
        }

        function closeModal() {
            const modal = document.getElementById('alertModal');
            if (modal) {
                modal.style.display = 'none';
            }
        }

        window.addEventListener('DOMContentLoaded', () => {
            const registrationSuccess = @json(session()->has('registration_success'));
            if (registrationSuccess) {
                showModal(false);
            } else if (!sessionStorage.getItem('popupShown')) {
                showModal();
                sessionStorage.setItem('popupShown', 'true');
            }
        });
    </script>
</body>
</html>
