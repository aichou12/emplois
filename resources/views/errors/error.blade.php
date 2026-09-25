<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Erreur {{ $status }} — PGDE</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}" type="image/png">
    <style>
        :root { color-scheme: light; --green:#008c45; --green-dark:#006b35; --ink:#25332c; --muted:#66736b; --line:#e5ebe7; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; display:grid; place-items:center; padding:24px; background:linear-gradient(145deg,#f4f8f5,#edf3ef); color:var(--ink); font-family:Inter,"Segoe UI",Arial,sans-serif; }
        .error-card { width:min(100%,620px); padding:clamp(28px,6vw,52px); border:1px solid var(--line); border-radius:24px; background:#fff; box-shadow:0 24px 70px rgba(25,63,42,.10); text-align:center; }
        .brand { display:inline-flex; align-items:center; justify-content:center; min-height:52px; margin-bottom:28px; }
        .brand img { display:block; width:auto; max-width:210px; max-height:58px; object-fit:contain; }
        .error-code { margin:0; color:var(--green); font-size:clamp(64px,14vw,100px); font-weight:750; letter-spacing:-.07em; line-height:1; }
        h1 { margin:18px 0 10px; font-size:clamp(22px,5vw,30px); letter-spacing:-.025em; }
        .message { max-width:440px; margin:0 auto; color:var(--muted); font-size:16px; line-height:1.7; }
        .actions { display:flex; flex-wrap:wrap; justify-content:center; gap:12px; margin-top:30px; }
        .button { display:inline-flex; align-items:center; justify-content:center; min-height:46px; padding:0 20px; border:1px solid var(--line); border-radius:10px; color:var(--ink); font-size:14px; font-weight:650; text-decoration:none; transition:background .15s ease,border-color .15s ease,transform .15s ease; }
        .button:hover { transform:translateY(-1px); border-color:#cbd9cf; background:#f8faf8; }
        .button-primary { border-color:var(--green); background:var(--green); color:#fff; }
        .button-primary:hover { border-color:var(--green-dark); background:var(--green-dark); }
        .reference { margin:24px 0 0; color:#8a958e; font-size:12px; }
        @media(max-width:480px) { body { padding:14px; } .error-card { border-radius:18px; } .actions { flex-direction:column; } .button { width:100%; } }
    </style>
</head>
<body>
    <main class="error-card" role="main">
        <a class="brand" href="{{ url('/') }}" aria-label="Accueil PGDE">
            <img src="{{ asset('images/logoPGDE.png') }}" alt="Plateforme de gestion des demandes d’emploi">
        </a>
        <p class="error-code" aria-hidden="true">{{ $status }}</p>
        <h1>
            @switch($status)
                @case(401) Accès à votre compte @break
                @case(403) Accès refusé @break
                @case(404) Page introuvable @break
                @case(419) Session expirée @break
                @case(429) Veuillez patienter @break
                @case(503) Service indisponible @break
                @default Un petit contretemps
            @endswitch
        </h1>
        <p class="message">{{ $message }}</p>
        <div class="actions">
            <a class="button button-primary" href="{{ url('/') }}">Retour à l’accueil</a>
            <a class="button" href="javascript:history.back()">Revenir à la page précédente</a>
        </div>
        <p class="reference">Plateforme de gestion des demandes d’emploi · PGDE</p>
    </main>
</body>
</html>
