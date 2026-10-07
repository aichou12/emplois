<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#00843F">
    <title>Nouveau mot de passe — Plateforme de Gestion des Demandes d’Emploi</title>
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Poppins:wght@500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --green: #00843F;
            --green-dark: #006B33;
            --green-soft: #EBF7F0;
            --ink: #282B2D;
            --muted: #6C757D;
            --line: #E5E9E6;
            --page: #F4F6F5;
            --danger: #B42318;
            --danger-bg: #FEF3F2;
            --font-heading: 'Poppins', sans-serif;
            --font-body: 'DM Sans', sans-serif;
        }

        *, *::before, *::after { box-sizing: border-box; }

        body {
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
            color: var(--ink);
            background: radial-gradient(ellipse at 50% 0%, #EAF5EE 0%, var(--page) 55%);
            font: 15px/1.55 var(--font-body);
            -webkit-font-smoothing: antialiased;
        }

        .reset-main {
            width: 100%;
            flex: 1;
            display: grid;
            place-items: center;
            padding: 42px 16px;
        }

        .reset-card {
            width: min(100%, 500px);
            padding: 36px 40px 30px;
            border: 1px solid rgba(218, 227, 220, .9);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 18px 50px rgba(33, 62, 44, .09);
        }

        .reset-brand {
            display: grid;
            place-items: center;
            width: 66px;
            height: 66px;
            margin: 0 auto 16px;
            border: 1px solid #E5EFE8;
            border-radius: 50%;
            background: #F8FBF9;
        }

        .reset-brand img { width: 48px; height: 48px; object-fit: contain; }

        .reset-eyebrow {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            margin: 0 0 8px;
            color: var(--green-dark);
            font-size: 11px;
            font-weight: 700;
            letter-spacing: .09em;
            text-transform: uppercase;
        }

        h1 {
            margin: 0;
            color: var(--ink);
            font: 700 23px/1.3 var(--font-heading);
            text-align: center;
        }

        .reset-lead {
            max-width: 370px;
            margin: 10px auto 24px;
            color: var(--muted);
            font-size: 14px;
            text-align: center;
        }

        .reset-error-summary {
            margin: 0 0 18px;
            padding: 12px 15px;
            border: 1px solid #F7C9C5;
            border-left: 4px solid var(--danger);
            border-radius: 8px;
            background: var(--danger-bg);
            color: #7A271A;
            font-size: 13px;
        }

        .reset-error-summary strong { display: block; margin-bottom: 4px; }
        .reset-error-summary ul { margin: 0; padding-left: 19px; }

        .reset-fields { display: grid; gap: 17px; }

        .reset-field label {
            display: block;
            margin-bottom: 7px;
            color: #343A36;
            font-size: 13px;
            font-weight: 600;
        }

        .reset-input-wrap { position: relative; }

        .reset-input-wrap > i {
            position: absolute;
            top: 50%;
            left: 14px;
            color: #87928A;
            font-size: 14px;
            transform: translateY(-50%);
            pointer-events: none;
        }

        .reset-input {
            width: 100%;
            min-height: 48px;
            padding: 11px 46px 11px 42px;
            border: 1px solid var(--line);
            border-radius: 8px;
            outline: 0;
            background: #FAFBFA;
            color: var(--ink);
            font: 14px var(--font-body);
            transition: border-color .16s ease, box-shadow .16s ease, background .16s ease;
        }

        .reset-input::placeholder { color: #9AA39D; }
        .reset-input:focus { border-color: var(--green); background: #fff; box-shadow: 0 0 0 3px rgba(0, 132, 63, .12); }
        .reset-input[aria-invalid="true"] { border-color: var(--danger); }

        .reset-toggle {
            position: absolute;
            top: 50%;
            right: 8px;
            display: grid;
            place-items: center;
            width: 34px;
            height: 34px;
            border: 0;
            border-radius: 6px;
            background: transparent;
            color: #69756D;
            cursor: pointer;
            transform: translateY(-50%);
        }

        .reset-toggle:hover { background: var(--green-soft); color: var(--green-dark); }
        .reset-toggle:focus-visible, .reset-submit:focus-visible, .reset-back:focus-visible { outline: 3px solid rgba(0, 132, 63, .3); outline-offset: 2px; }

        .reset-help { margin: 6px 0 0; color: var(--muted); font-size: 12px; }
        .reset-field-error { margin: 6px 0 0; color: var(--danger); font-size: 12px; }

        .reset-submit {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            width: 100%;
            min-height: 49px;
            margin-top: 23px;
            border: 0;
            border-radius: 8px;
            background: var(--green);
            box-shadow: 0 4px 11px rgba(0, 132, 63, .2);
            color: #fff;
            font: 600 14px var(--font-heading);
            cursor: pointer;
            transition: background .16s ease, transform .16s ease, box-shadow .16s ease;
        }

        .reset-submit:hover { background: var(--green-dark); box-shadow: 0 6px 15px rgba(0, 107, 51, .25); transform: translateY(-1px); }

        .reset-back {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            width: fit-content;
            margin: 20px auto 0;
            color: #56635A;
            font-size: 13px;
            text-decoration: none;
        }

        .reset-back:hover { color: var(--green-dark); text-decoration: underline; }

        @media (max-width: 560px) {
            .reset-main { padding: 24px 12px; }
            .reset-card { padding: 29px 21px 24px; border-radius: 14px; }
            h1 { font-size: 21px; }
        }

        @media (prefers-reduced-motion: reduce) {
            *, *::before, *::after { scroll-behavior: auto !important; transition-duration: .01ms !important; }
        }
    </style>
</head>
<body>
    @include('partials.site-header')

    <main class="reset-main">
        <section class="reset-card" aria-labelledby="reset-title">
            <div class="reset-brand">
                <img src="{{ asset('images/logoPGDE.png') }}" alt="Logo PGDE">
            </div>
            <p class="reset-eyebrow"><i class="fas fa-shield-halved" aria-hidden="true"></i> Sécurisé par la plateforme PGDE</p>
            <h1 id="reset-title">Choisissez un nouveau mot de passe</h1>
            <p class="reset-lead">Saisissez l’adresse e-mail de votre compte, puis choisissez un mot de passe d’au moins 8 caractères.</p>

            @if ($rateLimited ?? false)
                <div class="reset-error-summary" role="alert">
                    <strong>Veuillez patienter avant de continuer.</strong>
                    <p>{{ $rateLimitMessage }}</p>
                </div>
                <a class="reset-submit" href="{{ route('password.request') }}" style="text-decoration:none;">Demander un nouveau lien</a>
            @else
            @if ($errors->any())
                <div class="reset-error-summary" role="alert">
                    <strong>La réinitialisation n’a pas pu être effectuée.</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('password.update') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="reset-fields">
                    <div class="reset-field">
                        <label for="email">Adresse e-mail</label>
                        <div class="reset-input-wrap">
                            <i class="fas fa-envelope" aria-hidden="true"></i>
                            <input class="reset-input" type="email" id="email" name="email" value="{{ $email ?? old('email') }}" placeholder="nom@exemple.sn" autocomplete="email" required autofocus @if($errors->has('email')) aria-invalid="true" @endif>
                        </div>
                    </div>

                    <div class="reset-field">
                        <label for="password">Nouveau mot de passe</label>
                        <div class="reset-input-wrap">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input class="reset-input" type="password" id="password" name="password" placeholder="8 caractères minimum" autocomplete="new-password" minlength="8" required aria-describedby="password-help" @if($errors->has('password')) aria-invalid="true" @endif>
                            <button class="reset-toggle" type="button" data-toggle-password="password" aria-label="Afficher le mot de passe"><i class="fas fa-eye" aria-hidden="true"></i></button>
                        </div>
                        <p class="reset-help" id="password-help">Utilisez au moins 8 caractères.</p>
                        @error('password')<p class="reset-field-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="reset-field">
                        <label for="password_confirmation">Confirmer le nouveau mot de passe</label>
                        <div class="reset-input-wrap">
                            <i class="fas fa-lock" aria-hidden="true"></i>
                            <input class="reset-input" type="password" id="password_confirmation" name="password_confirmation" placeholder="Saisissez-le à nouveau" autocomplete="new-password" minlength="8" required>
                            <button class="reset-toggle" type="button" data-toggle-password="password_confirmation" aria-label="Afficher la confirmation du mot de passe"><i class="fas fa-eye" aria-hidden="true"></i></button>
                        </div>
                    </div>
                </div>

                <button class="reset-submit" type="submit">
                    <i class="fas fa-key" aria-hidden="true"></i>
                    <span>Enregistrer le nouveau mot de passe</span>
                </button>
            </form>

            <a class="reset-back" href="{{ route('login') }}"><i class="fas fa-arrow-left" aria-hidden="true"></i> Retour à la connexion</a>
            @endif
        </section>
    </main>

    @include('partials.user-footer')

    <script>
        document.querySelectorAll('[data-toggle-password]').forEach((button) => {
            button.addEventListener('click', () => {
                const input = document.getElementById(button.dataset.togglePassword);
                if (!input) return;

                const visible = input.type === 'password';
                input.type = visible ? 'text' : 'password';
                button.setAttribute('aria-label', visible ? 'Masquer le mot de passe' : 'Afficher le mot de passe');
                button.querySelector('i')?.classList.toggle('fa-eye', !visible);
                button.querySelector('i')?.classList.toggle('fa-eye-slash', visible);
            });
        });
    </script>
</body>
</html>
