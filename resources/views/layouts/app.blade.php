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
        <p>&copy; 2025 Votre entreprise</p>
    </footer>

    <!-- Scripts (si nécessaire) -->
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>
