
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <link rel="icon" href="images/dss.png" type="image/x-icon">
    <script src="https://cdn.tailwindcss.com"></script>

    <style>
        /* Animation d'apparition et disparition avec zoom */
        .hidden {
            display: none;
        }

        .zoom-in {
            transform: scale(0);
            opacity: 0;
            transition: transform 0.4s ease-out, opacity 0.4s ease-out;
        }

        .zoom-in.show {
            transform: scale(1);
            opacity: 1;
        }

        .zoom-out {
            transform: scale(0);
            opacity: 0;
            transition: transform 0.4s ease-in, opacity 0.4s ease-in;
        }
        @media (max-width: 640px) {
            .titre-plateforme {
                font-size: 18px;
            }
        }
        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .content {
            flex: 1;
        }
        footer {
            position: relative;
            bottom: 0;
            width: 100%;
        }
    </style>
 <!--  le pop up affich une seule fois par session -->
 <script>
    function showModal() {
        const modal = document.getElementById('alertModal');
        modal.classList.remove('hidden', 'opacity-0');
        modal.classList.add('opacity-100');

    <script>
        function showModal() {
            const modal = document.getElementById('alertModal');
            modal.classList.remove('hidden', 'zoom-out');
            modal.classList.add('zoom-in', 'show');
        const modalContent = modal.querySelector('div');
        modalContent.classList.remove('scale-95');
        modalContent.classList.add('scale-100');

        // Fermer automatiquement après 5 secondes
        setTimeout(closeModal, 10000);
    }

        function closeModal() {
            const modal = document.getElementById('alertModal');
            modal.classList.remove('zoom-in', 'show');
            modal.classList.add('zoom-out');

            setTimeout(() => {
                modal.classList.add('hidden');
            }, 400); // Temps de transition
        }

        window.onload = function () {
            if (!sessionStorage.getItem('popupShown')) {
                showModal();
                sessionStorage.setItem('popupShown', 'true');
            }
        };
        function closeModal() {
        const modal = document.getElementById('alertModal');
        modal.classList.remove('opacity-100');
        modal.classList.add('opacity-0');

        const modalContent = modal.querySelector('div');
        modalContent.classList.remove('scale-100');
        modalContent.classList.add('scale-95');

        setTimeout(() => {
            modal.classList.add('hidden');
        }, 300);
    }

    window.onload = function () {
        if (!sessionStorage.getItem('popupShown')) {
            showModal();
            sessionStorage.setItem('popupShown', 'true');
        }
    };
    </script>

</head>

<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="bg-white py-4">

    <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4 md:px-6">
        <!-- Partie gauche -->
        <div class="w-full md:w-1/4 flex flex-col items-center text-center space-y-1">
            <a href="#">
                <img src="../../images/dss.png" alt="Ministère de la Fonction Publique" class="h-10" style="margin-top:20px">
            </a>
            <p class="text-sm md:text-base font-bold text-gray-900">
                <a href="#" class="text-black">
                    République du Sénégal
                </a>
            </p>
            <p class="pbf text-xs md:text-sm mt-0">Un peuple, Un but, Une foi</p>
        </div>

        <!-- Partie centrale : Plateforme de gestion des demandes d'emploi -->
        <div class="w-full md:w-2/4 flex justify-center items-center text-center">
            <p class="text-sm md:text-[25px] font-bold text-gray-900">
                Plateforme de Gestion des Demandes d'Emploi
            </p>
        </div>

        <!-- Partie droite -->
        <div class="w-full md:w-1/4 flex flex-row items-center justify-center space-x-2">
            <a href="#">
                <img src="../../images/mfp.png" alt="Ministère de la Fonction Publique" class="h-12 md:h-20 object-contain">
            </a>
            <p class="text-sm md:text-base font-bold text-gray-900 text-center md:text-left leading-tight">
                <a href="#" class="text-black block">
                    Ministère de la Fonction Publique
                </a>
                <a href="#" class="text-black block">
                    et de la Réforme du Service Public
                </a>
            </p>
        </div>
    </div>
</header>




    <!-- Modal Alerte avec effet de zoom -->
    <div id="alertModal" class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-50 hidden zoom-in">
        <div class="bg-white p-6 rounded-lg shadow-lg max-w-lg mx-4 text-center">
            <p class="text-lg text-black">
                Cette plateforme s’adresse à<strong> tout Sénégalais </strong> souhaitant intégrer la fonction publique.<br>
                Si vous êtes Sénégalais établi à l’étranger, vous pouvez soumettre votre candidature.<br>
                <strong>Votre engagement fait notre fierté. Ensemble, renforçons notre administration!</strong>
            </p>
            <button onclick="closeModal()" class="mt-4 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                Fermer
            </button>
        </div>
    </div>

    <!-- Conteneur principal -->
    <div id="mainContent" class="container mx-auto flex flex-col md:flex-row gap-8 items-stretch justify-center mt-8 px-6 lg:px-20 equal-height-container" style="margin-top:50px">
        <!-- Formulaire -->
        <div class="bg-white shadow-md rounded-md p-6 w-full md:w-1/2 flex flex-col justify-center form-container">
            <h2 class="text-lg font-semibold text-gray-900 mb-3 text-center">Authentification</h2>
            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                @if ($errors->has('login'))
                    <div class="alert alert-danger text-center text-red-600">
                        ⚠️ {{ $errors->first('login') }}
                    </div>
                @endif

                <div class="mb-4">
                    <input type="text" id="username" name="username" placeholder="Votre nom d'utilisateur" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>

                <div class="mb-4">
                    <input type="password" id="password" name="password" placeholder="Votre mot de passe" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>

                <div class="flex items-center justify-between mb-4">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember" class="text-indigo-600 focus:ring-indigo-500">
                        <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
                    </label>
                    <p class="mt-2 text-center text-sm text-gray-600">
                        <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">🔑 Mot de passe oublié</a>
                    </p>
                </div>

                <!-- Boutons -->
                <div class="flex gap-4 mt-4">
                    <button type="submit" class="w-1/2 py-3 bg-green-600 text-white rounded-md hover:bg-green-700">Connexion</button>
                    <a href="{{ route('register') }}" class="w-1/2 py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 text-center">Créer un compte</a>
                </div>
            </form>
        </div>

        <!-- Vidéo -->
        <div class="w-full md:w-1/2 flex items-center justify-center">
               <img src="images/img.png" alt="Illustration"
                    class="w-full h-[415px] object-cover rounded-lg shadow-md">
        </div>
    </div>


    <footer class="bg-gray-200 text-center text-sm text-gray-700 py-4 mt-16">

    <footer class="bg-gray-200 text-center text-sm text-gray-700 py-4" style="margin-top:150px">
        <div class="container mx-auto">
            <div class="mb-2">
                <a href="#" class="text-blue-600 hover:underline mx-2">Mentions légales</a> |
                <a href="#" class="text-blue-600 hover:underline mx-2">Confidentialité et Cookies</a> |
                <a href="#" class="text-blue-600 hover:underline mx-2">Contact</a>
            </div>
            <p>© 2025 Ministère de la Fonction Publique et de la Réforme du Service Public - Tous droits réservés.</p>
        </div>
    </footer>
</body>
</html>

