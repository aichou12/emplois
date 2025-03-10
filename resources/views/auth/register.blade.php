<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Créer un compte</title>
   <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
   <!-- Header -->
   <header class="bg-white py-4 shadow">
        <div class="container mx-auto flex flex-col md:flex-row items-center justify-between px-4 md:px-6">
            <div class="w-full md:w-1/4 flex flex-col items-center text-center space-y-1">
                <a href="#"><img src="images/dss.png" alt="Ministère de la Fonction Publique" class="h-10"></a>
                <p class="text-sm md:text-base font-bold text-gray-900">République du Sénégal</p>
                <p class="pbf text-xs md:text-sm mt-0">Un peuple, Un but, Une foi</p>
            </div>
            <div class="w-full md:w-2/4 flex justify-center items-center text-center">
                <p class="text-base md:text-lg font-bold text-gray-900">Plateforme de gestion des demandes d'emploi</p>
            </div>
            <div class="w-full md:w-1/4 flex flex-row items-center justify-center space-x-2">
                <a href="#"><img src="images/mfp.png" alt="Ministère" class="h-12 md:h-14 object-contain"></a>
                <p class="text-sm md:text-base font-bold text-gray-900">
        <a href="#" class="text-black">
            Ministère de la Fonction Publique <br class="hidden"> Et de la Réforme du Service public
        </a>
    </p>     </div>
        </div>
    </header>
   <!-- Alerte -->
   <div class="bg-blue-100 text-black-700 p-4 text-center">
       <p>
       Cette plateforme s’adresse à<strong>  tout Sénégalais </strong> souhaitant intégrer la fonction publique.<br>Si vous êtes Sénégalais établi à l’étranger, elle vous offre également l’opportunité de soumettre votre candidature et de mettre votre expertise au service du Sénégal.<br>
              <strong>Votre engagement fait notre fierté. Ensemble, renforçons notre administration!</strong> 
       </p>
   </div>
   <!-- Conteneur principal -->
   <div class="container mx-auto flex flex-col md:flex-row gap-8 items-center justify-center mt-8 px-6 lg:px-20 h-full bg-white rounded-md p-6">
      <!-- Colonne gauche : Formulaire d'inscription -->
      <div class="w-full md:w-1/2 flex flex-col justify-center">
         @if (session('success'))
            <p class="bg-green-100 text-green-700 p-2 rounded-md text-center">{{ session('success') }}</p>
         @endif
         <form action="{{ route('register.store') }}" method="POST" class="h-full flex flex-col justify-between">
            @csrf
            <!-- Prénom et Nom sur la même ligne -->
            <div class="mb-4 flex gap-4">
                <!-- Prénom -->
                <div class="w-1/2">
                    <label for="firstname" class="block text-sm font-medium text-gray-700"></label>
                    <input type="text" id="firstname" name="firstname" placeholder="Votre prénom" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <!-- Nom -->
                <div class="w-1/2">
                    <label for="lastname" class="block text-sm font-medium text-gray-700"></label>
                    <input type="text" id="lastname" name="lastname" placeholder="Votre nom" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
            </div>
            <!-- Nom d'utilisateur et CNI sur la même ligne -->
            <div class="mb-4 flex gap-4">
                <!-- Nom d'utilisateur -->
                <div class="w-1/2">
                    <label for="username" class="block text-sm font-medium text-gray-700"></label>
                    <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <!-- CNI -->
                <div class="w-1/2">
                <label for="numberid" class="block text-sm font-medium text-gray-700"></label>
        <input type="text" id="numberid" name="numberid" placeholder="Votre numéro de CNI" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg @error('numberid') border-red-500 @enderror">
        @error('numberid')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror </div>
       
            </div>
            <!-- Email et Confirmer l'email sur la même ligne -->
            <div class="mb-4 flex gap-4">
    <!-- Email -->
    <div class="w-1/2">
        <label for="email" class="block text-sm font-medium text-gray-700"></label>
        <input type="email" id="email" name="email" placeholder="Votre email" required 
               class="block mt-1 w-full p-4 border border-gray-300 rounded-lg @error('email') border-red-500 @enderror">
        @error('email')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Confirmer l'email -->
    <div class="w-1/2">
        <label for="email_confirmation" class="block text-sm font-medium text-gray-700"></label>
        <input type="email" id="email_confirmation" name="email_confirmation" placeholder="Confirmer l'email" required 
               class="block mt-1 w-full p-4 border border-gray-300 rounded-lg @error('email_confirmation') border-red-500 @enderror">
        @error('email_confirmation')
            <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
        @enderror
    </div>
