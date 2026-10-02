<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Service temporairement indisponible — PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap">
    <style>
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; display: grid; place-items: center; padding: 24px; color: #282b2d; background: #f4f7f5; font-family: 'DM Sans', sans-serif; }
        main { width: min(100%, 620px); padding: clamp(30px, 7vw, 58px); border: 1px solid #e4ebe6; border-radius: 18px; background: #fff; box-shadow: 0 18px 55px rgba(23, 55, 35, .09); text-align: center; }
        img { display: block; width: 86px; height: 86px; margin: 0 auto 25px; object-fit: contain; }
        .eyebrow { display: inline-flex; align-items: center; gap: 8px; margin-bottom: 14px; padding: 7px 12px; border-radius: 999px; color: #805b00; background: #fff6d9; font-size: 12px; font-weight: 700; letter-spacing: .04em; text-transform: uppercase; }
        .eyebrow::before { width: 7px; height: 7px; border-radius: 50%; background: #e5ae00; content: ''; }
        h1 { margin: 0; font: 700 clamp(25px, 5vw, 34px)/1.2 'Poppins', sans-serif; }
        p { margin: 15px auto 0; max-width: 460px; color: #626b65; font-size: 16px; line-height: 1.75; white-space: pre-line; }
        .rule { width: 48px; height: 3px; margin: 28px auto 0; border-radius: 3px; background: #00843f; }
    </style>
</head>
<body>
    <main>
        <img src="{{ asset('images/logoPGDE.png') }}" alt="Logo PGDE">
        <span class="eyebrow">Interruption temporaire</span>
        <h1>Nous revenons bientôt</h1>
        <p>{{ $message }}</p>
        <div class="rule" aria-hidden="true"></div>
    </main>
</body>
</html>
