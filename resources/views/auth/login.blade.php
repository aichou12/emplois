
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


</head>

<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="bg-white shadow-md">
     <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-6 py-4">
      
      <!-- Logo gauche -->
      <div class="flex flex-col items-center text-center space-y-1">
        <a href="#">
          <img src="../../images/dss.png" alt="Drapeau Sénégal" class="h-12">
        </a>
        <p class="text-sm font-bold text-gray-900">République du Sénégal</p>
        <p class="text-xs text-gray-600 italic">Un peuple, Un but, Une foi</p>
      </div>

      <!-- Titre central -->
      <div class="mt-4 md:mt-0 text-center">
        <p class="text-xl md:text-2xl font-extrabold text-gray-800 tracking-wide">
          Plateforme de Gestion des Demandes d'Emploi
        </p>
      </div>

      <!-- Logo droite -->
      <div class="flex items-center space-x-3 mt-4 md:mt-0">
        <img src="../../images/mfp.png" alt="Ministère Fonction Publique" class="h-14 object-contain">
        <div class="text-sm font-bold text-gray-900 leading-tight">
  Ministère de la Fonction Publique <br>
  <span class="font-bold">et de la Réforme du Service Public</span>
</div>

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
    <script>
        function showModal() {
            const modal = document.getElementById('alertModal');
            modal.classList.remove('hidden', 'zoom-out');
            modal.classList.add('zoom-in', 'show');

            // Fermer automatiquement après 5 secondes
            setTimeout(closeModal, 5000);
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
    </script>
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

    <footer class="bg-gray-200 text-center text-sm text-gray-700 py-4" style="margin-top:100px">
        <div class="container mx-auto">
            <div class="mb-2">
            <a href="https://www.fonctionpublique.gouv.sn/" class="text-blue-600 hover:underline mx-2">Ministère de la Fonction publique</a> |
            <a href="https://presidence.sn" class="text-blue-600 hover:underline mx-2">Le Président de la République</a> |
            <a href="https://primature.sn/" class="text-blue-600 hover:underline mx-2">Gouvernement du Sénégal</a>
            </div>
            <p>© {{ date('Y') }} Ministère de la Fonction Publique et de la Réforme du Service Public - Tous droits réservés.</p>
        </div> 
    </footer>
</body>
</html>