</div>

            <!-- Mot de passe -->
            <div class="mb-4 flex flex-col md:flex-row gap-4">
                <div class="w-full">
                    <label for="password" class="block text-sm font-medium text-gray-700"></label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Choisissez un mot de passe"
                        required
                        pattern="(?=.*[A-Z])(?=.*\d).{8,}"
                        title="Le mot de passe doit contenir au moins 8 caractères, une majuscule et un chiffre."
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
                <!-- Confirmation du mot de passe -->
                <div class="w-full">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700"></label>
                    <input
                        type="password"
                        id="password_confirmation"
                        name="password_confirmation"
                        placeholder="Confirmer le mot de passe"
                        required
                        class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                </div>
            </div>
            <!-- Boutons S'inscrire et Annuler sur la même ligne -->
            <div class="flex gap-4">
                <button type="submit" class="w-full py-3 bg-green-600 text-white rounded-md hover:bg-green-700 transition" id="inscription">
                    S'inscrire
                </button>
                <!-- <button type="button" class="w-1/2 py-3 bg-red-600 text-white rounded-md hover:bg-red-700 transition" id="cancelButton" onclick="window.location.href='{{ route('login') }}'">
                    Annuler
                </button> -->
            </div>
         </form>
         <p class="mt-4 text-center text-gray-600">
            Vous avez déjà un compte ?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Se connecter</a>
         </p>
      </div>

      <!-- Colonne droite : Image -->
      <div class="w-full md:w-1/2 flex items-center justify-center h-[475px]">
         <iframe id="videoFrame" class="w-full h-64 md:h-80 lg:h-96 rounded-lg shadow-lg" 
                  src="https://www.youtube.com/embed/xuPkjiRKuiY?autoplay=1&mute=1" 
                  frameborder="0"
                  allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                  allowfullscreen>
         </iframe> 
      </div>
   </div>

   @if (session('success'))
      <div id="successPopup" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
          <div class="bg-white p-6 rounded-md shadow-md max-w-sm text-center">
              <h2 class="text-lg font-bold text-green-600 mb-4">Inscription réussie !</h2>
              <p>Un lien d'activation de votre compte vous a été envoyé par email.</p>
              <button id="closePopup" class="mt-4 px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Fermer</button>
          </div>
      </div>
   @endif

   <!-- Pied de page -->
   <footer class="bg-gray-200 text-center text-sm text-gray-700 py-4 mt-8">
      <div class="container mx-auto">
          <div class="mb-2">
              <a href="#" class="text-blue-600 hover:underline mx-2">Mentions légales</a> |
              <a href="#" class="text-blue-600 hover:underline mx-2">Confidentialité et Cookies</a> |
              <a href="#" class="text-blue-600 hover:underline mx-2">Contact</a>
          </div>
          <p>fonctionpublique.gouv.sn | gouv.sn | servicepublic.gouv.sn</p>
      </div>
   </footer>

   <script>
       document.addEventListener('DOMContentLoaded', function () {
           const successPopup = document.getElementById('successPopup');
           const closePopupButton = document.getElementById('closePopup');
           if (closePopupButton) {
               closePopupButton.addEventListener('click', function () {
                   // Fermer le pop-up
                   successPopup.style.display = 'none';
                   // Rediriger vers la page de connexion
                   window.location.href = "{{ route('login') }}";
               });
           }
       });
   </script>
</body>
<style>
   #inscription{
       background-color: #00626D;
   }
   #inscription:hover{
       background-color: #218838;
   }
</style>
</html>
