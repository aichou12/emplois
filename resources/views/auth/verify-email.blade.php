<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Activation du compte — PGDE</title>
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
</head>
<body class="bg-light">
    @include('partials.site-header')

    <main class="container py-5" style="max-width: 760px;">
        <section class="bg-white border rounded-3 shadow-sm p-4 p-md-5">
            <h1 class="h3 mb-3">Activez votre compte</h1>

            @if (session('status') === 'verification-link-sent')
                <div class="alert alert-success" role="status">
                    Un nouveau lien d’activation a été envoyé à {{ $user?->email }}.
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first() }}
                </div>
            @endif

            @if ($user)
                <p>Votre compte n’est pas encore activé. Consultez l’adresse <strong>{{ $user->email }}</strong> et suivez le lien reçu. Le lien est valable 60 minutes.</p>
                <form method="POST" action="{{ route('verification.send') }}" class="mt-4">
                    @csrf
                    <button type="submit" class="btn btn-success">Renvoyer le lien d’activation</button>
                </form>
            @else
                <p>Consultez l’adresse e-mail utilisée lors de votre inscription et suivez le lien d’activation. Si le lien a expiré, connectez-vous pour en demander un nouveau.</p>
                <a class="btn btn-success mt-3" href="{{ route('login') }}">Aller à la connexion</a>
            @endif
        </section>
    </main>
</body>
</html>
