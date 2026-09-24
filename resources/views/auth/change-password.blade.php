<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Modifier le mot de passe — Plateforme de Gestion des Demandes d'Emploi</title>
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
            --color-info-bg: #EEF6FF;
            --color-info-border: #D0E4FF;

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




















        /* ===== 2. BANNIÈRE INFO ===== */
        .info-banner {
            background: linear-gradient(90deg, #EBF7F0 0%, #EEF6FF 100%);
            border-bottom: 1px solid #D7EEDF;
            padding: 9px 16px;
            text-align: center;
            font-size: 13px;
            color: var(--color-primary-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            font-weight: 500;
        }

        /* ===== 3. CONTENU PRINCIPAL (CARTE CENTRÉE) ===== */
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 36px 16px;
            width: 100%;
        }

        .password-card {
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
            width: 58px;
            height: 58px;
            border-radius: 50%;
            margin: 0 auto 16px;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .emblem-wrapper img {
            width: 76px;
            height: 76px;
            object-fit: contain;
        }

        .password-card h1 {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 24px;
            text-align: center;
            margin: 0 0 6px;
            color: var(--color-text);
        }

        .password-card .lead {
            font-size: 13px;
            color: var(--color-text-secondary);
            text-align: center;
            line-height: 1.5;
            margin: 0 0 20px;
        }

        /* Panneau d'instructions */
        .info-panel {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            background: var(--color-info-bg);
            border: 1px solid var(--color-info-border);
            border-radius: var(--radius-sm);
            padding: 12px 14px;
            font-size: 12.5px;
            color: var(--color-text-secondary);
            line-height: 1.5;
            margin-bottom: 22px;
        }

        .info-panel i {
            color: #2563eb;
            font-size: 15px;
            margin-top: 2px;
            flex-shrink: 0;
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
            margin-bottom: 18px;
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

        .field-input.has-error {
            border-color: var(--color-danger);
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

        .field-error {
            color: var(--color-danger);
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
            display: block;
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
            margin-top: 8px;
        }

        .btn-primary:hover {
            background: var(--color-primary-dark);
            transform: translateY(-1px);
            box-shadow: 0 6px 14px rgba(0, 140, 69, 0.30);
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        /* Lien Retour */
        .back-link {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            margin-top: 22px;
            font-size: 13.5px;
            font-weight: 500;
            color: var(--color-text-secondary);
            text-decoration: none;
            transition: color 0.15s ease;
        }

        .back-link:hover {
            color: var(--color-primary);
            text-decoration: underline;
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

            .password-card {
                padding: 28px 20px;
                border-radius: var(--radius-md);
            }

            .password-card h1 {
                font-size: 21px;
            }





            .footer-links {
                flex-direction: column;
                gap: 6px;
            }
        }
    </style>
</head>

<body>

    <!-- 1. Header Institutionnel Multi-Plateforme -->
    @include('partials.site-header')

    <!-- 2. Bannière d'information -->
    <div class="info-banner">
        <i class="fas fa-shield-alt"></i>
        <span>Espace sécurisé de gestion et mise à jour de vos identifiants d'accès.</span>
    </div>

    <!-- 3. Contenu Principal / Formulaire Modifier le mot de passe -->
    <main class="main-wrapper">
        <div class="password-card">

            <div class="emblem-wrapper">
                <img src="{{ asset('images/logoPGDE.png') }}" alt="Sénégal">
            </div>

            <h1>Modifier le mot de passe</h1>
            <p class="lead">
                Pour garantir la sécurité de votre compte, choisissez un mot de passe robuste d'au moins 8 caractères.
            </p>

            <div class="info-panel">
                <i class="fas fa-info-circle"></i>
                <span>
                    Le mot de passe doit comporter au minimum 8 caractères. Veillez à ne pas partager vos accès.
                </span>
            </div>

            @if (session('status'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form id="passwordForm" action="{{ route('change.password') }}" method="POST">
                @csrf

                <!-- Mot de passe actuel -->
                <div class="field">
                    <label for="current_password">Mot de passe actuel</label>
                    <div class="field-input @error('current_password') has-error @enderror" id="field_current_password">
                        <i class="fas fa-lock field-icon"></i>
                        <input type="password" id="current_password" name="current_password" placeholder="Entrez votre mot de passe actuel" required autocomplete="current-password" autofocus>
                        <button type="button" class="toggle-pass" onclick="togglePasswordVisibility('current_password', 'toggleIconCurrent')" aria-label="Afficher/masquer le mot de passe">
                            <i id="toggleIconCurrent" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <span id="error_current_password" class="field-error">
                        @error('current_password') <i class="fas fa-exclamation-circle"></i> {{ $message }} @enderror
                    </span>
                </div>

                <!-- Nouveau mot de passe -->
                <div class="field">
                    <label for="new_password">Nouveau mot de passe</label>
                    <div class="field-input @error('new_password') has-error @enderror" id="field_new_password">
                        <i class="fas fa-key field-icon"></i>
                        <input type="password" id="new_password" name="new_password" placeholder="Entrez le nouveau mot de passe (min. 8 car.)" required autocomplete="new-password">
                        <button type="button" class="toggle-pass" onclick="togglePasswordVisibility('new_password', 'toggleIconNew')" aria-label="Afficher/masquer le mot de passe">
                            <i id="toggleIconNew" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <span id="error_new_password" class="field-error">
                        @error('new_password') <i class="fas fa-exclamation-circle"></i> {{ $message }} @enderror
                    </span>
                </div>

                <!-- Confirmez le nouveau mot de passe -->
                <div class="field">
                    <label for="new_password_confirmation">Confirmez le nouveau mot de passe</label>
                    <div class="field-input @error('new_password_confirmation') has-error @enderror" id="field_new_password_confirmation">
                        <i class="fas fa-check-double field-icon"></i>
                        <input type="password" id="new_password_confirmation" name="new_password_confirmation" placeholder="Confirmez le nouveau mot de passe" required autocomplete="new-password">
                        <button type="button" class="toggle-pass" onclick="togglePasswordVisibility('new_password_confirmation', 'toggleIconConfirm')" aria-label="Afficher/masquer le mot de passe">
                            <i id="toggleIconConfirm" class="fas fa-eye"></i>
                        </button>
                    </div>
                    <span id="error_new_password_confirmation" class="field-error">
                        @error('new_password_confirmation') <i class="fas fa-exclamation-circle"></i> {{ $message }} @enderror
                    </span>
                </div>

                <!-- Bouton Mettre à jour Vert -->
                <button type="submit" class="btn-primary">
                    <i class="fas fa-shield-alt"></i>
                    <span>Enregistrer le nouveau mot de passe</span>
                </button>
            </form>

            <!-- Retour -->
            <a href="{{ url()->previous() !== url()->current() ? url()->previous() : route('login') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>

        </div>
    </main>

    <!-- 4. Footer Institutionnel -->
    <footer class="site-footer">
        <div class="footer-container">
            <div class="footer-links">
                <a href="https://www.fonctionpublique.gouv.sn/" target="_blank" rel="noopener noreferrer">Ministère de la Fonction publique</a>
                <span>|</span>
                <a href="https://presidence.sn" target="_blank" rel="noopener noreferrer">Le Président de la République</a>
                <span>|</span>
                <a href="https://primature.sn/" target="_blank" rel="noopener noreferrer">Gouvernement du Sénégal</a>
            </div>
            <p class="footer-copy">
                © {{ date('Y') }} Ministère de la Fonction Publique, du Travail et de la Réforme du Service Public — Tous droits réservés.
            </p>
        </div>
    </footer>

    <!-- Scripts Javascript & SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Afficher / masquer le mot de passe pour chaque champ
        function togglePasswordVisibility(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
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

        // Validation interactive avant soumission
        document.getElementById('passwordForm').addEventListener('submit', function(event) {
            let currentPassword = document.getElementById('current_password').value;
            let newPassword = document.getElementById('new_password').value;
            let confirmPassword = document.getElementById('new_password_confirmation').value;

            const errCurrent = document.getElementById('error_current_password');
            const errNew = document.getElementById('error_new_password');
            const errConfirm = document.getElementById('error_new_password_confirmation');

            errCurrent.innerHTML = "";
            errNew.innerHTML = "";
            errConfirm.innerHTML = "";

            let valid = true;

            if (!currentPassword) {
                errCurrent.innerHTML = '<i class="fas fa-exclamation-circle"></i> Le mot de passe actuel est requis.';
                valid = false;
            }

            if (newPassword.length < 8) {
                errNew.innerHTML = '<i class="fas fa-exclamation-circle"></i> Le mot de passe doit contenir au moins 8 caractères.';
                valid = false;
            }

            if (newPassword !== confirmPassword) {
                errConfirm.innerHTML = '<i class="fas fa-exclamation-circle"></i> La confirmation ne correspond pas au nouveau mot de passe.';
                valid = false;
            }

            if (!valid) {
                event.preventDefault();
            }
        });

        // Alerte de succès avec redirection
        @if(session('success'))
            Swal.fire({
                title: "Succès !",
                text: "{{ session('success') }}",
                icon: "success",
                confirmButtonText: "OK",
                confirmButtonColor: "#008C45"
            });
        @endif
    </script>
</body>
</html>
