<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation du compte — PGDE</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --color-primary: #008C45;
            --color-primary-dark: #006B35;
            --color-primary-light: #EBF7F0;
            --color-danger: #ED2939;
            --color-text: #1D1D1B;
            --color-text-secondary: #575A7B;
            --color-white: #FFFFFF;
            --color-border: #E5E5E5;
            --color-bg: #F4F6F5;
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'DM Sans', sans-serif;
            --radius-sm: 6px;
            --radius-md: 10px;
            --radius-lg: 14px;
            --shadow-card: 0 12px 36px rgba(29, 29, 27, 0.07);
        }

        *, *::before, *::after { box-sizing: border-box; }
        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            color: var(--color-text);
            background: var(--color-bg);
            font: 15px/1.5 var(--font-body);
            -webkit-font-smoothing: antialiased;
        }
        .info-banner {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 9px 16px;
            border-bottom: 1px solid #D7EEDF;
            background: linear-gradient(90deg, #EBF7F0 0%, #EEF6FF 100%);
            color: var(--color-primary-dark);
            text-align: center;
            font-size: 13px;
            font-weight: 500;
        }
        .main-wrapper {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 100%;
            padding: 40px 16px;
        }
        .verify-card {
            width: 100%;
            max-width: 560px;
            padding: 40px 36px;
            border: 1px solid var(--color-border);
            border-radius: var(--radius-lg);
            background: var(--color-white);
            box-shadow: var(--shadow-card);
            text-align: center;
        }
        .verify-icon {
            display: grid;
            width: 68px;
            height: 68px;
            margin: 0 auto 18px;
            place-items: center;
            border-radius: 50%;
            background: var(--color-primary-light);
            color: var(--color-primary);
            font-size: 28px;
        }
        .verify-card h1 {
            margin: 0 0 10px;
            color: var(--color-text);
            font: 700 24px/1.3 var(--font-heading);
        }
        .verify-card p { margin: 0 0 18px; color: var(--color-text-secondary); }
        .verify-card strong { color: var(--color-text); overflow-wrap: anywhere; }
        .alert {
            margin: 0 0 18px;
            padding: 11px 14px;
            border-radius: var(--radius-sm);
            text-align: left;
            font-size: 13px;
        }
        .alert-success {
            border-left: 4px solid var(--color-primary);
            background: var(--color-primary-light);
            color: var(--color-primary-dark);
        }
        .alert-danger {
            border-left: 4px solid var(--color-danger);
            background: #FDF2F2;
            color: #991B1B;
        }
        .verify-actions { display: flex; flex-wrap: wrap; justify-content: center; gap: 10px; margin-top: 26px; }
        .btn {
            display: inline-flex;
            min-height: 42px;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 10px 18px;
            border: 1px solid transparent;
            border-radius: var(--radius-sm);
            font: 600 13.5px var(--font-heading);
            text-decoration: none;
            cursor: pointer;
            transition: background .15s ease, border-color .15s ease;
        }
        .btn-primary { background: var(--color-primary); color: #fff; }
        .btn-primary:hover { background: var(--color-primary-dark); }
        .btn-outline { border-color: var(--color-border); background: #fff; color: var(--color-text-secondary); }
        .btn-outline:hover { border-color: var(--color-primary); color: var(--color-primary-dark); }
        .site-footer { padding: 18px 16px; text-align: center; }
        .footer-links { display: flex; flex-wrap: wrap; justify-content: center; gap: 8px; margin-bottom: 8px; font-size: 12px; }
        .footer-links a { color: var(--color-primary); text-decoration: none; }
        .footer-links a:hover { text-decoration: underline; }
        .footer-copy { margin: 0; color: #64748B; font-size: 11.5px; }
        @media (max-width: 576px) {
            .main-wrapper { padding: 24px 14px; }
            .verify-card { padding: 30px 20px; }
            .verify-card h1 { font-size: 21px; }
            .footer-links { flex-direction: column; gap: 5px; }
        }
    </style>
</head>
<body>
    @include('partials.site-header')

    <div class="info-banner">
        <i class="fas fa-shield-halved" aria-hidden="true"></i>
        <span>Protégez votre compte en confirmant votre adresse e-mail.</span>
    </div>

    <main class="main-wrapper">
        <section class="verify-card" aria-labelledby="verify-title">
            <div class="verify-icon" aria-hidden="true"><i class="fas fa-envelope-open-text"></i></div>
            <h1 id="verify-title">Activez votre compte</h1>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success" role="status">
                    Un nouveau lien d’activation a été envoyé à {{ $user?->email }}.
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">{{ $errors->first() }}</div>
            @endif

            @if ($user)
                <p>Votre compte n’est pas encore activé. Consultez l’adresse <strong>{{ $user->email }}</strong> et suivez le lien reçu. Ce lien est valable 60 minutes.</p>
                <form method="POST" action="{{ route('verification.send') }}" class="verify-actions">
                    @csrf
                    <button type="submit" class="btn btn-primary"><i class="fas fa-paper-plane" aria-hidden="true"></i> Renvoyer le lien d’activation</button>
                </form>
            @else
                <p>Consultez l’adresse e-mail utilisée lors de votre inscription et suivez le lien d’activation. Si le lien a expiré, connectez-vous pour en demander un nouveau.</p>
                <div class="verify-actions">
                    <a class="btn btn-primary" href="{{ route('login') }}"><i class="fas fa-sign-in-alt" aria-hidden="true"></i> Aller à la connexion</a>
                </div>
            @endif
        </section>
    </main>

    <footer class="site-footer">
        <div class="footer-links">
            <a href="https://www.fonctionpublique.gouv.sn/" target="_blank" rel="noopener noreferrer">Ministère de la Fonction publique</a>
            <span aria-hidden="true">|</span>
            <a href="https://presidence.sn" target="_blank" rel="noopener noreferrer">Le Président de la République</a>
            <span aria-hidden="true">|</span>
            <a href="https://primature.sn/" target="_blank" rel="noopener noreferrer">Gouvernement du Sénégal</a>
        </div>
        <p class="footer-copy">© {{ date('Y') }} Ministère de la Fonction Publique, du Travail et de la Réforme du Service Public — Tous droits réservés.</p>
    </footer>
</body>
</html>
