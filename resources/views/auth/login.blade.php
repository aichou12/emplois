<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

    <!-- Header -->
    <header class="bg-white py-4 shadow">
        <div class="container mx-auto flex items-center justify-center px-6">
            <div class="flex flex-col items-center text-center space-y-4">
                <img src="images/dss.png" alt="Logo Sénégal" class="h-12">
                <h1 class="text-xl font-bold text-gray-900">
                    SERVIR MON PAYS
                </h1>
            </div>
        </div>
    </header>

    <!-- Alerte -->
    <div class="bg-blue-100 text-black-700 p-4 text-center">
        <p>
            Cette plateforme est <strong> dédiée aux Sénégalais de la diaspora</strong> souhaitant intégrer la fonction publique et contribuer au développement 
            du pays.<br>
            Pour toute assistance, contactez-nous à <strong>plateforme-emploi.fpubliquesn.com</strong>.
        </p>
    </div>

    <!-- Conteneur principal -->
    <div class="container mx-auto flex flex-col md:flex-row gap-8 items-center justify-center mt-8 px-6 lg:px-20">

        <!-- Colonne gauche : Formulaire -->
        <div class="bg-white shadow-md rounded-md p-6 w-full md:w-1/2">
            @if (session('success'))
                <div class="bg-green-100 text-green-800 p-4 rounded-md mb-4">
                    {{ session('success') }}
                </div>
            @endif

            <h2 class="text-lg font-semibold text-gray-900 mb-4">Se connecter</h2>

            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" id="email" name="email" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all ease-in-out">
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                    <input type="password" id="password" name="password" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 transition-all ease-in-out">
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" class="text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                    
                 </div>

                <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                    Connexion
                </button>
            </form>

            <!-- Bouton "Créer un compte" -->
            <div class="mt-6 text-center">
                <p class="text-gray-600">Pas de compte ? 
                    <a href="{{ route('register') }}" class="text-blue-600 hover:underline">Créer un compte</a>
                </p>
            </div>
        </div>

        <!-- Colonne droite : Image -->
        <div class="w-full md:w-1/2">
            <img src="images/fon.png" alt="Illustration" class="w-full h-auto rounded-lg shadow-md">
        </div>

    </div>

    <!-- Pied de page -->
    <footer class="bg-gray-200 text-center text-sm text-gray-700 py-4 mt-8">
        <div class="container mx-auto">
            <div class="mb-2">
                <a href="#" class="text-blue-600 hover:underline mx-2">Mentions légales</a> |
                <a href="#" class="text-blue-600 hover:underline mx-2">Confidentialité et Cookies</a> |
                <a href="#" class="text-blue-600 hover:underline mx-2">Contact</a>
            </div>
            <p>fonctionpublique.gouv.sn | gouv.sn | presidence.sn | servicepublic.gouv.sn</p>
        </div>
    </footer>

</body>
</html>
