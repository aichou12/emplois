<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">
    <title>Accès suspendu — PGDE</title>
    <link rel="icon" href="{{ asset('images/logogris.png') }}" type="image/x-icon">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap">
    <style>
        * { box-sizing: border-box; }
        body { min-height: 100vh; margin: 0; display: grid; place-items: center; padding: 24px; color: #1d1d1b; background: #f4f7f5; font-family: 'DM Sans', sans-serif; }
        main { width: min(100%, 580px); padding: clamp(30px, 7vw, 54px); border: 1px solid #e4ebe6; border-radius: 16px; background: #fff; box-shadow: 0 18px 55px rgba(23,55,35,.08); text-align: center; }
        .icon { display: grid; width: 58px; height: 58px; margin: 0 auto 20px; place-items: center; border-radius: 17px; color: #926b00; background: #fff6dc; font-size: 22px; }
        h1 { margin: 0; font: 700 clamp(24px,5vw,32px)/1.25 'Poppins',sans-serif; }
        p { margin: 13px auto 0; color: #626b65; font-size: 15px; line-height: 1.7; }
        .rule { width: 46px; height: 3px; margin: 25px auto 0; border-radius: 3px; background: #008c45; }
    </style>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
    <main>
        <span class="icon" aria-hidden="true"><i class="fas fa-shield-alt"></i></span>
        <h1>Accès temporairement suspendu</h1>
        <p>{{ $message }}</p>
        <div class="rule" aria-hidden="true"></div>
    </main>
</body>
</html>
