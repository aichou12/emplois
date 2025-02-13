<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Vérification de l'email</title>
</head>
<body>
    <h1>Vérifiez votre adresse e-mail</h1>

    @if (session('status') == 'verification-link-sent')
        <p style="color:green;">
            Un nouveau lien de vérification a été envoyé à {{ Auth::user()->email }}.
        </p>
    @endif

    <p>
        Avant de continuer, veuillez vérifier vos mails et cliquer sur le lien.
        <br>Si vous n'avez pas reçu l'email,
        cliquez ci-dessous pour le renvoyer :
    </p>

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">Renvoyer l’e-mail de vérification</button>
    </form>
</body>
</html>
