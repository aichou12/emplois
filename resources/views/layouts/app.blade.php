<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PGDE</title>
    <!-- Inclure le fichier CSS avec la méthode asset() -->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />
    <link rel="icon" href="{{ asset('images/mfp.png') }}?v=2" type="image/x-icon">

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
    <footer class="bg-gray-200 text-center text-sm text-gray-700 py-4" style="margin-top:10px">
        <div class="container mx-auto">
            <div class="mb-2">
                <a href="#" class="text-blue-600 hover:underline mx-2">Mentions légales</a> |
                <a href="#" class="text-blue-600 hover:underline mx-2">Confidentialité et Cookies</a> |
                <a href="#" class="text-blue-600 hover:underline mx-2">Contact</a>
            </div>
            <p>© 2025 Ministère de la Fonction Publique et de la Réforme du Service Public - Tous droits réservés.</p>
        </div>
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
