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
               :drapeau-sn: <strong>Votre engagement fait notre fierté. Ensemble, renforçons notre administration!</strong> :drapeau-sn:
       </p>
   </div>
   <!-- Conteneur principal -->
   <div class="container mx-auto flex flex-col md:flex-row gap-8 items-center justify-center mt-8 px-6 lg:px-20">
       <!-- Colonne gauche : Formulaire -->
       <div class="bg-white shadow-md rounded-md p-6 w-full md:w-1/2">
       <div class="mt-6 text-center">
       <!--<a href="{{ route('register') }}" class="w-full py-3 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition text-center block" id ="compte">
   Créer un compte
</a>-->
           </div>
           <h2 class="text-lg font-semibold text-gray-900 mb-3"><center>Authentification</center></h2>
           <form action="{{ route('login.store') }}" method="POST">
    @csrf  <!-- Protection CSRF obligatoire pour les requêtes POST -->

    <div class="mb-4">
        <label for="username" class="block text-sm font-medium text-gray-700"></label>
        <input type="text" id="username" name="username" placeholder="Votre nom d'utilisateur" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
    </div>

    <div class="mb-4">
        <label for="password" class="block text-sm font-medium text-gray-700"></label>
        <input type="password" id="password" name="password" placeholder="Votre mot de passe" required class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
    </div>

    <div class="flex items-center justify-between mb-4">
        <label class="flex items-center">
            <input type="checkbox" name="remember" class="text-indigo-600 focus:ring-indigo-500">
            <span class="ml-2 text-sm text-gray-600">Se souvenir de moi</span>
        </label>

        <p class="mt-2 text-center text-sm text-gray-600">
    <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline">🔑 J'ai oublié mon mot de passe</a>
</p>

    </div>

    <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition" id="connexion">
        Connexion
    </button>

    <br><br>

    <a href="{{ route('register') }}" class="w-full py-3 bg-orange-500 text-white rounded-md hover:bg-orange-600 transition text-center block" id="compte">
        Créer un compte
    </a>
</form>

           <!-- Bouton "Créer un compte" -->
       </div>
       <!-- Colonne droite : Image -->
   <!-- Colonne droite : Image -->
<!-- Colonne droite : Image -->
<div class="w-full md:w-1/2 flex items-center">
   <img src="images/img.png" alt="Illustration"
        class="w-full h-[415px] md:h-[415px] lg:h-[415px] object-cover rounded-lg shadow-md md:aspect-auto sm:h-[300px] sm:aspect-[4/3]">
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
</body>
<style>
#connexion{
    background-color: #06843F;
}
#compte{
    background-color: #00626D;
}
#compte:hover{
    background-color: #0087B7;
}
#connexion:hover{
    background-color: #008A99;
}
</style>
</html>
