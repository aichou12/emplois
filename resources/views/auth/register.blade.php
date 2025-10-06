<!DOCTYPE html>
<html lang="fr">
<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Créer un compte</title>
   <link rel="icon" href="images/mfp.png" type="image/x-icon">
   <script src="https://cdn.tailwindcss.com"></script>
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
                    <input type="text" id="firstname" name="firstname" placeholder="Votre prénom"
    value="{{ old('firstname') }}" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
   </div>
                <!-- Nom -->
                <div class="w-1/2">
                    <label for="lastname" class="block text-sm font-medium text-gray-700"></label>
                    <input type="text" id="lastname" name="lastname" placeholder="Votre nom"
    value="{{ old('lastname') }}" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
    </div>
            </div>
            <!-- Nom d'utilisateur et CNI sur la même ligne -->
            <div class="mb-4 flex gap-4">
                <!-- Nom d'utilisateur -->
                <div class="w-1/2">
                    <label for="username" class="block text-sm font-medium text-gray-700"></label>
                    <input type="text" id="username" name="username" placeholder="Nom d'utilisateur"
    value="{{ old('username') }}" required
    class="block mt-1 w-full p-4 border rounded-lg @error('username') border-red-500 @else border-gray-300 @enderror">
@error('username')
    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
@enderror
     </div>
                <!-- CNI -->
                <div class="w-1/2">
                <label for="numberid" class="block text-sm font-medium text-gray-700"></label>
                <input type="text" id="numberid" name="numberid" placeholder="CNI ou Passport"
    value="{{ old('numberid') }}" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg @error('numberid') border-red-500 @enderror">
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
  <!-- Colonne droite : Vidéo avec miniature et bouton play -->
<div class="w-full md:w-1/2 flex items-center justify-center h-[475px] relative">
    <!-- Miniature avec bouton play -->
    <div id="video-thumbnail" class="relative cursor-pointer w-full h-64 md:h-80 lg:h-96 rounded-lg overflow-hidden shadow-lg">
        <img src="images/img.png" alt="Comment s'inscrire" class="w-full h-full object-cover">
        <div class="absolute inset-0 flex items-center justify-center">
            <img src="images/play-button.png" alt="Play" class="w-16 h-16">
        </div>
    </div>

    <!-- Iframe cachée par défaut -->
    <iframe id="videoFrame" class="absolute top-0 left-0 w-full h-64 md:h-80 lg:h-96 rounded-lg shadow-lg hidden"
            src="https://www.youtube.com/embed/xuPkjiRKuiY?autoplay=1"
            frameborder="0"
            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
            allowfullscreen>
    </iframe>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const thumbnail = document.getElementById('video-thumbnail');
        const videoFrame = document.getElementById('videoFrame');

        if (thumbnail && videoFrame) {
            thumbnail.addEventListener('click', function () {
                thumbnail.style.display = 'none';
                videoFrame.classList.remove('hidden');
                // Relancer la vidéo avec autoplay
                const baseUrl = "https://www.youtube.com/embed/xuPkjiRKuiY";
                videoFrame.src = `${baseUrl}?autoplay=1`;
            });
        }
    });
</script>

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
