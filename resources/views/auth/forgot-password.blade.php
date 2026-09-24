<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <title>Mot de passe oublié — Plateforme de Gestion des Demandes d'Emploi</title>
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
            --color-info-text: #1E40AF;

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
        .site-header {
            background-color: var(--color-white);
            border-bottom: 1px solid var(--color-border);
            box-shadow: var(--shadow-subtle);
            width: 100%;
        }

        .header-container {
            max-width: 1240px;
            margin: 0 auto;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }

        .header-brand-left, .header-brand-right {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: inherit;
        }

        .header-logo {
            height: 48px;
            width: auto;
            object-fit: contain;
        }

        .header-brand-text {
            display: flex;
            flex-direction: column;
        }

        .header-brand-title {
            font-family: var(--font-heading);
            font-size: 13.5px;
            font-weight: 600;
            color: var(--color-text);
            line-height: 1.25;
        }

        .header-brand-sub {
            font-family: var(--font-body);
            font-size: 11.5px;
            color: var(--color-text-secondary);
            font-style: italic;
        }

        .header-center {
            text-align: center;
            flex: 1;
            padding: 0 12px;
        }

        .header-center-title {
            font-family: var(--font-heading);
            font-size: 17px;
            font-weight: 700;
            color: var(--color-primary-dark);
            letter-spacing: -0.2px;
        }

        .header-center-sub {
            font-family: var(--font-body);
            font-size: 12px;
            color: var(--color-text-secondary);
            font-weight: 500;
        }

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

        .forgot-card {
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
            background: ;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .emblem-wrapper img {
            width: 76px;
            height: 76px;
            object-fit: contain;
        }

        .forgot-card h1 {
            font-family: var(--font-heading);
            font-weight: 700;
            font-size: 24px;
            text-align: center;
            margin: 0 0 6px;
            color: var(--color-text);
        }

        .forgot-card .lead {
            font-size: 13px;
            color: var(--color-text-secondary);
            text-align: center;
            line-height: 1.5;
            margin: 0 0 20px;
        }

        /* Panneau d'aide informatif */
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

        /* Champ formulaire */
        .field {
            margin-bottom: 20px;
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

        .field-error {
            color: var(--color-danger);
            font-size: 12px;
            margin-top: 5px;
            font-weight: 500;
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
            .header-container {
                flex-direction: column;
                text-align: center;
                gap: 10px;
                padding: 12px 16px;
            }

            .header-brand-left, .header-brand-right {
                justify-content: center;
            }
        }

        /* Smartphones (< 576px) */
        @media (max-width: 576px) {
            .main-wrapper {
                padding: 20px 12px;
            }

            .forgot-card {
                padding: 28px 20px;
                border-radius: var(--radius-md);
            }

            .forgot-card h1 {
                font-size: 21px;
            }

            .header-center-title {
                font-size: 15px;
            }

            .header-logo {
                height: 40px;
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
    <header class="site-header">
        <div class="header-container">
            
            <!-- Logo gauche : République du Sénégal -->
            <div class="header-brand-left">
                <!-- <img src="{{ asset('images/dss.png') }}" alt="Armoiries République du Sénégal" class="header-logo"> -->
                <div class="header-brand-text">
                    <span class="header-brand-title">République du Sénégal</span>
                    <span class="header-brand-sub">Un peuple, Un but, Une foi</span>
                </div>
            </div>

            <!-- Titre central -->
            <div class="header-center">
                <h2 class="header-center-title">Plateforme de Gestion des Demandes d'Emploi</h2>
                <span class="header-center-sub">Portail officiel d'enregistrement des candidats</span>
            </div>

            <!-- Logo droite : Ministère -->
            <div class="header-brand-right">
                <img src="{{ asset('images/mfp.png') }}" alt="Ministère de la Fonction Publique" class="header-logo">
                <div class="header-brand-text">
                    <span class="header-brand-title">Ministère de la Fonction Publique</span>
                    <span class="header-brand-sub">et de la Réforme du Service Public</span>
                </div>
            </div>

        </div>
    </header>

    <!-- 2. Bannière d'information -->
    <div class="info-banner">
        <i class="fas fa-bullhorn"></i>
        <span>Plateforme officielle accessible à tous les citoyens sénégalais, au Sénégal et dans la Diaspora.</span>
    </div>

    <!-- 3. Contenu Principal / Formulaire Mot de passe oublié -->
    <main class="main-wrapper">
        <div class="forgot-card">
            
            <div class="emblem-wrapper">
                <img src="{{ asset('images/logoPGDE.png') }}" alt="Sénégal">
            </div>

            <h1>Mot de passe oublié</h1>
            <p class="lead">
                Entrez votre adresse email enregistrée pour recevoir un lien de réinitialisation sécurisé.
            </p>

            <div class="info-panel">
                <i class="fas fa-info-circle"></i>
                <span>
                    Un courriel contenant les instructions de réinitialisation vous sera transmis si l'adresse correspond à un compte actif.
                </span>
            </div>

            @if (session('status'))
                <div class="alert-success">
                    <i class="fas fa-check-circle"></i>
                    <span>{{ session('status') }}</span>
                </div>
            @endif

            <form action="{{ route('password.email') }}" method="POST">
                @csrf

                <!-- Adresse email -->
                <div class="field">
                    <label for="email">Adresse email</label>
                    <div class="field-input @error('email') has-error @enderror">
                        <i class="fas fa-envelope field-icon"></i>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="Entrez votre adresse email" required autocomplete="email" autofocus>
                    </div>
                    @error('email')
                        <div class="field-error">
                            <i class="fas fa-exclamation-circle"></i> {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Bouton Envoi Primaire Vert -->
                <button type="submit" class="btn-primary">
                    <i class="fas fa-paper-plane"></i>
                    <span>Envoyer le lien de réinitialisation</span>
                </button>
            </form>

            <!-- Retour vers la connexion -->
            <a href="{{ route('login') }}" class="back-link">
                <i class="fas fa-arrow-left"></i>
                <span>Retour à la page de connexion</span>
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

    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        Swal.fire({
            title: "Email envoyé !",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "Retour à la connexion",
            confirmButtonColor: "#008C45"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}";
            }
        });
    </script>
    @endif

</body>
</html>