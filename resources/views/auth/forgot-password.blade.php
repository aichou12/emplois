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
                <p class="text-sm md:text-base font-bold text-gray-900">Ministère de la Fonction Publique</p>
            </div>
        </div>
    </header>
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


   <!-- Alerte -->
   <div class="bg-blue-100 text-black-700 p-4 text-center">
       <p>
       Cette plateforme s’adresse à<strong> tout Sénégalais </strong> souhaitant intégrer la fonction publique.<br>
       Si vous êtes Sénégalais établi à l’étranger, elle vous offre également l’opportunité de soumettre votre candidature et de mettre votre expertise au service du Sénégal.<br>
       <strong>Votre engagement fait notre fierté. Ensemble, renforçons notre administration!</strong>
       </p>
   </div>
</br>
   <!-- Conteneur principal -->
   <div class="container mx-auto flex flex-col md:flex-row items-center justify-center">
       <!-- Formulaire -->
       <div class="bg-white shadow-md rounded-md p-6 w-full md:w-1/2">
           <h2 class="text-lg font-semibold text-gray-800 text-center mb-4">Réinitialisation du mot de passe</h2>
           <form action="{{ route('password.email') }}" method="POST" class="space-y-4">
               @csrf
               <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Adresse email</label>
                <input type="email" id="email" name="email" placeholder="Entrez votre email" required
                    class="block mt-1 w-full p-4 border border-gray-300 rounded-lg">
                @error('email')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

               <button type="submit" class="w-full py-3 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                   Envoyer le lien de réinitialisation
               </button>
           </form>
           <p class="mt-4 text-center text-gray-600">
               <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Retour à la connexion</a>
           </p>
       </div>


   </div>
   @if(session('success'))
   <script>
    @if(session('success'))
        Swal.fire({
            title: "Email envoyé !",
            text: "{{ session('success') }}",
            icon: "success",
            confirmButtonText: "OK"
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = "{{ route('login') }}"; // Redirection vers la page de connexion
            }
        });
    @endif
</script>

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
</body>
</html>
