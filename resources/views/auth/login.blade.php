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
    </style>

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
</head>

<body class="bg-gray-100 font-sans">
    <!-- Header -->
    <header class="bg-white py-4">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4 md:px-6">
            <div class="w-full md:w-1/4 flex flex-col items-center text-center space-y-1">
                <a href="#">
                    <img src="../../images/dss.png" alt="Ministère de la Fonction Publique" class="h-10 mt-4 md:h-16">
                </a>
                <p class="text-sm md:text-base font-bold text-gray-900">
                    <a href="#" class="text-black">
                        République du Sénégal
                    </a>
                </p>
                <p class="pbf text-xs md:text-sm mt-0">Un peuple, Un but, Une foi</p>
            </div>

            <div class="w-full md:w-2/4 flex justify-center items-center text-center mt-4 md:mt-0">
                <p class="text-sm md:text-2xl font-bold text-gray-900">
                    Plateforme de Gestion des Demandes d'Emploi
                </p>
            </div>

            <div class="w-full md:w-1/4 flex flex-row items-center justify-center space-x-2">
                <a href="#">
                    <img src="../../images/mfp.png" alt="Ministère de la Fonction Publique" class="h-16 md:h-28 object-contain">
                </a>
                <p class="text-sm md:text-base font-bold text-gray-900 ">
                    <a href="#" class="text-black block">
                        Ministère de la Fonction Publique
                    </a>
                    <a href="#" class="text-black block">
                        Et de la Réforme du Service Public
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

    <!-- Bulle flottante qui ouvre le chatbot -->
    <div id="chatBubble" onclick="toggleChatbot()" class="fixed bottom-4 right-4 w-16 h-16 bg-blue-600 text-white rounded-full flex items-center justify-center cursor-pointer shadow-lg hover:bg-blue-700">
        <span class="text-xl">💬</span>
    </div>

    <!-- Chatbot -->
    <div id="chatbot" class="fixed bottom-4 right-4 p-4 bg-gray-800 text-white rounded-lg shadow-lg max-w-xs w-80 hidden">
        <div id="chatMessages" class="space-y-2 max-h-80 overflow-y-auto">
            <div class="chatbot-message">Salut ! Comment puis-je vous aider ?</div>
            <div class="chatbot-message">1️⃣ Inscription</div>
            <div class="chatbot-message">2️⃣ Réinitialiser mon mot de passe</div>
        </div>
        <input type="text" id="userInput" placeholder="Tapez votre choix..." class="w-full mt-2 p-2 border border-gray-300 rounded-md">
        <button onclick="sendMessage()" class="mt-2 w-full bg-blue-600 text-white p-2 rounded-md hover:bg-blue-700">Envoyer</button>
        <button onclick="toggleChatbot()" class="mt-2 w-full bg-red-600 text-white p-2 rounded-md hover:bg-red-700">Fermer</button>
    </div>

 <script>
    // Fonction pour afficher ou masquer le chatbot en cliquant sur la bulle
function toggleChatbot() {
    let chatbot = document.getElementById("chatbot");
    let chatBubble = document.getElementById("chatBubble");
    let userInput = document.getElementById("userInput");
    let chatMessages = document.getElementById("chatMessages");

    // Si le chatbot est ouvert, on le ferme et on réinitialise
    if (!chatbot.classList.contains("hidden")) {
        chatbot.classList.add("hidden");
        chatBubble.classList.remove("hidden");  // Réafficher la bulle lorsque le chatbot est fermé

        // Réinitialiser le champ de saisie
        userInput.value = '';

        // Effacer uniquement les messages de l'utilisateur
        let initialMessages = chatMessages.querySelectorAll('.chatbot-message.initial');
        chatMessages.innerHTML = '';
        // Ajouter les messages initiaux à la conversation
        initialMessages.forEach(message => chatMessages.appendChild(message));
    } else {
        chatbot.classList.remove("hidden");
        chatBubble.classList.add("hidden");  // Cacher la bulle lorsque le chatbot est ouvert
    }
}

// Fonction pour afficher la réponse du chatbot
function sendMessage() {
    let userInput = document.getElementById("userInput").value.trim(); // Récupère ce que l'utilisateur a tapé
    let chatMessages = document.getElementById("chatMessages");

    // Ajouter le message de l'utilisateur dans la conversation
    chatMessages.innerHTML += '<div class="chatbot-message">Vous avez tapé : ' + userInput + '</div>';

    // Réponse en fonction de ce que l'utilisateur a écrit
    if (userInput === "1") {
        chatMessages.innerHTML += '<div class="chatbot-message">🔹 Pour vous inscrire, cliquez sur le bouton "Créer un compte" et remplissez le formulaire avec vos informations personnelles. Vous recevrez ensuite un e-mail pour activer votre compte.</div>';
    } else if (userInput === "2") {
        chatMessages.innerHTML += `
        <div class="chatbot-message">
            🔹 Voici les étapes pour réinitialiser votre mot de passe :
            <ol class="list-decimal pl-5">
                <li>Accédez à la page de connexion de notre plateforme.</li>
                <li>Cliquez sur "Mot de passe oublié".</li>
                <li>Entrez l'adresse e-mail associée à votre compte.</li>
                <li>Vous recevrez un e-mail avec un lien pour réinitialiser votre mot de passe.</li>
                <li>Cliquez sur le lien dans l'e-mail et saisissez un nouveau mot de passe.</li>
                <li>Soumettez le nouveau mot de passe et vous pourrez vous connecter avec celui-ci.</li>
            </ol>
        </div>
        `;
    } else {
        chatMessages.innerHTML += '<div class="chatbot-message">Désolé, je n’ai pas compris votre choix. Veuillez entrer "1" pour inscription ou "2" pour réinitialiser votre mot de passe.</div>';
    }

    // Effacer le champ de saisie
    document.getElementById("userInput").value = "";

    // Faire défiler les messages vers le bas
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

// Fonction de fermeture de la modale
function closeModal() {
    const modal = document.getElementById('alertModal');
    modal.classList.remove('zoom-in', 'show');
    modal.classList.add('zoom-out');

    // Réinitialiser les champs du formulaire de la modale
    const usernameInput = document.getElementById('username');
    const passwordInput = document.getElementById('password');

    usernameInput.value = '';  // Effacer le nom d'utilisateur
    passwordInput.value = '';  // Effacer le mot de passe

    setTimeout(() => {
        modal.classList.add('hidden');
    }, 400); // Temps de transition
}

window.onload = function () {
    if (!sessionStorage.getItem('popupShown')) {
        showModal();
        sessionStorage.setItem('popupShown', 'true');
    }

    // Ajouter les messages initiaux au chargement de la page
    const chatMessages = document.getElementById("chatMessages");
    chatMessages.innerHTML = `
        <div class="chatbot-message initial">Salut ! Comment puis-je vous aider ?</div>
        <div class="chatbot-message initial">1️⃣ Inscription</div>
        <div class="chatbot-message initial">2️⃣ Réinitialiser mon mot de passe</div>
    `;
};

 </script>

    <footer class="bg-gray-200 text-center text-sm text-gray-700 py-4 mt-16">
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
