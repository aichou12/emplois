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
       <div class="container mx-auto flex items-center justify-center px-6">
           <div class="flex flex-col items-center text-center space-y-4">
               <img src="images/dss.png" alt="Logo Sénégal" class="h-12">
               <h1 class="text-xl font-bold text-gray-900">
               Ministère de la Fonction Publique Et de la Réforme du Service public
               </h1>
               <h3>Plateforme de gestion des demandes d'emploi à la Fonction Publique (PGDE)</h3>
           </div>
       </div>
   </header>


   <!-- Alerte -->
   <div class="bg-blue-100 text-black-700 p-4 text-center">
       <p>
       Cette plateforme s’adresse à<strong>  tout Sénégalais </strong> souhaitant intégrer la fonction publique.<br>Si vous êtes Sénégalais établi à l’étranger, elle vous offre également l’opportunité de soumettre votre candidature et de mettre votre expertise au service du Sénégal.<br>
               🇸🇳 <strong>Votre engagement fait notre fierté. Ensemble, renforçons notre administration!</strong> 🇸🇳
       </p>
   </div>


   <!-- Conteneur principal -->
   <div class="container mx-auto flex flex-col md:flex-row gap-8 items-center justify-center mt-8 px-6 lg:px-20 h-full">


   <!-- Colonne gauche : Formulaire d'inscription -->
<div class="bg-white shadow-md rounded-md p-6 w-full md:w-1/2 flex flex-col justify-center">

@if (session('success'))
    <p class="bg-green-100 text-green-700 p-2 rounded-md text-center">{{ session('success') }}</p>
@endif

<form action="{{ route('register.store') }}" method="POST" class="h-full flex flex-col justify-between">
    @csrf

    <!-- Prénom -->
    <div class="mb-4">
        <label for="firstname" class="block text-sm font-medium text-gray-700"></label>
        <input type="text" id="firstname" name="firstname" placeholder="Votre prénom" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
    </div>

    <!-- Nom -->
    <div class="mb-4">
        <label for="lastname" class="block text-sm font-medium text-gray-700"></label>
        <input type="text" id="lastname" name="lastname" placeholder="Votre nom" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
    </div>

    <!-- Nom d'utilisateur -->
    <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700"></label>
        <input type="text" id="username" name="username" placeholder="Nom d'utilisateur" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
    </div>

    <!-- CNI -->
    <div class="mb-4">
        <label for="numberid" class="block text-sm font-medium text-gray-700"></label>
        <input type="text" id="numberid" name="numberid" placeholder="Votre numéro de CNI" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
    </div>

    <!-- Email -->
    <div class="mb-4">
        <label for="email" class="block text-sm font-medium text-gray-700"></label>
        <input type="email" id="email" name="email" placeholder="Votre email" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
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

    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition" id="inscription">
        S'inscrire
    </button>
</form>

<p class="mt-4 text-center text-gray-600">
    Vous avez déjà un compte ?
    <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Se connecter</a>
</p>
</div>


   <!-- Colonne droite : Image -->
   <div class="w-full md:w-1/2 flex items-center justify-center h-[475px]">
       <img src="images/img.png" alt="Illustration"
           class="w-full h-full object-cover rounded-lg shadow-md">
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
           <p>fonctionpublique.gouv.sn | gouv.sn | servicepublic.gouv.sn</p>
       </div>
   </footer>

   <script>
    document.addEventListener('DOMContentLoaded', function () {
        const passwordField = document.getElementById('password');
        const confirmPasswordField = document.getElementById('password_confirmation');

        confirmPasswordField.addEventListener('input', function () {
            if (passwordField.value !== confirmPasswordField.value) {
                confirmPasswordField.setCustomValidity("Les mots de passe ne correspondent pas.");
            } else {
                confirmPasswordField.setCustomValidity("");
            }
        });

        passwordField.addEventListener('input', function () {
            if (passwordField.value !== confirmPasswordField.value) {
                confirmPasswordField.setCustomValidity("Les mots de passe ne correspondent pas.");
            } else {
                confirmPasswordField.setCustomValidity("");
            }
        });
    });
</script>
</body>
<style>
#inscription{
    background-color: #00626D;
}
#inscription:hover{
    background-color: #06843F;
}
</style>
</html>
