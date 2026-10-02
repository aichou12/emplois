<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Oups</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}" type="image/png">
    <style>
        :root { color-scheme: light; --green:#008c45; --green-dark:#006b35; --ink:#25332c; --muted:#66736b; --line:#e5ebe7; }
        * { box-sizing:border-box; }
        body { min-height:100vh; margin:0; display:grid; place-items:center; padding:24px; background:linear-gradient(145deg,#f4f8f5,#edf3ef); color:var(--ink); font-family:Inter,"Segoe UI",Arial,sans-serif; }
        .error-card { width:min(100%,620px); padding:clamp(28px,6vw,52px); border:1px solid var(--line); border-radius:24px; background:#fff; box-shadow:0 24px 70px rgba(25,63,42,.10); text-align:center; }
        .brand { display:inline-flex; align-items:center; justify-content:center; min-height:52px; margin-bottom:28px; }
        .brand img { display:block; width:auto; max-width:210px; max-height:58px; object-fit:contain; }
        .status-mark { display:grid; place-items:center; width:66px; height:66px; margin:0 auto 20px; border:1px solid #d9eee2; border-radius:22px; background:#eff8f2; color:var(--green); font-size:30px; font-weight:700; }
        h1 { margin:0 0 10px; font-size:clamp(22px,5vw,30px); letter-spacing:-.025em; }
        .message { max-width:440px; margin:0 auto; color:var(--muted); font-size:16px; line-height:1.7; }
        .actions { display:flex; flex-wrap:wrap; justify-content:center; gap:12px; margin-top:30px; }
        .button { display:inline-flex; align-items:center; justify-content:center; min-height:46px; padding:0 20px; border:1px solid var(--line); border-radius:10px; color:var(--ink); font-size:14px; font-weight:650; text-decoration:none; transition:background .15s ease,border-color .15s ease,transform .15s ease; }
        .button:hover { transform:translateY(-1px); border-color:#cbd9cf; background:#f8faf8; }
        .button-primary { border-color:var(--green); background:var(--green); color:#fff; }
        .button-primary:hover { border-color:var(--green-dark); background:var(--green-dark); }
        @media(max-width:480px) { body { padding:14px; } .error-card { border-radius:18px; } .actions { flex-direction:column; } .button { width:100%; } }
    </style>
</head>
<body>
    <main class="error-card" role="main">
        <a class="brand" href="{{ url('/') }}" aria-label="Accueil">
            <img src="{{ asset('images/logoPGDE.png') }}" alt="">
        </a>
        <div class="status-mark" aria-hidden="true">!</div>
        <h1>Oups !</h1>
        <p class="message">Cette page est temporairement indisponible. Veuillez réessayer.</p>
        <div class="actions">
            <a class="button button-primary" href="{{ url('/') }}">Retour à l’accueil</a>
            <a class="button" href="javascript:history.back()">Revenir à la page précédente</a>
        </div>
    </main>
</body>
</html>
