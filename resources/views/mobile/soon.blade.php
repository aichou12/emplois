<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application mobile — Plateforme de Gestion des Demandes d'Emploi</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,600;9..40,700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background: #F2F3F5;
            color: #1D1D1B;
            font-family: 'DM Sans', sans-serif;
        }

        .soon-main {
            flex: 1;
            display: grid;
            place-items: center;
            padding: 40px 16px;
        }

        .soon-card {
            width: min(100%, 440px);
            padding: 36px 32px;
            border: 1px solid #e5e7eb;
            border-radius: 12px;
            background: #ffffff;
            text-align: center;
        }

        .soon-icon {
            display: grid;
            place-items: center;
            width: 56px;
            height: 56px;
            margin: 0 auto 16px;
            border-radius: 14px;
            background: #EBF7F0;
            color: #008C45;
            font-size: 24px;
        }

        .soon-card h1 {
            margin: 0 0 8px;
            font-family: 'Poppins', sans-serif;
            font-size: 22px;
            font-weight: 600;
        }

        .soon-card p {
            margin: 0 0 22px;
            color: #575A7B;
            line-height: 1.6;
        }

        .soon-card a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            border-radius: 4px;
            background: #008C45;
            color: #ffffff;
            font-family: 'Poppins', sans-serif;
            font-size: 13.5px;
            font-weight: 600;
            text-decoration: none;
        }

        .soon-card a:hover { background: #006B35; }
    </style>
</head>
<body>
    @include('partials.site-header')

    <main class="soon-main">
        <div class="soon-card">
            <div class="soon-icon" aria-hidden="true"><i class="fas fa-mobile-screen-button"></i></div>
            <h1>Bientôt sur {{ $storeName }}</h1>
            <p>L'application mobile de la plateforme est en préparation. En attendant, vous pouvez déposer et suivre votre demande depuis le site.</p>
            <a href="{{ route('login') }}"><i class="fas fa-arrow-left" aria-hidden="true"></i> Accéder à la plateforme</a>
        </div>
    </main>

    @include('partials.user-footer')
</body>
</html>
