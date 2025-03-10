<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Inclure le fichier CSS avec la méthode asset() -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
</head>
<body>
    <header>
        <!-- Barre de navigation -->
        <nav>
            <ul>
                
                <!-- Ajoutez d'autres liens ici si nécessaire -->
            </ul>
        </nav>
    </header>

    <div class="container">
        @yield('content') <!-- C'est ici que le contenu des vues sera injecté -->
    </div>

    <footer>
    <p>&copy; Ministère de la Fonction publique et de la Réforme du Service public © 2025</p>
</footer>

<style>
    footer {
        text-align: center;
        margin-top: 20px;
        padding: 10px;
        background-color: #f1f1f1;
    }

    footer p {
        margin: 0;
        font-size: 14px;
        color: #333;
    }
</style>

    <!-- Scripts (si nécessaire) -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
