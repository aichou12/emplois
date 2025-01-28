<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Créer un compte</title>
</head>
<body>
    <h1>Créer un compte</h1>

    @if (session('success'))
        <p>{{ session('success') }}</p>
    @endif

    <form action="{{ route('register.store') }}" method="POST">
        @csrf

        <div>
            <label for="name">Nom complet</label>
            <input type="text" id="name" name="name" required>
        </div>

     

        <div>
            <label for="cni">CNI</label>
            <input type="text" id="cni" name="cni" required>
        </div>

        <div>
            <label for="email">Email</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div>
            <label for="password">Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>

        <div>
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input type="password" id="password_confirmation" name="password_confirmation" required>
        </div>

        <button type="submit">S'inscrire</button>
    </form>
<!-- 
    <p>Vous avez déjà un compte ? <a href="{{ route('login') }}">Se connecter</a></p> -->


</body>
</html>
